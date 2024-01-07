<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        return view("barang", compact("jenis"));
    }

    public function tambah(Request $request){
        $data = $request->all();
        if(!isset($data['id_jenis'])) $data['id_jenis'] = 0;
        if(isset($data['id'])) unset($data['id']);
        $request->validate([
            'nama_barang' => 'required|string|max:250',
            'harga' => 'required',
            'stok' => 'required',
        ]);

        $res = Barang::create($data);
        if($res){
            return response()->json([
                'status'=> 200,
                'message'=> 'Berhasil menambahkan data']);
        }else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Gagal']);
        }
    }

      public function update(Request $request){
        $data = $request->all();
        if(!isset($data['id_jenis'])) $data['id_jenis'] = 0;
        $request->validate([
            'id' => 'required',
            'nama_barang' => 'required|string|max:250',
            'harga' => 'required',
            'stok' => 'required',
        ]);
        $id = $data['id'];
        $res = Barang::where('id', $id)->update([
            'nama_barang' => $data['nama_barang'],
            'id_jenis' => $data['id_jenis'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
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

    public function list(Request $request){
        $data = $request->all();
        $res = Barang::select('tbl_barang.*','tbl_jenis_barang.nama_jenis as jenis')->leftJoin('tbl_jenis_barang','tbl_jenis_barang.id','=','tbl_barang.id_jenis');
        $res = $res->get();
        if($res){
            foreach($res as $key => $value){
                $res[$key]['no'] = $key + 1;
                $res[$key]['harga'] = number_format($value['harga'],0,',','.');
            }
        }
        return DataTables::of($res)->make(true);
    }

    public function hapus(Request $request){    
        $id = $request->id;
        $res = Barang::destroy($id);
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

    public function detail(Request $request){
        $res = Barang::select('*')->where('id',$request->id)->first();
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

