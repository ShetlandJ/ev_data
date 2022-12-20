<?php

namespace App\Http\Controllers\Home;

use Inertia\Inertia;
use App\Services\ConnectorService;
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

    public function search(string $searchTerm)
    {
        $connectors = app(ConnectorService::class)->searchConnectors($searchTerm);

        return Inertia::render('SearchResultsPage', [
            'connectors' => $connectors,
            'searchTerm' => $searchTerm,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'isLoggedIn' => Auth::check(),
        ]);
    }
}
