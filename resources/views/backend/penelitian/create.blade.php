@extends('backend.layouts.app')

@section('breadcrumb')
    {!! cui_breadcrumb([
        'Home' => route('admin.home'),
        'Penelitian' => route('admin.penelitian.index'),
        'Edit' => '#'
    ]) !!}
@endsection

@section('toolbar')
    {!! cui_toolbar_btn(route('admin.penelitian.index'), 'icon-list', 'List Penelitian') !!}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                {{ Form::open(['route' => 'admin.penelitian.store', 'method' => 'post', 'files' => 'true']) }}

                {{-- CARD HEADER --}}
                <div class="card-header">
                    Tambah Penelitian
                </div>

                {{-- CARD BODY --}}
                <div class="card-body">
                    @include('backend.penelitian._form')
                </div>

                {{-- CARD FOOTER --}}
                <div class="card-footer">
                    <input type="submit" value="Simpan" class="btn btn-primary"/>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection
