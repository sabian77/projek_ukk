<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Guru;
use Illuminate\Support\Facades\Validator;

class PklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pkl = Pkl::all();
        return response()->json($pkl);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|string|max:255',
            'nama_industri' => 'required|string|max:255',
            'nama_guru' => 'required|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
        ]);
    
        // Jika validasi gagal, hentikan eksekusi dan berikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal! Silakan cek kembali input Anda.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Konversi nama menjadi ID
        $siswa = Siswa::where('nama', $request->nama_siswa)->first();
        $industri = Industri::where('nama', $request->nama_industri)->first();
        $guru = Guru::where('nama', $request->nama_guru)->first();

        // Jika nama tidak ditemukan, kirim error
        if (!$siswa || !$industri || !$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Nama Siswa, Industri, atau Guru tidak ditemukan!',
            ], 404);
        }
        // Jika validasi berhasil, simpan data industri
        $pkl = Pkl::create([
            'siswa_id' => $siswa->id,
            'industri_id' => $industri->id,
            'guru_id' => $guru->id,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
        ]);
        
    
        return response()->json([
            'success' => true,
            'message' => 'Data Pkl [' . $pkl->id . '] Berhasil Disimpan!',
            'pkl' => $pkl
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //menacri guru berdasar id
        $pkl = Pkl::find($id);

        //jika guru tidak ditemukan
        if (!$pkl) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pkl Tidak Ditemukan!',
            ], 404);
        }
        //return data guru
        return response()->json([
            'success' => true,
            'message' => 'Data Pkl Berhasil Ditemukan!',
            'pkl' =>$pkl
        ], 200);
            

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //berdasar id
        $pkl = Pkl::find($id);
        $pkl->siswa_id = $request->siswa_id ?? $pkl->siswa_id;
        $pkl->industri_id = $request->industri_id ?? $pkl->industri_id;
        $pkl->guru_id = $request->guru_id ?? $pkl->guru_id;
        $pkl->mulai = $request->mulai ?? $pkl->mulai;
        $pkl->selesai = $request->selesai ?? $pkl->selesai;
        $pkl->save();
        //return respone
        return response()->json([
            'success' => true,
            'message' => 'Data Pkl [' . $pkl->id . '] Berhasil Diupdate!',
            'pkl' => $pkl
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                //berdasar id
        $pkl = Pkl::find($id);

        //hapus data
        $pkl->delete();

        //retrun respone
        return response()->json([
            'success' => true,
            'message' => 'Data Pkl [' . $pkl->id . '] Berhasil Dihapus!',
        ], 200);
    }
}
