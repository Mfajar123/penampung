@extends ('template')

@section ('main')
    <section class="content-header">
        <h1>Edit Agenda</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li class="active">Edit Agenda</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">Form</h4>
            </div>
            <div class="box-body">
                {!! Form::model($agenda, ['method' => 'PATCH', 'route' => ['admin.agenda.update', $agenda->id_agenda]]) !!}
                    @include('pages.admin.agenda.form', ['btnSubmitText' => 'Perbarui'])
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop