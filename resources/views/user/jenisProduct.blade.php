@extends('layouts.base')
@section('content')
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div id="loading" class="loading">
            <img src="{{ asset('loading.gif') }}" alt="Loading..." />
        </div>
    </div>
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold ">Data Jenis Produk</h6>
            <button type="button" class="btn btn-outline-primary ml-auto" data-toggle="modal"
                data-target="#JenisProductModal" id="#myBtn">
                Tambah Data
            </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        {{-- modal updert data --}}
        <div class="modal fade" id="JenisProductModal" tabindex="-1" role="dialog" aria-labelledby="JenisProductLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="JenisProductLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formTambah" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row py-2">
                                <div class="col-md-12">
                                    <div class="form-group fill">
                                        <input type="hidden" name="id" id="id" value="">
                                        <label>Kode Jenis Produk</label>
                                        <input id="kode_product" name="kode_product" type="text" class="form-control"
                                            placeholder="input here....." autocomplete="off">
                                        <button type="button" id="generateKodeButton"
                                            class="btn btn-primary mt-2">Generate</button>
                                    </div>
                                    <div class="form-group fill">
                                        <input type="hidden" name="id" id="id" value="">
                                        <label>Nama Jenis Produk</label>
                                        <input id="nama_jenis_product" name="nama_jenis_product" type="text"
                                            class="form-control" placeholder="input here....." autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                        <button type="submit" form="formTambah" class="btn btn-outline-primary">Submit Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#generateKodeButton").click(function() {
                $.ajax({
                    url: "{{ url('api/v1/jenisproduct/generateCode') }}",
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        $("#kode_product").val(response.generateCode);
                    },
                    error: function() {
                        alert('Gagal mengambil kode otomatis');
                    }
                });
            });
        });

        $(document).ready(function() {
            function getDataJenisProduct() {

                // Hancurkan DataTable yang sudah ada jika ada
                if ($.fn.DataTable.isDataTable("#dataTable")) {
                    $("#dataTable").DataTable().destroy();
                }

                var dataTable = $("#dataTable").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                });
                $.ajax({
                    url: "{{ url('api/v1/jenisproduct/') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        var tableBody = "";
                        $.each(response.data, function(index, item) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>" + item.kode_product + "</td>";
                            tableBody += "<td>" + item.nama_jenis_product + "</td>";
                            tableBody += "<td>" +
                                "<button type='button' class='btn btn-primary edit-modal' data-toggle='modal' data-target='#EditModal' " +
                                "data-id='" + item.id + "'>" +
                                "<i class='fa fa-edit'></i></button>" +
                                "<button type='button' class='btn btn-danger delete-confirm' data-id='" +
                                item.id + "'><i class='fa fa-trash'></i></button>" +
                                "</td>";
                            tableBody += "</tr>";
                        });

                        dataTable.clear().rows.add($(tableBody)).draw();



                    },
                    error: function() {
                        console.log("Failed to get data from server");
                    }
                });
            }
            getDataJenisProduct();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                var isEditMode = false;

                function showModal(editMode = false, id = '') {
                    isEditMode = editMode;
                    if (isEditMode) {
                        $('.modal-title').text('Edit Data');
                        $('.modal-footer button[type="submit"]').text('Update');
                        $('#generateKodeButton').hide();
                    } else {
                        $('.modal-title').text('Tambah Data');
                        $('.modal-footer button[type="submit"]').text('Submit');
                        $('#generateKodeButton').show();
                    }
                    $('#JenisProductModal').modal('show');
                }

                $('#formTambah').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    if (isEditMode) {
                        var id = $('#id').val();
                        $('#loading-overlay').show();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('api/v1/jenisproduct/update/') }}/" +
                                id,
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data);
                                $('#loading-overlay').hide();
                                if (data.message === 'check your validation') {
                                    var error = data.errors;
                                    var errorMessage = "";

                                    $.each(error, function(key, value) {
                                        errorMessage += value[0] + "<br>";
                                    });

                                    Swal.fire({
                                        title: 'Error',
                                        html: errorMessage,
                                        icon: 'error',
                                        timer: 5000,
                                        showConfirmButton: true
                                    });
                                } else {
                                    console.log(data);
                                    $('#loading-overlay').hide();
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Data Success Update',
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonText: 'OK'
                                    }).then(function() {
                                        $('#JenisProductModal').modal('hide');
                                        getDataJenisProduct();
                                    });
                                }
                            },
                            error: function(data) {
                                $('#loading-overlay').hide();
                                var errors = data.responseJSON.errors;
                                var errorMessage = "";

                                $.each(errors, function(key, value) {
                                    errorMessage += value + "<br>";
                                });

                                Swal.fire({
                                    title: "Error",
                                    html: errorMessage,
                                    icon: "error",
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            }
                        });
                    } else {
                        $('#loading-overlay').show();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('api/v1/jenisproduct/create') }}',
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            processData: false,
                            success: function(data) {
                               
                                $('#loading-overlay').hide();
                                if (data.message === 'check your validation') {
                                    var error = data.errors;
                                    var errorMessage = "";
                                    $.each(error, function(key, value) {
                                        errorMessage += value[0] + "<br>";
                                    });
                                    Swal.fire({
                                        title: 'Error',
                                        html: errorMessage,
                                        icon: 'error',
                                        timer: 5000,
                                        showConfirmButton: true
                                    });
                                } else {
                                    resetModal()
                                    console.log(data);
                                    $('#loading-overlay').hide();
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Data Success Create',
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonText: 'OK'
                                    }).then(function() {
                                        $('#JenisProductModal').modal('hide');
                                        getDataJenisProduct();
                                    });
                                }
                            },
                            error: function(data) {
                                $('#loading-overlay').hide();

                                var error = data.responseJSON.errors;
                                var errorMessage = "";

                                $.each(error, function(key, value) {
                                    errorMessage += value[0] + "<br>";
                                });

                                Swal.fire({
                                    title: 'Error',
                                    html: errorMessage,
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            }
                        });
                    }
                });

                $(document).on('click', '.edit-modal', function() {
                    var id = $(this).data('id');
                    $.ajax({
                        url: "{{ url('api/v1/jenisproduct/get') }}/" +
                            id,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(data) {
                            console.log(data);
                            showModal(true);
                            $('#id').val(data.data.id);
                            $('#kode_product').val(data.data.kode_product);
                            $('#nama_jenis_product').val(data.data.nama_jenis_product);
                        },
                        error: function() {
                            alert("error");
                        }
                    });
                });

                function resetModal() {
                    $('#id').val('');
                    $('#kode_product').val('');
                    $('#nama_jenis_product').val('');
                }

                // Fungsi reset modal ketika modal ditutup
                $('#JenisProductModal').on('hidden.bs.modal', function() {
                    if (isEditMode) {
                        resetModal();
                    }
                    isEditMode = false;
                    $('#generateKodeButton').show();
                    $('.modal-title').text('Tambah Data');
                    $('.modal-footer button[type="submit"]').text('Submit');
                });

            });
        });


        //delete
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Delete',
                cancelButtonText: 'Cancel',
                resolveButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('api/v1/jenisproduct/delete') }}/` +
                            id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        success: function(response) {
                            if (response.message === 'success delete data') {
                                Swal.fire({
                                    title: 'Data berhasil dihapus',
                                    icon: 'success',
                                    timer: 5000,
                                    showConfirmButton: true
                                }).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal menghapus data',
                                    text: response.message,
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Terjadi kesalahan',
                                text: 'Gagal menghapus data',
                                icon: 'error',
                                timer: 5000,
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
