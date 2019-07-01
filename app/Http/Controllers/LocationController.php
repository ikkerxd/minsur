<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:locations.create')->only(['create', 'store']);
        $this->middleware('permission:locations.index')->only('index');
        $this->middleware('permission:locations.edit')->only(['edit', 'update']);
        $this->middleware('permission:locations.show')->only('show');
        $this->middleware('permission:locations.destroy')->only('destroy');
    }
    
    public function index()
    {
        $locations = Location::paginate();
        return view('locations.index',compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $location = new Location;
        $location->name = $request->name;       
        $location->state = 0;
        $location->save();

        return redirect()->route('locations.index')->with('success','El tipo de curso fue registrada');
    }

    public function show(Location $location)
    {
        return view('locations.show',compact('location'));
    }

    
    public function edit(Location $location)
    {        
        return view('locations.edit',compact('location'));
    }

    
    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        $location->name= $request->name;         
        $location->save();

        return redirect()->route('locations.index')->with('success','El tipo de curso fue actualizada');
    }

    
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {            
            $location = \App\Location::find($id);
            $location->delete();  
            return response()->json([                
                'success'   => $location->name.' fue eliminado.',
            ]);          
        }
    }
}
