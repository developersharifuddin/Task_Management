@extends('layouts.admin')
@section('title', 'Admin | Category')

@section('page-headder')
    {{-- Categories --}}
@endsection

@section('content')
    <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
        <div class="col-sm-6">
            <span class="my-auto h6 page-headder">@yield('page-headder')</span>
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i
                            class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('admin.categories.index') }}">Category</a></li>

            </ol>
        </div>
    </div>


    <div class="row">
        <div class="card p-0">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Add New Category</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-reHIDnsive p-4">

                {{-- <div class="row"> --}}
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name_english">English Name</label>
                                <input type="text" name="name_english"
                                    class="form-control @error('name_english') is-invalid @enderror" id="name_english"
                                    placeholder="Enter Name English..." value="{{ old('name_english') }}">
                                @error('name_english')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name_bangla">Bangla Name</label>
                                <input type="text" name="name_bangla"
                                    class="form-control @error('name_bangla') is-invalid @enderror" id="name_bangla"
                                    placeholder="name_bangla" value="{{ old('name_bangla') }}">
                                @error('name_bangla')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="parent_id">Parent Category</label>
                                <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror"
                                    id="parent_id">
                                    <option value="">--Select Parent Category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_english }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="logo">Category Logo</label>
                                <input type="file" name="logo"
                                    class="form-control @error('logo') is-invalid @enderror" id="logo"
                                    value="{{ old('logo') }}">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="descriptions">Descriptions</label>
                                <textarea name="descriptions" class="form-control @error('descriptions') is-invalid @enderror" id="descriptions">{{ old('descriptions') }}</textarea>
                                @error('descriptions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="home_status">Home Status</label><br>
                                <input type="checkbox" name="home_status" id="home_status" value="1"
                                    @if (old('home_status')) checked @endif>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="status">Active Status</label><br>
                                <input type="checkbox" name="status" id="status" value="1"
                                    @if (old('status')) checked @endif>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" name="meta_title"
                                    class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                    value="{{ old('meta_title') }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                    id="meta_description">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <div class="mb-3 text-right">
                        <a type="button" class="btn bg-danger" href="{{ route('admin.categories.index') }}">Cancel</a>
                        <button type="reset" class="btn btn-Info bg-info">Reset</button>
                        <button type="submit" class="btn btn-warning">Save</button>
                    </div>
                </form>
                {{-- </div> --}}


            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
    </div>
    <!-- /.content -->
@endsection
@push('.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();

            //$('#datepicker').datepicker();
            // $('#datepicker').datepicker({
            //    format: 'yyyy-mm-dd'
            //    , language: 'en'
            //    , autoclose: true
            //});
        });
        // categories.js

        document.addEventListener('DOMContentLoaded', function() {
            const showEntriesDropdown = document.getElementById('show-entries');
            const showingEntries = document.querySelectorAll('#showing-entries');
            const totalEntries = document.getElementById('total-entries');

            showEntriesDropdown.addEventListener('change', function() {
                const selectedValue = this.value;
                axios.get(`/admin/categories?show=${selectedValue}`)
                    .then(response => {
                        // Update the number of displayed entries
                        showingEntries.forEach(span => {
                            span.textContent = response.data.showing;
                            console.log(response.data);
                        });
                        // Update the total number of entries
                        totalEntries.textContent = response.data.total;
                    })
                    .catch(error => {
                        console.error(error);

                    });
            });
        });
    </script>
@endpush
