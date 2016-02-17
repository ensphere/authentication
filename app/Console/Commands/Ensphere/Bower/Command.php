<?php namespace Ensphere\Authentication\Console\Commands\Ensphere\Bower;

use Illuminate\Console\Command as IlluminateCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Command extends IlluminateCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ensphere:bower';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Compacts Bower Components.';

	/**
	 * [$writePath description]
	 * @var null
	 */
	private $writePath = 'resources/views/';

	/**
	 * [$order description]
	 * @var [type]
	 */
	private $order = [];

	/**
	 * [$ordered description]
	 * @var [type]
	 */
	private $ordered = [];

	/**
	 * [$satisfield description]
	 * @var integer
	 */
	private $satisfield = 0;

	/**
	 * [$bowers description]
	 * @var [type]
	 */
	private $bowers = [];

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->writePath = base_path($this->writePath);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		if( file_exists( public_path( 'package' ) ) ) {
			$it = new RecursiveDirectoryIterator( public_path( 'package' ) );
			foreach( new RecursiveIteratorIterator( $it ) as $file ) {
				if( $file->getFilename() === 'assets.json' ) {
					$packages = $this->getPackages( $file->getPath() );
					foreach( $packages as $name => $packageData ) {
						$this->bowers[] = new Bower( $name, $packageData );
					}
				}
			}
		}
		// Order the array by dependencies
		$this->order();
		// Generate the blade template
		$this->generateTemplate();
		$this->info('HTTP snippets generated!');
	}

	/**
	 * [getPackages description]
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	private function getPackages( $path ) {
		return json_decode( file_get_contents( $path . '/assets.json' ) );
	}

	/**
	 * [order description]
	 * @return [type] [description]
	 */
	private function order() {
		foreach( $this->bowers as $bower ) {
			$this->order[$bower->name()] = [
				'dependencies' => $bower->getDependencies(),
				'bower' => $bower
			];
		}
		$this->orderItems();
	}

	/**
	 * [orderItems description]
	 * @return [type] [description]
	 */
	private function orderItems(){
		while( ! empty( $this->order ) ) {
			$item = array_splice( $this->order, 0, 1 );
			$data = end( $item );
			$name = key( $item );
			if( empty( $data['dependencies'] ) ) {
				$this->ordered[$name] = $data;
			} else {
				$satisafied = true;
				foreach( $data['dependencies'] as $dependency ) {
					if( isset( $this->order[$dependency] ) ) $satisafied = false;
				}
				if( $satisafied ) {
					$this->ordered[$name] = $data;
				} else {
					$this->order = $this->order + $item;
				}
			}
		}
	}

	/**
	 * [assetLoaderTemplate description]
	 * @param  [type] $jsFiles  [description]
	 * @param  [type] $cssFiles [description]
	 * @return [type]           [description]
	 */
	public static function assetLoaderTemplate( $jsFiles, $cssFiles ) {

		$cssFileAsString = "'" . implode( "','", $cssFiles ) . "'";
		$jsFilesAsString = "'" . implode( "','", $jsFiles ) . "'";

		return "
		<script>
			var styles = [{$cssFileAsString}];
			var scripts = [{$jsFilesAsString}];
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
		";

	}

	/**
	 * [generateTemplate description]
	 * @return [type] [description]
	 */
	private function generateTemplate()
	{
		$js = $this->getJavascriptFiles() + $this->getModuleJsFiles();
		$css = $this->getStyleFiles() + $this->getModuleCssFiles();
		file_put_contents( $this->writePath . 'loader.blade.php', self::assetLoaderTemplate( $js, $css ) );
	}

	/**
	 * [getModuleJsFiles description]
	 * @return [type] [description]
	 */
	protected function getModuleJsFiles()
	{
		$files = array();
		if( file_exists( public_path( 'package' ) ) ) {
			$it = new RecursiveDirectoryIterator( public_path( 'package' ) );
			foreach( new RecursiveIteratorIterator( $it ) as $file ) {
				if( $file->getExtension() === 'js' ) {
					$files[] = str_replace( public_path(), '', $file->getPathname() );
				}
			}
		}
		return $files;
	}

	/**
	 * [getModuleCssFiles description]
	 * @return [type] [description]
	 */
	protected function getModuleCssFiles()
	{
		$files = array();
		if( file_exists( public_path( 'package' ) ) ) {
			$it = new RecursiveDirectoryIterator( public_path( 'package' ) );
			foreach( new RecursiveIteratorIterator( $it ) as $file ) {
				if( $file->getExtension() === 'css' ) {
					$files[] = str_replace( public_path(), '', $file->getPathname() );
				}
			}
		}
		return $files;
	}

	/**
	 * [getJavascriptFiles description]
	 * @return [type] [description]
	 */
	private function getJavascriptFiles() {
		$files = [];
		foreach( $this->ordered as $data ) {
			$bower = $data['bower'];
			$files = array_merge( $files, $bower->getJavascriptFiles() );
		}
		return $files;
	}

	/**
	 * [getStyleFiles description]
	 * @return [type] [description]
	 */
	private function getStyleFiles() {
		$files = [];
		foreach( $this->ordered as $data ) {
			$bower = $data['bower'];
			$files = array_merge( $files, $bower->getStyleFiles() );
		}
		return $files;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
		return [
			['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
