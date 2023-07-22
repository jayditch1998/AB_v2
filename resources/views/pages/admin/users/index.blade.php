<x-base-layout :scrollspy="false">

  <x-slot:pageTitle>
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
      <!--  BEGIN CUSTOM STYLE FILE  -->
      <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
      @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
      @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
      @vite(['resources/scss/light/assets/components/modal.scss'])
      @vite(['resources/scss/dark/assets/components/modal.scss'])
      @vite(['resources/scss/light/assets/components/font-icons.scss'])
      @vite(['resources/scss/dark/assets/components/font-icons.scss'])
      <!--  END CUSTOM STYLE FILE  -->
      </x-slot>
      <!-- END GLOBAL MANDATORY STYLES -->

      <!-- BREADCRUMB -->
      <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Users</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
          </ol>
        </nav>
      </div>
      <!-- /BREADCRUMB -->

      <div class="row layout-top-spacing">

        <div class="col-sm-12 pb-3 d-flex justify-content-end">
          <button class="btn btn-outline-primary float-right" data-bs-toggle="modal"
            data-bs-target="#exampleModalCenter">Add User</button>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
          @if (count($errors) > 0)
            <div class="alert m-0 mt-4 mb-3 alert-danger">
              <ul class="request-status m-0 p-0">
                @foreach ($errors->all() as $error)
                  <li class="d-block">
                    <i class="fa fa-exclamation-triangle"></i>
                    {!! $error !!}
                  </li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="widget-content widget-content-area br-8 ">
            <table id="zero-config" data-table="myTable" class="table dt-table-hover w-100">


              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Level</th>
                  <th>Role</th>
                  <th>License Key</th>
                  <th class="no-content">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr data-id="{{$user->id}}">
                    <td>{{ $user->id }}</td>
                    <td>{{ str($user->name)->title }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span
                        class="{{ $user->status == 'Active' ? 'alert alert-success p-1 rounded-lg' : 'alert alert-danger p-1 rounded-lg' }}">{{ str($user->status)->title }}</span>
                    </td>
                    <td>{{ str($user->level->name)->title }}</td>
                    <td>{{ str($user->role->name)->title }}</td>
                    <td>{{ str(Str::of($user->license_key)->substr(8, 50))->title }}...</td>
                    <td>
                      <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1"
                          data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-more-horizontal">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                          </svg>
                        </a>

                        <div class="dropdown-menu"  aria-labelledby="dropdownMenuLink1">
                          <!-- <a class="dropdown-item" href="javascript:void(0);">View</a> -->
                          <a data-bs-toggle="modal" class="dropdown-item view-details" data-bs-target="#editModal" href="#"
                            data-user_id="{{ $user->id }}" data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}" data-mobile="{{ $user->mobile }}"
                            data-role_id="{{ $user->role_id }}" data-level_id="{{ $user->user_level_id }}"
                            data-status="{{ $user->status }}" data-license_key="{{ $user->license_key }}"
                            onclick='editModal(
                                    {{ $user->id }},
                                    "{{ $user->name }}",
                                    "{{ $user->email }}",
                                    "{{ $user->mobile }}",
                                    {{ $user->role_id }},
                                    {{ $user->user_level_id }},
                                    "{{ $user->status }}",
                                    "{{ $user->license_key }}"
                                    )'>
                            Edit

                          </a>
                          {{-- <a class="text-danger delete-shortcode-btn" href="" data-target="#delete"><i class="fas fa-trash-alt"></i></a> --}}
                          <a class="dropdown-item" href="/admin/users/destroy?id={{$user->id}}">Delete</a>
                        </div>
                      </div>




                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <!-- Create Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feafeather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1x2="18" y2="18"></line>
                      </svg>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                    <form method="post" id='createUser' action='/admin/users/store'>
                      @csrf
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input required type="text" name="name" class="form-control"
                          id="exampleFormControlInput1" value="">
                        <label for="exampleFormControlInput1">Email Address</label>
                        <input required type="email" name="email" class="form-control"
                          id="exampleFormControlInput1" value="">
                        <label for="exampleFormControlInput1">Mobile #</label>
                        <input required type="text" name="mobile" class="form-control"
                          id="exampleFormControlInput1" value="">

                        <label for="exampleFormControlInput2">Role</label>
                        <!-- <input required type="text" name="website_category" class="form-control" id="exampleFormControlInput2" value=""> -->
                        <select id="exampleFormControlInput2" class="form-control" name="role_id">
                          <option value="all" selected>Select Role</option>
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                          @endforeach
                          <!-- <option>lkfdsjlkfds</option> -->
                        </select>

                        <label for="exampleFormControlInput5">Level</label>
                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                        <select id="exampleFormControlInput5" class="form-control" name="user_level_id">
                          <option value="all" selected>Select Level</option>
                          @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                          @endforeach
                          <!-- <option>lkfdsjlkfds</option> -->
                        </select>
                        <label for="exampleFormControlInput4">Status</label>
                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                        <select id="exampleFormControlInput4" class="form-control" name="status">
                          <option value="">Select Status</option>
                          <option value="Active">Active</option>
                          <option value="Pending">Pending</option>

                          <!-- <option>lkfdsjlkfds</option> -->
                        </select>

                        <label for="exampleFormControlInput1">Password</label>
                        <input required type="password" name="password" class="form-control"
                          id="exampleFormControlInput1" value="">
                        <label for="password_confirmation">Confirm Password</label>
                        <input required type="password" name="password_confirmation"
                          class="form-control" id="exampleFormControlInput1" value="">

                      </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-light-dark" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Website</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feafeather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1x2="18" y2="18"></line>
                      </svg>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                    <form method="post" id="userEditForm" action='/admin/users/update'>
                      @csrf
                      <input type="hidden" id="user_id" name="id">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input required type="text" name="name" class="form-control" id="name"
                          value="">
                        <label for="email">Email Address</label>
                        <input required type="email" name="email" class="form-control" id="email"
                          value="">
                        <label for="mobile">Mobile #</label>
                        <input required type="text" name="mobile" class="form-control" id="mobile"
                          value="">

                        <label for="role_id">Role</label>
                        <!-- <input required type="text" name="website_category" class="form-control" id="exampleFormControlInput2" value=""> -->
                        <select id="role_id" class="form-control" name="role_id">
                          <option value="all" selected>Select Role</option>
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                          @endforeach
                          <!-- <option>lkfdsjlkfds</option> -->
                        </select>

                        <label for="user_level_id">Level</label>
                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                        <select id="user_level_id" class="form-control" name="user_level_id">
                          <option value="all" selected>Select Level</option>
                          @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                          @endforeach
                          <!-- <option>lkfdsjlkfds</option> -->
                        </select>
                        <label for="status">Status</label>
                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                        <select id="status" class="form-control" name="status">
                          <option value="">Select Status</option>
                          <option value="Active">Active</option>
                          <option value="Pending">Pending</option>

                          <!-- <option>lkfdsjlkfds</option> -->
                        </select>
                        <label for="license_key">License Key</label>
                        <textarea rows="5" id="license_key" type="text"
                          class="form-control @error('license_key') is-invalid @enderror" name="license_key" autocomplete="license_key"
                          autofocus></textarea>

                      </div>
                  </div>
                  <div class="modal-footer">
                    <a class="btn btn-light-dark" data-bs-dismiss="modal">Discard</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--  BEGIN CUSTOM SCRIPTS FILE  -->
      <x-slot:footerFiles>
        <script type="module" src="{{asset('plugins/font-icons/feather/feather.min.js')}}"></script>
        <script type="module">
            setTimeout(() => {
                feather.replace();
            }, 2000);
        </script>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script>
          $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
              "<'table-responsive'tr>" +
              "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
              "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
              },
              "sInfo": "Showing page _PAGE_ of _PAGES_",
              "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
              "sSearchPlaceholder": "Search...",
              "sLengthMenu": "Results :  _MENU_",
              //    "sLengthMenu": "shiiss :",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10,
            "aaSorting": []
          });

          function editModal(id, name, email, mobile, role_id, user_level_id, status, license_key) {
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("mobile").value = mobile;
            document.getElementById("role_id").value = role_id;
            document.getElementById("user_level_id").value = user_level_id;
            document.getElementById("status").value = status;
            document.getElementById("license_key").value = license_key;
            document.getElementById("user_id").value = id;
          }


          // Listen for the form submission event
          document.getElementById('createUser').addEventListener('submit', function(event) {
                        event.preventDefault(); // Prevent page refresh

                        // Get form data
                        var formData = new FormData(this);

                        // Make an AJAX request to submit the form
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', this.action, true);

                        var csrfToken = document.querySelector('meta[name="csrf-token"]');
                        if (csrfToken) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.getAttribute('content'));
                        }

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Form submitted successfully

                                var response = JSON.parse(xhr.responseText);
                                // Add the submitted data to the table

                                var tableBody = document.querySelector('table[data-table="myTable"] tbody');
                                var firstRow = tableBody.rows[0];
                                var newRow = tableBody.insertRow(firstRow);
                                var idCell = newRow.insertCell(0);
                                var nameCell = newRow.insertCell(1);
                                var emailCell = newRow.insertCell(2);
                                var statusCell = newRow.insertCell(3);
                                var levelCell = newRow.insertCell(4);
                                var roleCell = newRow.insertCell(5);
                                var licenseCell = newRow.insertCell(6);
                                idCell.innerHTML = response.id;
                                nameCell.innerHTML = response.name;
                                emailCell.innerHTML = response.email;
                                statusCell.innerHTML = response.status;
                                levelCell.innerHTML = response.level;
                                roleCell.innerHTML = response.role;
                                licenseCell.innerHTML = response.license;
                                $("#exampleModalCenter").modal('hide');
                                // Clear the form inputs
                                document.getElementById('categoryCreateForm').reset();
                                // Close the modal

                            } else {
                                // Handle error cases
                                console.log(xhr.responseText);
                            }
                        };

                        xhr.send(formData);
                        return false;
                    });

                    const editForm = document.getElementById('userEditForm');

                    editForm.addEventListener('submit', function(event) {
                        event.preventDefault();
                        // Get form data
                        var formData = new FormData(this);
                        // Make an AJAX request to submit the form
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', this.action, true);

                        var csrfToken = document.querySelector('meta[name="csrf-token"]');
                        if (csrfToken) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.getAttribute('content'));
                        }

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Form submitted successfully
                                var response = JSON.parse(xhr.responseText);
                                editForm.elements['name'].value = response.name;
                                editForm.elements['email'].value = response.description;
                                editForm.elements['mobile'].value = response.user_id;
                                editForm.elements['role_id'].value = response.name;
                                editForm.elements['user_level_id'].value = response.description;
                                editForm.elements['status'].value = response.user_id;
                                editForm.elements['license_key'].value = response.description;
                                editForm.elements['user_id'].value = response.user_id;



                                var tableBody = document.querySelector('table[data-table="myTable"] tbody');
                                var rowToUpdate = tableBody.querySelector('[data-id="' + response.id + '"]');
                                // Update the cells with the new values
                                var id = rowToUpdate.cells[0];
                                id.textContent = response.id;

                                var name = rowToUpdate.cells[1];
                                name.textContent = response.name;

                                var email = rowToUpdate.cells[2];
                                email.textContent = response.email;

                                var status = rowToUpdate.cells[3];
                                status.textContent = response.status;

                                var level = rowToUpdate.cells[4];
                                level.textContent = response.level;

                                var role = rowToUpdate.cells[5];
                                role.textContent = response.role;

                                var license = rowToUpdate.cells[6];
                                license.textContent = response.license;

                                // Clear the form inputs
                                // document.getElementById('categoryEditForm').reset();
                                // Close the modal
                                $("#editModal").modal('hide');
                            } else {
                                // Handle error cases
                                console.log(xhr.responseText);
                            }
                        };

                        xhr.send(formData);
                        return false;
                    })
        </script>
        </x-slot>
        <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
