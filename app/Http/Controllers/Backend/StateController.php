<?php

namespace App\Http\Controllers\Backend;

use App\Exports\StateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StateStore;
use App\Http\Requests\StateUpdate;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:states-read'])->only('index');
        $this->middleware(['permission:states-create'])->only('store');
        $this->middleware(['permission:states-update'])->only('update');
        $this->middleware(['permission:states-delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states=State::with(['country'])->get();
        $countries=Country::all();
        return view('states.index',compact('states','countries'));
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
    public function store(StateStore $request)
    {
            echo "Loading...";
            State::create($request->validated());
            return  redirect()->back()->withSuccess('State Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if($request->ajax()){
            $state=State::where('country_id',$id)->get();
            return response()->json([$state]);
        }
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
            $state=State::find($request->id);
            return $state? response()->json([$state]):response()->json(['error'=>'something wrong']);
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
    public function update(StateUpdate $request, State $state)
    {
         $state->update($request->validated());
         return back()->withSuccess('State updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();
        return back()->withSuccess('State Deleted successfully.');
    }
    public function export($format)
    {
        return Excel::download(new StateExport,"states.$format");
    }
}
