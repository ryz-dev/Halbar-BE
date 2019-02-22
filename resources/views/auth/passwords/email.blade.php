<!DOCTYPE html>
<html lang="en" class="">
    <head>
        <meta charset="utf-8" />
        <title>CMS Docotel Teknologi Celebes</title>
        <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/libs/assets/animate.css/animate.css" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/libs/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/libs/assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/libs/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/css/font.css" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/css/app.css" type="text/css" />
    </head>
    <body>
    <div class="app app-header-fixed">
    <div class="container w-xl w-auto-xs">
        <a href class="navbar-brand block m-t">CMS DTC</a>
        <div class="m-b-lg">
            <div class="wrapper text-center">
                <strong>Input your email to reset your password</strong>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
                <div class="list-group list-group-sm">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <div class="list-group-item">
                        <input placeholder="Email" id="email" type="email" class="form-control no-border" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary btn-block">Send</button>
            </form>
            <div collapse="isCollapsed" class="m-t">
                <div class="alert alert-success">
                    <p>A reset link sent to your email address, please check it in 7 days. <a href="{{ route('login') }}" class="btn btn-sm btn-success">Sign in</a></p>
                </div>
            </div>
        </div>
        <div class="text-center">
            <p>
                <small class="text-muted">CMS from Docotel Teknologi Celebes<br>&copy; 2017</small>
            </p>
        </div>
    </div>
    </div>
    <script src="{{ asset('assets') }}/admin/libs/jquery/jquery/dist/jquery.js"></script>
    <script src="{{ asset('assets') }}/admin/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
    <script src="{{ asset('assets') }}/admin/js/ui-load.js"></script>
    <script src="{{ asset('assets') }}/admin/js/ui-jp.config.js"></script>
    <script src="{{ asset('assets') }}/admin/js/ui-jp.js"></script>
    <script src="{{ asset('assets') }}/admin/js/ui-nav.js"></script>
    <script src="{{ asset('assets') }}/admin/js/ui-toggle.js"></script>
    <script src="{{ asset('assets') }}/admin/js/ui-client.js"></script>
    </body>
</html>
