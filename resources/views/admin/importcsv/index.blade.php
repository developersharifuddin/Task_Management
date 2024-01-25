@extends('layouts.admin')
@section('title', 'Admin | Category')

@section('page-headder')
    {{-- Categories --}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>
    </li>
@endsection


@section('content')
    <div class="row">
        <div class="col-12 p-0">
            <div class="card">
                <div class="card-header justify-content-between py-3">
                    <h4 class="card-title float-left pt-2">Import CSV File for Products</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body card-body table-reHIDnsive p-5">
                    @if (session('success'))
                        <div class="alert alert-success shadow-lg">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.uploadcsv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('POST') --}}
                        <div class="mb-3 col-md-6">
                            <label for="floatingTextarea">Import csv file</label>
                            <input type="file" class="from-control" name="csv_file">
                        </div>

                        <div class="mb-3 col-md-6">
                            <div class="progress d-none">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <input class="btn btn-md btn-warning" type="submit" value="submit">
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
