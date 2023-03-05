<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\Request;

class CompController extends Controller
{

    protected $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.data')->with(['comp' => $this->comp, 'title' => 'Setting Company']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comp  $comp
     * @return \Illuminate\Http\Response
     */
    public function show(Comp $comp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comp  $comp
     * @return \Illuminate\Http\Response
     */
    public function edit(Comp $comp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comp  $comp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comp $comp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comp  $comp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comp $comp)
    {
        //
    }
}
