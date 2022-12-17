<?php

namespace App\Services;

use App\Models\Station;
use App\Models\StationConnector;
use App\Models\StatusChange;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ConnectorService
{
    public function getConnector(int $connectorId): StationConnector
    {
        return StationConnector::where('id', $connectorId)
            ->with('station', 'statusChanges')
            ->first();
    }

    public function searchConnectors(): array
    {
        // get search from request
        $search = request()->search;

        $connectors = StationConnector::select('station_connectors.*')
            ->join('stations', 'stations.id', '=', 'station_connectors.station_id')
            ->where('stations.address_sitename', 'like', '%' . $search . '%')
            ->orWhere('stations.address_streetnumber', 'like', '%' . $search . '%')
            ->orWhere('stations.address_street', 'like', '%' . $search . '%')
            ->orWhere('stations.address_area', 'like', '%' . $search . '%')
            ->orWhere('stations.address_postcode', 'like', '%' . $search . '%')
            ->with('station', 'statusChanges')
            ->get();

        return $connectors->toArray();
    }
}
