@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User List</h1>
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
                @can('user.create')
                <a href="{{route('user.create')}}" class="btn btn-primary mb-2">Create User</a>
                @endcan
                <br>
                <div class="row">
                <table class="table table-bordered table-fixed">
                    <thead>
                    <tr>
                        <th class="col-1">S.No</th>
                        <th class="col-2">User Name</th>
                        <th class="col-6">User Role</th>
                        <th class="col-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $currentPage = (\Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage() - 1) * 10;
                    @endphp
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{$currentPage+$key+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                {{implode(", ",$user->roles->pluck('name')->toarray())}}
                            </td>
                            <td>
                                @if($user->name!='Super_Admin')
                                    <a class="btn btn-primary" href="{{route('user.show',$user->id)}}">Show</a>
                                    @can('user.edit')
                                        <a class="btn btn-warning" href="{{route('user.edit',$user->id)}}">Edit</a>
                                    @endcan
                                    @can('user.delete')
                                        <a class="d-inline" href="#" data-toggle="modal" data-target="#deleteModal"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('delete');">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </a>
                                    @endcan
                                @else
                                    <a class="btn btn-primary" href="{{route('user.show',$user->id)}}">Show</a>
                               @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <div style="margin-top: 10px;">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you want to delete all the tickets raised by this user.</div>
                <div class="modal-footer">
                    <form id="delete" action ="{{route('user.destroy',$user->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
