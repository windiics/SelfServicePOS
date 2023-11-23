<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)){
            $data = Mahasiswa::where('NIM', 'like', "%$katakunci%")
                    ->orWhere('Nama', 'like', "%$katakunci%")
                    ->orWhere('Jurusan', 'like', "%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            
        }
        $data = Mahasiswa::orderBy('NIM', 'desc')->paginate($jumlahbaris);
        return view('Mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('NIM', $request->NIM);
        Session::flash('Nama', $request->Nama);
        Session::flash('Jurusan', $request->Jurusan);

        $request->validate([
            'NIM'=>'required|numeric|unique:Mahasiswa,NIM',
            'Nama'=>'required',
            'Jurusan'=>'required',
        ],[
            'NIM.required'=>'NIM wajib diisi',
            'NIM.numeric'=>'NIM wajib dalam angka',
            'NIM.unique'=>'NIM yang diisikan sudah terdaftar dalam database',
            'Nama.required'=>'Nama wajib diisi',
            'Jurusan.required'=>'Jurusan wajib diisi',
        ]);
        $data = [
            'NIM'=>$request->NIM,
            'Nama'=>$request->Nama,
            'Jurusan'=>$request->Jurusan,
        ];
        Mahasiswa::create($data);
        return redirect()->to('Mahasiswa')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Mahasiswa::where('NIM', $id)->first();
        return view('Mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Nama'=>'required',
            'Jurusan'=>'required',
        ],[
            'Nama.required'=>'Nama wajib diisi',
            'Jurusan.required'=>'Jurusan wajib diisi',
        ]);
        $data = [
            'Nama'=>$request->Nama,
            'Jurusan'=>$request->Jurusan,
        ];
        Mahasiswa::where('NIM', $id)->update($data);
        return redirect()->to('Mahasiswa')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Mahasiswa::where('NIM', $id)->delete();
        return redirect()->to('Mahasiswa')->with('success', 'Berhasil menghapus data');
    }
}
