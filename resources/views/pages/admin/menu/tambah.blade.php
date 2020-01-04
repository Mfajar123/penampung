@extends('dashboard.hrd')

@section('main')
    <section class="content-header">
        <h1>Add Menu</h1>
    </section><!-- /.content-header -->

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Form</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'route' => 'menu.simpan']) !!}
                    @include('hrd.menu.form', ['btnSubmit' => 'Save Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
