@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Show Role</h1>
        </div>
        <div class="float-right">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> <!-- Font Awesome back arrow icon -->
            </a>
        </div>
        <!-- End Page Heading -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Role') }}</div>
                    <div class="card-body">
                        <form action="/role" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="name" value="{{$role->name}}" class="form-control" readonly>
                                @if ($errors->has('name'))
                                    <div class="text-danger"
                                         style="margin-top: 10px; margin-bottom: 10px;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="row">
                                @if($permissionGroups->count())
                                    @foreach($permissionGroups as $permissiongroup)
                                        <div class="col-md-4">
                                            <h3> {{$permissiongroup->name}} </h3>
                                            @foreach($permissiongroup->permissions as $permission)
                                                <div class="form-check">
                                                    <input name = "permission_ids[]"
                                                           @if(in_array($permission->id,$role->permissions->pluck('id')->toarray()))
                                                               checked
                                                           @endif
                                                           value="{{$permission->id}}" class="form-check-input" type="checkbox" id="gridCheck1" disabled>
                                                    <label class="form-check-label" for="gridCheck1">
                                                        {{$permission->name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
