@extends('admin.layouts.main')

@section('container')
<div class="mt-3 mb-5">
    <h1>Halaman Utama Admin sade-pos</h1>
</div>

<div class="row mb-5">
    <div class="col-lg-4">
        <div class="card p-3 border-dark">
            <div class="card-title">
                <h5>Penjualan | Hari ini</h5>
            </div>
            <div class="card-body">
                <h3 class="text-center">Rp. 500.000</h3>
                <p class="card-text text-right"><a href="#" class="text-right">Lihat detail</a></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-3 border-dark">
            <div class="card-title">
                <h5>Penjualan | Bulan ini</h5>
            </div>
            <div class="card-body">
                <h3 class="text-center">Rp. 9.500.000</h3>
                <p class="card-text text-right"><a href="#" class="text-right">Lihat detail</a></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-3 border-dark">
            <div class="card-title">
                <h5>Pengeluaran | Bulan ini</h5>
            </div>
            <div class="card-body">
                <h3 class="text-center">Rp. 3.500.000</h3>
                <p class="card-text text-right"><a href="#" class="text-right">Lihat detail</a></p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-lg-6">
        <div class="card">

            <h5 class="card-header">Grafik Penjualan</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">Produk Terlaris</h5>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Terjual</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Masako</td>
                            <td>200</td>
                            <td>50.000</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Minyak</td>
                            <td>5</td>
                            <td>100.000</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Gukaku</td>
                            <td>3</td>
                            <td>33.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection