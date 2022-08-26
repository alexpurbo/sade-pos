<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <div class="text-center mb-3 mt-3">
                <h3>Pilih merchant anda : </> 
            </div>
            <div class="row merchant-div">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  text-center merchant-button" >
                    <button type="button" class="btn btn-primary btn-lg">Toko A</button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  text-center merchant-button" >
                    <button type="button" class="btn btn-primary btn-lg">Toko B</button>
                </div>
            </div>
            <div class="add-merchant text-center">
                Tambah Merchant 
                <a href={{ route('addmerchant') }}>
                    <button type="button"  class="btn btn-secondary"> tambah</button>
                </a>
            </div>
        </div>
        
    </x-slot>

   
</x-app-layout>
