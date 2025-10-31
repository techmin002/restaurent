<?php

namespace Modules\User\Http\Controllers;

use Modules\User\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Branch\Entities\Branch;
use Modules\Restaurent\Models\Employee;
use Modules\Restaurent\Models\Restaurent;
use Modules\Upload\Entities\Upload;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('access_user_management'), 403);
        if (auth()->user()->role() == 'Super Admin') {
            $users = User::latest()->get();
        } else {
            $users = User::where('restaurent_id', auth()->user()->restaurent_id)->latest()->get();
        }
        return view('user::users.index', compact("users"));
    }


    public function create()
    {
        abort_if(Gate::denies('access_user_management'), 403);
        $restaurents = Restaurent::where('status', 'on')->get();
        return view('user::users.create', compact('restaurents'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'branch_id' => 'required'
        ]);

        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/users'), $imageName);
        }
        $role = Role::where('name', $request->role)->first();
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'access_type'    => $request->role,
            'branch_id'    => $request->branch_id,
            'created_by'    => $request->created_by,
            'user_type'    => $request->user_type,
            'password' => Hash::make($request->password),
            'image'    => $imageName,
            'role_id'    => $role->id,
            'status' => $request->status
        ]);

        $user->assignRole($request->role);
         $employee = new Employee();
        $employee->name = $request['admin_name'];
        $employee->email = $request['admin_email'];
        $employee->phone = $request['admin_phone'];
        $employee->address = $request['admin_address'];
        $employee->role = $role->name;
        $employee->restaurent_id = auth()->user()->restaurent_id;
        $employee->created_by = auth()->user()->id;
        $employee->user_id = $user->id;
        $employee->status = $request['status'] ?? 'on';
        $employee->save();
        return redirect()->route('users.index')->with('success', 'Created Successfully');
    }


    public function edit(User $user)
    {
        abort_if(Gate::denies('access_user_management'), 403);
        $branches = Branch::where('status', 'on')->get();
        return view('user::users.edit', compact('user', 'branches'));
    }


    public function update(Request $request, User $user)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        if ($request->password) {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
                'password' => 'string|min:8|max:255|confirmed'
            ]);
        } else {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            ]);
        }

        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/users'), $imageName);
        } else {
            $imageName = $user->image;
        }
        $role_id = Role::where('name', $request->role)->first();
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'branch_id'    => $request->branch_id,
            'role_id' => $role_id->id,
            'status' => $request->status
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Updated Successfully');
    }


    public function destroy(User $user)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Removed Successfully');
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_user_management'), 403);
        $user = User::findOrfail($id);
        if ($user->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $user->update([
            'status' => $status
        ]);
        return redirect()->route('users.index')->with('success', 'Status Updated Successfully');
    }
}
