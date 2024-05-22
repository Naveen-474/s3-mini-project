@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center">
            <h1 class="h3 mb-0 text-gray-800">Role List</h1>
        </div>
        <!-- End Page Heading -->
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('failure'))
            <div class="alert alert-danger" role="alert">
                {{ session('failure') }}
            </div>
        @endif
        <div class="row justify-content-center">

            <div class="col-12">
                @can('role.create')
                <a href="{{route('role.create')}}" class="btn btn-primary mb-2">Create Role</a>
                @endcan
                @can('user.edit')
                <a href="{{route('user.index')}}" class="btn btn-primary mb-2">Assign Role to User</a>
                @endcan

                <br>
                <div class="row">


                <table class="table table-bordered table-fixed">
                    <!--Table head-->
                    <thead>
                    <tr>
                        <th class="col-1">S.No</th>
                        <th class="col-2">Role Name</th>
                        <th class="col-6">Permission</th>
                        <th class="col-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                       $currentPage = (\Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage() - 1) * 10;
                    @endphp
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>{{$currentPage+$key+1}}</td>
                            <td>{{$role->name}}</td>
                            <td>
                                {{implode(", ",$role->permissions->pluck('name')->toarray())}}
                            </td>
                            <td>
                                @if($role->name!='Super_Admin')
                                    <a class="btn btn-primary" href="{{route('role.show',$role->id)}}">Show</a>
                                    @can('role.edit')
                                        <a class="btn btn-warning" href="{{route('role.edit',$role->id)}}">Edit</a>
                                    @endcan
                                    @can('role.delete')
                                    <form method="POST" action="{{route('role.destroy',$role->id)}}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    @endcan
                                @else
                                    <a class="btn btn-primary" href="{{route('role.show',$role->id)}}">Show</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <div style="margin-top: 10px;">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
