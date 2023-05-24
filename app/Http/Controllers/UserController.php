<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('roles')->get();
            if ($request->email) {
                $data = User::where('email', 'like', "%{$request->email}%")->get();
            }
            return DataTables::of($data)->toJson();
        }
        return view('user.data')->with(['comp' => $this->comp, 'title' => 'Data User']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:5',
            'wa'        => 'required|max:15',
            'address'   => 'max:150',
            'role'      => 'required',
        ]);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'wa'        => $request->wa,
            'address'   => $request->address,
        ]);
        $user->assignRole($request->role);
        if ($user) {
            return response()->json(['status' => true, 'message' => 'Success Insert Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Insert Data', 'data' => '']);
        }
    }

    public function edit(Request $request, User $user)
    {
        if ($request->ajax()) {
            $user = User::with('roles')->find($user->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $user]);
        } else {
            abort(404);
        }
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'wa'        => 'required|max:15',
            'address'   => 'max:150',
            'role'      => 'required|in:admin,kasir',
            'password'  => 'nullable|min:5'
        ]);
        $user = User::findOrFail($user->id);
        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'wa'            => $request->wa,
            'address'       => $request->address,
        ]);
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $user->syncRoles($request->role);
        if ($user) {
            return response()->json(['status' => true, 'message' => 'Success Update Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Update Data', 'data' => '']);
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $user = User::findOrFail($id);
                    $user->delete();
                    if ($user) {
                        $counter = $counter + 1;
                    }
                }
                return response()->json(['status' => true, 'message' => 'Success Delete ' . $count . '/' . $counter . ' Data', 'data' => '']);
            } else {
                return response()->json(['status' => false, 'message' => 'No Selected Data', 'data' => '']);
            }
        } else {
            abort(404);
        }
    }

    public function profile()
    {
        return view('user.profile')->with(['comp' => $this->comp, 'title' => 'Profile Setting']);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'wa'        => 'required|max:15|min:8',
            'address'   => 'max:150',
        ]);
        $update = $user->update([
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
        return view('user.password')->with(['comp' => $this->comp, 'title' => 'Password Setting']);
    }

    public function passwordUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $this->validate($request, [
            'password'  => ['required', 'same:password2', Password::min(8)->numbers()],
            'password2' => 'required',
        ]);
        if (Hash::check($request->password, $user->password)) {
            return redirect()->route('user.password')->with(['error' => "Password tidak boleh sama dengan sebelumnya!"]);
        } else {
            $password = $user->update([
                'password'     => Hash::make($request->password),
            ]);
            if ($password) {
                return redirect()->route('user.profile')->with(['success' => 'Success Update Password!']);
            } else {
                return redirect()->route('user.profile')->with(['error' => 'Failed Update Password!']);
            }
        }
    }
}
