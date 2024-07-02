@extends('layouts.dashboard')

@section('title', 'Edit Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')

<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="name" class="form-control-lg">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}">
    </div>

    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" class="form-control form-select">
            <option value="">Primary Category</option>
            @foreach(App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" accept="image/*" class="form-control">
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="" height="60">
        @endif
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}">
    </div>

    <div class="form-group">
        <label for="compare_price">Compare Price</label>
        <input type="text" class="form-control" id="compare_price" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}">
    </div>

    <div class="form-group">
        <label for="tags">Tags</label>
        <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags', $tags) }}">
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <div>
            <input type="radio" name="status" value="active" @checked(old('status', $product->status) == 'active')> Active
            <input type="radio" name="status" value="draft" @checked(old('status', $product->status) == 'draft')> Draft
            <input type="radio" name="status" value="archived" @checked(old('status', $product->status) == 'archived')> Archived
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    </div>
</form>

@push('styles')
<link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('js/tagify.min.js') }}"></script>
<script src="{{ asset('js/tagify.polyfills.min.js') }}"></script>
<script>
    var inputElm = document.querySelector('[name=tags]'),
    tagify = new Tagify (inputElm);
</script>
@endpush

@endsection
