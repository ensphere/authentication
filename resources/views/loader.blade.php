
		<script>
			var styles = ['/vendor/semantic-ui/dist/semantic.min.css','/package/ensphere/authentication/css/authentication.css'];
			var scripts = ['/vendor/jquery/dist/jquery.min.js','/vendor/semantic-ui/dist/semantic.min.js','/package/ensphere/authentication/js/authentication.js'];
			var cb = function() {
				window.loadStyles = function() {
					var href = styles.shift(); var h = document.getElementsByTagName('head')[0]; var l = document.createElement('link');
					l.rel = 'stylesheet'; l.href = href;l.onload = function(){if( styles.length !== 0 ){window.loadStyles();}};h.appendChild(l);
				};
				window.loadScripts = function( _callback ) {
					var callback = _callback || function(){};
					var src = scripts.shift(); var h = document.getElementsByTagName('head')[0]; var html = document.getElementsByTagName('html')[0]; var l = document.createElement('script');
					l.rel = 'text/javascript'; l.src = src;
					l.onload = function(){if( scripts.length !== 0 ) {window.loadScripts( _callback );} else {html.className += ' loaded';callback();}};h.appendChild(l);
				};
				window.loadStyles();
				window.loadScripts(function(){ if( document.body ) $(document).trigger('ready'); if( document.readyState == 'complete' ) $(window).trigger('load'); });
			};
			var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
			if (raf) raf(cb);
			else window.addEventListener('load', cb);
		</script>
		