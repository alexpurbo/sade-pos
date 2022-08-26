@extends('admin.layouts.main')

@section('container')
<div class="mt-3 mb-3">
    <h1>Halaman Transaksi Admin sade-pos</h1>
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
                            <input type="hidden" class="form-control" id="status" name="status" readonly>
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
                <table class="table table-bordered table-striped" id="tblShopCart">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tblPurchaseList">

                    </tbody>
                </table>
                <div class="text-right">
                    <div class="form-group row">
                        <div class="col-lg-1"><label for="txtTotal">Total</label></div>
                        <div class="col-lg-2"><input type="text" id="totalTransaksi" name="totalTransaksi" class="form-control"></div>
                        <div class="col-lg-1"><button class="btn btn-danger" onclick="return confirm('Apakah anda yakin membatalkan transaksi?')">Batal</button></div>
                        <div class="col-lg-1"><button class="btn btn-primary" id="btnSimpan" name="btnSimpan">Simpan</button></div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        setTablePurchaseCart();
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

        $('#tblPurchaseList').on('click', 'button.btnEditItem', function() {
            let editId = $(this).attr('id');
            console.log(editId);
            $.ajax({
                // type: "POST",
                url: "{{ url('/cart') }}",
                dataType: "json",
                success: function(data) {
                    // console.log(data[editId].name);
                    $('#product_name').val(data[editId].name);
                    $('#product_id').val(data[editId].id);
                    $('#product_price').val(data[editId].price);
                    $('#product_amount').val(data[editId].quantity);
                    let total = data[editId].price * data[editId].quantity;
                    $('#total_price').val(total);
                    $('#status').val('edit');
                    $('#product_amount').focus();
                    window.scrollTo(0, 0);
                }
            });
        });

        $('#tblPurchaseList').on('click', 'button.btnHapusItem', function() {
            let deleteId = $(this).attr('id');
            if (confirm("Apakah anda yakin akan menghapus data?") == true) {
                console.log('setuju ' + deleteId);
                $.ajax({
                    url: "{{ url('/') }}/remove",
                    data: {
                        id: deleteId
                    },
                    success: function(data) {
                        console.log('sukses dihapus');
                        setTablePurchaseCart();
                    }
                });
            } else {
                console.log('batal ' + deleteId);
            }
        });

        $('#btnSimpan').on('click', function(e) {
            $.ajax({
                type: "POST",
                url: "{{url('/')}}/pembelian",
                data: {
                    _token: '{{ csrf_token() }}',
                    //     id: '2',
                    //     quantity: 3,
                    //     price: 4000
                },
                success: function(data) {
                    console.log('data tersimpan');
                }
            });

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
                console.log(data);
                console.log(data.length);
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

    function addPurchaseItem() {
        let prod_id = $('#product_id').val();
        let prod_name = $('#product_name').val();
        let prod_qty = $('#product_amount').val();
        let prod_price = $('#product_price').val();
        let status = $('#status').val();
        // console.log(prod_name);
        if (status == 'edit') {
            console.log('edit');
            $.ajax({
                type: "POST",
                url: "{{ url('/update-cart') }}",

                data: {
                    _token: '{{ csrf_token() }}',
                    id: prod_id,
                    price: prod_price,
                    quantity: prod_qty,
                },
                success: function(data) {
                    console.log(data);
                    console.log('data length: ' + data.length)
                    console.log('berhasil diupdate');
                    clearInputText();
                }
            });
        } else {
            console.log('tambah');
            $.ajax({
                type: "POST",
                url: "{{ url('/addToCart') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: prod_id,
                    name: prod_name,
                    price: prod_price,
                    quantity: prod_qty,
                },
                success: function(data) {
                    console.log(data);
                    console.log('berhasil ditambah');
                    clearInputText();
                }
            });
        }
        setTablePurchaseCart();
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

    function cancelledToCart() {
        clearInputText();
        $('#product_name').focus();
    }

    function setTablePurchaseCart() {
        $.ajax({
            url: "{{ url('/cartTable') }}",
            // dataType: "json",
            success: function(data) {
                // console.log(data);
                var html = data;
                $('#tblPurchaseList').html(html);
            }
        });
    }
</script>


@endsection