@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Show User</h1>
    </div>
    <div class="float-right">
        <a href="{{url()->previous()}}" class="btn btn-secondary">Back</a>
    </div>
    <!-- End Page Heading -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Show User') }}</div>
                    <div class="card-body">
                          <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" name="name" class="form-control" value="{{$user->name}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" value="{{$user->email}}" readonly>

                            </div>
                            <h5>User Roles</h5>
                            <div class="row">
                                @if($roles->count())
                                    @foreach($roles as $role)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input name = "role_ids[]"
                                                       @if(in_array($role->id,$user->roles->pluck('id')->toarray()))
                                                           checked
                                                       @endif
                                                       value="{{$role->id}}" class="form-check-input" type="checkbox" id="gridCheck1" disabled>
                                                <label class="form-check-label" for="gridCheck1">
                                                    {{$role->name}}
                                                </label>
                                            </div>
                                            <br>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
