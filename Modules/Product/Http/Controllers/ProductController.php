<?php

namespace Modules\Product\Http\Controllers;

use Modules\Settings\Entities\Weight;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use File;

class ProductController extends Controller
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
            $products = Product::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('quantity', 'LIKE', "%$keyword%")
                ->orWhere('capacity', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('discount_price', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $products = Product::latest()->paginate($perPage);
        }

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $weights = Weight::orderBy('value')->get();
        return view('admin.product.create')->
            with('weights',$weights);
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

        if($request->discount!=null)
        {
            $discount=$request->discount;
            $price=request('price');
            $discount=request('discount');
            
            $discount_price=round($price*((100-$discount)/100), 2);
        }
        else{
            $discount=0;
            $price=request('price');
            $discount_price=round($price,2);
        }
        
        $product=Product::create([
            'title' => request('title'),
            'content' => request('content'),
            'quantity' => request('quantity'),
            'capacity' => request('capacity'),
            'price' => request('price'),
            'discount_price'=>$discount_price,
            'is_active' => request('is_active'),
            'discount' => $discount,
        ]);
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo){
                $filename = $photo->store('uploads', 'public');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'image' => $filename
                ]);
            }
        }
        
        return redirect('admin/product')->with('flash_message', 'Product added!');
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
        $product = Product::findOrFail($id);

        return view('admin.product.show', compact('product'));
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
        $weights = Weight::orderBy('value')->get();
        $product = Product::findOrFail($id);
        $productPhoto = ProductPhoto::where('product_id','LIKE',$id)->get();
        return view('admin.product.edit', compact(['product','productPhoto','weights']));
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

        $product = Product::findOrFail($id);
      
        $product->update([
            'title' => request('title'),
            'content' => request('content'),
            'quantity' => request('quantity'),
            'capacity' => request('capacity'),
            'price' => request('price'),
            'is_active' => request('is_active'),
            'discount' => request('discount'),
        ]);
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo){
                $filename = $photo->store('uploads', 'public');
            ProductPhoto::create([
                        'product_id' => $product->id,
                        'image' => $filename
                    ]);
            }
           
        }
        return redirect('admin/product')->with('flash_message', 'Product updated!');
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
        Product::destroy($id);
        $productPhoto=ProductPhoto::where('id','LIKE',$id)->get();
        
        if($productPhoto!=null)
        {
            foreach($productPhoto as $photo)
           File::delete('storage/'.$photo->image); 
           ProductPhoto::destroy($id);
        }
        

        return redirect('admin/product')->with('flash_message', 'Product deleted!');
    }
    public function destroyPhoto($product_id,$id)
    {
        
        $productPhoto=ProductPhoto::where('id','LIKE',$id)->get();
        
        if($productPhoto!=null)
        {
           File::delete('storage/'.$productPhoto[0]->image); 
           ProductPhoto::destroy($id);
        }
        
        return redirect('admin/product/'.$product_id.'/edit');
    }
}

