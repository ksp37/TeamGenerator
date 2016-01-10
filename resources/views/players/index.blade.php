<!-- resources/views/players/index.blade.php-->

@extends('layouts.intapp')

@section('content')
    <div class="container">
    <div class="page-header">
      <h1>Rate Players</h1>      
    </div>
    @if(count($players) > 0)
        <p>Give players a rating between 1 to 99 (empty entries aren't recorded).</p>   
        <form role="form" id="frmVote" action="/players" method="POST"
              onsubmit="document.getElementById('submitbutton').disabled=true;
              document.getElementById('submitbutton').value='Submitting, please wait...';"
              >
                <table style="width: auto;" class="table table-striped">
                    <thead>
                      <tr>
                        <th>Player Name</th>
                        <th>Rating</th>
                      </tr>
                    </thead>
                <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td> {{$player->name}} </td>
                        <td> <input type="number" name="{{$player->name}}" size="5" min="1" max="99" value="{{ old($player->name) }}"> </td>
                    </tr>
                @endforeach
                </table>
            <button type="submit" class="btn btn-default" >Submit Ratings</button>
            <input name="_token" hidden value="{!! csrf_token() !!}" />
        </form>
    @endif
  </div>
  <div style="margin-top:15px"></div>
@endsection