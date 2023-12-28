<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdukResource;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        // produk berelasi dengan jenis_produk
        $produk = Produk::get();
        return new ProdukResource(true, 'Data Produk', $produk);
    }

    public function show($id) {
        $produk = Produk::where('id', $id)
        ->get();
        return new ProdukResource(true, 'Detail Produk', $produk);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'kode'=> 'required | max:10 | unique:produk',
            'nama'=> 'required | max:45',
            'harga_beli'=> 'required | numeric',
            'harga_jual'=> 'required | numeric',
            'stok'=> 'required | numeric',
            'min_stok'=> 'required | numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 442);
        }

        DB::table('produk')->insert([
            'kode'=> $request->input('kode'),
            'nama'=> $request->input('nama'),
            'harga_beli'=> $request->input('harga_beli'),
            'harga_jual'=> $request->input('harga_jual'),
            'stok'=> $request->input('stok'),
            'min_stok'=> $request->input('min_stok'),
        ]);

        return new ProdukResource(true, 'Data Produk Berhasil ditambahkan', 'produk');
    }

    public function update(Request $request, string $id) {
        $validator = Validator::make($request->all(),[
            'kode'=> 'required | max:10',
            'nama'=> 'required | max:45',
            'harga_beli'=> 'required | numeric',
            'harga_jual'=> 'required | numeric',
            'stok'=> 'required | numeric',
            'min_stok'=> 'required | numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 442);
        }

        $produk = DB::table('produk')->where('id',$id)->update([
            'kode'=> $request->input('kode'),
            'nama'=> $request->input('nama'),
            'harga_beli'=> $request->input('harga_beli'),
            'harga_jual'=> $request->input('harga_jual'),
            'stok'=> $request->input('stok'),
            'min_stok'=> $request->input('min_stok'),
        ]);

        return new ProdukResource(true, 'Data Produk Berhasil diubah', $produk);
    }

    public function destory($id) {
        $produk = DB::table('produk')->where('id', $id);
        $produk->delete();
        return new ProdukResource(true, 'Data Produk Berhasil dihapus', $produk);
    }
}
