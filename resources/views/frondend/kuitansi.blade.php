@extends('layoutsfe.base')

@section('content')
<div class="container" style="margin-top: 200px;">
    <h1>Kuitansi Orderan #</h1>
    <p><strong id="first_name">Nama Pelanggan:</strong> </p>
    <p><strong>Nomor Telepon:</strong> </p>
    <p><strong>Alamat:</strong> </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
           <td></td>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>Total:</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
    </body>

    </html>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ambil D dari URL
            const id = window.location.href.split('/').pop();

            // Request data dari API
            $.ajax({
                url: `/v3/order/get/${id}`,
                method: 'GET',
                success: function(response) {
                    console.log(response); // Tampilkan data yang telah diambil
                    $('#first_name').text(response.data.firstname);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

    </script>
@endsection
