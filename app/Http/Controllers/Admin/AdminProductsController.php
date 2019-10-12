<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminProductsController extends Controller
{
    //

    public function index(){

        $product = Product::all();

        return view('admin.displayProducts', ['products' => $product]);
    }

    
    
  
  
    public function destroy($id){

        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->back();

    }

    
    
   
    public function editProduct($id){

        $product = Product::findOrFail($id);

        return view('admin.editProduct', ['product' => $product]);


    }


    
    
    
    public function editProductImage($id){

        $product = Product::findOrFail($id);

        return view('admin.editProductImage', ['product' => $product]);

    }



   /*  public function store(Request $request){

        $file = $request->file('file');

        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);

        Photo::create(['file' => $name]);

        
    } */



    public function updateProductImage(Request $request, $id){
 
        Validator::make($request->all(), ['image' => 'required|file|image|mimes:jpg,png,jpeg|max:3000'])->validate(); 

        if($request->hasFile("image")){

            $product = Product::findOrFail($id);

            $exists =  Storage::disk('local')->exists("public/product_images/".$product->image);

            if($exists){
                Storage::delete('public/product_image/'.$product->image);
            }

            $ext = $request->file('image')->getClientOriginalExtension();

            $request->image->storeAs("public/product_images/", $product->image);

            $arrayToUpdate = array('image' =>$product->image); 
            DB::table('products')->where('id', $id)->update($arrayToUpdate); // change current image with new one

            return redirect()->route('adminDisplayProducts'); // back to display admin products

        } else {

            $error = "You should select picture first";

            return $error;

        }

    }



    public function updateProduct(Request $request, $id){

    $name = $request->input('name');
    $description = $request->input('description');
    $type =  $request->input('type');
    $price = $request->input('price');

    $newUpdatedArray = array("name" => $name, "description" => $description, "type" => $type, "price" => $price);
    DB::table('products')->where('id', $id)->update($newUpdatedArray);

    return redirect()->route('adminDisplayProducts');


    }



    public function createProductForm(){

        return view('admin.createProductForm');
    }


    public function sendCreateProductForm(Request $request){
 
    $name = $request->input('name');
    $description = $request->input('description');
    $type =  $request->input('type');
    $price = $request->input('price');

    Validator::make($request->all(), ['image' => 'required|file|image|mimes:jpg,png,jpeg|max:3000'])->validate(); 

    $ext = $request->file('image')->getClientOriginalExtension();

   // return dd($ext); "jpeg"

    $cutWithespaces = str_replace(" ", "", $request->input('name'));
    
    $nameOfImage = $cutWithespaces. "." .$ext;

    
    $imageEncoded = File::get($request->image);
    
    Storage::disk('local')->put('public/product_images/' .$nameOfImage, $imageEncoded);
    
    $newProduct = array("name" => $name, "description" => $description, "type" => $type, "price" => $price, "image" =>  $nameOfImage);
 
    
    $created = DB::table("products")->insert($newProduct);

    if ($created){

        return redirect()->back();
    } else {
        return "Product was not created";
    }

    }

}
