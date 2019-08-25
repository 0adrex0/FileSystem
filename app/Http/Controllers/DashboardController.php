<?php

namespace App\Http\Controllers;

use App\Http\Traits\UserProvider;
use Illuminate\Http\Request;
use App\User;
class DashboardController extends Controller
{
    use UserProvider;
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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $data = [
            'files' => $user->files,
            'user' => $user
        ];
        return view('dashboard')->with($data);
    }
}
