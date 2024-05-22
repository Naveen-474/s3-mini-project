@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
    </div>
    <!-- End Page Heading -->
    <div class="container">
        @if (session('failure'))
            <div class="alert alert-danger" role="alert">
                {{ session('failure') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>
                    <div class="card-body">
                        <form action="{{url('/user')}}/{{$user->id}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                    <div class="text-danger"
                                         style="margin-top: 10px; margin-bottom: 10px;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
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
                                                <input name = "role_ids[]"
                                                       @if(in_array($role->id,$user->roles->pluck('id')->toarray()))
                                                           checked
                                                       @endif
                                                       value="{{ $role->id }}" class="form-check-input" type="checkbox" id="role_ids">
                                                <label class="form-check-label" for="role_ids">
                                                        {{ $role->name }}
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
                                <a href="{{ route('user.index') }}" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
