<?php

namespace App\Logic;

class TeamCombination
{
    public $itsFirstTeam = array();
    public $itsSecondTeam = array();
    public $itsIsFirstTeamStronger = NULL;
    public $itsRatingDifference = NULL;
};

class TeamLogic
{
    
    private static function RatingComp(TeamCombination $teamOne, TeamCombination $teamTwo)
    {
        if($teamOne->itsRatingDifference == $teamTwo->itsRatingDifference)
        {
            return 0;
        }
        return ($teamOne->itsRatingDifference < $teamTwo->itsRatingDifference) ? -1 : 1; 
    }
    
    /**
     * This method calculates the rating difference between two teams
     * @param array $teamOnePlayerAvgs an array containing the averages of the
     *              players in team one in the form playerName => $avgScore
     * @param array $teamTwoPlayerAvgs an array containing the averages of the
     *              players in team two in the form playerName => $avgScore
     * @return float
     */
    public function GetRatingDiffForTeams(
            array $teamOnePlayerAvgs
            , array $teamTwoPlayerAvgs
            )
    {
        $teamOneTotal = 0;
        $teamTwoTotal = 0;
        
        foreach ($teamOnePlayerAvgs as $player => $avg)
        {
            $teamOneTotal += $avg;
        }
        
        foreach ($teamTwoPlayerAvgs as $player => $avg)
        {
            $teamTwoTotal += $avg;
        }
        
       return abs($teamOneTotal - $teamTwoTotal);
    }
    
    /**
     * This method generates all possible combinations of teams based on $ratingDiff. It sets up
     * the variables required and initiates the recursive call to GenerateTeams(). 
     * @param array $thePlayerAvgs Array containing averages for players in form playerName => avgScore.
     * @param type $theRatingDiff Allowed difference in ratings of two teams.
     * returns all possible teams within rating difference.
     */
    public function GetTeamsForRatingDiff(
            array $thePlayerAvgs
            , $theRatingDiff
            )
    {
        $aTeam = new TeamCombination(); 
        $possibleTeams = array();
        $playerNames = array_keys($thePlayerAvgs);
        $teamSize = count($playerNames)/2;
        //This loop is the top level of recursion. It adds the first player to aTeam->itsFirstTeam
        //and calls GenerateTeam() to populate the team with remaining players. 
        foreach ($playerNames as $key => &$playerName)
        {
          array_push($aTeam->itsFirstTeam, $playerName);
          unset($playerNames[$key]);
          self::GenerateTeams($playerNames
                  , $thePlayerAvgs
                  , $aTeam
                  , $teamSize
                  , $possibleTeams
                  , $theRatingDiff
                  );
          break;
        }
        
        usort($possibleTeams, array($this, "RatingComp"));
        
        return $possibleTeams;
    }
    
    /**
     * This method recursively populates a team with players. Once a team is completely
     * filled, it calls AssessTeamsAndStore() to determine whether the teams are suitable to use. 
     * @param array $thePlayerNames an array containing names of the players
     * @param type $thePlayerAvgs an array containing the averages of players in the form $playerName => $playerAvg
     * @param type $theTeam the current team being built
     * @param type $theTeamSize size of the team
     * @param type $thePossibleTeams array containing possible combination of teams found thus far. 
     * @param type $theRatingDiff the allowed difference of rating between two teams.
     */
    private function GenerateTeams(
      array $thePlayerNames
      , $thePlayerAvgs
      , $theTeam
      , $theTeamSize
      , &$thePossibleTeams
      , $theRatingDiff
      )
    {
      //Base case for recusion - if the first team has been completely filled with players...
      if(count($theTeam->itsFirstTeam) == $theTeamSize)
      {
        $teamCopy = clone $theTeam;
        $allPlayers = array_keys($thePlayerAvgs);
        //Second team is squad - first team. 
        $teamCopy->itsSecondTeam = array_diff($allPlayers, $theTeam->itsFirstTeam); 
        //Check if the two teams are within the rating difference and store if so.
        self::AssessTeamsAndStore($teamCopy, $thePlayerAvgs, $theRatingDiff, $thePossibleTeams);
      }
      //Otherwise use remaining players in squad to fill first team...
      else
      {
        foreach ($thePlayerNames as $key => &$playerName)
        {
          $teamCopy = clone $theTeam;
          array_push($teamCopy->itsFirstTeam, $playerName);
          //Remember to remove player added to team from squad
          unset($thePlayerNames[$key]);
          //Call recursively to fill up the first team
          self::GenerateTeams($thePlayerNames, $thePlayerAvgs, $teamCopy, $theTeamSize, $thePossibleTeams, $theRatingDiff);
        }
      } 
    }
    
    /**
     * This method calculates the rating for both teams and determines if it is within
     * the rating difference ($theRatingDiff) specified. If so, the teams are stored in $thePossibleTeams.
     * @param type $theTeam the team to asses
     * @param type $thePlayerAvgs an array containing the averages for players
     * @param type $theRatingDiff the allowed difference in rating between the two teams
     * @param type $thePossibleTeams array containing possible combination of teams found thus far. 
     */
    private function AssessTeamsAndStore(
      $theTeam
      , $thePlayerAvgs
      , $theRatingDiff
      , &$thePossibleTeams
      )
    {
      $theFirstTeamRating = 0;
      $theSecondTeamRating = 0;
      
      foreach ($theTeam->itsFirstTeam as $firstPlayers)
      {
        $theFirstTeamRating += $thePlayerAvgs[$firstPlayers];
      }
      
      foreach ($theTeam->itsSecondTeam as $secondPlayers)
      {
        $theSecondTeamRating += $thePlayerAvgs[$secondPlayers];
      }
      
      if($theRatingDiff >= abs($theFirstTeamRating - $theSecondTeamRating))
      {
        $theTeam->itsIsFirstTeamStronger = $theFirstTeamRating > $theSecondTeamRating;
        $theTeam->itsRatingDifference = abs($theFirstTeamRating - $theSecondTeamRating);
        array_push($thePossibleTeams, $theTeam);
      }
    }
    
};