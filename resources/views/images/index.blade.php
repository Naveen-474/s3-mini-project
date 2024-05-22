@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.alert_model')
        <div class="row justify-content-center">
            <div class="col-12">
                @can('image.create')
                    <a href="{{ route('image.create') }}" class="btn btn-primary mb-2">Upload Image</a>
                @endcan

                <table class="table table-hover" id="imageTable">
                    <thead class="text-center">
                    <tr>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Image Count</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($categories as $category)
                        @foreach($category->sub_category as $subCategory)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $subCategory->name }}</td>
                                <td>{{ $subCategory->imageCount }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('image.show', $subCategory->id) }}"><i class="fas fa-eye"></i></a>
                                    @can('image.edit')
                                        <a class="btn btn-warning" href="{{ route('image.edit', $subCategory->id) }}"><i class="fas fa-edit"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Initialize DataTable
        jQuery('#imageTable').DataTable({
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
    </script>
@endsection
