@extends('backend.layouts.app')

@section('breadcrumb')
    {!! cui_breadcrumb([
        'Home' => route('admin.home'),
        'Penelitian' => route('admin.penelitian.index'),
        'Edit' => '#'
    ]) !!}
@endsection

@section('toolbar')
    {!! cui_toolbar_btn(route('admin.penelitian.create'), 'icon-plus', 'Tambah Penelitian') !!}
    {!! cui_toolbar_btn(route('admin.penelitian.index'), 'icon-list', 'List Penelitian') !!}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                {{ Form::model($penelitian, ['route' => ['admin.penelitian.update', $penelitian->id], 'method' => 'patch', 'files' => 'true']) }}

                {{--CARD HEADER --}}
                <div class="card-header">
                    Edit Penelitian
                </div>

                {{-- CARD BODY--}}
                <div class="card-body">
                    @include('backend.penelitian._form')
                </div>

                {{-- CARD FOOTER--}}
                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Simpan"/>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
