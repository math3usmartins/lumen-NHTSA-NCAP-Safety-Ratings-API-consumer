<?php

namespace App\NHTSA\WebApi;

class OutputFormatter
{
    /**
     * @param SafetyRatings $api
     * @param \StdClass $vehicle
     */
    public static function withCrashRating(SafetyRatings $api, \StdClass $vehicle)
    {
        $apiResponse = $api->getByVehicleId($vehicle->VehicleId);

        // default value: not rated.
        $vehicle->CrashRating = "Not Rated";

        if ($apiResponse->getStatusCode() == 200) {
            $vehicleData = json_decode($apiResponse->getBody()->getContents());

            if (isset($vehicleData->Results[0]->OverallRating)) {
                $vehicle->CrashRating = $vehicleData->Results[0]->OverallRating;
            }
        }
    }

    /**
     * @param $vehicle
     * @return \StdClass
     */
    public static function vehicle($vehicle)
    {
        return (object) array(
            'Description' => $vehicle->VehicleDescription,
            'VehicleId'   => $vehicle->VehicleId,
        );
    }
}