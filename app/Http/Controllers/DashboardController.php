<?php

namespace Ensphere\Authentication\Http\Controllers;

use Ensphere\Authentication\Http\Requests;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = view('ensphere.auth::dashboard.dashboard');
    }
}
