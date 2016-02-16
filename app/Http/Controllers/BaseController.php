<?php namespace Ensphere\Authentication\Http\Controllers;

use Session;
use Illuminate\Auth\Guard;

class BaseController extends Controller {

	/**
	 * [$layout description]
	 * @var string
	 */
	protected $layout = 'ensphere.auth::auth.global.base';

	/**
	 * [$header description]
	 * @var string
	 */
	protected $header = 'ensphere.auth::auth.global.header';

	/**
	 * [$footer description]
	 * @var string
	 */
	protected $footer = 'ensphere.auth::auth.global.footer';

	/**
	 * [$HTMLheader description]
	 * @var string
	 */
	protected $HTMLheader = 'ensphere.auth::auth.global.HTMLheader';

	/**
	 * [$HTMLfooter description]
	 * @var string
	 */
	protected $HTMLfooter = 'ensphere.auth::auth.global.HTMLfooter';

	/**
	 * [$data description]
	 * @var array
	 */
	protected $data = array();

	/**
	 * [$errors description]
	 * @var boolean
	 */
	protected $errors = false;

	/**
	 * [callAction description]
	 * @param  [type] $method     [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function callAction($method, $parameters) {
        $this->setupLayout();
        $response = call_user_func_array(array($this, $method), $parameters);
        if ( is_null($response ) && ! is_null( $this->layout ) ) {
            $response = $this->layout;
        }
        return $response;
    }

    /**
     * [setLayout description]
     * @param [type] $name [description]
     */
    protected function setLayout($name) {
        $this->layout = $name;
    }

	/**
	 * [setupLayout description]
	 * @return [type] [description]
	 */
	protected function setupLayout() {
		if ( ! is_null( $this->layout ) ) {
			$this->layout = view( $this->layout, $this->data );
		}
		$this->layout->nest( 'HTMLheader', $this->HTMLheader, array( 'header' => view( $this->header ) ) );
		$this->layout->nest( 'HTMLfooter', $this->HTMLfooter, array( 'footer' => view( $this->footer ) ) );
		if( is_null( $this->layout->content ) ) {
			$this->layout->content = '';
		}
	}


}