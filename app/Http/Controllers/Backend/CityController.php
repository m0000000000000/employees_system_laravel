<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CityExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CityStore;
use App\Http\Requests\CityUpdate;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:cities-read'])->only('index');
        $this->middleware(['permission:cities-create'])->only('store');
        $this->middleware(['permission:cities-update'])->only('update');
        $this->middleware(['permission:cities-delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities=City::with('state')->get();
        $states=State::all();
        return view('cities.index',compact('cities','states'));
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
    public function store(CityStore $request)
    {
        echo "Loading...";
        City::create($request->validated());
        return  redirect()->back()->withSuccess('City Added Successfully.');
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
            $city=City::where('state_id',$id)->get();
            return response()->json([$city]);
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
            $cities=City::find($request->id);
            return $cities? response()->json([$cities]):response()->json(['error'=>'something wrong']);
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
    public function update(CityUpdate $request, City $city)
    {
        $city->update($request->validated());
        return back()->withSuccess('City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return back()->withSuccess('City Deleted successfully.');
    }
    public function export($format)
    {
        return Excel::download(new CityExport,"cities.$format");
    }
}
