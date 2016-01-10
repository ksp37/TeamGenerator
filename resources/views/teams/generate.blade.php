<!-- resources/views/teams/generate.blade.php-->

@extends('layouts.intapp')

@section('content')  
<!--  <link rel="stylesheet" type="text/css" href="../private/css/errorcss.css"/>-->
  <div class="container">
  <div class="page-header">
    <h1>Select Squad</h1>      
  </div>
    <p>Select squad to choose teams from (must be an even number).</p> 
    <div class="well">
        <form role="form" id="squadSelForm" action="/teams/generate" method="POST" align="left">
            <div class="form-group">
                <select multiple class="form-control" id="squadSelBox" name="squadSel[]" size="7">
                    <?php $id = 0; ?>
                    @foreach ($players as $player)
                        <option id="{{$id}}" name="{{$player->name}}" value="{{$player->name}}">{{$player->name}}</option>"
                        <?php $id = $id + 1; ?>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="rd">Allowed Rating Difference:</label>
                <input type="number" class="form-control" name="ratingDiff" id="rd" min="0" max="20" step="0.5" required>
            </div>
            <button type="submit" class="btn btn-default">Generate Teams</button>
            <input name="_token" hidden value="{!! csrf_token() !!}" />
                 <!--<input type="submit" value="Generate Teams">-->
        </form>
    </div>
  </div>
  <div style="margin-top:15px"></div>
@endsection