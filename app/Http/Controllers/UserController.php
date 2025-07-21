<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $audit = DB::table('audits')
            ->leftJoin('users', function ($join) {
                $join->on('audits.user_id', '=', 'users.id')
                    ->where('audits.user_type', '=', \App\Models\User::class);
            })
            ->select('audits.*', 'users.name as user_name', 'users.role as user_role')
            ->orderBy('audits.created_at', 'desc')
            ->get();
        // dd($audit);

        $users = DB::table('users')->get();

        $auditJson = $audit->toJson();
        return view('user', compact('audit', 'users'));
    }


    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = Auth::user();


        \OwenIt\Auditing\Models\Audit::create([
            'user_type' => get_class($user),
            'user_id' => $user->id,
            'event' => 'User added: ' . $validated['email'] . ' (' . $validated['role'] . ')',
            'auditable_type' => get_class($user),
            'auditable_id' => $user->id,
            'old_values' => [],
            'new_values' => ['status' => 'User logged in'],
            'url' => url()->current(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);


        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'User successfully added.');
    }
}
