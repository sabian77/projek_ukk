<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industri = Industri::all();
        return response()->json($industri);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'website' => 'required|url',
            'bidang_usaha' => 'required',
            'alamat' => 'required',
            'kontak' => 'required|unique:industris,kontak',
            'email' => 'required|email|unique:industris,email',
        ]);
    
        // Jika validasi gagal, hentikan eksekusi dan berikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal! Silakan cek kembali input Anda.',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Jika validasi berhasil, simpan data industri
        $industri = Industri::create($request->all());
    
        return response()->json([
            'success' => true,
            'message' => 'Data industri Berhasil Disimpan!',
            'industri' => $industri
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //menacri industri berdasar id
        $industri = Industri::find($id);

        //jika industri tidak ditemukan
        if (!$industri) {
            return response()->json([
                'success' => false,
                'message' => 'Data industri Tidak Ditemukan!',
            ], 404);
        }
        //return data industri
        return response()->json([
            'success' => true,
            'message' => 'Data industri Berhasil Ditemukan!',
            'industri' =>$industri
        ], 200);
            

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $industri = Industri::find($id);
        $industri->nama = $request->nama ?? $industri->nama;
        $industri->website = $request->website ?? $industri->website;
        $industri->bidang_usaha = $request->bidang_usaha ?? $industri->bidang_usaha;
        $industri->alamat = $request->alamat ?? $industri->alamat;
        $industri->kontak = $request->kontak ?? $industri->kontak;
        $industri->email = $request->email ?? $industri->email;

        $industri->save();

        return response()->json([
            'success' => true,
            'message' => 'Data industri Berhasil Diupdate!',
            'industri' => $industri
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                //berdasar id
        $industri = industri::find($id);
        //hapus data
        $industri->delete();

        //retrun respone
        return response()->json([
            'success' => true,
            'message' => 'Data industri Berhasil Dihapus!',
        ], 200);
    }
}
