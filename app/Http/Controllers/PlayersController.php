<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PlayersController extends Controller
{

    private $m_errMessages = array(
            'integer' => 'The rating for :attribute is not an integer.',
            'between' => 'The rating for :attribute is not between 1 and 99.'
        );
    
    public function __construct()
    {
        //Requires user to be logged in before accessing any pages
        $this->middleware('auth');
    }

    /**
     * Display a list of all players available to rate
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $players = \App\PlayerInfo::all();
        return view('players.index', ['players' => $players]);
    }

    /**
     * Store user ratings for players.
     *
     * @param  Request  $request
     * @return Response
     */
    public function rate(Request $request)
    {
        $players = \App\PlayerInfo::all();
        
        //Valid rating is an integer between 1 and 99.
        foreach ($players as $player)
        {
            $playerVald[$player->name] = 'integer|between:1,99';
        }
        
        $this->validate($request, $playerVald, $this->m_errMessages);

        //Store ratings for the players.
        foreach ($players as $player)
        {
            if($request->has($player->name))
            {
                $score = new \App\Score();
                $score->score = $request->get($player->name);
                $score->save();
                
                $weeklyRating = new \App\UserRating();
                $weeklyRating->score_id = $score->id; 
                $weeklyRating->player_id = $player->id;
                $weeklyRating->user_id = Auth::user()->id;
                $weeklyRating->save();
            }
        }

        return redirect('/players');
    }

}
