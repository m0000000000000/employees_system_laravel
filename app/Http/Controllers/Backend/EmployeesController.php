<?php

namespace App\Http\Controllers\Backend;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStore;
use App\Http\Requests\EmployeeUpdate;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:employees-read'])->only('index');
        $this->middleware(['permission:employees-create'])->only('store');
        $this->middleware(['permission:employees-update'])->only('update');
        $this->middleware(['permission:employees-delete'])->only('destroy');
    }
    /**e
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employee::with(['department','country'])->get();
        $countries=Country::get(['name','id']);
        $states=State::get(['name','id']);
        $cities=City::get(['name','id']);
        $departments=Department::get(['name','id']);
        return view('employees.index',compact('employees','countries','states','cities','departments') );
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
    public function store(EmployeeStore $request)
    {
         echo "Loading...";
        Employee::create($request->all());
        return  redirect()->back()->withSuccess('Employee Added Successfully.');
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
            $employee=Employee::find($request->id);
            $employee['states']=State::where('country_id',$employee->country_id)->get();
            $employee['cities']=City::where('state_id',$employee->state_id)->get();
            return $employee? response()->json([$employee]):response()->json(['error'=>'something wrong']);
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
    public function update(EmployeeUpdate $request, Employee $employee)
    {
        $employee->update($request->validated());
        return  redirect()->back()->withSuccess('Employee Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return  redirect()->back()->withSuccess('Employee Deleted Successfully.');
    }
    public function export($format)
    {
        return Excel::download(new EmployeeExport,"employees.$format");
    }
}
