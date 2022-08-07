
@extends('layouts.success')


@section('title')
    Store Success Page
@endsection


@section('content')
    <div class="page-content page-success">
      <div class="section-success" data-aos="zoom-in">
        <div class="container">
          <div class="row align-items-center row-login justify-content-center">
            <div class="col-lg-6 text-center">
              <img src="/images/success.svg" alt="" class="mb-4" />
              <h2>Transaksi di Proses!</h2>
              <p>
                Terimakasih telah berbelanja di toko Irvianda Bakery! Produk akan kami kirim ke rumah kamu. Mohon ditunggu ya terimakasih!
              </p>
              <div>
                
                
                <a href="{{route('home')}}" class="btn btn-success w-50 mt-2"
                  >Kembali ke halaman utama</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

