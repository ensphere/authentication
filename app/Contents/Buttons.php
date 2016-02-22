<?php namespace Ensphere\Authentication\Contents;

use Ensphere\Container\Content;
use Illuminate\Http\Request;

class Buttons extends Content {

	/**
	 * the view to be rendered in said area
	 * @var string
	 */
	protected $view = 'ensphere.auth::contents.dashboard-top-bar';

	/**
	 * Validates pass instance of Validator back to the container to validate this section.
	 * @param  Request $request - Illuminate\Http\Request
	 * @return Instance of Illuminate\Contracts\Validation\Validator
	 */
	public function validate( Request $request  )
	{

	}

	/**
	 * called once all validation has passed from other areas.
	 * @param  Request $request - Illuminate\Http\Request
	 * @return NULL
	 */
	public function process( Request $request )
	{

	}

}