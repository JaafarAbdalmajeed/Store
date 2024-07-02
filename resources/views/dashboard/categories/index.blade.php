@extends('layouts.dashboard')

@section('content')

@include('dashboard.categories.createModel')
@include('dashboard.categories.editModel')

<div class="mb-5">

</div>

<div class="row">
    <div class="col-lg-12">
        <button type="button" class="btn btn-info btn-lg mb-3" data-toggle="modal" data-target="#createModel">Add Category</button>
        <a href="{{ route('categories.trash')}}" class="btn btn-dark btn-lg mb-3">Trash</a>
            <div class="card" id="category-table">

            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th>Slug</th>
                        <th>Count products</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td><img src="{{ asset('storage/'.$category->image) }}" alt="Category Image" class="img-thumbnail" width="50" height="50"></td>
                            <td>{{ $category->id }}</td>
                            <td><a href="{{route('category.show', $category->id)}}">{{ $category->name }}</a></td>
                            <td>{{ $category->parent? $category->parent->name : ''}}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>{{ $category->status }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <button  type="button" data-toggle="modal"  data-target="#editModal" data-id="{{ $category->id }}">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                            </td>

                            <td>
                                <button type="button" class="delete-category-btn" data-id="{{ $category->id }}">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No categories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="pagination-links">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="{{asset('js/category.js')}}"></script>

@endpush
