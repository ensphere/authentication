<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Application</title>
        <meta name="description" content="" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        @include('loader')
    </head>
    <body class="authentication register">
        <div id="screen-loader" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: #DADADA; z-index: 9999;"></div>
        <div class="ui middle aligned center aligned grid">
            <div class="column left aligned">
                <div class="ui aligned center aligned grid">
                    <div class="column center aligned">
                        <h2 class="ui teal center aligned header">
                            <div class="content">
                                Register for an account
                            </div>
                        </h2>
                    </div>
                </div>
                <form method="post" action="{{ route('post.register') }}">
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
                    <div class="ui form segment">
                        <div class="required field {{ $errors->has('name') ? 'error' : '' }}">
                            <label class="ui left item">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="required field {{ $errors->has('email') ? 'error' : '' }}">
                            <label>E-Mail Address</label>
                            <input type="text" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="two fields">
                            <div class="required field {{ $errors->has('password') ? 'error' : '' }}">
                                <label>Password</label>
                                <input type="password" name="password">
                            </div>
                            <div class="required field {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation">
                            </div>
                        </div>
                        <button class="ui large fluid teal submit button">Register for an account</button>
                    </div>
                </form>
                <div class="ui aligned center aligned grid">
                    <div class="column center aligned">
                        <div class="ui message">
                            <a href="{{ route('get.login') }}">Already got an account?</a></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
