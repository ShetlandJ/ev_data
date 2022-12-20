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
        $connector = StationConnector::where('id', $connectorId)
            ->with('station', 'statusChanges')
            ->first();

        $connector->station->fullAddress = $connector->station->fullAddress;

        return $connector;
    }

    public function searchConnectors(?string $searchTerm = null): array
    {
        // get search from request
        $search = $searchTerm ?? request()->search;

        $connectors = StationConnector::select('station_connectors.*')
            ->join('stations', 'stations.id', '=', 'station_connectors.station_id')
            ->where('stations.address_sitename', 'like', '%' . $search . '%')
            ->orWhere('stations.address_streetnumber', 'like', '%' . $search . '%')
            ->orWhere('stations.address_street', 'like', '%' . $search . '%')
            ->orWhere('stations.address_area', 'like', '%' . $search . '%')
            ->orWhere('stations.address_postcode', 'like', '%' . $search . '%')
            ->with('station')
            ->get();

        return $connectors->toArray();
    }
}
