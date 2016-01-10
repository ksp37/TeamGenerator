<!-- resources/views/teams/choose.blade.php-->

@extends('layouts.intapp')

@section('content')  
<!--  <link rel="stylesheet" type="text/css" href="../private/css/errorcss.css"/>-->
  <div class="container">
  <div class="page-header">
    <h1>Choose Teams</h1>      
  </div>
  @if(count($players) > 0)
    <p>Choose teams from players below (each team must have at least 4 players).</p> 
    <div class="errorTxtC"></div>
    <form role="form" id="squadsel" action="/teams/choose" method="POST" align="left">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>Team 1</th>
                <th>Team 2</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="form-group">
                      <select multiple class="form-control" id="teamOneBox" name="teamOne[]" size="7">
                        <?php $id = 0; ?>
                        @foreach ($players as $player)
                            <option id="{{$id}}" name="{{$player->name}}" value="{{$player->name}}">{{$player->name}}</option>"
                            <?php $id = $id + 1; ?>
                        @endforeach
                      </select>
                  </div>
                </td>
                <td>
                    <div class="form-group">
                      <select multiple class="form-control" id="teamTwoBox" name="teamTwo[]" size="7">
                        <?php $id = 0; ?>
                        @foreach ($players as $player)
                            <option id="{{$id}}" name="{{$player->name}}" value="{{$player->name}}">{{$player->name}}</option>"
                            <?php $id = $id + 1; ?>;
                        @endforeach
                      </select>
                    </div>
                </td>
              </tr>
            </tbody>
           </table>
        <button type="submit" class="btn btn-default">Calculate Rating</button>
        <input name="_token" hidden value="{!! csrf_token() !!}" />
            <!--<input type="submit" value="Calculate Rating">-->
      </form>
    </div>
    <div style="margin-top:15px"></div>
  @endif
@endsection