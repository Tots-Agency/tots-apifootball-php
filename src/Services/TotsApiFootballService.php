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
    const ACTION_GET_STANDINGS = 'get_standings';
    const ACTION_GET_EVENTS = 'get_events';
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
     * @param string $teamId
     * @return void
     */
    public function getTeamById($teamId)
    {
        return $this->call(self::ACTION_GET_TEAMS, ['league_id' => $teamId]);
    }
    /**
     *
     * {
     *     "country_name": "Spain",
     *     "league_id": "302",
     *     "league_name": "La Liga",
     *     "team_id": "76",
     *     "team_name": "Real Madrid",
     *     "overall_promotion": "Promotion - Champions League (Group Stage)",
     *     "overall_league_position": "1",
     *     "overall_league_payed": "37",
     *     "overall_league_W": "24",
     *     "overall_league_D": "9",
     *     "overall_league_L": "4",
     *     "overall_league_GF": "65",
     *     "overall_league_GA": "27",
     *     "overall_league_PTS": "81",
     *     "home_league_position": "",
     *     "home_promotion": "",
     *     "home_league_payed": "",
     *     "home_league_W": "",
     *     "home_league_D": "",
     *     "home_league_L": "",
     *     "home_league_GF": "",
     *     "home_league_GA": "",
     *     "home_league_PTS": "",
     *     "away_league_position": "",
     *     "away_promotion": "",
     *     "away_league_payed": "",
     *     "away_league_W": "",
     *     "away_league_D": "",
     *     "away_league_L": "",
     *     "away_league_GF": "",
     *     "away_league_GA": "",
     *     "away_league_PTS": "",
     *     "league_round": "Current",
     *     "team_badge": "https://apiv3.apifootball.com/badges/76_real-madrid.jpg",
     *     "fk_stage_key": "402",
     *     "stage_name": "Current"
     * },
     * 
     * @param string $leagueId
     * @return array
     */
    public function getStandings($leagueId)
    {
        return $this->call(self::ACTION_GET_STANDINGS, ['league_id' => $leagueId]);
    }
    /**
     * More data: https://apifootball.com/documentation/#Events
     * 
     * @param string $leagueId
     * @param string $from
     * @param string $to
     * @param string $timezone
     * @return array
     */
    public function getMatches($leagueId, $from = '2023-01-01', $to = '2023-12-01', $timezone = 'America/New_York')
    {
        return $this->call(self::ACTION_GET_EVENTS, ['league_id' => $leagueId, 'from' => $from, 'to' => $to, 'timezone' => $timezone]);
    }
    /**
     *
     * @param string $matchId
     * @return array
     */
    public function getMatchById($matchId) 
    {
        return $this->call(self::ACTION_GET_EVENTS, ['match_id' => $matchId]);
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
        $obj = json_decode($dataString);
        // Verify error
        if(is_object($obj) && $obj->error){
            return [];
        }
        return $obj;
    }

}
