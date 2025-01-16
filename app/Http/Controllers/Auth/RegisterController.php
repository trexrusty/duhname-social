<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $iconUrl = $this->generateDicebearIcon($validated['username']);

        $user = User::create([
            'username' => $validated['username'],
            'tag' => $validated['tag'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->saveIconToS3($iconUrl, $user->id);

        Auth::login($user);

        return to_route('home');
    }

    private function generateDicebearIcon($seed)
    {
        $url = "http://host.docker.internal:3000/9.x/pixel-art/png?seed={$seed}";
        return $url;
    }

    private function saveIconToS3($iconUrl, $userId)
    {
        $imageData = file_get_contents($iconUrl);
        $fileName = "user_icons/{$userId}.png";

        // Store the image in S3
        Storage::disk('s3')->put($fileName, $imageData);
    }
}
