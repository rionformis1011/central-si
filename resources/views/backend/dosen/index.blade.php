@extends('backend.layouts.app')

@section('breadcrumb')
    {!! cui_breadcrumb([
        'Home' => route('admin.home'),
        'Dosen' => route('admin.dosen.index'),
        'Index' => '#'
    ]) !!}
@endsection

@section('toolbar')
    {!! cui_toolbar_btn(route('admin.dosen.create'), 'icon-plus', 'Tambah Dosen') !!}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">

            <div class="card">
                <div class="card-header">
                    Form Pencarian
                </div>

                <div class="card-body">

                    <form method="post" action="{{ route('admin.dosencari.show') }}">
                        <div class="form-row">
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <label for="keyword" class="col-form-label">Pencarian Dosen </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="keyword" id="keyword" class="form-control mb-2 mr-sm-2"
                                       value="@if(isset($keyword)) {{ $keyword }} @endif"
                                       placeholder="Inputkan keyword berdasarkan nama atau nip"/>
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
                    <strong>List Dosen</strong>
                </div>

                {{-- CARD BODY--}}
                <div class="card-body">

                    <br>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">NIK</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dosens as $dosen)
                            <tr>
                                <td>{{ $dosen->nama }}</td>
                                <td class="text-center">{{ $dosen->nip }}</td>
                                <td class="text-center">{{ $dosen->nik }}</td>
                                <td class="text-center">
                                    {!! cui_btn_view(route('admin.dosen.show', [$dosen->id])) !!}
                                    {!! cui_btn_edit(route('admin.dosen.edit', [$dosen->id])) !!}
                                    {!! cui_btn_delete(route('admin.dosen.destroy', [$dosen->id]), "Anda yakin akan menghapus data dosen ini?") !!}
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
                                {{ $dosens->links() }}
                            </div>
                        </div>
                    </div>

                </div><!--card-body-->

                {{-- CARD FOOTER--}}
                <div class="card-footer">
                </div>

            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

@endsection
