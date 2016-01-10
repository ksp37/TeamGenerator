<?php

namespace App\Repositories;

use App\User;
use App\PlayerInfo;
use DB;

class PlayerRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Task::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
    
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
