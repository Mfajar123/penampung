@extends('template')

@section('main')
<section class="content-header">

  <h1>Menu</h1>

  </ol>
</section>



<!-- Main content -->

<section class="content">

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-actions">
                <a href="#" id="btn-tambah" class="btn btn-primary btn-tambah" title="Belanja"><i class="fa fa-plus"></i> Tambah Menu</a>
            </div>
        </div>
        <div class="box-body">
            
            {!! Form::open([ 'route' => 'menu.save_position', 'class' => 'dropzone', 'id' => 'reportfile' ]) !!}

            <div class="table-responsive">
                <table class="table table-striped table-bordered display nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="10%">ID Menu</th>
                            <th width="40%">Menu Name</th>
                            <th width="20%">Link Menu</th>
                            <th width="10%">Icon Menu</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                </table>
                <ul id="sortable" style="padding: 0; margin:0; list-style: none;">
                    @if (count($list_menu) > 0)
                        <?php $no = 1; ?>

                        @foreach ($list_menu as $menu)

                            @if(!empty($menu->id_menu))

                            <li class="ui-state-default" style="padding: 0; margin:0; list-style: none;">
                            
                                <table class="table table-bordered table-hover table-striped" style="margin-bottom:0;" title="Drag to reposition">
                                    <tbody>
                                        <tr>
                                            <td width="5%" class="move"><i class="fa fa-bars"></i></td>
                                            <td width="10%">{{ $menu->id_menu }}</td>
                                            <td width="40%">{{ $menu->nama_menu }}</td>
                                            <td width="20%">{{ empty($menu->link_menu) ? '-' : $menu->link_menu }}</td>
                                            <td width="10%">
                                                @if (empty($menu->icon_menu))
                                                    -
                                                @else
                                                    <i class="fa fa-{{ $menu->icon_menu }}"></i>
                                                @endif
                                                <input type="hidden" name="id_menu[]" value="{{ $menu->id_menu }}">
                                                <input type="hidden" name="position[]" value="x">
                                            </td>
                                            <td width="30%">
                                                <a href="#" class="btn-edit" title="Edit" data-id="{{$menu->id_menu}}"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn-hapus" title="Delete" data-id="{{$menu->id_menu}}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <ul class="sortable2" style="padding: 0; margin:0; list-style: none;">

                                    @if (!empty($menu->child))
                                        <?php $no = 1; ?>
                                        @foreach ($menu->child as $childs)
                                            
                                            <li class="ui-state-default" style="padding: 0; margin:0; list-style: none;">
                                            
                                                <table class="table table-bordered table-hover table-striped" style="margin-bottom:0;" title="Drag to reposition">
                                                    <tbody>
                                                        <tr>
                                                            <td width="5%" style="padding-left: 20px;" class="move2"><i class="fa fa-bars"></i></td>
                                                            <td width="10%">{{ $childs->id_menu }}</td>
                                                            <td width="40%"> --> {{ $childs->nama_menu }}</td>
                                                            <td width="20%">{{ empty($childs->link_menu) ? '-' : $childs->link_menu }}</td>
                                                            <td width="10%">
                                                                @if (empty($childs->icon_menu))
                                                                    -
                                                                @else
                                                                    <i class="fa fa-{{ $childs->icon_menu }}"></i>
                                                                @endif
                                                                <input type="hidden" name="id_menu[]" value="{{ $childs->id_menu }}">
                                                                <input type="hidden" name="position[]" value="x">
                                                            </td>
                                                            <td width="30%">
                                                                <a href="#" class="btn-edit" title="Edit" data-id="{{$childs->id_menu}}"><i class="fa fa-edit"></i></a>
                                                                <a href="#" class="btn-hapus" title="Delete" data-id="{{$childs->id_menu}}"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                
                                                <ul class="sortable3" style="padding: 0; margin:0; list-style: none;">

                                                    @if (!empty($childs->child))
                                                        <?php $no = 1; ?>
                                                        @foreach ($childs->child as $childs2)
                                                            
                                                            <li class="ui-state-default" style="padding: 0; margin:0; list-style: none;">
                                                            
                                                                <table class="table table-bordered table-hover table-striped" style="margin-bottom:0;" title="Drag to reposition">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width="5%" style="padding-left: 30px;" class="move3"><i class="fa fa-bars"></i></td>
                                                                            <td width="10%">{{ $childs2->id_menu }}</td>
                                                                            <td width="40%"> ----> {{ $childs2->nama_menu }}</td>
                                                                            <td width="20%">{{ empty($childs2->link_menu) ? '-' : $childs2->link_menu }}</td>
                                                                            <td width="10%">
                                                                                @if (empty($childs2->icon_menu))
                                                                                    -
                                                                                @else
                                                                                    <i class="fa fa-{{ $childs2->icon_menu }}"></i>
                                                                                @endif
                                                                                <input type="hidden" name="id_menu[]" value="{{ $childs2->id_menu }}">
                                                                                <input type="hidden" name="position[]" value="x">
                                                                            </td>
                                                                            <td width="30%">
                                                                                <a href="#" class="btn-edit" title="Edit" data-id="{{$childs2->id_menu}}"><i class="fa fa-edit"></i></a>
                                                                                <a href="#" class="btn-hapus" title="Delete" data-id="{{$childs2->id_menu}}"><i class="fa fa-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </li>
                                                        @endforeach
                                                    @endif
                                                    
                                                </ul>

                                            </li>
                                        @endforeach
                                    @endif

                                </ul>

                            </li>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No data.</td>
                        </tr>
                    @endif
                </ul>
            </div><!-- /.table-responsive -->
            <br><br>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update posisi menu</button>
            {!! Form::close() !!}
        </div>
    </div>
    
    <div class="modal fade" id="modalFormMenu2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {!! Form::open(['method' => 'POST', 'route' => 'menu.simpan']) !!}
                    <div class="modal-body">
                        {!! Form::hidden('id_menu', '', ['id' => 'id_menu']) !!}
                        
                        <div class="form-group">
                            {!! Form::label('menu_sub', 'Menu Parent', ['class' => 'control-label']) !!}
                            {!! Form::select('menu_sub', $list_menu2, isset($menu->parent_id_1) ? $menu->parent_id_1 : null, ['class' => 'form-control']) !!}
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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
            
