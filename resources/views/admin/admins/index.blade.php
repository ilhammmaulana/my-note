<x-admin.layout>
  <x-slot name="title">Admins </x-slot>
  <x-slot name="html">
      <div class="box-white table-responsive mx-3">
          <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createUser">Create User Admin +</button>
          {{-- Modal --}}
          <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title fw-bold" id="createUserLabel">Create user admin</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="d-flex py-4"id="banner_photo_create" style="background-size: cover; background-position: center center;">
                    <label for="file-input-banner-create" class="position-absolute btn-primary fw-bold text-white" style="right: 1rem; top: 10.9rem; font-size: .6rem">
                      Uploud Banner
                    </label>
                    <img src="" width="150px" height="150px" alt="" class="mx-auto border rounded-circle position-relative" style="top: 5rem" id="photo_create">
                  </div>
                  <form class="mt-5" id="form-create" action="{{ url('admins') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="file-input-create" class="custom-file-upload position-absolute" style="top: 14.2rem; right:12rem;">
                      <img src="{{ asset('assets/images/icons/camera.svg') }}" class="px-2 py-2 btn-primary text-white rounded-circle fs-5 border-4">
                    </label>
                    <input type="file" id="file-input-create" class="opacity-0" name="photo">
                    <input type="file"id="file-input-banner-create" name="banner_photo_" class="opacity-0">

                    <div class="form-group">
                      <label for="name-create">Name</label>
                      <input type="text" class="form-control" name="name" id="name-create" placeholder="Enter user name">
                    </div>
                    <div class="form-group">
                      <label for="password-create">Password</label>
                      <input type="text" class="form-control" name="password" id="password" placeholder="Enter user password" min="8">
                    </div>
                    
                    <div class="form-group">
                      <label for="email-create">Email</label>
                      <input type="email" name="email" class="form-control" id="email-create" placeholder="Enter email user">
                    </div>
                    <div class="form-group">
                      <label for="phone-create">Phone</label>
                      <input type="text" name="phone" class="form-control" id="phone-create" placeholder="Enter phone user">
                    </div>
                    <div class="form-group d-flex flex-column">
                      <label for="school_id-create">School</label>
                      <select name="school_id" autocomplete required id="school_id-create">
                        <option selected disabled>Select school</option>
                        @foreach ($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Create</button>
                </form>

                </div>
              </div>
            </div>
        </div>
        {{-- Table --}}
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Photo</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Total Likes</th>
                  <th scope="col">School</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($users as $i => $user)
                      <tr>
                        <td>{{ $i + 1 + 10 * ($users->currentPage() - 1) }}</td>
                          <td>
                              <img src="@if($user->photo !== null) {{ url($user->photo) }}@else {{ asset('assets/images/default.jpg') }} @endif" alt="{{ $user->name . ' photo' }}" width="50px" class="rounded-circle">
                          </td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                              <i class="fa-solid fa-heart @if($user->total_likes > 0) text-danger @else text-secondary @endif fs-5"></i>
                          {{
                          $user->total_likes }}</td>
                          <td>{{ $user->school->school_name }}</td>
                          <td class="d-flex gap-2" data-user-id="{{ $user->id }}" data-user-email="{{ $user->email }}" data-user-name="{{ $user->name }}" data-user-photo="{{ $user->photo !== null ? asset($user->photo) : asset('assets/images/default.jpg') }}" data-user-banner_photo="{{ $user->banner_photo !== null ? asset($user->banner_photo) : asset('assets/images/default.jpg') }}" data-user-phone="{{ $user->phone }}" data-user-school_id="{{ $user->school_id }}">
                              <button class="btn btn-danger btnDelete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                  <i class="fa-solid fa-trash"></i>
                              </button>
                              <button class="btn btn-primary btnEdit" data-bs-toggle="modal" data-bs-target="#myModal">
                                  <i class="fa-solid fa-pen-to-square"></i>
                              </button>
                              <a href="{{ url('users/'.$user->id) }}">
                                <button type="button" class="btn btn-info text-white fw-bold">
                                  <i class="fa-solid fa-ellipsis"></i>
                                  </button>
                              </a>
                          </td>

                      </tr>
                  @endforeach
                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Edit Details</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="d-flex py-4"id="banner_photo" style="background-size: cover; background-position: center center;">
                              <label for="file-input-banner" class="position-absolute btn-primary fw-bold text-white" style="right: 1rem; top: 10.9rem; font-size: .6rem">
                                Change banner
                              </label>
                              <img src="" width="150px" height="150px" alt="" class="mx-auto border rounded-circle position-relative" style="top: 5rem" id="photo">
                            </div>
                            <form class="mt-5" id="form-edit" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PATCH')
                              <label for="file-input" class="custom-file-upload position-absolute" style="top: 14.2rem; right:12rem;">
                                <img src="{{ asset('assets/images/icons/camera.svg') }}" class="px-2 py-2 btn-primary text-white rounded-circle fs-5">
                              </label>
                              <input type="file" id="file-input" class="opacity-0" name="photo">
                              <input type="file"id="file-input-banner" name="banner_photo" class="opacity-0">

                              <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                              </div>
                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email">
                              </div>
                              <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone">
                              </div>
                              <div class="form-group d-flex flex-column">
                                <label for="school_id">School</label>
                                <select name="school_id" autocomplete id="school_id">
                                  @foreach ($schools as $school)
                                  <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </form>

                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="deleteModalLabel">Delete this user ..?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p>This user <span class="text-danger fw-bold"id="name-delete"></span> deleted when click delete button</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form action="" method="post" id="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
              </tbody>
            </table>
            <ul class="pagination">
              @if($users->currentPage() > 1)
                  <li class="page-item">
                      <a class="page-link" href="{{ url('admins?page='.($users->currentPage() - 1)) }}" tabindex="-1">Previous</a>
                  </li>
              @else
                  <li class="page-item disabled">
                      <span class="page-link">Previous</span>
                  </li>
              @endif
          
              @for($i = 0; $i < $users->lastPage(); $i++)
                  @if($users->currentPage() === $i + 1)
                      <li class="page-item active">
                          <a class="page-link">{{ $i + 1 }}</a>
                      </li>
                  @else
                      <li class="page-item">
                          <a class="page-link" href="{{ url('admins?page='.($i + 1)) }}">{{ $i + 1 }}</a>
                      </li>
                  @endif
              @endfor
          
              @if($users->currentPage() < $users->lastPage())
                  <li class="page-item">
                      <a class="page-link" href="{{ url('admins?page='.($users->currentPage() + 1)) }}">Next</a>
                  </li>
              @else
                  <li class="page-item disabled">
                      <span class="page-link">Next</span>
                  </li>
              @endif
          </ul>
      </div>
  </x-slot>
  <x-slot name="js">
      <script defer type="module">
          const randomPassword = (length) => {
              var result = '';
              var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
              var charactersLength = characters.length;
              for (var i = 0; i < length; i++) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
              }

              return result;
          }
        $(document).ready(function(){
          
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
            const file = event.target.files[0];
            const allowedTypes = ['image/jpeg', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
              alert('Please select a JPEG or JPG image file.');
              return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
              $('#banner_photo').css('background-image', `url(${e.target.result})`);
            };
            reader.readAsDataURL(file);
          } 

          const changePhotoCreate =  (event) =>  {
            const file = event.target.files[0];
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            if (!allowedTypes.includes(file.type)) {
              alert('Please select a JPEG or JPG or PNG image file.');
              return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
              const img = document.getElementById('photo_create');
              img.src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
          const changeBannerCreate = (event)=> {
            const file = event.target.files[0];
            const allowedTypes = ['image/jpeg', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
              alert('Please select a JPEG or JPG image file.');
              return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
              $('#banner_photo_create').css('background-image', `url(${e.target.result})`);
            };
            reader.readAsDataURL(file);
          } 
        
        
          $('.btnDelete').click(function(){
            const component = this.parentNode;
            const idUser = $(component).data('user-id');
            const name = $(component).data('user-name');
            let baseUrl = `${idUser}`;
            $('#name-delete').text(name)
            const url = "{{ url('users') }}" + '/' + baseUrl;
            $('#form-delete').attr('action', url)

          });
          $('.btnEdit').click(function(){
              const component = this.parentNode;
              const school_id = $(component).data('user-school_id');
              const name = $(component).data('user-name');
              const email = $(component).data('user-email');
              const phone = $(component).data('user-phone');
              const photo = $(component).data('user-photo');
              const schoolId = $(component).data('user-school_id');
              const banner_photo = $(component).data('user-banner_photo');
              const idUser = $(component).data('user-id');
              let baseUrl = `${idUser}`;
              const url = "{{ url('users') }}" + '/' + baseUrl  ;
              const selectedOption = $('#school_id option[value="' + schoolId + '"]');
              $('#school_id option:selected').removeAttr('selected');
              selectedOption.attr('selected', 'true')
                $('#name').val(name);
                $('#email').val(email);
                $('#phone').val(phone);
                $('#photo').attr('src', photo);
                $('#photo').attr('src', photo);
                $('#form-edit').attr('action', url)
                $('#banner_photo').css('background-image', 'url(' + banner_photo + ')');
            });
            $('#file-input-create').on('change', changePhotoCreate)
            $('#file-input-banner-create').on('change', changeBannerCreate)

            $('#file-input').on('change', changePhoto)
            $('#file-input-banner').on('change', changeBanner)
          });
     
          $("#password").val(randomPassword(9))
      </script>
  </x-slot>
</x-admin.layout>