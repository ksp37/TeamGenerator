<!DOCTYPE html>
<html lang="en">
<head>
    <title>Team Generator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/home">The Football Team Generator</a>
      </div>
      <div>
        <ul class="nav navbar-nav">
<!--      <li" ($whichIsActive === 1 ? " class="active"" : "")   "><a href="/players">Rate Players</a></li>
          <li"  ($whichIsActive === 2 ? " class="active"" : "")   "><a href="/">Generate Teams</a></li>
          <li"  ($whichIsActive === 3 ? " class="active"" : "")   "><a href="/">Calculate Rating Difference for Teams</a></li>-->
          <li><a href="/players">Rate Players</a></li>
          <li><a href="/teams/generate">Generate Teams</a></li>
          <li><a href="/teams/choose">Calculate Rating Difference for Teams</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="navbar-text"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->name }}</li>
            <li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>  
    @include('common.errors')
    @yield('content')
</body>
</html>