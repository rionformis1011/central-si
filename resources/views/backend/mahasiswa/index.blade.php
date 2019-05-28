@extends('backend.layouts.app')

@section('breadcrumb')
    {!! cui_breadcrumb([
        'Home' => route('admin.home'),
        'Mahasiswa' => route('admin.mahasiswa.index'),
        'Index' => '#'
    ]) !!}
@endsection

@section('toolbar')
    {!! cui_toolbar_btn(route('admin.mahasiswa.create'), 'icon-plus', 'Tambah Mahasiswa') !!}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">

            <div class="card">
                <div class="card-header">
                    Form Pencarian
                </div>

                <div class="card-body">

                    <form method="post" action="{{ route('admin.mahasiswacari.show') }}">
                        <div class="form-row">
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <label for="keyword" class="col-form-label">Pencarian Mahasiswa </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="keyword" id="keyword" class="form-control mb-2 mr-sm-2"
                                       value="@if(isset($keyword)) {{ $keyword }} @endif"
                                       placeholder="Inputkan keyword berdasarkan nama atau nim"/>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary mb-2 btn-block"><i class="fa fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card">

                {{-- CARD HEADER--}}
                <div class="card-header">
                    Mahasiswa
                </div>

                {{-- CARD BODY--}}
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIM</th>
                            <th class="text-center">Angkatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswa->nama }}</td>
                                <td class="text-center">{{ $mahasiswa->nim }}</td>
                                <td class="text-center">{{ $mahasiswa->angkatan }}</td>
                                <td class="text-center">
                                    {!! cui_btn_view(route('admin.mahasiswa.show', [$mahasiswa->id])) !!}
                                    {!! cui_btn_edit(route('admin.mahasiswa.edit', [$mahasiswa->id])) !!}
                                    {!! cui_btn_delete(route('admin.mahasiswa.destroy', [$mahasiswa->id]), "Anda yakin akan menghapus data dosen ini?") !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row justify-content-end">
                        <div class="col-md-6 text-right">

                        </div>
                        <div class="col-md-6 justify-content-end">
                            <div class="row justify-content-end">
                                {{ $mahasiswas->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
