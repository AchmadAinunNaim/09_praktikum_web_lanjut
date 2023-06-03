<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
        return view('mahasiswas.index', ['mahasiswa' => $mahasiswas,'paginate'=> $paginate]);

        // $mahasiswas = Mahasiswa::all();
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6); 
        // return view('mahasiswas.index', compact('posts')); 
        // with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create',['kelas' => $kelas]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'Nim' => 'required', 
            'Nama' => 'required', 
            'foto' => 'image|file',
            'kelas_id' => 'required', 
            'Jurusan' => 'required', 
            'No_Handphone' => 'required', 
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        // Mahasiswa::create($request->all());
        if ($request->file('foto')) {
            $nama_foto = $request->file('foto')->store('fotoMahasiswa', 'public');
        } else {
            dd('Foto Tidak ada');
        }

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->foto = $nama_foto;
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index') 
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $Nim)
    {
        // $Mahasiswa = Mahasiswa::find($Nim); 
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        // return view('mahasiswas.detail', compact('Mahasiswa'));
        return view('mahasiswas.detail', ['Mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $Nim)
    {
        // $Mahasiswa = Mahasiswa::find($Nim); 
        // return view('mahasiswas.edit', compact('Mahasiswa'));
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $Nim)
    {
        // dd($request);
        $validateData = $request->validate([ 
            'Nim' => 'required', 
            'Nama' => 'required', 
            'foto' => 'image|file',
            'Kelas' => 'required', 
            'Jurusan' => 'required', 
            'No_Handphone' => 'required', 
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);
        //  dd($request);

        // Mahasiswa::where('Nim', $Nim)->update($validateData);
        if ($request->foto && file_exists(storage_path('app/public/' . $request->foto))) {
            Storage::delete('public/' . $request->foto);
        }

        $nama_foto = $request->file('foto')->store('fotoMahasiswa', 'public');

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->foto = $nama_foto;
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

         return redirect()->route('mahasiswa.index') 
         ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $Nim)
    {
        $Mahasiswa = Mahasiswa::where('Nim', $Nim)->delete();
        return redirect()->route('mahasiswa.index') 
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function khs(Mahasiswa $mahasiswa)
    {
        $matkuls = $mahasiswa->matakuliah;


        return view('mahasiswas.khs', [
            'matkuls' => $matkuls,
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function cetak_khs(Mahasiswa $mahasiswa)
    {
        $matkuls = $mahasiswa->matakuliah;
        $pdf = pdf::loadview('mahasiswas.cetak_khs', [
            'matkuls' => $matkuls,
            'mahasiswa' => $mahasiswa,
        ]);
        return $pdf->stream();
    }

    
}
