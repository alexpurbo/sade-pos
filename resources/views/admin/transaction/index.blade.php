@extends('admin.layouts.main')

@section('container')
<div class="mt-3 mb-5">
    <h1>Halaman Transaksi Admin sade-pos</h1>
</div>

<div class="row mb-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Produk ID</label>
                            <input type="text" class="form-control" id="product_id" name="product_id">
                        </div>
                        <div class="form-group col-md-7">
                            <label for="inputPassword4">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Jumlah</label>
                            <input type="text" class="form-control" id="product_amount" name="product_amount">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">Harga</label>
                            <input type="text" class="form-control" id="product_price" name="product_price">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">Total</label>
                            <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary" id="btnAddToCart" name="btnAddToCart">Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin membatalkan transaksi?')">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $("#product_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: siteUrl + '/' + "autocomplete",
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        var resp = $.map(data, function(obj) {
                            return obj.product_name;
                        });
                        response(resp);
                    }
                });
            },
            minLength: 2,

        });

        $('#product_name').on('change', function() {
            getProductIdByName();
        });

        $('#product_amount').on('keypress', function(e) {
            console.log('keypress amount= ' + e.which);
            let amount = $('#product_amount').val();
            if (e.which == 13 || e.which == 9) {
                if (amount > 0) {
                    $('#product_price').focus();
                } else {
                    alert('Jumlah minimal 1');
                }
            }
        });

        $('#product_price').on('keypress', function(e) {

            let price = $('#product_price').val();
            let amount = $('#product_amount').val();
            console.log('keypress= ' + e.which);
            if (e.which == 13 || e.which == 9) {
                if (price > 0 && amount > 0) {
                    let total = price * amount;
                    $('#total_price').val(total);
                    $('#btnAddToCart').focus();
                } else {
                    alert('Harga tidak boleh kosong');
                }
            }
        });

    });

    function getProductIdByName() {
        let prod_name = $('#product_name').val();
        $.ajax({
            url: "{{url('/')}}/getProductIdByName",
            data: {
                term: prod_name
            },
            dataType: "json",
            success: function(data) {
                if (data.length > 0) {
                    $('#product_id').val(data[0].id_product);
                    $('#product_amount').focus();
                } else {
                    alert('Produk tidak ditemukan');
                    $('#product_name').val('');
                }
            }
        });
    }
</script>


@endsection