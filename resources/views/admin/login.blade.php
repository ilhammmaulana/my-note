<x-auth.layout>
    <x-slot name="title">Login</x-slot>
    <x-slot name="html">
        <x-alerts.alert></x-alerts.alert>
        <div class="container">
            <div class="row m-5 bg-white">
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/images/astronot.jpg') }}" class="img-fluid" id="image-sidebar"/>
            </div>
              <div class="col-md-6 d-flex">
                <div class="form-style m-auto">
                  <h3 class="pb-3 text-start">Login Form</h3>
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group pb-3">    
                      <input type="email" name="email" placeholder="Email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">   
                    </div>
                    <div class="form-group pb-3">   
                      <input type="password" name="password" placeholder="Password" class="form-control" id="exampleInputPassword1">
                    </div>                           
                    <div class="pb-2">
                      <button type="submit" class="btn-theme-dark w-100 font-weight-bold mt-2">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>          
    </x-slot>
</x-auth.layout> 
