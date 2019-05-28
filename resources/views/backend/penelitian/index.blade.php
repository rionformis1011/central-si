@extends('backend.layouts.app')

@section('breadcrumb')
    {!! cui_breadcrumb([
        'Home' => route('admin.home'),
        'Penelitian' => route('admin.penelitian.index'),
        'Index' => '#'
    ]) !!}
@endsection

@section('toolbar')
    {!! cui_toolbar_btn(route('admin.penelitian.create'), 'icon-plus', 'Tambah Penelitian') !!}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">

                {{-- CARD HEADER--}}
                <div class="card-header">
                    <strong>List Penelitian</strong>
                </div>

                {{-- CARD BODY--}}
                <div class="card-body">

                    <div class="row justify-content-end">
                        <div class="col-md-6 text-right">

                        </div>
                        <div class="col-md-6 justify-content-end">
                            <div class="row justify-content-end">
                                {{ $penelitians->links() }}
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Judul</th>
                            <th class="text-center">Jumlah Anggota</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($penelitians as $penelitian)
                            <tr>
                                <td class="text-center">{{ $penelitian->tahun }}</td>
                                <td >{{ $penelitian->judul }}</td>
                                <td class="text-center"> {{ $penelitian->anggotas->count() }} </td>
                                <td class="text-center">
                                    {!! cui_btn_view(route('admin.penelitian.show', [$penelitian->id])) !!}
                                    {!! cui_btn_edit(route('admin.penelitian.edit', [$penelitian->id])) !!}
                                    {!! cui_btn_delete(route('admin.penelitian.destroy', [$penelitian->id]), "Anda yakin akan menghapus data penelitian ini?") !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data penelitian belum ada
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="row justify-content-end">
                        <div class="col-md-6 text-right">

                        </div>
                        <div class="col-md-6 justify-content-end">
                            <div class="row justify-content-end">
                                {{ $penelitians->links() }}
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
