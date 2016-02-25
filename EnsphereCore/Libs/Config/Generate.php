<?php namespace EnsphereCore\Libs\Config;

class Generate {

	/**
	 * [providers description]
	 * @param  [type] $laravelProviders [description]
	 * @param  array  $appProviders     [description]
	 * @return [type]                   [description]
	 */
	public static function providers( $laravelProviders, $appProviders = array() ) {
		$packageProviders = array();
		$path = base_path('config/packages.json');
		if( file_exists( $path ) ) {
			$data = json_decode( file_get_contents( $path ) );
			if( isset( $data->providers ) ) {
				$packageProviders = $data->providers;
			}
		}
		$array = array_unique( array_merge( $laravelProviders, $packageProviders, $appProviders ) );
		return $array;
	}

	/**
	 * [aliases description]
	 * @param  array  $appAliases [description]
	 * @return [type]             [description]
	 */
	public static function aliases( $appAliases = array() ) {
		$packageAliases = array();
		$path = base_path('config/packages.json');
		if( file_exists( $path ) ) {
			$data = json_decode( file_get_contents( $path ) );
			if( isset( $data->aliases ) ) {
				$packageAliases = (array)$data->aliases;
			}
		}
		$array = array_unique( array_merge( $packageAliases, $appAliases ) );
		return $array;
	}

}