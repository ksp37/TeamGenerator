<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PlayerRepository;
use App\Logic\TeamLogic as TeamLogic;
use Validator;
use Input;

class TeamController extends Controller
{
    
    /**
     * The TeamLogic class used to calculate teams.
     */
    protected $itsTeamGenerator;
    
   /**
     * The player repository instance.
     */
    protected $itsPlayerRepository;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(TeamLogic $teamGenerator, PlayerRepository $playerRepo)
    {
        //Requires user to be logged in before accessing any pages
        $this->middleware('auth');
        $this->itsTeamGenerator = $teamGenerator;
        $this->itsPlayerRepository = $playerRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Display a list of all players available to generate teams from
     *
     * @return Response
     */
    public function getGenerate()
    {
        $players = \App\PlayerInfo::all();
        return view('teams.generate', ['players' => $players]);
    }
   /**
     * Display a list of teams in ascending order of rating difference
     *
     * @param  Request  $request
     * @return Response
     */
    public function postGenerate(Request $request)
    {
        $squad = $request->input("squadSel");
        $ratingDiff = $request->input("ratingDiff");
        
        $firstValidator = Validator::make(
            array(
                'squadSel' => $squad
            ),
            array(
                'squadSel' => 'required|min:4|max:16|check_even'
            ),
            array(
                'min' => 'Please select at least :min players.'
                , 'max' => 'Please select no more than :max players.'
                , 'required'   => 'No players have been selected.'
                , 'check_even' => 'Please select an even number of players.'
            )
        );
        
        if( $firstValidator->fails())
        {
            return redirect('teams/generate')
            ->withErrors($firstValidator);
        }
        
        $squadAvgs = $this->itsPlayerRepository->avgScoreForPlayers($squad);
        $teams = $this->itsTeamGenerator->GetTeamsForRatingDiff($squadAvgs, $ratingDiff);
        return view('teams.generated', ['teams' => $teams]);
    }
    
   /**
     * Display a list of all players available from which two teams should be chosen
     *
     * @return Response
     */
    public function getChoose()
    {
        $players = \App\PlayerInfo::all();
        return view('teams.choose', ['players' => $players]);
    }
   /**
     * Display the selected teams and their rating difference
     *
     * @param  Request  $request
     * @return Response
     */
    public function postChoose(Request $request)
    {
        $teamOne = $request->input("teamOne");
        $teamTwo = $request->input("teamTwo");
        $firstValidator = Validator::make(
            array(
                'teamOne' => $teamOne
                , 'teamTwo' => $teamTwo
            ),
            array(
                'teamOne' => 'required|min:4'
                , 'teamTwo' => 'required|min:4'
            ),
            array(
                'min' => 'Please select at least :min players from :attribute.'
                , 'required'   => 'No players have been selected from :attribute.'
            )
        );
        
        $secondValidator = Validator::make(
            array(
                'teamOne' => $teamOne
                , 'teamTwo' => $teamTwo
            ),
            array(
                'teamTwo' => 'distinct_sets:teamOne|same_size:teamOne'
            ),
            array(
                'distinct_sets' => 'One or more players belong to both teams.'
                , 'same_size'   => 'Please select the same number of players for both teams.'
            )
        );
        
        if( $firstValidator->fails())
        {
            return redirect('teams/choose')
            ->withErrors($firstValidator);
        }
        
        if( $secondValidator->fails())
        {
            return redirect('teams/choose')
            ->withErrors($secondValidator);
        }        
        $teamOneAvgs = $this->itsPlayerRepository->avgScoreForPlayers($teamOne);
        $teamTwoAvgs = $this->itsPlayerRepository->avgScoreForPlayers($teamTwo);
        $ratingDiff = $this->itsTeamGenerator->GetRatingDiffForTeams($teamOneAvgs, $teamTwoAvgs);
        return view('teams.chosen', ['teamOne' => $teamOne, 
                                    'teamTwo' => $teamTwo, 
                                    'ratingDiff' => $ratingDiff
                                    ]);
    }
}
