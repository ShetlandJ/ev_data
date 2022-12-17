<?php

namespace App\Http\Controllers\Home;

use App\Models\Trip;
use Inertia\Inertia;
use GuzzleHttp\Client;
use App\Services\NorthlinkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HomeController
{
    public function index()
    {
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'isLoggedIn' => Auth::check(),
        ]);
    }
}
