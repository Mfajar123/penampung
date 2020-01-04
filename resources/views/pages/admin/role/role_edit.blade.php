@extends('template')

@section('main')

<section class="content-header">

  <h1>Akses Role</h1>

  </ol>
</section>



<!-- Main content -->

<section class="content">

    <div class="box">
        <div class="box-header">
            <i class="fas fa-shopping-cart"></i> <strong>Role Akses untuk {{ $role->role_name }}</strong>
        </div>
        <div class="box-body">
            
            {!! Form::open([ 'route' => ['role_link.save_role', $id], 'id' => 'reportfile' ]) !!}

            <div class="table-responsive">
                <table class="table table-striped table-bordered display nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="20%">Menu Name</th>
                            <th style="display:none; " width="15%">All</th>
                            <th width="15%">Can Access</th>
                            <th style="display: none" width="15%">Can Create</th>
                            <th style="display: none" width="15%">Can Modify</th>
                            <th style="display: none" width="15%">Can Delete</th>
                            <th style="display: none" width="15%">Restricted</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($list_menu) > 0)
                        <?php $no = 1; ?>

                        @foreach ($list_menu as $menu)

                            @if(!empty($menu->id_menu))

                                    <tr>
                                        <td width="5%" class="move">{{$no}}</td>
                                        <td width="20%">{{ $menu->nama_menu }}</td>
                                        <td style="display:none; " width="15%"><input type="checkbox" <?php echo (@$role_before[$menu->id_menu]['all'] == '1') ? 'checked' : '' ?> onclick="$(this).parent().parent().find('input.check').click()"></td>
                                        <td width="15%"><input type="checkbox" <?php echo (@$role_before[$menu->id_menu]['can_access'] == '1') ? 'checked' : '' ?> name="can_access[{{ $menu->id_menu }}]" class="check" value="1"></td>
                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$menu->id_menu]['can_access'] == '1') ? 'checked' : '' ?> name="can_create[{{ $menu->id_menu }}]" class="check" value="1"></td>
                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$menu->id_menu]['can_modify'] == '1') ? 'checked' : '' ?> name="can_modify[{{ $menu->id_menu }}]" class="check" value="1"></td>
                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$menu->id_menu]['can_delete'] == '1') ? 'checked' : '' ?> name="can_delete[{{ $menu->id_menu }}]" class="check" value="1"></td>
                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$menu->id_menu]['see_restricted'] == '1') ? 'checked' : '' ?> name="see_restricted[{{ $menu->id_menu }}]" class="check" value="1"></td>
                                    </tr>

                                    @if (!empty($menu->child))
                                        @foreach ($menu->child as $childs)

                                        @if(isset($childs->nama_menu))
                                            
                                            <tr>
                                                <td width="5%" class="move">{{$no}}</td>
                                                <td width="20%" style="padding-left: 30px;">|-- {{ $childs->nama_menu }}</td>
                                                <td style="display:none; " width="15%"><input type="checkbox" <?php echo (@$role_before[$childs->id_menu]['all'] == '1') ? 'checked' : '' ?> onclick="$(this).parent().parent().find('input.check').click()"></td>
                                                <td width="15%"><input type="checkbox" <?php echo (@$role_before[$childs->id_menu]['can_access'] == '1') ? 'checked' : '' ?> name="can_access[{{ $childs->id_menu }}]" class="check" value="1"></td>
                                                <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs->id_menu]['can_access'] == '1') ? 'checked' : '' ?> name="can_create[{{ $childs->id_menu }}]" class="check" value="1"></td>
                                                <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs->id_menu]['can_modify'] == '1') ? 'checked' : '' ?> name="can_modify[{{ $childs->id_menu }}]" class="check" value="1"></td>
                                                <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs->id_menu]['can_delete'] == '1') ? 'checked' : '' ?> name="can_delete[{{ $childs->id_menu }}]" class="check" value="1"></td>
                                                <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs->id_menu]['see_restricted'] == '1') ? 'checked' : '' ?> name="see_restricted[{{ $childs->id_menu }}]" class="check" value="1"></td>
                                            </tr>
                                            <?php $no++; ?>

                                            @if (!empty($childs->child))
                                            <?php //var_dump($childs->child) ?>
                                                @foreach ($childs->child as $childs2)
                                                    
                                                    <tr>
                                                        <td width="5%" class="move">{{$no}}</td>
                                                        <td width="20%" style="padding-left: 60px;">|-- {{ $childs2->nama_menu }}</td>
                                                        <td style="display:none; " width="15%"><input type="checkbox" <?php echo (@$role_before[$childs2->id_menu]['all'] == '1') ? 'checked' : '' ?> onclick="$(this).parent().parent().find('input.check').click()"></td>
                                                        <td width="15%"><input type="checkbox" <?php echo (@$role_before[$childs2->id_menu]['can_access'] == '1') ? 'checked' : '' ?> name="can_access[{{ $childs2->id_menu }}]" class="check" value="1"></td>
                                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs2->id_menu]['can_access'] == '1') ? 'checked' : '' ?> name="can_create[{{ $childs2->id_menu }}]" class="check" value="1"></td>
                                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs2->id_menu]['can_modify'] == '1') ? 'checked' : '' ?> name="can_modify[{{ $childs2->id_menu }}]" class="check" value="1"></td>
                                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs2->id_menu]['can_delete'] == '1') ? 'checked' : '' ?> name="can_delete[{{ $childs2->id_menu }}]" class="check" value="1"></td>
                                                        <td style="display:none;" width="15%"><input type="checkbox" <?php echo (@$role_before[$childs2->id_menu]['see_restricted'] == '1') ? 'checked' : '' ?> name="see_restricted[{{ $childs2->id_menu }}]" class="check" value="1"></td>
                                                    </tr>
                                                    <?php $no++; ?>
                                                @endforeach
                                            @endif

                                        @endif

                                        @endforeach
                                    @endif


                                    
                                </ul>

                            </li>
                            <?php $no++; ?>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No data.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
            <br><br>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Akses Role</button>
            {!! Form::close() !!}
        </div>
    </div>
</section>

@stop