<x-admin.layout>
    <x-slot name="title">Manage Friend List</x-slot>
    <x-slot name="html">
        <div class="box-white table-responsive mx-3">
          <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createUser">Create School</button>
          <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title fw-bold" id="createUserLabel">Create Friend List</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form class="mt-1" id="form-create" action="{{ url('schools') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="school_name">School Name</label>
                      <input type="text" class="form-control" name="school_name" id="school_name" placeholder="Enter user name">
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
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">School Name</th>
                    <th scope="col">Total User</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach ($schools as $i => $school)
                        <tr>
                            <td>{{ $i + 1 + 10 * ($schools->currentPage() - 1) }}</td>
                           <td>{{ $school->school_name }}</td>
                           <td>{{ count($school->user) }}</td>
                            <td data-school-name="{{ $school->school_name }}" data-school-id="{{ $school->id }}">
                                <button class="btn btn-danger btnDelete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button class="btn btn-primary btnEdit" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>

                        </tr>
                    @endforeach
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Edit School</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form id="form-edit" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                  <label for="school_name">School Name</label>
                                  <input type="text" class="form-control" name="school_name" id="school_name">
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
                            <h1 class="modal-title fs-5" id="deleteModalLabel">Non active this school ..?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>This school <span class="text-danger fw-bold"id="name-delete"></span> nonactived when click nonactive button</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="" method="post" id="form-delete">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Non Active</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </tbody>
              </table>
              <ul class="pagination">
                @if($schools->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ url('schools?page='.($schools->currentPage() - 1)) }}" tabindex="-1">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @endif
            
                @for($i = 0; $i < $schools->lastPage(); $i++)
                    @if($schools->currentPage() === $i + 1)
                        <li class="page-item active">
                            <a class="page-link">{{ $i + 1 }}</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ url('schools?page='.($i + 1)) }}">{{ $i + 1 }}</a>
                        </li>
                    @endif
                @endfor
            
                @if($schools->currentPage() < $schools->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ url('schools?page='.($schools->currentPage() + 1)) }}">Next</a>
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
            
          $(document).ready(function(){
            
         
            $('.btnDelete').click(function(){
              const component = this.parentNode;
              const school_id = $(component).data('school-id');

              let baseUrl = `${school_id}`;
              const url = "{{ url('schools') }}" + '/' + baseUrl;
              $('#form-delete').attr('action', url)

            });
            $('.btnEdit').click(function(){
                const component = this.parentNode;
                const school_name = $(component).data('school-name');
                const school_id = $(component).data('school-id');

                let baseUrl = `${school_id}`;
                const url = "{{ url('schools') }}" + '/' + baseUrl  ;
                $('#school_id option:selected').removeAttr('selected');
                console.log(school_name);
                  $('#school_name').val(school_name);
                  $('#form-edit').attr('action', url)
              });

            });
        </script>
    </x-slot>
</x-admin.layout>