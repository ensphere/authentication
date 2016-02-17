<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Application</title>
        <meta name="description" content="" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        @include('loader')
    </head>
    <body class="authentication email">
        <div id="screen-loader" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: white; z-index: 9999;"></div>
        <div class="ui middle aligned center aligned grid">
            <div class="column">
                <h2 class="ui teal image header">
                    <div class="content">
                        Reset Password
                    </div>
                </h2>
                <form class="ui large form" method="post" action="{{ route('post.sendEmail') }}">
                    {!! csrf_field() !!}
                    @if ( ! $errors->isEmpty() )
                        <div class="ui error small message">
                            <div class="header">There was some errors with your submission</div>
                            <ul class="list">
                                @foreach ( $errors->all() as $error )
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ( session( 'status' ) )
                        <div class="ui success small message">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="ui stacked segment">
                        <div class="field">
                            <div class="ui left icon input {{ $errors->has('email') ? 'error' : '' }}">
                                <i class="user icon"></i>
                                <input type="text" name="email" value="{{ old('email') }}" placeholder="E-mail address">
                            </div>
                        </div>
                        <button class="ui fluid large teal submit button">Send Password Reset Link</button>
                    </div>
                </form>

                <div class="ui message">
                    <a href="{{ route('get.login') }}">Login</a> | <a href="{{ route('get.register') }}">Sign Up</a>
                </div>
            </div>
        </div>
    </body>
</html>