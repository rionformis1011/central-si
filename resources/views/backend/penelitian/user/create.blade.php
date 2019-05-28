@extends('backend.layouts.app')

@section('breadcrumb')
    {!! cui_breadcrumb([
        'Home' => route('admin.home'),
        'Penelitian' => route('admin.penelitian.index'),
        'Detail' => '#'
    ]) !!}
@endsection

@section('toolbar')
    {!! cui_toolbar_btn(route('admin.penelitian.show', [$penelitian->id]), 'icon-eye', 'Lihat Penelitian') !!}
    {!! cui_toolbar_btn_delete(route('admin.penelitian.destroy', [$penelitian->id]), $penelitian->id, 'icon-trash', 'Hapus Penelitian', 'Anda yakin akan menghapus penelitian ini?') !!}
    {!! cui_toolbar_btn(route('admin.penelitian.edit', [$penelitian->id]), 'icon-pencil', 'Edit Penelitian') !!}
    {!! cui_toolbar_btn(route('admin.penelitian.index'), 'icon-list', 'List Penelitian') !!}
    {!! cui_toolbar_btn(route('admin.penelitian.create'), 'icon-plus', 'Tambah Penelitian') !!}
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                {{-- CARD HEADER--}}
                <div class="card-header">
                    Detail Penelitian
                </div>

                {{-- CARD BODY--}}
                <div class="card-body">

                    {{ Form::model($penelitian, []) }}

                    <div class="form-group">
                        <label for="judul"><strong>Judul</strong></label>
                        {{ Form::text('judul', null, ['class' => 'form-control-plaintext', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="form-group">
                        <label for="tahun"><strong>Tahun</strong></label>
                        {{ Form::text('tahun', null, ['class' => 'form-control-plaintext', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="form-group">
                        <label for="lama_tahun"><strong>Jangka Waktu</strong></label>
                        {{ Form::text('lama_tahun', null, ['class' => 'form-control-plaintext', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="form-group">
                        <label for="total_dana"><strong>Total Dana</strong></label>
                        {{ Form::text('total_dana', number_format($penelitian->total_dana, 0, ',', '.'), ['class' => 'form-control-plaintext', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="form-group">
                        <label for="skema_penelitian_id"><strong>Skema Penelitian</strong></label>
                        {{ Form::text('skema_penelitian_id', optional($penelitian->skema_penelitian)->nama, ['class' => 'form-control-plaintext', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="form-group">
                        <label for="sumber_dana_id"><strong>Sumber Dana</strong></label>
                        {{ Form::text('sumber_dana_id', optional($penelitian->sumber_dana)->nama, ['class' => 'form-control-plaintext', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="form-group">
                        <label for="file_kontrak"><strong>File Kontrak</strong></label>
                        @if(!empty($penelitian->file_kontrak))
                            <a href="{{ $file_kontrak_url }}"><i class="fa fa-file-pdf"></i> Download</a>
                        @else
                            Tidak ada file
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="file_laporan"><strong>File Laporan</strong></label>
                        @if(!empty($penelitian->file_laporan))
                            <a href="{{ $file_laporan_url }}"><i class="fa fa-file-pdf"></i> Download</a>
                        @else
                            Tidak ada file
                        @endif
                    </div>

                    {{ Form::close() }}

                    <div class="form-group">
                        <label for=""><strong>Anggota Penelitian</strong></label>
                        <ul class="list-group">
                            <li class="list-group-item">
                                {{ Form::open(['route' => 'admin.penelitian-user.store', 'method' => 'post']) }}
                                {{ Form::hidden('penelitian_id', $penelitian->id) }}
                                <div class="row">
                                    <div class="col-md-6">
                                        {{ Form::select('user_id', $users, null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::select('jabatan', [1 => 'Ketua', 2=> 'Anggota'], null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary" > <i class="fa fa-floppy-o"></i> Tambah</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </li>
                            @forelse($penelitian->anggotas as $anggota)
                                <li class="list-group-item">{{ optional($anggota->user)->nama }} @if($anggota->jabatan == 1) / Ketua @else / Anggota @endif {!! cui_btn_delete(route('admin.penelitian-user.destroy', [$penelitian->id, $anggota->id]), 'Anda yakin menghapus anggota penelitian ini?') !!}</li>
                            @empty
                                <li class="list-group-item"> Tidak ada anggota penelitian</li>
                            @endforelse
                        </ul>
                    </div>


                </div>

                {{-- CARD FOOTER --}}
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>

@endsection