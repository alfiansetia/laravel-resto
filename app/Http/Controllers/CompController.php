<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        $title = 'General Setting';
        if ($request->has('type') && $request->type == 'image') {
            $title = 'Image Setting';
        } elseif ($request->has('type') && $request->type == 'social') {
            $title = 'Social Setting';
        } elseif ($request->has('type') && $request->type == 'other') {
            $title = 'Other Setting';
        }
        return view('company.data')->with(['comp' => $this->comp, 'title' => $title]);
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
        $title = 'General Setting';
        if ($request->has('type') && $request->type == 'general') {
            $title = 'General Setting';
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:30',
                'telp'      => 'required|max:15',
                'address'   => 'required|max:200',
            ]);
            if ($validator->fails()) {
                return redirect(route('company.index') . '?type=' . $request->type)->withErrors($validator);
            }
            $comp->update([
                'name'      => $request->name,
                'telp'      => $request->telp,
                'address'   => $request->address,
            ]);
        } elseif ($request->has('type') && $request->type == 'image') {
            $title = 'Image Setting';
            $validator = Validator::make($request->all(), [
                'logo'      => 'image|mimes:jpeg,png,jpg|max:2048',
                'fav'       => 'image|mimes:png,jpg|max:1024',
            ]);
            if ($validator->fails()) {
                return redirect(route('company.index') . '?type=' . $request->type)->withErrors($validator);
            }
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
            $title = 'Social Setting';
            $validator = Validator::make($request->all(), [
                'wa'        => 'required|max:15',
                'fb'        => 'max:15|nullable',
                'ig'        => 'max:15|nullable',
            ]);
            if ($validator->fails()) {
                return redirect(route('company.index') . '?type=' . $request->type)->withErrors($validator);
            }
            $comp->update([
                'wa'        => $request->wa,
                'fb'        => $request->fb,
                'ig'        => $request->ig,
            ]);
        } elseif ($request->has('type') && $request->type == 'other') {
            $title = 'Other Setting';
            $validator = Validator::make($request->all(), [
                'footer_struk'  => 'required|max:100',
                'tax'           => 'required|in:yes,no',
            ]);
            if ($validator->fails()) {
                return redirect(route('company.index') . '?type=' . $request->type)->withErrors($validator);
            }
            $comp->update([
                'footer_struk'  => $request->footer_struk,
                'tax'           => $request->tax,
            ]);
        } else {
            abort(404);
        }
        if ($comp) {
            return redirect(route('company.index') . '?type=' . $request->type)->with(['success' => 'Data Berhasil Diupdate!', 'title' => $title]);
        } else {
            return redirect(route('company.index') . '?type=' . $request->type)->route('company.index')->with(['error' => 'Data Gagal Diupdate!', 'title' => $title]);
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
