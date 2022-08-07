
@extends('layouts.admin')


@section('title')
    Product
@endsection


@section('content')
{{-- Section Content  --}}

          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Product</h2>
                <p class="dashboard-subtitle">
                  List Product
                </p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Produk Baru</a>
                                    <div class="table-responsive">
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama</th>
                                                    <th>Pemilik</th>
                                                    <th>kategori</th>
                                                    <th>Harga</th>
                                                    <th>Stock</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>


@endsection



@push('addon-script')
    <script>
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current()  !!}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'name', name: 'name' },
                { data: 'user.name', name: 'user.name' },
                { data: 'category.name', name: 'category.name' },
                { data: 'price', name: 'price' },
                { data: 'stock', name: 'stock' },
                { 
                    data: 'action', 
                    name: 'action',
                    orderable: false,
                    searcable: false, 
                    width: '15%' 
                },
            ]
        })
    </script>
     <script>
        function ShowPlush(id)
        {
          if (id) {
            jQuery.ajax({
              url: '/api/product/stock/'+id,
              type: "GET", 
              dataType: "json",
              success: function (response) {
                console.log(response);
                           $("#showModal").modal('show');
                        //    $("#exampleModalLabel").text(`${response.data.name} ${response.data.type} ${response.data.jenis}`);
                        //    $("#product_id").val(response.data.id)
                       
                             },
     
                         });
                     }
        }
       
      </script>
@endpush
