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
	</div>
	<div class="container">
		<div class="ui segment">
			{!! $content !!}
		</div>
	</div>
</div>

{!! $HTMLfooter !!}