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
        <div class="col-sm-6">
            <ol class="float-right button">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add Category</a>

            </ol>
        </div>
    </div>




    <div class="row">
        <div class="col-12 p-0">
            <div class="card">
                <div class="card-header justify-content-between py-3">
                    <h4 class="card-title float-left pt-2">All Category</h4>

                    <div class="float-right d-flex">
                        <form action="{{ route('admin.categories.index') }}" method="GET"
                            class="float-right d-flex my-auto gap-3">
                            <div class="form-group mb-0 d-flex w-auto">
                                <label for="mySelect">Sort By:</label>
                                <select name="type" class="selectpicker from-control" id="Select">
                                    <option value="" {{ request('type') == '' ? 'selected' : '' }}>--All Categories--
                                    </option>
                                    <option value="0" {{ request('type') == 'parent' ? 'selected' : '' }}>Parent
                                        Category</option>
                                    <option value="1" {{ request('type') == 'child' ? 'selected' : '' }}>Child Category
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mb-0 d-flex w-auto">
                                <select name="parent_id" class="selectpicker from-control" id="Select">
                                    <option value="" {{ request('parent_id') == '' ? 'selected' : '' }}>--Select
                                        Parent Category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_english }}
                                        </option>
                                        @if (count($category->children) > 0)
                                            @foreach ($category->children as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ request('parent_id') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;{{ $child->name_english }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            <div class="input-group py-0 my-0">
                                <input type="text" name="search" class="form-control" id="inputGroupFile02"
                                    placeholder="Search by name" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i
                                    class="fas fa-search"></i></button>
                        </form>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body card-body table-reHIDnsive p-0">
                    <table id="example1" class="table table-hover">
                        <thead>
                            <tr>
                                <th>S/L</th>
                                <th class="image">Logo</th>
                                <th>Name (English)</th>
                                <th>Name (Bangla)</th>
                                <th>Slug</th>
                                <th>Parent Category</th>
                                <th>Type</th>
                                <th>Meta Title</th>
                                <th>Meta Description</th>
                                <th>Home Status</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>


                        <tbody id="datatable">
                            @if (count($categories) > 0)
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/category/' . ($category->logo ?? 'default.png')) }}"
                                                alt="{{ $category->logo }}" width="60px">

                                        </td>
                                        <td>{{ $category->name_english }}</td>
                                        <td>{{ $category->name_bangla }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->parent ? $category->parent->name_english : 'N/A' }}</td>
                                        <td>{{ $category->type }}</td>
                                        <td>
                                            <p class="text-start" style="max-width:250px">{{ $category->meta_title }}</p>
                                        </td>
                                        <td>
                                            <p class="text-start" style="max-width:250px">{{ $category->meta_description }}
                                            </p>
                                        </td>
                                        <td>{{ $category->home_status ? 'Yes' : 'No' }}</td>
                                        <td>
                                            {{ $category->status ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete"
                                                    onclick="return confirm('Are you sure?')"> <i
                                                        class="fas fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="h-50">
                                    <td colspan="13">
                                        <h4 class="fs-4">No Record Found</h4>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="pt-4 pb-2 px-4">
                        <div class="pagination d-flex justify-content-between">
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
                                        searchParams.set('per_page', perPage);
                                        window.location.href = url.pathname + '?' + searchParams.toString();
                                    }
                                    // Function to fetch data and update the table body
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
                                    <span id="showing-entries-from">{{ $categories->firstItem() }}</span>
                                    to
                                    <span id="showing-entries-to">{{ $categories->lastItem() }}</span>
                                    of
                                    <span id="total-entries">{{ $categories->total() }}</span>
                                    entries
                                </div>
                            </div>
                            <!-- ... (remaining content) -->
                            {{ $categories->links('components.pagination.default') }}

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

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



    {{-- <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-reHIDnsive/js/dataTables.reHIDnsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-reHIDnsive/js/reHIDnsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $("#example1").DataTable({
                "reHIDnsive": true
                , "lengthChange": false
                , "autoWidth": false
                , "searching": true
                , "ordering": true
                , "paging": true
                , "info": true
                , "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    });

</script> --}}
@endpush
