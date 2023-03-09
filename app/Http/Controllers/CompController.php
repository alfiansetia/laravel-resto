<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $this->validate($request, [
            'name'      => 'required|max:30',
            'slogan'    => 'required|max:200',
            'telp'      => 'required|max:15',
            'logo'      => 'image|mimes:jpeg,png,jpg|max:2048',
            'fav'       => 'image|mimes:png,jpg|max:1024',
            'wa'        => 'required|max:15',
            'fb'        => 'max:30|nullable',
            'ig'        => 'max:30|nullable',
            'address'   => 'required|max:200',
        ]);
        $comp = $this->comp;

        $logo = $comp->logo;
        $fav = $comp->fav;
        if ($files = $request->file('logo')) {
            //delete old file
            File::delete('images/company/' . $logo);
            //insert new file
            $destinationPath = 'images/company/'; // upload path
            $logo = 'logo.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $logo);
        }

        if ($files = $request->file('fav')) {
            //delete old file
            File::delete('images/company/' . $fav);
            //insert new file
            $destinationPath = 'images/company/'; // upload path
            $fav = 'favicon.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fav);
        }

        $comp->update([
            'name'      => $request->name,
            'slogan'    => $request->slogan,
            'telp'      => $request->telp,
            'logo'      => $logo,
            'fav'       => $fav,
            'wa'        => $request->wa,
            'fb'        => $request->fb,
            'ig'        => $request->ig,
            'address'   => $request->address,
        ]);
        if ($comp) {
            return redirect()->route('company.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('company.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
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
