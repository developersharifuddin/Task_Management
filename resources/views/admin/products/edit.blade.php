@extends('layouts.admin')
@section('title', 'Admin | product edit')

@section('page-headder')
    {{-- Categories --}}
@endsection


@section('content')
    <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
        <div class="col-md-6">
            <span class="my-auto h6 page-headder">@yield('page-headder')</span>
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i
                            class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.create') }}">Edit</a></li>
            </ol>
        </div>
        <div class="col-md-6">
            <ol class="float-right button">
                <a href="{{ route('admin.products.index') }}" class="btn btn-success" rel="tooltip" id="add"
                    title="add">
                    Products
                </a>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12 p-0">
            <div class="card">
                <div class="card-header justify-content-between py-3">
                    <h4 class="card-title float-left pt-2">Edit product</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body card-body bg-light">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}" class="form-horizontal"
                        id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-9 px-4">
                                <div class="row bg-light">

                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="name">Name (English)</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Name (English)" value="{{ $product->name }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="name_bangla">Name (Bangla)</label>
                                            <input type="text" name="name_bangla"
                                                class="form-control @error('name_bangla') is-invalid @enderror"
                                                placeholder="Name (Bangla)"
                                                value="{{ old('name_bangla', $product->name_bangla) }}">
                                            @error('name_bangla')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="sub_title">Sub Title</label>
                                            <input type="text" name="sub_title"
                                                class="form-control @error('sub_title') is-invalid @enderror"
                                                placeholder="Sub Title"
                                                value="{{ old('sub_title', $product->sub_title) }}">
                                            @error('sub_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <!-- Pricing Information -->
                                        <div class="form-group">
                                            <label for="published_price">Published Price</label>
                                            <input type="number" name="published_price"
                                                class="form-control @error('published_price') is-invalid @enderror"
                                                placeholder="Published Price"
                                                value="{{ old('published_price', $product->published_price) }}">
                                            @error('published_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="purchase_price">Purchase Price</label>
                                            <input type="number" name="purchase_price"
                                                class="form-control @error('purchase_price') is-invalid @enderror"
                                                placeholder="Purchase Price"
                                                value="{{ old('purchase_price', $product->purchase_price) }}">
                                            @error('purchase_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="sell_price">Sales Price</label>
                                            <input type="number" name="sell_price"
                                                class="form-control @error('sell_price') is-invalid @enderror"
                                                placeholder="Sales Price"
                                                value="{{ old('sell_price', $product->sell_price) }}">
                                            @error('sell_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="current_stock">Quantity</label>
                                            <input type="number" name="current_stock"
                                                class="form-control @error('current_stock') is-invalid @enderror"
                                                id="Reference No" placeholder="Reference No.."
                                                value="{{ old('current_stock', $product->current_stock) }}">
                                            @error('current_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-3 px-4">
                                <div class="row bg-white">

                                    <div class="mb-3 col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="category_id" class="control-label mb-0 pb-0">Category<label
                                                    class="text-danger">*</label></label>
                                            <div class="input-group mr-2">
                                                <div class="input-group">
                                                    <select name="category_id" id="mySelect" data-live-search="true"
                                                        class="selectpicker @error('category_id') is-invalid @enderror">
                                                        <option value="">--Select Category--</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                                {{ $category->name_english }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="my-4 text-right">
                            <a type="button" class="btn btn-primary"
                                href="{{ route('admin.products.index') }}">Cancel</a>
                            <button type="submit" class="btn home-details-btn btn-success">Update</button>

                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

    </div>
    <!-- /.content -->
@endsection
@push('.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();

        });
    </script>
@endpush
