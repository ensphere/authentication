<?php

namespace Ensphere\Authentication\Http\Controllers;

use Ensphere\Authentication\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class DashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( Application $app )
    {
        $this->middleware('auth');
        $this->container = $app['ensphere.container'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->render();
        $this->share( 'dashboardRightLeft',  $this->container->render( 'dashboard-right-left' ) );
        $this->share( 'dashboardRightRight',  $this->container->render( 'dashboard-right-right' ) );
        $this->layout->content = view( 'ensphere.auth::dashboard.dashboard' );
    }

    /**
     * [postToIndex description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postToIndex( Request $request )
    {
        $this->container->process( $request );
        return back()->with([ 'success' => 'Successfully updated' ]);
    }

    /**
     * [render description]
     * @return [type] [description]
     */
    public function render()
    {
        $this->share( 'dashboardTopbar',  $this->container->render( 'dashboard-top-bar' ) );
        $this->share( 'dashboardLeft',  $this->container->render( 'dashboard-left' ) );
    }
}
