<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function authorizeAdmin(): void
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Tikai admini');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $users = User::with('tracks')->orderBy('role')->orderBy('id')->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $this->authorizeAdmin();
        $tracks = Track::orderBy('name')->get();
        $ownerTrackId = $user->tracks()->value('id');
        return view('users.edit', compact('user', 'tracks', 'ownerTrackId'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,owner,guest',
            'owner_track_id' => 'nullable|exists:tracks,id',
            'remove_profile_image' => 'nullable|boolean',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($request->boolean('remove_profile_image')) {
            if ($user->profile_image) {
                $full = public_path($user->profile_image);
                if (file_exists($full)) {
                    unlink($full);
                }
            }
            $user->update(['profile_image' => null]);
        }

        if ($user->role === 'owner') {
            $selectedTrackId = $validated['owner_track_id'] ?? null;
            Track::where('owner_id', $user->id)->update(['owner_id' => null]);

            if ($selectedTrackId) {
                Track::where('id', $selectedTrackId)->update(['owner_id' => $user->id]);
            }
        } else {
            Track::where('owner_id', $user->id)->update(['owner_id' => null]);
        }

        return redirect()->route('users.index')->with('success');
    }

    public function destroy(User $user)
    {
        $this->authorizeAdmin();

        Track::where('owner_id', $user->id)->update(['owner_id' => null]);

        if ($user->profile_image) {
            $full = public_path($user->profile_image);
            if (file_exists($full)) {
                unlink($full);
            }
        }

        $user->delete();

        return redirect()->route('users.index')->with('success');
    }
}
