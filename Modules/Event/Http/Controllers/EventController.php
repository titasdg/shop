<?php

namespace Modules\Event\Http\Controllers;

use Modules\Event\Entities\EventPhoto;
use Modules\Event\Entities\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use File;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            $event = Event::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('date', 'LIKE', "%$keyword%")
                ->orWhere('time', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $event = Event::latest()->paginate($perPage);
        }

        return view('admin.event.index', compact('event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    /*public function store(Request $request)
    {

        $requestData = $request->all();

        Event::create($requestData);

        return redirect('admin/event')->with('flash_message', 'Event added!');
    }*/
    public function store(Request $request)
    {

        $event=Event::create([
            'title' => request('title'),
            'content' => request('content'),
            'date' => request('date'),
            'time' => request('time')
        ]);
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo){
                $filename = $photo->store('uploads', 'public');
            EventPhoto::create([
                        'event_id' => $event->id,
                        'image' => $filename
                    ]);

            }
           
        }

       
        return redirect('admin/event')->with('flash_message', 'Event added!');
    
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
        $event = Event::findOrFail($id);

        return view('admin.event.show', compact('event'));
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
        $event = Event::findOrFail($id);
        $eventPhoto = EventPhoto::where('event_id','LIKE',$id)->get();
        return view('admin.event.edit', compact(['event','eventPhoto']));
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

        

        $event = Event::findOrFail($id);
        $event->update([
            'title' => request('title'),
            'content' => request('content'),
            'date' => request('date'),
            'time' => request('time')
        ]);
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo){
                $filename = $photo->store('uploads', 'public');
            EventPhoto::create([
                        'event_id' => $event->id,
                        'image' => $filename
                    ]);

            }
           
        }

        return redirect('admin/event')->with('flash_message', 'Event updated!');


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
        Event::destroy($id);

        $eventPhoto=EventPhoto::where('event_id','LIKE',$id)->get();
        
        if($eventPhoto!=null)
        { 
            
            foreach($eventPhoto as $photo)
            {
                File::delete('storage/'.$photo->image); 
              EventPhoto::destroy($photo->id);
            }
             
        }


        return redirect('admin/event')->with('flash_message', 'Event deleted!');
    }
    public function destroyPhoto($event_id,$id)
    {
        
        $eventPhoto=EventPhoto::where('id','LIKE',$id)->get();
        
        if($eventPhoto!=null)
        {
           File::delete('storage/'.$eventPhoto[0]->image); 
           EventPhoto::destroy($id);
        }
        
        return redirect('admin/event/'.$event_id.'/edit');
    }
}
