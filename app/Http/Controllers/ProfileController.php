<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Maximum number of available profile pictures
    const MAX_PROFILE_PICTURES = 50;
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the profile picture selection page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get available profile pictures (1.png to MAX_PROFILE_PICTURES.png)
        $availableProfiles = [];
        for ($i = 1; $i <= self::MAX_PROFILE_PICTURES; $i++) {
            $availableProfiles[] = [
                'id' => $i,
                'filename' => $i . '.png',
                'path' => '/images/profile/' . $i . '.png'
            ];
        }
        
        return view('profile.index', compact('user', 'availableProfiles'));
    }

    /**
     * Update the user's profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        // Generate validation rule for all available profile pictures (1.png to MAX_PROFILE_PICTURES.png)
        $allowedPictures = ['default'];
        for ($i = 1; $i <= self::MAX_PROFILE_PICTURES; $i++) {
            $allowedPictures[] = $i . '.png';
        }
        
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|string|in:' . implode(',', $allowedPictures)
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        
        // Update profile picture
        if ($request->profile_picture === 'default') {
            $user->profile_picture = null;
        } else {
            $user->profile_picture = $request->profile_picture;
        }
        
        $user->save();

        return back()->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Get user's profile picture URL
     */
    public static function getProfilePictureUrl($user)
    {
        if ($user && $user->profile_picture) {
            $filePath = public_path('images/profile/' . $user->profile_picture);
            if (file_exists($filePath)) {
                return '/images/profile/' . $user->profile_picture;
            }
        }
        
        // Return default profile picture URL - fallback to a CSS-based avatar if file doesn't exist
        $defaultPath = public_path('images/profile/default.png');
        if (file_exists($defaultPath)) {
            return '/images/profile/default.png';
        }
        
        // Return a data URL for a simple generated avatar
        return 'data:image/svg+xml;base64,' . base64_encode(
            '<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" fill="#6c757d"/>
                <text x="50" y="60" font-family="Arial" font-size="40" fill="white" text-anchor="middle">
                    ' . strtoupper(substr($user->name ?? 'U', 0, 1)) . '
                </text>
            </svg>'
        );
    }
}
