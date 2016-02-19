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
                <form class="ui small form" method="post" action="{{ route('post.reset') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">
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
                    <div class="ui stacked segment">
                        <div class="field">
                            <div class="ui left icon input {{ $errors->has('name') ? 'error' : '' }}">
                                <i class="mail icon"></i>
                                <input type="text" name="email" value="{{ $email or old('email') }}" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input {{ $errors->has('password') ? 'error' : '' }}">
                                <i class="lock icon"></i>
                                <input type="password" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                                <i class="lock icon"></i>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                        <button class="ui small fluid blue submit button">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>