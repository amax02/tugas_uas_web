<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiskonController extends Controller
{
    public function index()
    {
        return view("diskon");
    }

    

    public function update(Request $request){
        $data = $request->all();
        if(!isset($data['total_belanja'])) $data['total_belanja'] = 0;
        $request->validate([
            'id' => 'required',
            'total_belanja' => 'required',
            
        ]);
        $id = $data['id'];
        $res = Diskon::where('id', $id)->update([
            'total_belanja' => $data['total_belanja'],
           
        ]);
        if($res){
            return response()->json([
                'status'=> 200,
                'message'=> 'Berhasil memperbarui data']);
        }else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Gagal']);
        }
    }

        public function list(Request $request){
        $data = $request->all();
        $res = Diskon::select('*');
        $res = $res->get();
       
        return DataTables::of($res)->make(true);
    }

    public function detail(Request $request){
        $res = Diskon::select('*')->where('id',$request->id)->first();
        if  ($res){
        return response()->json([
            'status'=> 200,
            'message'=> 'Berhasil',
            'data'=> $res  
            ]);
        }else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Gagal mengambil data'
                ]);
            }
    }
}
