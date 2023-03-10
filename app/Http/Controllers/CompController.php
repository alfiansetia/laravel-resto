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
        $comp = $this->comp;
        if ($request->has('type') && $request->type == 'general') {
            $this->validate($request, [
                'name'      => 'required|max:30',
                'telp'      => 'required|max:15',
                'address'   => 'required|max:200',
            ]);
            $comp->update([
                'name'      => $request->name,
                'telp'      => $request->telp,
                'address'   => $request->address,
            ]);
        } elseif ($request->has('type') && $request->type == 'image') {
            $this->validate($request, [
                'logo'      => 'image|mimes:jpeg,png,jpg|max:2048',
                'fav'       => 'image|mimes:png,jpg|max:1024',
            ]);
            $logo = $comp->logo;
            $fav = $comp->fav;
            if ($files = $request->file('logo')) {
                File::delete('images/company/' . $logo);
                $destinationPath = 'images/company/'; // upload path
                $logo = 'logo.' . $files->getClientOriginalExtension();
                $files->move($destinationPath, $logo);
            }
            if ($files = $request->file('fav')) {
                File::delete('images/company/' . $fav);
                $destinationPath = 'images/company/'; // upload path
                $fav = 'favicon.' . $files->getClientOriginalExtension();
                $files->move($destinationPath, $fav);
            }
            $comp->update([
                'logo'      => $logo,
                'fav'       => $fav,
            ]);
        } elseif ($request->has('type') && $request->type == 'social') {
            $this->validate($request, [
                'wa'        => 'required|max:15',
                'fb'        => 'max:30|nullable',
                'ig'        => 'max:30|nullable',
            ]);
            $comp->update([
                'wa'        => $request->wa,
                'fb'        => $request->fb,
                'ig'        => $request->ig,
            ]);
        } elseif ($request->has('type') && $request->type == 'other') {
            $this->validate($request, [
                'footer_struk'  => 'required|max:100',
                'tax'           => 'required|in:yes,no',
            ]);
            $comp->update([
                'footer_struk'  => $request->footer_struk,
                'tax'           => $request->tax,
            ]);
        } else {
            abort(404);
        }
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
