<?php

namespace Tots\ApiFootball\Services;

class TotsApiFootballService 
{
    /**
     * 
     */
    const API_URL = 'https://apiv3.apifootball.com/';

    const ACTION_GET_COUNTRIES = 'get_countries';
    const ACTION_GET_LEAGUES = 'get_leagues';
    const ACTION_GET_TEAMS = 'get_teams';
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
     *  [
     *  {
     *      "country_id": "44",
     *      "country_name": "England",
     *      "country_logo": "https://apiv3.apifootball.com/badges/logo_country/44_england.png"
     *  },
     *  ]
     * @return array
     */
    public function getCountries()
    {
        return $this->call(self::ACTION_GET_COUNTRIES);
    }
    /**
     * [
     * {
     *     "country_id": "6",
     *     "country_name": "Spain",
     *     "league_id": "300",
     *     "league_name": "Copa del Rey",
     *     "league_season": "2020/2021",
     *     "league_logo": "https://apiv3.apifootball.com/badges/logo_leagues/300_copa-del-rey.png",
     *     "country_logo": "https://apiv3.apifootball.com/badges/logo_country/6_spain.png"
     * },
     * ]
     * 
     * @param string $countryId
     * @return array
     */
    public function getLeagues($countryId = null)
    {
        return $this->call(self::ACTION_GET_LEAGUES, $countryId != null ? ['country_id' => $countryId] : []);
    }
    /**
     * [
     * {
     *      "team_key": "73",
     *      "team_name": "Atletico Madrid",
     *      "team_badge": "https://apiv3.apifootball.com/badges/73_atl.-madrid.jpg",
     *      "players": []
     *      ....
     * }
     * ]
     *
     * @param string $leagueId
     * @return array
     */
    public function getTeams($leagueId)
    {
        return $this->call(self::ACTION_GET_TEAMS, ['league_id' => $leagueId]);
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
