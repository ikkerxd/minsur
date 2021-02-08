<!--Messages -->
@if ( Session::has('success') )
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
    </button>
    <i class="fa fa-check" aria-hidden="true"></i> {{ Session::get('success') }}
</div>
@endif
@if ( Session::has('danger') )
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
    </button>
    <i class="fa fa-ban" aria-hidden="true"></i> {{ Session::get('danger') }}
</div>
@endif 
@if ( Session::has('warning') )
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <i class="fa fa-ban" aria-hidden="true"></i> {{ Session::get('warning') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Sorry!</strong> Tienes problemas con tu Solicitud.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
</div>
@endif