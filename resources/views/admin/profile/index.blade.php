<x-admin.layout>
    <x-slot name="title">Hi , {{ $user->name }} </x-slot>
    <x-slot name="html">
        <a href="{{ url('users') }}" class="btn-primary text-white px-3 py-2 rounded-5 mb-4 ">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="box-white mt-4">
            <div class="row">
                <div class="col-md-6" id="banner_photo" style="height: 40vh;  background-image: url({{ $user->banner_photo !== null ? asset($user->banner_photo) : asset('assets/images/default-banner.jpg') }}); background-size:cover;   ">
                    <div class="m-auto d-flex">
                        <img src="{{ $user->photo !== null ? asset($user->photo) : asset('assets/images/default.jpg') }}" alt="" id="photo" class="rounded-circle m-auto mt-5" width="150" height="150">
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold">Profile</h2>
                    <form id="form" action="{{ url('users/' . auth()->id()) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="file" id="photo-input" class="opacity-0" name="photo">
                        <div class="d-flex gap-1">
                            <label for="photo-input" class="btn btn-primary" >
                                <img src="{{ asset('assets/icons/camera.svg') }}" alt="">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name" placeholder="Enter user name">
                        </div>

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="email" placeholder="Enter email user">
                        </div>
                        <div class="form-group">
                          <label for="phone">Phone</label>
                          <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" id="phone" placeholder="Enter phone user">
                        </div>
                    
                        <button class="btn btn-primary mt-2">Edit user</button>
                        <form>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="js">
        <script>
            $(document).ready(function () {
            const changePhoto =  (event) =>  {
              const file = event.target.files[0];
              const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

              if (!allowedTypes.includes(file.type)) {
                alert('Please select a JPEG or JPG or PNG image file.');
                return;
              }
              const reader = new FileReader();
              reader.onload = (e) => {
                const img = document.getElementById('photo');
                img.src = e.target.result;
              };
              reader.readAsDataURL(file);
            }
            const changeBanner = (event)=> {
                console.log('Banner_Photo')
              const file = event.target.files[0];
              const allowedTypes = ['image/jpeg', 'image/jpg'];
              console.log('active')
              if (!allowedTypes.includes(file.type)) {
                  alert('Please select a JPEG or JPG image file.');
                  return;
                }
                const reader = new FileReader();
              console.log($('#banner_photo'))
              reader.onload = (e) => {
                $('#banner_photo').css('background-image', `url(${e.target.result})`);
              };
              reader.readAsDataURL(file);
            }
            $('#photo-input').on('change', changePhoto)

            });
            
            


        </script>
    </x-slot>
</x-admin.layout>