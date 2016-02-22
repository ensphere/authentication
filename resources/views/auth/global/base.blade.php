{!! $HTMLheader !!}

<div class="wrapper">
	<div class="side-bar">
		<h2 class="ui header">
			<img src="{!! 'http://www.gravatar.com/avatar/' . md5( Auth::user()->email) . '?s=100&d=%2package%2ensphere%2backbone%2images%2gravatar.png' !!}" class="ui circular image">
			<div class="content">
				{!! Auth::user()->name !!}
				<div class="sub header">Web Developer</div>
			</div>
		</h2>
		{!! LukeSnowden\Menu\Menu::render( 'main', [ 'class' => 'ui vertical fluid blue menu' ], 'div' ) !!}
		{!! $dashboardLeft !!}
	</div>
	<div class="container">
		<div class="ui segment">
			@if( ! $errors->isEmpty() )
				<div class="ui error message">
					<div class="header">There was some errors with your submission</div>
					<ul class="list">
						@foreach( $errors->all() as $error )
							<li>{!! $error !!}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<form method="post">
				{!! csrf_field() !!}
				{!! $content !!}
			</form>
		</div>
	</div>
</div>

{!! $HTMLfooter !!}