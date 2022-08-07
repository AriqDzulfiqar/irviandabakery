
@extends('layouts.dashboard')


@section('title')
    Store Dashboard Transaction
@endsection


@section('content')
{{-- Section Content  --}}
 <!-- Section Content-->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaksi</h2>
                <p class="dashboard-subtitle">
                </p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12 mt-2">
                    <ul
                      class="nav nav-pills mb-3"
                      id="pills-tab"
                      role="tablist"
                    >
                      <li class="nav-item" role="presentation">
                        <a
                          class="nav-link active"
                          id="home-tab"
                          data-toggle="tab"
                          href="#home"
                          role="tab"
                          aria-controls="home"
                          aria-selected="true"
                          >Daftar Transaksi</a
                        >
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div
                        class="tab-pane fade show active"
                        id="home"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                      >
                        @foreach  ($buyTransactions as $transaction)
                          <a
                          href="{{route('dashboard-transaction-details', $transaction->id)}}"
                          class="card card-list d-block"
                        >
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-1">
                                <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}" 
                                class="w-50"
                                />
                              </div>
                              <div class="col-md-4">{{$transaction->product->name}}</div>
                              <div class="col-md-3"> {{ Auth::user()->name }}</div>
                              <div class="col-md-3">{{$transaction->created_at}}</div>
                              <div class="col-md-1 d-none d-md-block">
                                <img
                                  src="/images/dashboard-arrow-right.svg"
                                  alt=""
                                />
                              </div>
                            </div>
                          </div>
                        </a>
                        @endforeach  
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection