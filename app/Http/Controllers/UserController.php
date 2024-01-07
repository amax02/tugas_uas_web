<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view("user");
    }




    public function tambah(Request $request)
    {
        $data = $request->all();
        if (!isset($data['name'])) $data['name'] = 0;
        if (!isset($data['email'])) $data['email'] = 0;
        if (isset($data['id'])) unset($data['id']);
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required',
            'password' => 'required',

        ]);

        $res = User::create($data);
        if ($res) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menambahkan User '
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal'
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if (!isset($data['name'])) $data['name'] = 0;
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:250',
            'email' => 'required',


        ]);
        $id = $data['id'];
        $res = User::where('id', $id)->update([
            'name' => $data['name'],
            'email' => $data['email'],

        ]);
        if ($res) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil mengubah data'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal'
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $res = User::destroy($id);
        if ($res) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal menghapus'
            ]);
        }
    }

    public function list(Request $request)
    {
        $data = $request->all();
        $res = User::select('*');
        $res = $res->get();

        return DataTables::of($res)->make(true);
    }

    public function detail(Request $request)
    {
        $res = User::select('*')->where('id', $request->id)->first();
        if ($res) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil',
                'data' => $res
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal mengambil data'
            ]);
        }
    }
}
