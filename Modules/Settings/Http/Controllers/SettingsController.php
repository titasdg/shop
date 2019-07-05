<?php

namespace Modules\Settings\Http\Controllers;

use Modules\Settings\Entities\Weight;
use Modules\Settings\Entities\Shipping;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Settings;
use Gate;



class SettingsController extends Controller
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
         if(Gate::allows('superadmin'))
        {
   
        }
        else{
            return redirect('/login');
        }
        $keyword = $request->get('search');
        $perPage = 25;
        $weights = Weight::orderBy('value')->get();
        $shipping = Shipping::all();

        if (!empty($keyword)) {
            $settings = Settings::where('title', 'LIKE', "%$keyword%")
                ->orWhere('value', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $settings = Settings::latest()->paginate($perPage);
        }

        return view('admin.settings.index')->
        with('settings', $settings )->
        with('weights' ,$weights )->
        with('shipping' ,$shipping );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.settings.create');
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

        Settings::create($requestData);

        return redirect('admin/settings')->with('flash_message', 'Setting added!');
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
        $setting = Settings::findOrFail($id);

        return view('admin.settings.show', compact('setting'));
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
        $setting = Settings::findOrFail($id);

        return view('admin.settings.edit', compact('setting'));
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

        $setting = Settings::findOrFail($id);
        $setting->update($requestData);

        return redirect('admin/settings')->with('flash_message', 'Setting updated!');
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
        Settings::destroy($id);

        return redirect('admin/settings')->with('flash_message', 'Setting deleted!');
    }
}
