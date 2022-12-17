<?php

namespace App\Services;

use App\Models\Station;
use App\Models\StationConnector;
use App\Models\StatusChange;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ScraperService
{
    public function syncChargers(): bool
    {
        $stationsListEndpoint = 'https://account.chargeplacescotland.org/api/v3/poi/chargepoint/static';
        $apiKey = 'c3VwcG9ydCtjcHNhcHBAdmVyc2FudHVzLmNvLnVrOmt5YlRYJkZPJCEzcVBOJHlhMVgj';

        $stationsList = Http::withHeaders([
            'api-auth' => $apiKey,
        ])->get($stationsListEndpoint);

        $json = $stationsList->getBody();
        $data = json_decode($json, true);

        foreach ($data['features'] as $chargePoint) {
            $station = Station::where('external_id', $chargePoint['properties']['id'])->first();

            if (!$station) {
                $station = new Station();
            }

            [$lat, $lon] = $chargePoint['geometry']['coordinates'];

            $station->latitude = $lat;
            $station->longitude = $lon;

            $stationData = $chargePoint['properties'];

            $station->name = $stationData['name'];
            $station->external_id = $stationData['id'];
            $station->site_id = $stationData['siteID'];
            $station->tariff_amount = $stationData['tariff']['amount'] === '' ? null : $stationData['tariff']['amount'];
            $station->tariff_currency = $stationData['tariff']['currency'] === '' ? null : $stationData['tariff']['currency'];
            $station->tariff_connection_fee = $stationData['tariff']['connectionfee'];

            $station->address_sitename = $stationData['address']['sitename'];
            $station->address_streetnumber = $stationData['address']['streetnumber'];
            $station->address_street = $stationData['address']['street'];
            $station->address_area = $stationData['address']['area'];
            $station->address_city = $stationData['address']['city'];
            $station->address_postcode = $stationData['address']['postcode'];
            $station->address_country = $stationData['address']['country'];
            $station->allowed_vehicle_type = $stationData['allowedVehicleType'];

            $station->save();

            foreach ($stationData['connectorGroups'] as $connectorGroup) {
                foreach ($connectorGroup['connectors'] as $connector) {
                    $stationConnector = StationConnector::where('connector_id', $connector['connectorID'])
                        ->where('station_id', $station->id)
                        ->first();

                    if (! $stationConnector) {
                        $stationConnector = new StationConnector();
                    }

                    $stationConnector->station_id = $station->id;
                    $stationConnector->status = $stationConnector->status ?? null;
                    $stationConnector->connector_id = $connector['connectorID'];
                    $stationConnector->connector_type = $connector['connectorType'];
                    $stationConnector->connector_plug_type = $connector['connectorPlugType'];
                    $stationConnector->connector_plug_type_name = $connector['connectorPlugTypeName'];
                    $stationConnector->connector_max_charge_rate = $connector['connectorMaxChargeRate'];

                    $stationConnector->save();
                }
            }
        }

        return true;
    }

    public function getChargerStatuses(): Response
    {
        $url = 'https://account.chargeplacescotland.org/api/v2/poi/chargepoint/dynamic';
        $apiKey = 'c3VwcG9ydCtjcHNhcHBAdmVyc2FudHVzLmNvLnVrOmt5YlRYJkZPJCEzcVBOJHlhMVgj';

        $response = Http::withHeaders([
            'api-auth' => $apiKey,
        ])->get($url);

        $json = $response->getBody();
        $data = json_decode($json, true);

        foreach ($data['chargePoints'] as $dataChargePoint) {
            $chargePointData = $dataChargePoint['chargePoint'];

            $station = Station::where('name', $chargePointData['name'])
                ->where('external_id', $chargePointData['id'])
                ->first();

            if ($station) {
                foreach ($chargePointData['connectorGroups'] as $connectorGroup) {
                    foreach ($connectorGroup['connectors'] as $connector) {
                        $stationConnector = StationConnector::where('connector_id', $connector['connectorID'])
                            ->where('station_id', $station->id)
                            ->first();

                        if (! $stationConnector) {
                            continue;
                        }

                        $previousStatus = $stationConnector->status;
                        $newStatus = $connector['connectorStatus'];

                        $stationConnector->station_id = $station->id;
                        $stationConnector->status = $connector['connectorStatus'];

                        $stationConnector->save();

                        if (!is_null($previousStatus) && $previousStatus !== $newStatus) {
                            $statusChange = new StatusChange();
                            $statusChange->station_id = $station->id;
                            $statusChange->station_connector_id = $stationConnector->id;
                            $statusChange->old_status = $previousStatus;
                            $statusChange->new_status = $newStatus;
                            $statusChange->save();
                        }
                    }
                }
            }
        }
        return $response;
    }
}
