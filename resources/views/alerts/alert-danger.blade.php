@if(Session::has('alert-danger'))
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ Session::get('alert-danger')}}
    </div>
@endif