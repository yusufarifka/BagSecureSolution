<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use Inertia\Inertia;
use DB;

class productController extends Controller
{
    public function product(){
        $data=product::latest()->get();
        return Inertia::render('product',[
            'data'=>$data
        ]);
    }
    public function productPost(Request $request){
        $request->validate([
            'product_name'=>'required',
            'product_desc'=>'required',
            'price'=>'required',
        ]);
        product::updateOrCreate(['id'=>$request->id],[
            'product_name'=>$request->product_name,
            'product_desc'=>$request->product_desc,
            'price'=>$request->price,
        ]);
    }
}