@stop

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/nestable.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/nestable.css') }}">

<script>
    $( function() {

        $("#sortable").sortable({
            containment: "parent",
            handle: ".move",
            tolerance: "pointer",
            cursor: "move",
            opacity: 0.7,
            revert: 300,
            delay: 150,
            dropOnEmpty: true,
            placeholder: "movable-placeholder",
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            }
        });
        
        // Sort the children
        $(".sortable2").sortable({
            handle: ".move2",
        });
        
        // Sort the children
        $(".sortable3").sortable({
            handle: ".move3",
        });

    } );


    var action;

    var modalForm = $('#modalFormMenu2');
    var modalFormTitle = $(modalForm).find('.modal-title');

    var form = $(modalForm).find('form');

    var idMenu      = $(form).find('input[name="id_menu"]');
    var menuSub     = $(form).find('input[name="menu_sub"]');
    var namaMenu    = $(form).find('input[name="nama_menu"]');
    var menuType    = $(form).find('input[name="menu_type"]');
    var menuLink    = $(form).find('input[name="link_menu"]');
    var menuIcon    = $(form).find('input[name="icon_menu"]');

    function clearForm() {
        $(idMenu).val('');
        $(menuSub).val('');
        $(namaMenu).val('');
        $(menuType).val('');
        $(menuLink).val('');
        $(menuIcon).val('');
        $(modalForm).find('button[type="submit"]').removeAttr('disabled');
    }

    $(document).ready(function () {

        $('.btn-tambah').on('click', function (e) {
            e.preventDefault();

            action = 'tambah';

            clearForm();

            $(modalFormTitle).html('Tambah Menu');
            $(modalForm).modal('show');
        });

        $('.table').on('click', '.btn-edit', function (e) {

            e.preventDefault();

            var id = this.getAttribute('data-id');

            action = 'edit';

            clearForm();

            $.ajax({
                url: "{{ route('menu.index') }}/"+id+"/edit",
                type: "GET",
                success: function (data) {

                    // alert(data.menu.id_menu);

                    $(idMenu).val(data.menu.id_menu);
                    $(menuSub).val(data.menu.parent_id_1);
                    $(namaMenu).val(data.menu.nama_menu);
                    $(menuType).val(data.menu.menu_type);
                    $(menuLink).val(data.menu.link_menu);
                    $(menuIcon).val(data.menu.icon_menu);

                    $(modalFormTitle).html('Edit Menu');
                    $(modalForm).modal('show');

                }
            });
        });

        $('.table').on('click', '.btn-hapus', function (e) {
            e.preventDefault();

            var id = this.getAttribute('data-id');
            
            if (confirm('Anda yakin ingin menghapus data tersebut?')) {

                $.ajax({
                    url: "{{ route('menu.index') }}/"+id+"/hapus",
                    type: "GET",
                    data: {id},
                    success: function (data) {
                        alert('Data berhasil dihapus.');

                        document.location="{{ route('menu.index') }}";

                    }
                });
            }
        });

        $(form).on('submit', function (e) {

            e.preventDefault();

            $(modalForm).find('button[type="submit"]').attr('disabled', 'disabled').html('Menyimpan...');

            if (action === 'tambah') {
                url = "{{ route('menu.simpan') }}";
                type = 'POST';
            } else {
                var id = $(idMenu).val();

                url = "{{ route('menu.index') }}/"+id+"/perbarui";
                type = 'PATCH';
            }

            $.ajax({
                url: url,
                type: type,
                data: $(form).serialize(),
                success: function (data) {
                    $(modalForm).modal('hide');
                    document.location="{{ route('menu.index') }}";
                }
            });
        });
    });
</script>
@stop