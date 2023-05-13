@extends('layoutsfe.base')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12 " style="margin-top: 150px;">
                <a href="{{ url('/') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Kembali</a>
            </div>
            <div class="col-md-12  " style="margin-bottom: 120px;">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="" id="image_phone" class="rounded mx-auto d-block" alt="">

                                <div>
                                    <table class="table">
                                        <tbody class="text-center">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Ram</td>
                                            <td>:</td>
                                            <td id="ram"></td>
                                        </tr>
                                        <tr>
                                            <td>Storage</td>
                                            <td>:</td>
                                            <td id="storage"></td>
                                        </tr>
                                        <tr>
                                            <td>OS</td>
                                            <td>:</td>
                                            <td id="os"></td>
                                        </tr>
                                        <tr>
                                            <td>Cpu</td>
                                            <td>:</td>
                                            <td id="cpu"></td>
                                        </tr>
                                        <tr>
                                            <td>Battery</td>
                                            <td>:</td>
                                            <td id="baterry"></td>
                                        </tr>
                                        <tr>
                                            <td>Camera</td>
                                            <td>:</td>
                                            <td id="camera"></td>
                                        </tr>
                                        <tr>
                                            <td>Harga</td>
                                            <td>:</td>
                                            <td class="" id="price">Rp. </td>

                                        </tr>
                                    </tbody>
                                </table>

                                <form method="post" action="" id="formTambah">
                                    @csrf
                                    <table class="table">


                                        <input type="hidden" name="product_id" id="product_id">
                                        <tbody>

                                            <tr>
                                                <td>First Name</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="firstname" id="first_name"
                                                        class="form-control">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Last Name</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="lastname" id="first_name"
                                                        class="form-control">
                                                </td>

                                            </tr>

                                            <tr>
                                                <td>Phone Number</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" name="phone_number" id="phone_number"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Post Code</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" name="post_code" id="post_code"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>City</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="city" id="city"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Detail State</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="detail_state" id="detail_state"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Qty</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="qty" id="qty"
                                                        class="form-control">

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>

                                                    <button type="submit" id="btn-pesan" class="btn btn-primary mt-2 "><i
                                                            class="fa fa-shopping-cart"></i>Pesan</button>
                                                </td>
                                </form>



                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Ambil UUID dari URL
            const uuid = window.location.href.split('/').pop();

            // Request data dari API
            $.ajax({
                url: `/v1/phone/get/${uuid}`,
                method: 'GET',
                success: function(response) {
                    console.log(response); // Tampilkan data yang telah diambil
                    $('#nama_produk').text(response.data.nama_produk);
                    $('#image_phone').attr('src', '/uploads/phone/' + response.data.image_phone);
                    $('#price').text('Rp. ' + response.data.price);
                    $('#ram').text(response.data.detail.ram);
                    $('#storage').text(response.data.detail.storage);
                    $('#os').text(response.data.detail.os);
                    $('#cpu').text(response.data.detail.cpu);
                    $('#baterry').text(response.data.detail.baterry);
                    $('#camera').text(response.data.detail.camera);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {

            var formTambah = $('#formTambah');
            const uuid = window.location.href.split('/').pop();

            // Set nilai product_id pada input field tersembunyi
            $('#product_id').val(uuid);

            formTambah.on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('api/v3/phone/order') }}',
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

                            if (error.stock) {
                                errorMessage += "Stock is not enough";
                            }

                            Swal.fire({
                                title: 'Error',
                                html: errorMessage,
                                icon: 'error',
                                timer: 5000,
                                showConfirmButton: true
                            });
                        } else if (data.message === 'Stock tidak cukup') {
                            var errorMessage = data.errors;
                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
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
                                window.location.href =
                                    "{{ url('/kuitansi/phone/') }}/" + data.data.id;
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
    </script>
@endsection
