<?php

namespace Modules\Blog\Http\Controllers;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use File;
use Carbon\Carbon;

class BlogController extends Controller
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
            $blog = Blog::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('tag', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $blog = Blog::latest()->paginate($perPage);
        }

        return view('admin.blog.index', compact('blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.blog.create');
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
        $now=Carbon::now()->format('Y-m-d');
        $blog=Blog::create([
            'title' => request('title'),
            'content' => request('content'),
            'tag' => request('tag'),
            'created_at' => $now
        ]);
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo){
                $filename = $photo->store('uploads', 'public');
            BlogPhoto::create([
                        'blog_id' => $blog->id,
                        'image' => $filename
                    ]);

            }
           
        }
    
        return redirect('admin/blog')->with('flash_message', 'Blog added!');
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
        $blog = Blog::findOrFail($id);

        return view('admin.blog.show', compact('blog'));
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
        $blog = Blog::findOrFail($id);
        $blogPhoto = BlogPhoto::where('blog_id','LIKE',$id)->get();

        return view('admin.blog.edit', compact(['blog','blogPhoto']));
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

        

        $blog = Blog::findOrFail($id);
      
        $blog->update([
            'title' => request('title'),
            'content' => request('content'),
            'tag' => request('tag')
        ]);
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo){
                $filename = $photo->store('uploads', 'public');
            BlogPhoto::create([
                        'blog_id' => $blog->id,
                        'image' => $filename
                    ]);

            }
           
        }

        return redirect('admin/blog')->with('flash_message', 'Blog updated!');
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
        Blog::destroy($id);
        $blogPhoto=BlogPhoto::where('blog_id','LIKE',$id)->get();
        
        if($blogPhoto!=null)
        { 
            foreach($blogPhoto as $photo)
            {
                File::delete('storage/'.$photo->image); 
              BlogPhoto::destroy($photo->id);
            } 
        }

        return redirect('admin/blog')->with('flash_message', 'Blog deleted!');
    }
    public function destroyPhoto($blog_id,$id)
    {
        
        $blogPhoto=BlogPhoto::where('id','LIKE',$id)->get();
        
        if($blogPhoto!=null)
        {
           File::delete('storage/'.$blogPhoto[0]->image); 
           BlogPhoto::destroy($id);
        }
        
        return redirect('admin/blog/'.$blog_id.'/edit');
    }
}
