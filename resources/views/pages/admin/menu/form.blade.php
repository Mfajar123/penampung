@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css') }}">
@stop

<div class="form-group">
    {!! Form::label('menu_sub', 'Menu Parent', ['class' => 'control-label']) !!}
    {!! Form::select('menu_sub', $list_menu, isset($menu->parent_id_1) ? $menu->parent_id_1 : null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama_menu', 'Menu Name', ['class' => 'control-label']) !!}
    {!! Form::text('nama_menu', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="menu_type" class="control-label">Menu Type</label>
    <select name="menu_type" id="menu_type" class="form-control">
        <option value="NORMAL">NORMAL</option>
        <option value="HEADER">HEADER</option>
    </select>
</div>

<div class="form-group">
    {!! Form::label('link_menu', 'Link Menu', ['class' => 'control-label']) !!}
    {!! Form::text('link_menu', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('icon_menu', 'Icon Menu', ['class' => 'control-label']) !!}
    {!! Form::text('icon_menu', null, ['id' => 'icon_menu', 'class' => 'form-control']) !!}
</div>

{!! Form::submit($btnSubmit, ['class' => 'btn btn-primary']) !!}
<a href="{{ route('menu.index') }}" class="btn btn-default">Cancel</a>

@section('script')
    <script src="{{ asset('plugins/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#icon_menu').iconpicker({
                title: 'Icon Menu',
                placement: 'top'
            });
        });
    </script>
@stop