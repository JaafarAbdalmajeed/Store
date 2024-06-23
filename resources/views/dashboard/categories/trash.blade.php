@extends('layouts.dashboard')

@section('content')

@include('dashboard.categories.createModel')
@include('dashboard.categories.editModel')
<div class="mb-5">
    <a href="{{route('category.index')}} " class="btn btn-primary btn-lg mb-3">back</a>
</div>

<div class="row">
    <div class="col-lg-12">
        <button type="button" class="btn btn-info btn-lg mb-3" data-toggle="modal" data-target="#createModel">Add Category</button>
            <div class="card" id="category-table">

            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Deleted At</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td><img src="{{ asset('storage/'.$category->image) }}" alt="Category Image" class="img-thumbnail" width="50" height="50"></td>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->status }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->deleted_at }}</td>
                            <td>
                                <form action="{{ route('categories.restore', $category->id)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-info btn-lg mb-3">Restore</button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('categories.force-delete', $category->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-lg mb-3">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No categories found</td>
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
