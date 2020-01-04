@extends ('template')

@section ('main')
    <section class="content-header">
        <h1>Tambah Agenda</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li class="active">Tambah Agenda</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">Form</h4>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.agenda.store']) !!}
                    @include('pages.admin.agenda.form', ['btnSubmitText' => 'Simpan'])
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop