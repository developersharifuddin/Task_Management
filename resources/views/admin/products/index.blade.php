@extends('layouts.admin')
@section('title', 'Admin | product')

@section('page-headder')
    {{-- products --}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>
    </li>
    <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.index') }}">product</a></li>
@endsection


@section('content')
    <style>
        .form-switch {
            padding-left: 0em;
        }

        .form-check {
            /* display: block; */
            /* min-height: 1.5rem; */
            padding-left: 0em;
            /* margin-bottom: 0.125rem; */
        }

        .float-left {
            /* float: left!important; */
        }
    </style>
    <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
        <div class="col-md-6">
            <span class="my-auto h6 page-headder">@yield('page-headder')</span>
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i
                            class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.index') }}">Products</a></li>
            </ol>
        </div>
        <div class="col-md-6">
            <ol class="float-right button">
                {{-- <span class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"> Add New</span> --}}
                <a href="{{ route('admin.products.create') }}" class="btn btn-success" rel="tooltip" id="add"
                    title="add">
                    Add New
                </a>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12 p-0">
            <div class="card">
                <div class="card-header justify-content-between py-3">
                    <h4 class="card-title float-left pt-2">All product</h4>

                    <div class="float-right d-flex my-auto gap-3">

                        <form class="mb-0 pb-0" id="sort_products" action="" method="GET">
                            <div class="input-group py-0 my-0">
                                <input type="text" name="search" class="form-control" id="inputGroupFile02"
                                    placeholder="Search">
                                <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i
                                        class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body card-body p-0 table-responsive">
                    @if (session('success'))
                        <div class="alert alert-success shadow-lg">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table id="example1" class="table table-hover">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th class="image text-start">Image</th>
                                <th style="text-align: left !important; ">Product Name</th>
                                <th>Product Code</th>
                                <th>Category</th>
                                <th>Published Price</th>
                                <th>Purchase Price</th>
                                <th>Sells Price</th>
                                <th>Minimum Qty.</th>
                                <th>Stock Qty.</th>
                                <th>Stock Status</th>
                                <th>Approved Status</th>
                                <th>Active Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="datatable">
                            @if (count($products) > 0)
                                @foreach ($products as $key => $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/products/' . $item->thumbnail) }}"
                                                alt="{{ $item->thumbnail }}" width="70">
                                        </td>
                                        <td class="product-name text-start" style="line-height:1.5; min-width:150px">
                                            <p>{{ $item->name }}</p>
                                        </td>
                                        <td>{{ $item->code }}</td>

                                        <td>
                                            @if ($item->category)
                                                {{ $item->category->name_english }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $item->published_price }}</td>
                                        <td>{{ $item->purchase_price }}</td>
                                        <td>{{ $item->sell_price }}</td>
                                        <td>{{ $item->min_qty }}</td>
                                        <td>{{ $item->current_stock }}</td>
                                        <td>
                                            @php
                                                $badgeClass = $item->stock_status > 0 ? 'badge badge-success' : 'badge badge-danger';
                                                $statusText = $item->stock_status > 0 ? 'In-Stock' : 'Out-Of-Stock';
                                            @endphp
                                            <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                                        </td>

                                        <td>
                                            @php
                                                $badgeClass = $item->approved == '1' ? 'badge badge-success' : 'badge badge-danger';
                                            @endphp
                                            <span
                                                class="{{ $badgeClass }}">{{ $item->approved == '1' ? 'Approved' : 'Un-Approved' }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = $item->status == '1' ? 'badge badge-success' : 'badge badge-danger';
                                            @endphp
                                            <span
                                                class="{{ $badgeClass }}">{{ $item->status == '1' ? 'Active' : 'In-Active' }}</span>
                                        </td>

                                        <td style="min-width:130px" class="d-flex my-4">

                                            <a href="{{ route('admin.products.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm edit text-light border-0 mx-2" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete"
                                                    onclick="return confirm('Are you sure?')"> <i
                                                        class="fas fa-trash-can"></i></button>
                                            </form>

                                            <a href="{{ route('admin.products.show', $item->id) }}"
                                                class="btn btn-info btn-sm text-light view border-0 view mx-2"
                                                id="view" rel="tooltip" title="view">
                                                <i class="fas fa-eye"></i>
                                            </a>


                                            <form action="{{ route('admin.purchase.purchase', $item->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger delete"
                                                    onclick="return confirm('Are you sure want to purchase this?')">
                                                    Purchase</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="h-50">
                                    <td colspan="13">
                                        <h4 class="fs-4">No data found</h4>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                    <div class="pt-4 pb-2 px-4">
                        <div class="pagination d-flex justify-content-between">
                            <!-- ... (previous content) -->
                            <div class="d-flex">
                                <label for="per_page">Entries per Page:</label>
                                <select name="per_page" id="per_page" onchange="updateQueryString()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>

                                <script>
                                    function updateQueryString() {
                                        var perPage = document.getElementById('per_page').value;
                                        var currentUrl = window.location.href;
                                        var url = new URL(currentUrl);
                                        var searchParams = new URLSearchParams(url.search);
                                        // Update or add the per_page parameter
                                        searchParams.set('per_page', perPage);
                                        // Redirect to the updated URL
                                        window.location.href = url.pathname + '?' + searchParams.toString();
                                    }

                                    function fetchDataAndPopulateTable() {

                                        document.addEventListener('DOMContentLoaded', function() {
                                            const table = document.getElementById('datatable');
                                            const tableRow = table.querySelector('tr');

                                            // Display loading animation
                                            if (tableRow) {
                                                const loadingDiv =
                                                    '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
                                                tableRow.appendChild(loadingDiv);
                                                setTimeout(function() {

                                                }, 2000); // Adjust the time according to your needs
                                            }
                                        });
                                    }

                                    // Call the function when the page loads
                                    fetchDataAndPopulateTable();
                                </script>

                                <!-- Information about displayed entries -->
                                <div class="dataTables_info pl-2">
                                    Showing
                                    <span id="showing-entries-from">{{ $products->firstItem() }}</span>
                                    to
                                    <span id="showing-entries-to">{{ $products->lastItem() }}</span>
                                    of
                                    <span id="total-entries">{{ $products->total() }}</span>
                                    entries
                                </div>
                            </div>
                            <!-- ... (remaining content) -->
                            {{ $products->links('components.pagination.default') }}
                        </div>
                    </div>
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
