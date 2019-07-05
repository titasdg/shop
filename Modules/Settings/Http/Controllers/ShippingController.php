<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Modules\Settings\Entities\Shipping;
use Illuminate\Http\Request;
use Gate;

class ShippingController extends Controller
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
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $shipping = Shipping::where('title', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('days', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $shipping = Shipping::latest()->paginate($perPage);
        }

        return view('admin.shipping.index', compact('shipping'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shipping.create');
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
        
        Shipping::create($requestData);

        return redirect('/settings')->with('flash_message', 'Shipping added!');
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
       
        $shipping = Shipping::findOrFail($id);

        return view('admin.shipping.show', compact('shipping'));
     
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
        
          $shipping = Shipping::findOrFail($id);

        return view('admin.shipping.edit', compact('shipping'));
       
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
        if(Gate::allows('superadmin'))
        {
     $requestData = $request->all();
        
        $shipping = Shipping::findOrFail($id);
        $shipping->update($requestData);

        return redirect('admin/settings')->with('flash_message', 'Shipping updated!');
        }
        else{
            return redirect('/login');
        }
        
      
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
        Shipping::destroy($id);

        return redirect('admin/shipping')->with('flash_message', 'Shipping deleted!');
    }
}
