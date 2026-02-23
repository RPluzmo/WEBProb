<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
            'clubs' => Club::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'club_id' => ['nullable', 'exists:clubs,id'],
            'category' => ['nullable', Rule::in(['MX1', 'MX2', 'MX125', 'MX85', 'MX65', 'MX50', 'Kvadracikls', 'Blakusvāģis'])],
            'experience_level' => ['nullable', Rule::in(['Iesācējs', 'Amatieris', 'Veterāns', 'Profesionālis'])],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                $oldPath = public_path($user->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $dir = public_path('profile_images/user_' . $user->id);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $ext = $request->file('profile_image')->getClientOriginalExtension();
            $filename = 'avatar.' . $ext;
            $request->file('profile_image')->move($dir, $filename);

            $user->profile_image = 'profile_images/user_' . $user->id . '/' . $filename;
        }

        $club = !empty($validated['club_id']) ? Club::find($validated['club_id']) : null;

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->club_id = $club?->id;
        $user->category = $validated['category'] ?? null;
        $user->experience_level = $validated['experience_level'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success');
    }
}
