<?php

namespace App\Http\Controllers;

use App\RefSkemaPenelitian;
use App\RefSumberDana;
use App\Penelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenelitianController extends Controller
{
    public function index()
    {
        $penelitians = Penelitian::paginate(25);
        return view('backend.penelitian.index', compact('penelitians'));
    }

    public function create()
    {
        $skema_penelitian = RefSkemaPenelitian::all()->pluck('nama', 'id');
        $sumber_dana = RefSumberDana::all()->pluck('nama', 'id');
        return view('backend.penelitian.create', compact('skema_penelitian', 'sumber_dana'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tahun' => 'required|digits:4',
            'lama_tahun' => 'digits:1',
            'total_dana' => 'numeric',
            'skema_penelitian_id' => 'required',
            'sumber_dana_id' => 'required',
            'file_kontrak' => 'file|mimes:pdf',
            'file_laporan' => 'file|mimes:pdf'
        ]);
        //Simpan file upload
        $file_kontrak = null;
        if($request->hasFile('file_kontrak') && $request->file('file_kontrak')->isValid())
        {
            $filename = uniqid('kontrak-');
            $fileext = $request->file('file_kontrak')->extension();
            $filenameext = $filename.'.'.$fileext;

            $file_kontrak = $request->file_kontrak->storeAs('public/penelitian_kontrak', $filenameext);
        }

        $file_laporan = null;
        if($request->hasFile('file_laporan') && $request->file('file_laporan')->isValid())
        {
            $filename = uniqid('laporan-');
            $fileext = $request->file('file_laporan')->extension();
            $filenameext = $filename.'.'.$fileext;

            $file_laporan = $request->file_laporan->storeAs('public/penelitian_laporan', $filenameext);
        }
        $penelitian = Penelitian::create([
            'judul' => $request->input('judul'),
            'tahun' => $request->input('tahun'),
            'lama_tahun' => $request->input('lama_tahun'),
            'total_dana' => $request->input('total_dana'),
            'sumber_dana_id' => $request->input('sumber_dana_id'),
            'skema_penelitian_id' => $request->input('skema_penelitian_id'),
            'file_kontrak' => $file_kontrak,
            'file_laporan' => $file_laporan
        ]);
        if($penelitian->save()) {
            session()->flash('flash_success', 'Berhasil menambahkan data penelitian baru');
            //Redirect ke halaman detail
            return redirect()->route('admin.penelitian-user.create', [$penelitian->id]);
        }
        return redirect()->back()->withErrors();
    }

    public function show(Penelitian $penelitian)
    {
        $file_kontrak_url = Storage::url($penelitian->file_kontrak);
        $file_laporan_url = Storage::url($penelitian->file_laporan);
        return view('backend.penelitian.show', compact('penelitian', 'file_kontrak_url', 'file_laporan_url'));
    }

    public function edit(Penelitian $penelitian)
    {
        $skema_penelitian = RefSkemaPenelitian::all()->pluck('nama', 'id');
        $sumber_dana = RefSumberDana::all()->pluck('nama', 'id');

        return view('backend.penelitian.edit', compact('penelitian', 'skema_penelitian', 'sumber_dana'));
    }

    public function update(Request $request, Penelitian $penelitian)
    {
        $request->validate([
            'judul' => 'required',
            'tahun' => 'required|digits:4',
            'lama_tahun' => 'digits:1',
            'total_dana' => 'numeric',
            'skema_penelitian_id' => 'required',
            'sumber_dana_id' => 'required',
            'file_kontrak' => 'file|mimes:pdf',
            'file_laporan' => 'file|mimes:pdf'
        ]);

        $penelitian->judul = $request->input('judul');
        $penelitian->tahun = $request->input('tahun');
        $penelitian->lama_tahun = $request->input('lama_tahun');
        $penelitian->total_dana = $request->input('total_dana');
        $penelitian->skema_penelitian_id = $request->input('skema_penelitian_id');
        $penelitian->sumber_dana_id = $request->input('sumber_dana_id');
        //Simpan file upload
        if($request->file('file_kontrak')->isValid())
        {
            //Hapus file, jika sebelumnya sudah ada
            if(Storage::exists($penelitian->file_kontrak))
            {
                Storage::delete($penelitian->file_kontrak);
            }
            //Simpan file yang diupload
            $filename = uniqid('kontrak-');
            $fileext = $request->file('file_kontrak')->extension();
            $filenameext = $filename.'.'.$fileext;

            $filepath = $request->file_kontrak->storeAs('public/penelitian_kontrak', $filenameext);
            $penelitian->file_kontrak = $filepath;
        }

        if($request->file('file_laporan')->isValid())
        {
            //Hapus file, jika sebelumnya sudah ada
            if(Storage::exists($penelitian->file_laporan))
            {
                Storage::delete($penelitian->file_laporan);
            }
            //Simpan file yang diupload
            $filename = uniqid('laporan-');
            $fileext = $request->file('file_laporan')->extension();
            $filenameext = $filename.'.'.$fileext;

            $filepath = $request->file_laporan->storeAs('public/penelitian_laporan', $filenameext);
            $penelitian->file_laporan = $filepath;
        }
        if($penelitian->save())
        {
            session()->flash('flash_success', 'Berhasil memperbaharui data penelitian');
            //Redirect ke halaman detail
            return redirect()->route('admin.penelitian.show', [$penelitian->id]);
        }
        return redirect()->back()->withErrors();

    }

    public function destroy(Request $request, Penelitian $penelitian)
    {
        //Hapus dulu anggota penelitinya
        foreach($penelitian->anggotas as $anggota){
                $anggota->delete();
        }
        if($penelitian->delete()) {
            session()->flash('flash_success', 'Berhasil menghapus data penelitian');
            return redirect()->route('admin.penelitian.index');
        }
    }

}
