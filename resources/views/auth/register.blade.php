@extends('layouts.auth')

@section('content')

    <div class="page-content page-auth" id="register">
      <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
          <div class="row align-items-center justify-content-center row-login">
            <div class="col-lg-4">
              <h2>
                Belanja Roti sehat <br />
                tanpa pengawet
              </h2>
              <form method="POST" action="{{ route('register') }}">
                  @csrf
              <form class="mt-3">
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input id="name" v-model="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                </div>
                <div class="form-group">
                  <label>Email Address</label>
                  <input id="email" 
                        v-model="email" 
                        @change="checkForEmailAvailability()" type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        :class="{'is-invalid: this.email_unavailable'}"
                        name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>

                <div class="form-group">
                  <label>Konfirmasi Password</label>
                  <input id="password_confirmation" 
                        type="password" 
                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                        name="password_confirmation" 
                        required 
                        ocomplete="new-password">

                                @error('password_confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>

                <button
                  type="submit"
                  class="btn btn-success btn-block mt-4"
                  :disabled="this.email_unavailable"
                >
                  Sign Up Now
                </button>
                <a href="{{route('login')}}" class="btn btn-signup btn-block mt-2">
                  Back to Sign In
                </a>
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
      Vue.use(Toasted);

      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
        },
        methods:{
          checkForEmailAvailability: function(){
            var self = this;
            axios.get('{{route('api-register-check')}}',{
              params:{
                email: this.email
              }
            })
                  .then(function (response) {
                    
                    if(response.data == 'Available') {
                      self.$toasted.show(
                            "Kamu bisa menggunakan E-mail ini,silahkan lanjut ke langkah berikutnya !",
                           {
                             position: "top-center",
                             className: "rounded",
                             duration: 1000,
                           }
                        );
                        self.email_unavailable = false;

                    } else{
                      
                          self.$toasted.error(
                            "Maaf, Email tersebut sudah terdaftar. Gunakan Email lain.",
                           {
                             position: "top-center",
                             className: "rounded",
                             duration: 1000,
                           }
                        );
                        self.email_unavailable = true;
                    }


                       // handle success
                      console.log(response);
                   })
            }
        },
        data(){
          {
          name: "Ariq Uzumaki",
          email: "uzumaki@gmail.com",
          email_unavailable: false
        }
        },
      });
    </script>
@endpush

