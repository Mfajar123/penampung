@extends('dashboard.hrd')

@section('main')
    <section class="content-header">
        <h1>Edit Menu</h1>
    </section><!-- /.content-header -->

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Edit</h3>
            </div>
            <div class="box-body">
                {!! Form::model($menu, ['method' => 'PATCH', 'route' => ['menu.perbarui', $menu->id_menu]]) !!}
                    @include('hrd.menu.form', ['btnSubmit' => 'Edit Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
