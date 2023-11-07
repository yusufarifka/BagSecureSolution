<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use DB;
class homeController extends Controller

{
    public function show()
    {
        return Inertia::render('Home');
    }
    public function profile()
    {
        return Inertia::render('Profile');
    }
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'username'=>'required',
            'password'=>'required',
            'email'=>'required',
        ],[
            'name.required'=>'Nama Tidak Boleh Kosong',
            'username.required'=>'Nama Pengguna Tidak Boleh Kosong',
            'password.required'=>'Password Tidak Boleh Kosong',
            'email.required'=>'Email Tidak Boleh Kosong',
        ]);
        // DB::table('users')->insert([
        //     'name'=>$request->name,
        //     'username'=>$request->username,
        //     'password'=>bcrypt($request->username),
        //     'email'=>$request->email,
        // ]);
        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>bcrypt($request->password),
            'email'=>$request->email,

        ]);
        return back();
    }
    public function dashboard()
    {
        return Inertia::render('dashboard');
    }
    public function products()
    {
        return Inertia::render('products');
    }
    public function user()
    {
        $data=User::latest()->get();
        return Inertia::render('user',[
            'data'=>$data
        ]);
    }
    public function userPost(Request $request){
        $request->validate([
            'name'=>'required',
            'username'=>'required',
            'password'=>'required',
            'email'=>'required',
        ]);
        User::updateOrCreate(['id'=>$request->id],[
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>bcrypt($request->password),
            'email'=>$request->email
        ]);
    }
    public function userEdit($id){
        $data=User::where('id',$id)->first();
        return response()->json($data); //tampilkan data ke axios
    }
    public function userHapus($id){
        if($id){
            $hapus=User::find($id);
            $hapus->delete();
        }
        return back();
    }
}


