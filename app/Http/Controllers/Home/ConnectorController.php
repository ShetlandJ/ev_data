<?php

namespace App\Http\Controllers\Home;

use App\Models\Trip;
use App\Services\ConnectorService;
use Inertia\Inertia;
use GuzzleHttp\Client;
use App\Services\NorthlinkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ConnectorController
{
    public function view(int $connectorId)
    {
        $connector = app(ConnectorService::class)->getConnector($connectorId);

        return Inertia::render('Connector', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'isLoggedIn' => Auth::check(),
            'connector' => $connector,
        ]);
    }
}
