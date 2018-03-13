<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Favourite\Favourite;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $count["users"] = User::count();
        $count["latestusers"] = User::where('status',1)->orderBy('created_at','desc')->take(10)->get();
        $count["favourite"] = Favourite::with(['user'=> function($q){
            $q->where('status',1);
        }])->orderBy('created_at','desc')->take(10)->get();
//        dd($count['latestusers']);
        return view('backend.dashboard', $count);
    }
}
