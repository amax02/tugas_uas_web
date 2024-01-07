<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return view("transaksi");
    }

    public function tambah(Request $request){
        $data = $request->all();
        if(!isset($data['no_transaksi'])) $data['no_transaksi'] ;
        if(!isset($data['tgl_transaksi'])) $data['tgl_transaksi'] ;
        if(!isset($data['diskon'])) $data['diskon'] ;
        if(!isset($data['total_bayar'])) $data['total_bayar'] ;
        if(isset($data['id'])) unset($data['id']);
        $request->validate([
            'no_transaksi' => 'required',
            'tgl_transaksi' => 'required',
            'diskon' => 'required',
            'total_bayar' => 'required',
            
        ]);

        $res = Transaksi::create($data);
        if($res){
            return response()->json([
                'status'=> 200,
                'message'=> 'Berhasil menambahkan Transaksi data Transaksi']);
        }else{
            return response()->json([
                'status'=> 500,
                'message'=> 'Gagal']);
        }
    }

    public function update(Request $request){
        $data = $request->all();
        if(!isset($data['no_transaksi'])) $data['no_transaksi'] = 0;
        if(!isset($data['tgl_transaksi'])) $data['tgl_transaksi'] = 0;
        if(!isset($data['diskon'])) $data['diskon'] = 0;
        if(!isset($data['total_bayar'])) $data['total_bayar'] = 0;
        
        $request->validate([
            'id' => 'required',
            'no_transaksi' => 'required',
            'tgl_transaksi' => 'required',
            'diskon' => 'required',
            'total_bayar' => 'required',
            
        ]);
        $id = $data['id'];
        $res = Transaksi::where('id', $id)->update([
            'no_transaksi' => $data['no_transaksi'],
            'tgl_transaksi' => $data['tgl_transaksi'],
            'diskon' => $data['diskon'],
            'total_bayar' => $data['total_bayar'],
           
           
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
        $res = Transaksi::destroy($id);
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
        $res = Transaksi::select('*');
        $res = $res->get();
       
        return DataTables::of($res)->make(true);
    }

    public function detail(Request $request){
        $res = Transaksi::select('*')->where('id',$request->id)->first();
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






