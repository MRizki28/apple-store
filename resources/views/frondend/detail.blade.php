@extends('layoutsfe.base')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12 " style="margin-top: 150px;">
                <a href="{{ url('/') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Kembali</a>
            </div>
            <div class="col-md-12  " style="margin-bottom: 120px;">
                <div class="card">
                    <div class="card-header">
                        <input type="hidden" name="menu_id" id="menu_id" value="">
                    </div>
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
                                    <form method="post" action="">
                                        @csrf
                                        <tbody>
                                            <h2 class="d-flex justify-content-center ">Specification :</h2>
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
                                                <input type="hidden" name="harga" id="harga">
                                            </tr>
                                           
                                            <tr>
                                                <td>First Name</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Last Name</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control">
                                                </td>

                                            </tr>

                                            <tr>
                                                <td>Phone Number</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" name="jumlah_pesanan" id="jumlah_pesanan"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Post Code</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" name="jumlah_pesanan" id="jumlah_pesanan"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>City</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" name="jumlah_pesanan" id="jumlah_pesanan"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Detail State</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" name="jumlah_pesanan" id="jumlah_pesanan"
                                                        class="form-control">

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>

                                                    <button type="submit" class="btn btn-primary mt-2 "><i
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
    </script>
@endsection
