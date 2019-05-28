<?php

namespace App\Http\Controllers;

use App\Penelitian;
use App\PenelitianUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenelitianUserController extends Controller
{

    public function create(Penelitian $penelitian)
    {
        $users = User::all()->pluck('nama', 'id');
        $file_kontrak_url = Storage::url($penelitian->file_kontrak);
        $file_laporan_url = Storage::url($penelitian->file_laporan);
        return view('backend.penelitian.user.create', compact('penelitian', 'users', 'file_laporan_url', 'file_kontrak_url'));
    }

    public function store(Request $request)
    {
        $penelitianUser = new PenelitianUser();
        $penelitianUser->penelitian_id = $request->input('penelitian_id');
        $penelitianUser->user_id = $request->input('user_id');
        $penelitianUser->jabatan = $request->input('jabatan');
        if($penelitianUser->save()){
            session()->flash('flash_success', 'Berhasil menambahkan anggota peneliti');
            return redirect()->route('admin.penelitian-user.create', [$request->input('penelitian_id')]);
        }

    }

    public function destroy(Penelitian $penelitian, PenelitianUser $user)
    {
        if($user->delete()){
            session()->flash('flash_success', 'Berhasil menghapus anggota penelitian');
            return redirect()->route('admin.penelitian-user.create', [$penelitian->id]);
        }
    }
}
