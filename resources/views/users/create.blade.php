@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create User</h1>
    </div>
    <!-- End Page Heading -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create User') }}</div>
                    <div class="card-body">
                        <form action="/user" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <div class="text-danger"
                                         style="margin-top: 10px; margin-bottom: 10px;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="text-danger"
                                         style="margin-top: 10px; margin-bottom: 10px;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <h5>Select Roles</h5>
                            <div class="row">
                                @if($roles->count())
                                    @foreach($roles as $role)
                                        @if($role->name != 'Super_Admin')
                                        <div class="col-md-4">
                                                <div class="form-check">
                                                    <input name = "role_ids[]" value="{{$role->id}}" class="form-check-input" type="checkbox" id="role_ids">
                                                    <label class="form-check-label" for="role_ids">
                                                        {{$role->name}}
                                                    </label>
                                                </div>
                                            <br>
                                        </div>
                                        @endif
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
