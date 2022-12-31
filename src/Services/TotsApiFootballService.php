<?php

namespace Tots\ApiFootball\Services;

class TotsApiFootballService 
{
    /**
     * 
     */
    const API_URL = 'https://apiv3.apifootball.com/';

    const ACTION_GET_COUNTRIES = 'get_countries';
    /**
     *
     * @var string
     */
    protected $apiKey = '';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    /**
     *
     * @return array
     */
    public function getCountries()
    {
        return $this->call(self::ACTION_GET_COUNTRIES);
    }
    /**
     *
     * @param string $action
     * @param array $params
     * @return object|array
     */
    protected function call($action, $params = [])
    {
        // Execute request
        $dataString = file_get_contents(
            self::API_URL 
            . '?action=' 
            . $action 
            . '&' 
            . http_build_query(
                array_merge($params, ['APIkey' => $this->apiKey])
            )
        );
        // Convert to object
        return json_decode($dataString);
    }

}
