<!DOCTYPE html>
<html lang="en">
<head>
    <title>The Football Team Generator</title>
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
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="/auth/register"><i class="glyphicon glyphicon-user"></i>Register</a></li>
                                <li><a href="/auth/login"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
                            </ul>
                </div>
        </nav>

	@yield('content')
</body>
</html>
