<?php

namespace App\Http\Controllers\Backend;

use App\Exports\DepartmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStore;
use App\Http\Requests\DepartmentUpdate;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:departments-read'])->only('index');
        $this->middleware(['permission:departments-create'])->only('store');
        $this->middleware(['permission:departments-update'])->only('update');
        $this->middleware(['permission:departments-delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments=Department::all();
         return  view('departments.index',compact('departments'));
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
    public function store(DepartmentStore $request)
    {
        echo "Loading...";
        Department::create($request->validated());
        return  redirect()->back()->withSuccess('Department Added Successfully.');
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
    public function edit(Request $request)
    {
        //        chk if the request is ajax
        if ($request->ajax()){
//           find user and return him to front-end
            $departments=Department::find($request->id);
            return $departments? response()->json([$departments]):response()->json(['error'=>'something wrong']);
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
    public function update(DepartmentUpdate $request, Department $department)
    {
        $department->update($request->validated());
        return back()->withSuccess('Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return back()->withSuccess('Department Deleted successfully.');
    }
    public function export($format)
    {
        return Excel::download(new DepartmentExport ,"departments.$format");
    }
}
