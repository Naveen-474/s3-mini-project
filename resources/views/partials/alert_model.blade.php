<div class="row">
    <div class="col-md-8 offset-md-2">
        @if(session('success'))
            <div class="alert alert-success mt-3" role="alert">
                {{session('success')}}
            </div>
        @endif
        @if(session('failure'))
            <div class="alert alert-danger mt-3" role="alert">
                {{session('failure')}}
            </div>
        @endif
    </div>
</div>
