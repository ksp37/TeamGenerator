<!-- resources/views/teams/choosen.blade.php-->

@extends('layouts.intapp')

@section('content')  
<!--  <link rel="stylesheet" type="text/css" href="../private/css/errorcss.css"/>-->
  <div class="container">
  <div class="page-header">
    <h1>Rating Difference for Chosen Teams</h1>      
  </div>
    <p>The rating difference between the teams is specified below:</p> 
    @foreach ($teams as $team) 
    <div class="well">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>Team 1</th>
                <th>Team 2</th>
              </tr>
            </thead>
            <tbody>
            <?php
               $teamOne = $team->itsFirstTeam;
               $teamTwo = $team->itsSecondTeam;
               $teamSize = count($teamOne);
               for( $i = 0 ; $i < $teamSize; $i++)
                {
                  $teamOnePlayer = array_pop($teamOne);
                  $teamTwoPlayer = array_pop($teamTwo);
                  echo "<tr>
                          <td>$teamOnePlayer</td>
                          <td>$teamTwoPlayer</td>
                        </tr>";
                }
            ?>
            </tbody>
        </table>
    <p>Rating difference of {{$team->itsRatingDifference}}</p>
    </div>
    @endforeach
  </div>
  <div style="margin-top:15px"></div>
@endsection