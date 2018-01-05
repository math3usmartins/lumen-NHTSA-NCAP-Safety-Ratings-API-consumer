<?php

namespace App\NHTSA\WebApi;

use GuzzleHttp\Client;

class SafetyRatings
{
    protected $format = 'json';

    protected $url;

    protected $httpClient;

    public function __construct(string $url)
    {
        $this->url = $url;

        $this->httpClient = new Client([
            'base_uri' => rtrim($this->url, '/') . '/',
        ]);
    }

    /**
     * @param string $modelYear
     * @param string $make
     * @param string $model
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getByModelYearMakeModel(string $modelYear, string $make, string $model)
    {
        $path = "modelyear/$modelYear/make/$make/model/$model?format={$this->format}";

        return $this->httpClient->get($path);
    }

    public function getByVehicleId($vehicleId)
    {
        $path = "VehicleId/$vehicleId?format={$this->format}";

        return $this->httpClient->get($path);

    }
}