<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:users-read'])->only('index');
        $this->middleware(['permission:users-create'])->only('store');
        $this->middleware(['permission:users-update'])->only('update');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           $users=User::whereRoleIs('admin')->get();
        return  view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
         echo "Loading...";
       $user=User::create($request->except('password')+['password'=>Hash::make($request->password)]);
        $user->attachRole('admin');
         if(!empty($request->permissions)){
             $user->syncPermissions($request->permissions);
         }
        return  redirect()->back()->withSuccess('User Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
//        chk if the request is ajax
       if ($request->ajax()){
//           find user and return him to front-end
           $user=User::find($request->id)->load('permissions');
           return $user? response()->json([$user]):response()->json(['error'=>'something wrong']);
       }
       return  abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request,User $user)
    {
//        chk f password filled f true hash it
        $hashPass=$request->filled('password')?['password'=>Hash::make($request->password)]:[];
 //        f every thing is ok update user
        $user->update($request->except(['password'])+$hashPass);
             $user->syncPermissions($request->permissions);
         return redirect()->back()->withSuccess('User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //delete user
        $user->delete();
        return back()->withSuccess('User deleted successfully.');
    }
    public function export($format)
    {
         return Excel::download(new UsersExport,"users.$format");
    }
}

