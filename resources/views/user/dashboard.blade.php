@extends('layouts.base')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"> Home</li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="user"></h3>
                        <p>User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <span class="small-box-footer">Maritim muda</span>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="absen"><sup style="font-size: 20px"></sup></h3>
                        <p>Total absen</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <span class="small-box-footer">Maritim muda</span>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>1</h3>
                        <p>Admin</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <span class="small-box-footer">Maritim muda</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "get",
                url: "{{ url('count') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('#user').text(response.data.user);
                    $('#absen').html(response.data.absen);
                }
            });
        });
    </script>
@endsection
