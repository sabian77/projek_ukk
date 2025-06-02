<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::all();
        return response()->json($guru);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nip' => 'required|unique:gurus,nip',
            'gender' => 'required',
            'alamat' => 'required',
            'kontak' => 'required|unique:gurus,kontak',
            'email' => 'required|email|unique:gurus,email',
        ]);
    
        // Jika validasi gagal, hentikan eksekusi dan berikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal! Silakan cek kembali input Anda.',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Jika validasi berhasil, simpan data guru
        $guru = Guru::create($request->all());
    
        return response()->json([
            'success' => true,
            'message' => 'Data Guru Berhasil Disimpan!',
            'guru' => $guru
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //menacri guru berdasar id
        $guru = Guru::find($id);

        //jika guru tidak ditemukan
        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data Guru Tidak Ditemukan!',
            ], 404);
        }
        //return data guru
        return response()->json([
            'success' => true,
            'message' => 'Data Guru Berhasil Ditemukan!',
            'guru' =>$guru
        ], 200);
            

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guru = Guru::find($id);
        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data Guru Tidak Ditemukan!',
            ], 404);
        }

        // Debug log request
        Log::info('Request Data:', $request->all());

        $guru->nama = $request->nama ?? $guru->nama;
        $guru->nip = $request->nip ?? $guru->nip;
        $guru->gender = $request->gender ?? $guru->gender;
        $guru->alamat = $request->alamat ?? $guru->alamat;
        $guru->kontak = $request->kontak ?? $guru->kontak;
        $guru->email = $request->email ?? $guru->email;

        $guru->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Guru Berhasil Diupdate!',
            'guru' => $guru
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                //berdasar id
        $guru = guru::find($id);

        //hapus data
        $guru->delete();

        //retrun respone
        return response()->json([
            'success' => true,
            'message' => 'Data guru Berhasil Dihapus!',
        ], 200);
    }
}
