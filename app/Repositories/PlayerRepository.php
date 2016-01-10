<?php

namespace App\Repositories;

use App\User;
use App\PlayerInfo;
use DB;

class PlayerRepository
{

    /**
     * Returns the average score of players in $playerNames. If a player has
     * not been rated, a default score of 50 is assigned to that player.
     * @param array $playerNames array containing names of players
     * @return array containing averages in form playerName => playerAvg.
     */
    public function avgScoreForPlayers(array $playerNames)
    {
        $avgScoreResult = PlayerInfo::whereIn('name', $playerNames)
                        ->leftJoin('user_ratings', 'player_info.id', '=', 'user_ratings.player_id')
                        ->leftJoin('scores', 'user_ratings.score_id', '=', 'scores.id')
                        ->groupBy('player_info.id', 'player_info.name')
                        ->select(DB::raw('player_info.name AS pname, '
                                .         'AVG(scores.score) AS pavg'))
                        ->get();
        
        foreach ($avgScoreResult as $result => $info)
        {
            $attributes = $info->getAttributes();
            $playerAvgScores[$attributes['pname']] = ( $attributes['pavg'] !== NULL ? $attributes['pavg'] : "50");
        }
        
        return $playerAvgScores;
    }
}
