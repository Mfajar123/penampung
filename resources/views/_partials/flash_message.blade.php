@if (Session::has('flash_message'))

    <div class="alert alert-info alert-dismissible alert-slide" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <i class="fa fa-info"></i> {{ Session::get('flash_message') }}

    </div>

@elseif(Session::has('success'))

	<div class="alert alert-success alert-dismissible alert-slide" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <i class="fa fa-check"></i> {{ Session::get('success') }}

    </div>

@elseif(Session::has('fail'))

	<div class="alert alert-danger alert-dismissible alert-slide" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <i class="fa fa-remove"></i> {{ Session::get('fail') }}

    </div>

@endif

