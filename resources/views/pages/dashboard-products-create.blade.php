
@extends('layouts.dashboard')


@section('title')
    Store Dashboard Product Detail
@endsection


@section('content')
<!-- Section Content-->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Tambah Produk Baru</h2>
                <p class="dashboard-subtitle">
                  Tambahkan produk baru kamu
                </p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12">
                    <form action="{{route('dashboard-product-store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" nama="users_id" value="{{Auth::user()->id}}">
                      <div class="card">
                        <div class="card-body">
                          <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" name="name"/>        
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="price"/>        
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Kategori</label>
                                <select name="categories_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>      
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" id="editor"></textarea>        
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Thumbnails</label>
                                <input type="file" name="photo" class="form-control"/>
                                <p class="text-muted">
                                  Kamu dapat memeilih lebih dari 1 file
                                </p>        
                              </div>
                            </div>
                            

                            
                        </div>
                        <div class="row">
                          <div class="col text-right">
                            <button type="submit" class="btn btn-success px-5">
                              Save
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>@endsection


@push('addon-script')
  <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    
    <script>
      CKEDITOR.replace( 'editor' );
     </script>
@endpush
