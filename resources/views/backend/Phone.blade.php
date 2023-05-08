@extends('layoutsbe.Base')
@section('content')
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Artikel</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PhoneModal" id="#myBtn">
                    Tambah Data
                </button>
            </div>
            <div class="p-3">
                <div class="row" id="data-container">
                    <div class="table-responsive p-3">
                        <table id="dataTable" class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Uuid</th>
                                    <th>Product Name</th>
                                    <th>Product Model</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Product Image</th>
                                    <th>Detail ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data from database will be shown here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create --}}
    <div class="modal fade" id="PhoneModal" tabindex="-1" role="dialog" aria-labelledby="PhoneModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="PhoneModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTambah" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="uuid">
                        <div class="form-group">
                            <label for="product_name">Nama Product</label>
                            <input type="text" class="form-control" name="product_name" id="product_name"
                                placeholder="Input Here..">
                        </div>
                        <div class="form-group">
                            <label for="product_model">Product Model</label>
                            <input type="text" class="form-control" name="product_model" id="product_model"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" name="stock" id="stock"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="image_phone">Image</label>
                            <input type="file" class="form-control" name="image_phone" id="image_phone"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="detail_id">Detail</label>
                            <select name="detail_id" id="detail_id" class="form-control">
                                <option value="">-- Pilih Detail --</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Menu Bazar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="uuid" id="uuid">
                        <div class="form-group">
                            <label for="product_name">Nama Product</label>
                            <input type="text" class="form-control" name="product_name" id="eproduct_name"
                                placeholder="Input Here..">
                        </div>
                        <div class="form-group">
                            <label for="product_model">Product Model</label>
                            <input type="text" class="form-control" name="product_model" id="eproduct_model"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="eprice">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" name="stock" id="estock"
                                placeholder="Input Here">
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="eimage_phone" name="image_phone">
                                <label class="custom-file-label" for="eimage_phone" id="eimage_phone-label">Image</label>
                            </div>
                            <img src="" alt="" id="preview" class="mx-auto d-block pb-2"
                                style="max-width: 200px; padding-top: 23px">
                        </div>
                        <div class="form-group">
                            <label for="detail_id">Detail</label>
                            <select name="detail_id" id="edetail_id" class="form-control">
                                <option value="">-- Pilih Detail --</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="submit" form="formEdit" class="btn btn-outline-primary">Update Data</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        //get data
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('v1/phone') }}",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var tableBody = "";
                    $.each(response.data, function(index, item) {
                        tableBody += "<tr>";
                        tableBody += "<td>" + (index + 1) + "</td>";
                        tableBody += "<td>" + item.uuid + "</td>";
                        tableBody += "<td>" + item.product_name + "</td>";
                        tableBody += "<td>" + item.product_model + "</td>";
                        tableBody += "<td>" + item.price.toLocaleString('id') + "</td>";
                        tableBody += "<td>" + item.stock + "</td>";
                        tableBody += "<td><img src='/uploads/phone/" + item.image_phone +
                            "' alt='" +
                            item.title +
                            "' class='img-thumbnail' style='width: 200px'></td>";
                        tableBody += "<td>" + item.detail_id + "</td>";
                        tableBody += "<td>" +
                            "<button type='button' class='btn btn-primary edit-modal' data-toggle='modal' data-target='#EditModal' " +
                            "data-uuid='" + item.uuid+ "' " +
                            "<i class='fa fa-edit'>Edit</i></button>" +
                            "<button type='button' class='btn btn-danger delete-confirm' data-uuid='" +
                            item.uuid + "'><i class='fa fa-trash'></i></button>" +
                            "</td>";

                        tableBody += "</tr>";
                    });
                    $('#dataTable').DataTable().destroy();
                    $("#dataTable tbody").empty();
                    $("#dataTable tbody").append(tableBody);
                    $('#dataTable').DataTable({
                        "paging": true,
                        "ordering": true,
                        "searching": true
                    });
                },
                error: function() {
                    console.log("Failed to get data from server");
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //create 
        $(document).ready(function() {

            var formTambah = $('#formTambah');

            formTambah.on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('v1/phone/create') }}',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
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
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Success Create',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'OK'
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(data) {
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
            });
        });
        // get detail data and populate the options
        $.ajax({
            url: "{{ url('v2/detail') }}",
            method: "GET",
            dataType: "json",
            success: function(response) {
                var options = '';
                $.each(response.data, function(index, item) {
                    options += '<option value="' + item.id + '">' + item.id + '</option>';
                });
                $('#detail_id').append(options);
                $('#edetail_id').append(options);
            },
            error: function() {
                console.log("Failed to get data from server");
            }
        });

        //edit
        $(document).on('click', '.edit-modal', function() {
            var uuid = $(this).data('uuid');
            $.ajax({
                url: "{{ url('v1/phone/get') }}/" + uuid,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    $('#uuid').val(data.data.uuid);
                    $('#eproduct_name').val(data.data.product_name);
                    $('#eproduct_model').val(data.data.product_model);
                    $('#eprice').val(data.data.price);
                    $('#estock').val(data.data.stock);
                    $('#preview').attr('src', "{{ asset('uploads/phone') }}/" + data.data.image_phone);
                    $('#edetail_id').val(data.data.detail_id);
                    $('#EditModal').modal('show');
                },
                error: function() {
                    alert("error");
                }
            });
        });

        //update
        $(document).ready(function () { 
            var formEdit = $('#formEdit');

            formEdit.on('submit', function (e) { 
                e.preventDefault();

                var uuid = $('#uuid').val();
                var formData = new FormData(this);

                var file = $('#eimage_phone')[0].files[0];
                if (!file) {
                    formData.delete('image_phone');
                }

                $.ajax({
                    type: "POST",
                    url: "{{ url('v1/phone/update') }}/" + uuid,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) { 
                        console.log(data);
                        Swal.fire({
                            title: 'Success',
                            text: 'Data success for update',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location.reload();
                        });
                     },
                     error: function(data) {
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
             });
         })


        //delete
        $(document).on('click ', '.delete-confirm', function(e) {
            e.preventDefault();
            var uuid = $(this).data('uuid');
            Swal.fire({
                title: 'Do your sure want to delete this data ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                resolveButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('v1/phone/delete') }}/" + uuid,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "uuid": uuid
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Data berhasil dihapus',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: true
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                tite: 'Terjadi kesalahan ',
                                icon: 'error',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }


                    });
                }
            });
        });
    </script>
@endsection
