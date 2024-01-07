<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



class JenisBarangController extends Controller
{
    public function index()
    {
        return view("jenisbarang");
    }

    public function tambah(Request $request){
        $data = $request->all();
        if(!isset($data['nama_jenis'])) $data['nama_jenis'] = 0;
        if(isset($data['id'])) unset($data['id']);
        $request->validate([
            'nama_jenis' => 'required|string|max:250',
            
        ]);

        $res = Jenis::create($data);
        if($res){
            return response()->json([
                'status'=> 200,
                'message'=> 'Berhasil menambahkan Jenis data Barang']);
        }else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Gagal']);
        }
    }

    public function update(Request $request){
        $data = $request->all();
        if(!isset($data['nama_jenis'])) $data['nama_jenis'] = 0;
        $request->validate([
            'id' => 'required',
            'nama_jenis' => 'required|string|max:250',
            
        ]);
        $id = $data['id'];
        $res = Jenis::where('id', $id)->update([
            'nama_jenis' => $data['nama_jenis'],
           
        ]);
        if($res){
            return response()->json([
                'status'=> 200,
                'message'=> 'Berhasil mengubah data']);
        }else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Gagal']);
        }
    }

    public function hapus(Request $request){    
        $id = $request->id;
        $res = Jenis::destroy($id);
        if($res){
            return response()->json([
                'status'=> 200,
                'message'=> 'Berhasil dihapus'     
                ]);

        }else{
            return response()->json([
                'status'=> 500, 
                'message'=> 'Gagal menghapus' ]);

        }
    }

    public function list(Request $request){
        $data = $request->all();
        $res = Jenis::select('*');
        $res = $res->get();
       
        return DataTables::of($res)->make(true);
    }

    public function detail(Request $request){
        $res = Jenis::select('*')->where('id',$request->id)->first();
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




