<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switchLanguage(Request $request, $language)
    {
        // Validate language
        if (!in_array($language, ['en', 'id'])) {
            $language = 'en'; // Default to English
        }
        
        // Store language in session
        Session::put('locale', $language);
        
        // Set application locale
        App::setLocale($language);
        
        // Redirect back to previous page
        return redirect()->back();
    }
}
