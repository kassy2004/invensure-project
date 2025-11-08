<?php

namespace App\Http\Controllers;

use App\Exports\AuditExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $usersRole = DB::table('users')->where('role', 'pending')->get();

        $auditJson = $audit->toJson();
        return view('user', compact('audit', 'users', 'usersRole'));
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

    public function exportAudits()
    {
        return Excel::download(new AuditExport, 'audit-logs.xlsx');

    }
    public function destroy($id)
    {
        // dd($id);
        $users = DB::table('users')->where('id', $id)->delete();
        if (!$users) {
            return redirect()->back()->with('error', 'User not found.');
        }
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function edit($id)
    {
        // dd($id);
        $users = DB::table('users')->where('id', $id)->first();
        
        return view('components.user.edit', compact('users'));
        // return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string',
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'updated_at' => now(), // optional
            ]);

        return redirect()->route('users')
            ->with('success', 'User updated successfully!');
    }
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,customer,logistics_coordinator,inventory_manager'
        ]);
        DB::table('users')
            ->where('id', $id)
            ->update([
                'role' => $request->role,
                'updated_at' => now() // optional, keep timestamps updated
            ]);
        return redirect()->back()->with('success', 'User role assigned successfully!');
    }
}
