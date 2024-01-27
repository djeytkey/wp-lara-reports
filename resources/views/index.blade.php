@extends('layouts.admin')

@section('contentheader')
    Dashboard
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                                {{ __('You are logged in!') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(".active").removeClass("active");
        $("#dashboard-item").addClass("active");
    </script>
@endsection
