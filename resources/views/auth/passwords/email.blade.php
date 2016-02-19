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
        <div id="screen-loader" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: #DADADA; z-index: 9999;"></div>
        <div class="ui middle aligned center aligned grid">
            <div class="column">
                <h2 class="ui teal header">
                    <div class="content">
                        <div class="ui horizontal divider"><i class="unlock alternate icon"></i> Reset Password</div>
                    </div>
                </h2>
                <form class="ui small form" method="post" action="{{ route('post.sendEmail') }}">
                    {!! csrf_field() !!}
                    @if ( ! $errors->isEmpty() )
                        <div class="ui error small message">
                            <div class="ui left aligned header">There was some errors with your submission</div>
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
                                <i class="mail icon"></i>
                                <input type="text" name="email" value="{{ old('email') }}" placeholder="E-mail address">
                            </div>
                        </div>
                        <button class="ui fluid small blue submit button">Send Password Reset Link</button>
                    </div>
                </form>

                <div class="ui small message">
                    <a href="{{ route('get.login') }}">Login</a> | <a href="{{ route('get.register') }}">Sign Up</a>
                </div>
            </div>
        </div>
    </body>
</html>