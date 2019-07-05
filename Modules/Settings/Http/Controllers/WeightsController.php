<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Modules\Settings\Entities\Weight;
use Illuminate\Http\Request;
use Gate;

class WeightsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(Gate::allows('superadmin'))
        {
   
        }
        else{
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return redirect('/login');
       /* $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $weights = Weight::where('value', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $weights = Weight::latest()->paginate($perPage);
        }

        return view('admin.weights.index', compact('weights'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
     return view('admin.weights.create');
     
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
       
          $requestData = $request->all();
        
        Weight::create($requestData);

        return redirect('admin/settings')->with('flash_message', 'Weight added!');
       
        
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
      
   $weight = Weight::findOrFail($id);

        return view('admin.weights.show', compact('weight'));
      
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
       
           $weight = Weight::findOrFail($id);

        return view('admin.weights.edit', compact('weight'));
       

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
            
             $requestData = $request->all();
        
        $weight = Weight::findOrFail($id);
        $weight->update($requestData);

        return redirect('admin/weights')->with('flash_message', 'Weight updated!');
   
       
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
      
           Weight::destroy($id);

        return redirect('admin/settings')->with('flash_message', 'Weight deleted!');
     

    }
}
