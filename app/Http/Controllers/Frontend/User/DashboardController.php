<?php

namespace App\Http\Controllers\Frontend\User;

use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        \Auth::logout();
        return redirect()->back();
        //return view('frontend.user.dashboard');
    }
}
