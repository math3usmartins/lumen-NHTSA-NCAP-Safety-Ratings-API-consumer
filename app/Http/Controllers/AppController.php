<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

use App\NHTSA\WebApi\SafetyRatings;
use App\NHTSA\WebApi\OutputFormatter;

class AppController extends BaseController
{
    /**
     * @param SafetyRatings $api
     * @param string $modelYear
     * @param string $make
     * @param string $model
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getByModelYearMakeModel(Request $request, SafetyRatings $api, string $modelYear, string $manufacturer, string $model)
    {
        $apiResponse = $api->getByModelYearMakeModel($modelYear, $manufacturer, $model);

        if ($apiResponse->getStatusCode() == 200) {
            $data = json_decode($apiResponse->getBody()->getContents());

            $withRating = ('true' === $request->get('withRating'));

            $data->Results = array_map(function($vehicle) use($withRating, $api) {
                $vehicle = OutputFormatter::vehicle($vehicle);

                if ($withRating) {
                    OutputFormatter::withCrashRating($api, $vehicle);
                }

                return $vehicle;
            },  $data->Results);

            return response()->json([
                'Count'   => $data->Count,
                'Results' => $data->Results,
            ]);
        }
        else {
            /** @var \Psr\Log\LoggerInterface $logger */
            $logger = app('Psr\Log\LoggerInterface');

            $headers = $apiResponse->getHeaders();

            $logger->error($msg = sprintf(
                "SafetyRatings API failure [HTTP STATUS CODE = %s]\n-----\n%s\n-----\n%s",
                $apiResponse->getStatusCode(),
                implode("\n", array_map(function($k, $v){
                    return sprintf('%s: %s', $k, implode("; ", $v));
                }, array_keys($headers), $headers)),
                $apiResponse->getBody()->getContents()
            ));

            return response()->json([
                'Count'   => 0,
                'Results' => [],
            ]);
        }
    }

    /**
     * @param Request $request
     * @param SafetyRatings $api
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getByModelYearMakeModelAsPost(Request $request, SafetyRatings $api)
    {
        /** @var ParameterBag $values */
        $values = $request->json();

        return $this->getByModelYearMakeModel(
            $request,
            $api,
            $values->get('modelYear'),
            $values->get('manufacturer'),
            $values->get('model')
        );
    }
}
