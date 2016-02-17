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
            <div class="column left aligned">
                <div class="ui aligned center aligned grid">
                    <div class="column center aligned">
                        <h2 class="ui teal center aligned header">
                            <div class="content">
                                Reset Password
                            </div>
                        </h2>
                    </div>
                </div>
                <form method="post" action="{{ route('post.reset') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">
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
                    <div class="ui form segment">
                        <div class="required field {{ $errors->has('email') ? 'error' : '' }}">
                            <label>E-Mail Address</label>
                            <input type="text" name="email" value="{{ $email or old('email') }}">
                        </div>
                        <div class="required field {{ $errors->has('password') ? 'error' : '' }}">
                            <label>Password</label>
                            <input type="password" name="password">
                        </div>
                        <div class="required field {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation">
                        </div>
                        <button class="ui large fluid teal submit button">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>