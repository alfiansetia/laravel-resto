<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }


    public function profile()
    {
        return view('user.profile')->with('comp', $this->comp);
    }

    public function profileUpdate(Request $request)
    {

        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'wa'        => 'required|max:15|min:8',
            'address'   => 'max:150',
        ]);

        $update = Auth::user()->update([
            'name'      => $request->name,
            'wa'        => $request->wa,
            'address'   => $request->address,
        ]);
        if ($update) {
            return redirect()->route('user.profile')->with('success', 'Profile Updated!');
        } else {
            return redirect()->route('user.profile')->with('error', 'Profile not Updated!');
        }
    }
}
