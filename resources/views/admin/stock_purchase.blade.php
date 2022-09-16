@extends('admin.layouts.main')

@section('container')

<div class="mt-3 mb-3">
    <h1>Pembelian Stock</h1>
</div>

<div class="row mb-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Produk ID</label>
                            <input type="text" class="form-control" id="product_id" name="product_id">
                        </div>
                        <div class="form-group col-md-7">
                            <label for="inputPassword4">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                            <input type="hidden" id="purchase_id" name="purchase_id">
                            <!-- <input type="text" id="stock_id" name="stock_id"> -->
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
                        <div class="form-group col-md-3">
                            <!-- <label for="inputPassword4">Status</label> -->
                            <input type="hidden" class="form-control" id="sp_status" name="sp_status" readonly>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <button class="btn btn-danger" id="btnCancelledToCart" name="btnCancelledToCart" onclick="clearInputText()">Batal</button>
                    <button class="btn btn-primary" id="btnAddToCart" name="btnAddToCart" onclick="addPurchaseItem()">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped" id="tblStockPurchase">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total</th>
                            <th style="display:none;"></th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tblBodyStockPurchase">

                    </tbody>
                </table>

                <!-- <div class="float-right mt-3">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <label for="staticEmail">Total</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="totalTransaksi" name="totalTransaksi" class="form-control" readonly>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin membatalkan transaksi?')">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" id="btnSimpan" name="btnSimpan">Simpan</button>
                        </div>
                    </div>
                </div> -->

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var tblDataStockPurchase = '';
    let stockId = '';
    $(document).ready(function() {

        setTblStockPurchase();

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
            // console.log('keypress amount= ' + e.which);
            var amount = $('#product_amount').val();
            if (e.which == 13 || e.which == 9) {
                console.log('amount ' + amount + ' amount')
                if (amount <= 0 || amount == "") {
                    $('#product_amount').val('1');
                    amount = 1;
                }
                // let price = $('#product_price').val();
                // let total = amount * price;

                // $('#total_price').val(total);
                $('#product_price').focus();
            }
        });

        $('#product_price').on('keypress', function(e) {

            let price = $('#product_price').val();
            let amount = $('#product_amount').val();
            // console.log('keypress= ' + e.which);
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

        $('#tblStockPurchase').on('click', 'button.btnEditPurchase', function() {
            let purchase_id = $(this).attr('id');
            var currentRow = $(this).closest("tr");
            var prod_id = currentRow.find("td:eq(5)").text();
            var price = currentRow.find("td:eq(3)").text(); // get current row 2nd TD
            var qty = currentRow.find("td:eq(2)").text(); // get current row 3rd TD
            var name = currentRow.find("td:eq(1)").text();
            var total = currentRow.find("td:eq(4)").text();

            $.ajax({
                url: "{{url('/')}}/cekEditPurchase",
                data: {
                    _token: '{{ csrf_token() }}',
                    prod_id: prod_id,
                    price: price,
                    qty: qty
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.length > 0) {
                        $('#product_id').val(prod_id);
                        $('#product_name').val(name);
                        $('#product_price').val(price);
                        $('#product_amount').val(qty);
                        $('#total_price').val(total);
                        $('#sp_status').val('edit');
                        $('#purchase_id').val(purchase_id);
                        // $('#stock_id').val(data[0].id_stock);
                        stockId = data[0].id_stock;
                        window.scrollTo(0, 0);
                    } else {
                        alert('Data sudah tidak dapat dikoreksi');
                    }
                }

            });

        });

    });

    function getProductIdByName() {
        let prod_name = $('#product_name').val();
        $.ajax({
            url: "{{url('/')}}/getProductDataByName",
            data: {
                term: prod_name
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                console.log(data.length);
                if (data.length > 0) {
                    $('#product_id').val(data[0].id_product);
                    // $('#product_price').val(data[0].price);
                    $('#product_amount').focus();
                } else {
                    alert('Produk tidak ditemukan');
                    $('#product_name').val('');
                }
            }
        });
    }

    function addPurchaseItem() {
        let prod_id = $('#product_id').val();
        let prod_name = $('#product_name').val();
        let qty = $('#product_amount').val();
        let price = $('#product_price').val();
        let total = $('#total_price').val();
        let status = $('#sp_status').val();
        let purchase_id = $('#purchase_id').val();
        // console.log(prod_name);
        if (status == 'edit') {
            console.log(status);
            $.ajax({
                type: "PATCH",
                url: "{{ url('/stock-purchase') }}/"+purchase_id,

                data: {
                    _token: '{{ csrf_token() }}',
                    prod_id: prod_id,
                    price: price,
                    qty: qty,
                    total: total,
                    purchase_id: purchase_id,
                    stockId: stockId,
                },
                success: function(data) {
                    console.log(data);
                    console.log('data length: ' + data.length)
                    console.log('berhasil diupdate');
                    clearInputText();
                }
            });
        } else {
            console.log(status);
            $.ajax({
                type: "POST",
                url: "{{ url('/stock-purchase') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    prod_id: prod_id,
                    price: price,
                    qty: qty,
                    total: total
                },
                success: function(data) {
                    console.log(data);
                    console.log('berhasil ditambah');
                    clearInputText();
                    $('#product_name').focus();
                }
            });
        }
        setTblStockPurchase();
    }

    function setTblStockPurchase() {
        $.ajax({
            url: "{{ url('/getStockPurchaseList') }}",
            success: function(data) {
                console.log(data);
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    // var tgl = data[i].report_date;
                    // var tglArr = tgl.split('-');
                    // var tglFix = tglArr[2] + '-' + tglArr[1] + '-' + tglArr[0];
                    var nomor = i + 1;
                    html += '<tr>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + '">' + nomor +
                        '</td>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + '">' + data[i].product_name +
                        '</td>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + '">' + data[i].quantity +
                        '</td>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + '">' + data[i].purchase_price +
                        '</td>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + '">' + data[i].total +
                        '</td>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + ' " style="display:none;">' + data[i].id_product +
                        '</td>';
                    html += '<td class="table_data" data-row_id="' +
                        data[i].id + '"><button type="submit" class="btn btn-warning btnEditPurchase" id="' + data[i].id + '">Edit</button>' +
                        ' <button type="submit" class="btn btn-danger hapusNilai" id="' + data[i].id + '">Hapus</button></td></tr>';
                }

                if (tblDataStockPurchase) {
                    tblDataStockPurchase.destroy();
                }
                $('#tblBodyStockPurchase').html(html);
                tblDataStockPurchase = $('#tblStockPurchase').DataTable();
            }
        });
    }

    function clearInputText() {
        $('#product_name').val('');
        $('#product_id').val('');
        $('#product_price').val('');
        $('#product_amount').val('');
        $('#total_price').val('');
        $('#status').val('');
        $('#product_name').focus();
    }
</script>

@endsection