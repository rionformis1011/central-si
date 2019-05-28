<?php
namespace App\Http\Controllers;
use App\RefSkemaPengabdian;
use App\RefSumberDana;
use App\Pengabdian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PengabdianController extends Controller
{
    public function index()
    {
        $pengabdians = pengabdian::paginate(25);
        return view('backend.pengabdian.index', compact('pengabdians'));
    }
    public function create()
    {
        $skema_pengabdian = RefSkemapengabdian::all()->pluck('nama', 'id');
        $sumber_dana = RefSumberDana::all()->pluck('nama', 'id');
        return view('backend.pengabdian.create', compact('skema_pengabdian', 'sumber_dana'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tahun' => 'required|digits:4',
            'total_dana' => 'numeric',
            'skema_pengabdian_id' => 'required',
            'sumber_dana_id' => 'required',
            'file_kontrak' => 'file|mimes:pdf',
            'file_laporan' => 'file|mimes:pdf'
        ]);

        $file_kontrak = null;
        if($request->hasFile('file_kontrak') && $request->file('file_kontrak')->isValid())
        {
            $filename = uniqid('kontrak-');
            $fileext = $request->file('file_kontrak')->extension();
            $filenameext = $filename.'.'.$fileext;
            $file_kontrak = $request->file_kontrak->storeAs('public/pengabdian_kontrak', $filenameext);
        }
        $file_laporan = null;
        if($request->hasFile('file_laporan') && $request->file('file_laporan')->isValid())
        {
            $filename = uniqid('laporan-');
            $fileext = $request->file('file_laporan')->extension();
            $filenameext = $filename.'.'.$fileext;
            $file_laporan = $request->file_laporan->storeAs('public/pengabdian_laporan', $filenameext);
        }
        $pengabdian = pengabdian::create([
            'judul' => $request->input('judul'),
            'tahun' => $request->input('tahun'),
            'total_dana' => $request->input('total_dana'),
            'sumber_dana_id' => $request->input('sumber_dana_id'),
            'skema_pengabdian_id' => $request->input('skema_pengabdian_id'),
            'file_kontrak' => $file_kontrak,
            'file_laporan' => $file_laporan
        ]);
        if($pengabdian->save()) {
            session()->flash('flash_success', 'Berhasil menambahkan data pengabdian baru');

            return redirect()->route('admin.pengabdian-user.create', [$pengabdian->id]);
        }
        return redirect()->back()->withErrors();
    }
    public function show(Pengabdian $pengabdian)
    {
        $file_kontrak_url = Storage::url($pengabdian->file_kontrak);
        $file_laporan_url = Storage::url($pengabdian->file_laporan);
        return view('backend.pengabdian.show', compact('pengabdian', 'file_kontrak_url', 'file_laporan_url'));
    }
    public function edit(Pengabdian $pengabdian)
    {
        $skema_pengabdian = RefSkemapengabdian::all()->pluck('nama', 'id');
        $sumber_dana = RefSumberDana::all()->pluck('nama', 'id');
        return view('backend.pengabdian.edit', compact('pengabdian', 'skema_pengabdian', 'sumber_dana'));
    }
    public function update(Request $request, pengabdian $pengabdian)
    {
        $request->validate([
            'judul' => 'required',
            'tahun' => 'required|digits:4',
            'total_dana' => 'numeric',
            'skema_pengabdian_id' => 'required',
            'sumber_dana_id' => 'required',
            'file_kontrak' => 'file|mimes:pdf',
            'file_laporan' => 'file|mimes:pdf'
        ]);
        $pengabdian->judul = $request->input('judul');
        $pengabdian->tahun = $request->input('tahun');
        $pengabdian->total_dana = $request->input('total_dana');
        $pengabdian->skema_pengabdian_id = $request->input('skema_pengabdian_id');
        $pengabdian->sumber_dana_id = $request->input('sumber_dana_id');

        if($request->file('file_kontrak')->isValid())
        {
 
            if(Storage::exists($pengabdian->file_kontrak))
            {
                Storage::delete($pengabdian->file_kontrak);
            }
            $filename = uniqid('kontrak-');
            $fileext = $request->file('file_kontrak')->extension();
            $filenameext = $filename.'.'.$fileext;
            $filepath = $request->file_kontrak->storeAs('public/pengabdian_kontrak', $filenameext);
            $pengabdian->file_kontrak = $filepath;
        }
        if($request->file('file_laporan')->isValid())
        {

            if(Storage::exists($pengabdian->file_laporan))
            {
                Storage::delete($pengabdian->file_laporan);
            }

            $filename = uniqid('laporan-');
            $fileext = $request->file('file_laporan')->extension();
            $filenameext = $filename.'.'.$fileext;
            $filepath = $request->file_laporan->storeAs('public/pengabdian_laporan', $filenameext);
            $pengabdian->file_laporan = $filepath;
        }
        if($pengabdian->save())
        {
            session()->flash('flash_success', 'Berhasil memperbaharui data pengabdian');

            return redirect()->route('admin.pengabdian.show', [$pengabdian->id]);
        }
        return redirect()->back()->withErrors();
    }
    public function destroy(Request $request, pengabdian $pengabdian)
    {

        foreach($pengabdian->anggotas as $anggota){
                $anggota->delete();
        }
        if($pengabdian->delete()) {
            session()->flash('flash_success', 'Berhasil menghapus data pengabdian');
            return redirect()->route('admin.pengabdian.index');
        }
    }
}