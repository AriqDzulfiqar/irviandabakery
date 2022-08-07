
@extends('layouts.dashboard')


@section('title')
    Account
@endsection


@section('content')
    <!-- Section Content-->
          <div
            class="section-content section-dashboard-home"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Akun Saya</h2>
                <p class="dashboard-subtitle">
                  Update profil kamu !
                </p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-12">
                    <form action="{{route('dashboard-redirect','dashboard-account')}}" method="POST" enctype="multipart/form-data" id="locations">
                    @csrf
                      <div class="card">
                        <div class="card-body">
                          <div class="row mb-2" >
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="addressOne">Nama</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="name"
                                  name="name"
                                  value="{{$user->name}}"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="addressTwo">Email</label>
                                <input
                                  type="email"
                                  class="form-control"
                                  id="email"
                                  name="email"
                                  value="{{$user->email}}"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="address">Alamat</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="address"
                                  name="address"
                                  value="{{$user->address}}"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="detail_address">Detail Alamat</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="detail_address"
                                  name="detail_address"
                                  value="{{$user->detail_address}}"
                                />
                              </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="provinces_id">Provinsi</label>
                                  <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id" v-if="provinces">
                                    <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                                  </select>
                                  <select v-else class="form-control"></select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="regencies_id">Kota</label>
                                  <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id" v-if="regencies">
                                    <option v-for="regency in regencies" :value="regency.id">@{{regency.name }}</option>
                                  </select>
                                  <select v-else class="form-control"></select>
                                </div>
                              </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="zip_code">Kode Pos</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="zip_code"
                                  name="zip_code"
                                  value="{{$user->zip_code}}"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="country">Negara</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="country"
                                  name="country"
                                  value="{{$user->country}}"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="phone_number">Nomor Hp</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="phone_number"
                                  name="phone_number"
                                  value="{{$user->phone_number}}"
                                />
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
          </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      var locations = new Vue({
        el: "#locations",
        mounted() {
          this.getProvincesData();
        },
        data: {
          provinces: null,
          regencies: null,
          provinces_id: null,
          regencies_id: null,
        },
        methods: {
          getProvincesData() {
            var self = this;
            axios.get('{{ route('api-provinces') }}')
              .then(function (response) {
                  self.provinces = response.data;
              })
          },
          getRegenciesData() {
            var self = this;
            axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
              .then(function (response) {
                  self.regencies = response.data;
              })
          },
        },
        watch: {
          provinces_id: function (val, oldVal) {
            this.regencies_id = null;
            this.getRegenciesData();
          },
        }
      });
    </script>
@endpush