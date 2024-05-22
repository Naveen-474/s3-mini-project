@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.alert_model')
        @can('category.create')
            <div class="m-2">
                <a class="btn btn-primary" href="{{route('category.create')}}">Create Category</a>
            </div>
        @endcan
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table table-hover" id="categoryTable">
                    <thead class="text-center">
                    <tr>
                        <th class="col-2">S.No</th>
                        <th class="col-7">Name</th>
                        <th class="col-3">Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @php
                        $count = 1;
                    @endphp
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('category.show', $category->id)}}" title="Show"><i class="fas fa-eye"></i></a>
                                @can('category.edit')
                                    <a class="btn btn-warning" href="{{route('category.edit', $category->id)}}" title="Edit"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('category.delete')
                                    <button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteConfirmationModal" data-id="{{ $category->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteConfirmationMessage">Are you sure you want to delete this category?</div>
                <div class="modal-footer">
                    <form method="POST" action="" class="d-inline" id="deleteConfirmationForm">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Initialize DataTable
        jQuery('#categoryTable').DataTable({
            "oLanguage": {
                "sEmptyTable": "No contents to display"
            },
            order: [],
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [-1, 'no-sort']
                }
            ]
        });

        // Set form action dynamically based on clicked delete button
        jQuery(document).ready(function() {
            jQuery('.delete-button').on('click', function() {
                var categoryId = jQuery(this).data('id');
                var formAction = "{{ route('category.destroy', ':id') }}";
                formAction = formAction.replace(':id', categoryId);
                jQuery('#deleteConfirmationForm').attr('action', formAction);
            });
        });
    </script>
@endsection
