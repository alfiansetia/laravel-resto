<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $comp;

    public function __construct()
    {
        $this->middleware('auth');
        $this->comp = Comp::first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with('comp', $this->comp);
    }
}
