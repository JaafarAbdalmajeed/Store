@extends('layouts.dashboard')

@section('content')

@include('dashboard.products.createModel')
@include('dashboard.products.editModel')

<div class="mb-5">

</div>

<div class="row">
    <div class="col-lg-12">
        <button type="button" class="btn btn-info btn-lg mb-3" data-toggle="modal" data-target="#createModel">Add Products</button>
        {{-- <a href="{{ route('products.edit')}}" class="btn btn-dark btn-lg mb-3">Trash</a> --}}
            <div class="card" id="category-table">

            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        {{-- <th>Image</th> --}}
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Store</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            {{-- <td><img src="{{ asset('storage/'.$products->image) }}" alt="Product Image" class="img-thumbnail" width="50" height="50"></td> --}}
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->store->name }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>
                                {{-- <button  type="button" data-toggle="modal"  data-target="#editModal" data-id="{{ $product->id }}">
                                    <i class="fas fa-edit text-primary"></i>
                                </button> --}}

                                <a href="{{route('products.edit', $product->id)}}"><i class="fas fa-edit text-primary"></i></a>
                            </td>

                            <td>
                                <button type="button" class="delete-category-btn" data-id="{{ $product->id }}">
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

{{-- <script src="{{asset('js/category.js')}}"></script> --}}

@endpush
