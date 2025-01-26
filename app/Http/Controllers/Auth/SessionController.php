<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\Auth\SessionRequest;
class SessionController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(SessionRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('tag', $validated['tag'])->first();

        if ($user && $this->userbanned($user)) {
            return back()->withErrors([
                'tag' => 'You are banned.',
            ])->onlyInput('tag');
        }


        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return to_route('home');
        }

        return back()->withErrors([
            'tag' => 'wrong tag or password',
        ])->onlyInput('tag');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return to_route('home');
    }

    private function userbanned(User $user)
    {
        if ($user->banned_at) {
            return true;
        }
        return false;
    }
}
