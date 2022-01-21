<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;


class AdminController extends Controller
{
    // requiere autenticacion
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $products = Product::all();
        return view('admin.index', compact('products', $products));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // validar los datos de ingreso del formulario
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,gif,svg,jfif|max:2048'
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->status = $request->status;
        if($request->warranty == "yes") $product->warranty = true;
        $product->warranty = false;
        // migra el objeto a la db
        $product->save();

        foreach ($request->image as $image) {
            $name = $image->getClientOriginalName();
            $url =  md5($image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
            // sube la imagen a public
            Image::make($image)->save(public_path('storage/images/'.$url));
            // creamos el objeto imágen de nuestro modelo
            $newImage = new \App\Models\Image;

            $newImage->name = $name;
            $newImage->url = $url;
            $newImage->product_id = $product->id;
            // migra el objeto a la db
            $newImage->save();
        }

        // redirección al index
        return redirect()->route('admin.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $product = Product::findOrFail($id);

        // recuperamos las imagenes
        $images = \App\Models\Image::all()->where('product_id', '=', $id);

        return view('admin.show', compact('product', $product, 'images', $images));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $product = Product::findOrFail($id);
        return view('admin.edit', compact('product', $product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // validar los datos de ingreso del formulario
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'image.*' => 'image|mimes:jpeg,png,gif,svg,jfif|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->status = $request->status;
        if($request->warranty == "yes") $product->warranty = true;
        $product->warranty = false;

        $product->update();

        if(count($request->files) > 0){
            $images = \App\Models\Image::all()->where('product_id', '=', $id);
            foreach ($images as $image) {
                // eliminamos las imágenes
                $exists = File::exists(public_path('storage/images/'.$image->url));
                if($exists) {
                    File::delete(public_path('storage/images/'.$image->url));
                    \App\Models\Image::destroy($image->id);
                }
            }
            // cargamos las nuevas imágenes
            foreach ($request->image as $image) {
                $name = $image->getClientOriginalName();
                $url =  md5($image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
                // sube la imagen a public
                Image::make($image)->save(public_path('storage/images/'.$url));
                // creamos el objeto imágen de nuestro modelo
                $newImage = new \App\Models\Image;
    
                $newImage->name = $name;
                $newImage->url = $url;
                $newImage->product_id = $product->id;
                // migra el objeto a la db
                $newImage->save();
            }
        }

        // redirección al index
        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $product = Product::findOrFail($id);

        // eliminamos las imagenes
        $images = \App\Models\Image::all()->where('product_id', '=', $product->id);

        foreach ($images as $image) {
            // eliminamos las imágenes
            
            $exists = File::exists(public_path('storage/images/'.$image->url));
            if($exists) {
                File::delete(public_path('storage/images/'.$image->url));
                \App\Models\Image::destroy($image->id);
            }
        }

        // eliminamos el prducto
        Product::destroy($product->id);

        // redirección al index
        return redirect()->route('admin.index');
    }
}
