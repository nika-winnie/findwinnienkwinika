<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = '';
            }
//            if(!empty($data['care'])){
//                $product->care = $data['care'];
//            }else{
//                $product->care = '';
//            }
            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }
            $product->price = $data['price'];
            $product->status = $status;
            $product->save();
            return redirect()->back()->with('flash_message_success', 'Product has been added successfully');
        }

        $categories = Category::where(['parent_id' => 0])->get();

        $categories_drop_down = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_drop_down .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_drop_down .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        //echo "<pre>"; print_r($categories_drop_down); die;

        return view('admin.products.add_product')->with(compact('categories_drop_down'));
    }

    public function editProduct(Request $request,$id=null){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }
            if(empty($data['description'])){
                $data['description'] = '';
            }



            Product::where(['id'=>$id])->update(['status'=>$status,'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'price'=>$data['price']]);

            return redirect()->back()->with('flash_message_success', 'Product has been edited successfully');
        }

        // Get Product Details start //
        $productDetails = Product::where(['id'=>$id])->first();
        // Get Product Details End //

        // Categories drop down start //
        $categories = Category::where(['parent_id' => 0])->get();

        $categories_drop_down = "<option value='' disabled>Select</option>";
        foreach($categories as $cat){
            if($cat->id==$productDetails->category_id){
                $selected = "selected";
            }else{
                $selected = "";
            }
            $categories_drop_down .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if($sub_cat->id==$productDetails->category_id){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                $categories_drop_down .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        // Categories drop down end //

        return view('admin.products.edit_product')->with(compact('productDetails','categories_drop_down'));
    }
    public function viewProducts(Request $request){
        $products = Product::get();
        foreach($products as $key => $val){
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        $products = json_decode(json_encode($products));
        //echo "<pre>"; print_r($products); die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProduct($id = null){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product has been deleted successfully');
    }


}
