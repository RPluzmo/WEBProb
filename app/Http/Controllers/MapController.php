<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Image;
use App\Models\Rider;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MapController extends Controller
{
    private const RIDE_PERIOD_TO_TIME = [
        'morning' => '08:00:00',
        'noon' => '12:00:00',
        'afternoon' => '16:00:00',
        'evening' => '20:00:00',
    ];

    public function index()
    {
        $tracks = Track::with([
            'images' => fn($q) => $q->where('slot', 'cover')->select('id', 'track_id', 'path')
        ])->withCount([
            'riders as riders_count' => function ($q) {
                $q->whereIn('ride_date', [now()->toDateString(), now()->addDay()->toDateString()]);
            }
        ])->get();

        return view('map', ['tracks' => $tracks, 'filter' => 'all']);
    }

    public function active()
    {
        $tracks = Track::with([
            'images' => fn($q) => $q->where('slot', 'cover')->select('id', 'track_id', 'path')
        ])->withCount([
            'riders as riders_count' => function ($q) {
                $q->whereIn('ride_date', [now()->toDateString(), now()->addDay()->toDateString()]);
            }
        ])->having('riders_count', '>', 0)->get();

        return view('map', ['tracks' => $tracks, 'filter' => 'active']);
    }

    public function show(Track $track)
    {
        $allowedDates = [now()->toDateString(), now()->addDay()->toDateString()];

        $track->load([
            'images',
            'events',
            'riders' => fn($q) => $q->whereIn('ride_date', $allowedDates)->orderBy('ride_date')->orderBy('ride_time'),
            'riders.clubRelation',
            'owner',
        ]);

        $groupedRiders = $track->riders->groupBy(function ($rider) {
            return $rider->clubRelation?->name ?? 'Privāti';
        });

        $clubs = Club::orderBy('name')->get();

        return view('tracks.show', compact('track', 'groupedRiders', 'clubs'));
    }

    public function storeRider(Request $request, Track $track)
    {
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        $validated = $request->validate([
            'ride_date' => ['required', 'date', "in:$today,$tomorrow"],
            'ride_period' => ['required', Rule::in(array_keys(self::RIDE_PERIOD_TO_TIME))],
            'name' => ['nullable', 'string', 'max:255'],
            'club_id' => ['nullable', 'exists:clubs,id'],
            'category' => ['nullable', Rule::in(['MX1', 'MX2', 'MX125', 'MX85', 'MX65', 'MX50', 'Kvadracikls', 'Blakusvāģis'])],
            'experience_level' => ['nullable', Rule::in(['Iesācējs', 'Amatieris', 'Veterāns', 'Profesionālis'])],
        ]);

        $rideTime = self::RIDE_PERIOD_TO_TIME[$validated['ride_period']];

        if (Auth::check()) {
            $user = Auth::user();

            $alreadyBookedToday = Rider::where('user_id', $user->id)
                ->where('ride_date', $validated['ride_date'])
                ->first();

            if ($alreadyBookedToday) {
                if ((int) $alreadyBookedToday->track_id === (int) $track->id) {
                    return back()->withErrors([
                        'ride_date' => 'Tu jau esi pieteicies šai trasei šajā dienā.',
                    ])->withInput();
                }

                $otherTrack = Track::find($alreadyBookedToday->track_id);

                return back()->withErrors([
                    'ride_date' => 'Tu jau esi pieteicies citā trasē šajā dienā: ' . ($otherTrack->name ?? 'nezināma trase') . '.',
                ])->withInput();
            }

            if (empty($user->category) || empty($user->experience_level)) {
                return back()->withErrors([
                    'category' => 'Pievieno klasi un pieredzi savā profilā.',
                ])->withInput();
            }

            $club = $user->club_id ? Club::find($user->club_id) : null;

            $track->riders()->create([
                'user_id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'club_id' => $club?->id ?? $user->club_id,
                'category' => $user->category,
                'experience_level' => $user->experience_level,
                'ride_date' => $validated['ride_date'],
                'ride_time' => $rideTime,
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'category' => ['required', Rule::in(['MX1', 'MX2', 'MX125', 'MX85', 'MX65', 'MX50', 'Kvadracikls', 'Blakusvāģis'])],
                'experience_level' => ['required', Rule::in(['Iesācējs', 'Amatieris', 'Veterāns', 'Profesionālis'])],
            ]);

            $club = !empty($validated['club_id']) ? Club::find($validated['club_id']) : null;

            $track->riders()->create([
                'name' => $validated['name'],
                'club_id' => $club?->id,
                'category' => $validated['category'],
                'experience_level' => $validated['experience_level'],
                'ride_date' => $validated['ride_date'],
                'ride_time' => $rideTime,
            ]);
        }

        return back()->with('success');
    }

    public function storeImages(Request $request, Track $track)
    {
        $this->authorizeTrackEdit($track);

        $validated = $request->validate([
            'slot' => ['required', 'in:cover,gallery_1,gallery_2,gallery_3'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);

        $dir = public_path('track_images/track_' . $track->id);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = $request->file('image')->getClientOriginalExtension();
        $filename = $validated['slot'] . '.' . $ext;
        $request->file('image')->move($dir, $filename);

        $relative = 'track_images/track_' . $track->id . '/' . $filename;

        $track->images()->updateOrCreate(
            ['slot' => $validated['slot']],
            ['path' => $relative]
        );

        return back()->with('success');
    }

    public function destroyImage(Image $image)
    {
        $track = $image->track;
        $this->authorizeTrackEdit($track);

        $fullPath = public_path($image->path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $image->delete();

        return back()->with('success');
    }

    public function editTrack(Track $track)
    {
        $this->authorizeTrackEdit($track);
        $track->load('events');

        return view('tracks.edit', compact('track'));
    }

    public function updateTrack(Request $request, Track $track)
    {
        $this->authorizeTrackEdit($track);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'surface_type' => 'nullable|string|max:255',
            'event_titles' => 'array',
            'event_titles.*' => 'nullable|string|max:255',
            'event_dates' => 'array',
            'event_dates.*' => 'nullable|date',
        ]);

        $track->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'surface_type' => $validated['surface_type'] ?? null,
        ]);

        $titles = $request->input('event_titles', []);
        $dates = $request->input('event_dates', []);

        $track->events()->delete();

        foreach ($titles as $i => $title) {
            $title = trim((string) $title);
            $date = $dates[$i] ?? null;

            if ($title !== '' && !empty($date)) {
                $track->events()->create([
                    'title' => $title,
                    'event_date' => $date,
                ]);
            }
        }

        return redirect()->route('tracks.show', $track->id)->with('success');
    }

    private function authorizeTrackEdit(Track $track): void
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->id !== $track->owner_id) {
            abort(403, 'Nav tiesību rediģēt šo trasi.');
        }
    }
}
