@extends('layoutsfe.base')

@section('content')
    <div class="container" style="margin-top: 200px;">
        <h1>Kuitansi Orderan #</h1>
        <p><strong id="first_name">Nama Pelanggan:</strong> </p>
        <p><strong id="qty">Jumalah</strong> </p>
        <p><strong id="total_price">Total price:</strong> </p>
        <p><strong id="nama_product">Nama Product:</strong> </p>


        <button class="btn btn-primary" id="pay-button">Bayar sekarang</button>
        {{-- <table>
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
    </table> --}}
    </div>
    </body>

    </html>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Ambil D dari URL
            id = window.location.href.split('/').pop();

            // Request data dari API
            $.ajax({
                url: `/v3/order/get/${id}`,
                method: 'GET',
                success: function(response) {
                    console.log(response); // Tampilkan data yang telah diambil
                    $('#first_name').text(response.data.firstname);
                    $('#qty').text(response.data.qty);
                    $('#total_price').text(response.data.total_price);
                    $('#nama_product').text(response.data.product.product_name);
                    snapToken = response.snapToken; // Ambil snapToken dan simpan ke variabel snapToken
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        // Trigger Snap popup when pay button is clicked
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {

            // Call API endpoint to get Snap token
            fetch(`/v3/order/get/${id}`)
                .then(response => response.json())
                .then(data => {

                    // Trigger Snap popup with retrieved Snap token
                    window.snap.pay(data.data.snapToken, {
                        onSuccess: function(result) {
                            /* You may add your own implementation here */
                            alert("payment success!");

                            console.log(result);
                        },
                        onPending: function(result) {
                            /* You may add your own implementation here */
                            alert("waiting for your payment!");
                            console.log(result);
                        },
                        onError: function(result) {
                            /* You may add your own implementation here */
                            alert("payment failed!");
                            console.log(result);
                        },
                        onClose: function() {
                            /* You may add your own implementation here */
                            alert('you closed the popup without finishing the payment');
                        }
                    })
                })
                .catch(error => console.error(error))
        });
    </script>
@endsection
