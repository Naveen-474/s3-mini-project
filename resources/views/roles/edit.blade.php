@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Role Edit</h1>
        </div>
        @if (session('failure'))
            <div class="alert alert-danger" role="alert">
                {{ session('failure') }}
            </div>
        @endif
        <!-- End Page Heading -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Role') }}</div>
                    <div class="card-body">
                        <form action="{{url('/role')}}/{{$role->id}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="name" value="{{$role->name}}" class="form-control">

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
                                                           value="{{$permission->id}}" class="form-check-input" type="checkbox" id="permission_id">
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
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
