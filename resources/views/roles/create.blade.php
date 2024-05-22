@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Role</h1>
    </div>
    <!-- End Page Heading -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Role') }}</div>
                    <div class="card-body">
                        <form action="/role" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                                 </div>
                            <div class="row">
                                @if($permissionGroups->count())
                                    @foreach($permissionGroups as $permissiongroup)
                                        <div class="col-md-4">
                                            <h3> {{$permissiongroup->name}} </h3>
                                            @foreach($permissiongroup->permissions as $permission)
                                                <div class="form-check">
                                                    <input name = "permission_ids[]" value="{{$permission->id}}" class="form-check-input" type="checkbox" id="permission_id">
                                                    <label class="form-check-label" for="permission_id">
                                                        {{$permission->name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div style="margin-top: 20px;">
                                <a href="{{ route('role.index') }}" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
