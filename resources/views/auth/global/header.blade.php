
<div id="wrapper">

	<nav class="navbar-default navbar-static-side" role="natigation">
		@if( Auth::user() )
			<div id="user-block">
				<img class="gravatar" src="{!! 'http://www.gravatar.com/avatar/' . md5( Auth::user()->email) . '?s=220&d=%2package%2ensphere%2backbone%2images%2gravatar.png' !!}" />
			</div>
		@endif
	</nav>

	<div id="page-wrapper" class="gray-bg dashbard-1">

		<div class="row border-bottom">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								@if( Auth::user() )
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{!! Auth::user()->email  !!} <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Action</a></li>
										<li><a href="#">Another action</a></li>
										<li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li><a href="{!! route( 'get.logout' ) !!}">Logout</a></li>
									</ul>
								@endif
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>

		<div id="content" class="clearfix">

			@if (count($errors) > 0)
				<div class="col-sm-12">
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endif
			@if( session()->has('success') )
				<div class="col-sm-12">
					<div class="alert alert-success">
						{!! session('success') !!}
					</div>
				</div>
			@endif
