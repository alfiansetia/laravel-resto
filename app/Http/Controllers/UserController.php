<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }


    public function profile()
    {
        return view('user.profile')->with(['comp' => $this->comp, 'title' => 'User Profile']);
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
            return redirect()->route('user.profile')->with('success', 'Success Update Profile!');
        } else {
            return redirect()->route('user.profile')->with('error', 'Failed Update Profile!');
        }
    }

    public function password()
    {
        return view('user.password')->with(['comp' => $this->comp, 'title' => 'Change Password']);
    }

    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'password'  => ['required', 'same:password2', Password::min(8)->numbers()],
            'password2' => 'required',
        ]);
        if (Hash::check($request->password, $user->password)) {
            return redirect()->route('user.password')->with(['error' => "Password can't be the same as before!"]);
        } else {
            $password = $user->update([
                'password'     => Hash::make($request->password),
            ]);
            if ($password) {
                return redirect()->route('user.password')->with(['success' => 'Success Update Password!']);
            } else {
                return redirect()->route('user.password')->with(['error' => 'Failed Update Password!']);
            }
        }
    }
}
