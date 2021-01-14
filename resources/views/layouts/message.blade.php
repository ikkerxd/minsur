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
@if ( Session::has('error') )
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
    </button>
    <i class="fa fa-ban" aria-hidden="true"></i> {{ Session::get('error') }}
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