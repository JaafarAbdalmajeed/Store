@extends('layouts.dashboard')

@section('content')

@include('dashboard.products.createModel')
@include('dashboard.products.editModel')

<div class="mb-5"></div>

<div class="row">
    <div class="col-lg-12">
        {{-- Uncomment the button to enable adding products --}}
        {{-- <button type="button" class="btn btn-info btn-lg mb-3" data-toggle="modal" data-target="#createModel">Add Products</button> --}}
        {{-- Uncomment the link to enable access to trash --}}
        {{-- <a href="{{ route('products.trash') }}" class="btn btn-dark btn-lg mb-3">Trash</a> --}}

        <div class="card" id="category-table">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Store</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $products = $category->products()->with('store')->latest()->paginate(7)
                    @endphp
                    @forelse ($products as $product)
                        <tr>
                            {{-- Uncomment and adjust image display as needed --}}
                            {{-- <td><img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" class="img-thumbnail" width="50" height="50"></td> --}}
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->store->name }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#editModal" data-id="{{ $product->id }}">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="delete-category-btn" data-id="{{ $product->id }}">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No products found</td>
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
{{-- Uncomment and adjust the script inclusion as needed --}}
{{-- <script src="{{ asset('js/category.js') }}"></script> --}}
@endpush
