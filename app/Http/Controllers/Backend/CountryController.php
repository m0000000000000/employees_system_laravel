<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CountriesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryStore;
use App\Http\Requests\CountryUpdate;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:countries-read'])->only('index');
        $this->middleware(['permission:countries-create'])->only('store');
        $this->middleware(['permission:countries-update'])->only('update');
        $this->middleware(['permission:countries-delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=Country::all();
        return view('countries.index',compact('countries'));
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
    public function store(CountryStore $request)
    {
        echo "Loading...";
        Country::create($request->validated());
        return  redirect()->back()->withSuccess('State Added Successfully.');
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
//        chk if the request is ajax
        if ($request->ajax()){
//           find user and return him to front-end
            $country=Country::find($request->id);
            return $country? response()->json([$country]):response()->json(['error'=>'something wrong']);
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
    public function update(CountryUpdate $request, Country $country)
    {
//        f every thing is ok update user
        $country->update($request->validated());
        return redirect()->back()->withSuccess('Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //delete country
        $country->delete();
        return back()->withSuccess('Country deleted successfully.');
    }
    public function export($format)
    {
        return Excel::download(new CountriesExport,"countries.$format");
    }
}
