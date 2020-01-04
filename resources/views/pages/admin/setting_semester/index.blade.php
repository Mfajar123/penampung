@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Setting Semester</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Setting</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.setting.semester.submit']) !!}
					{!! Form::submit('Update Semester', ['class' => 'btn btn-primary btn-lg btn-block', 'onClick' => 'return confirm("Anda yakin ingin menghapus data tersebut?")']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop