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
      <meta name="csrf-token" content="your-csrf-token-value">
      <!-- END GLOBAL MANDATORY STYLES -->

      <!-- BREADCRUMB -->
      <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">User Settings</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
          </ol>
        </nav>
      </div>
      <!-- /BREADCRUMB -->

      <div class="row layout-top-spacing">

        <div class="col-sm-12 pb-3 d-flex justify-content-end">
          <button class="btn btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Add Setting</button>
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
            <table id="zero-config" class="table dt-table-hover w-100" data-table="myTable">


              <thead>
                <tr>
                  <th>User Level</th>
                  <th>Website Limit</th>
                  <th>Business Limit</th>
                  <th>Approval Hours</th>
                  <th>Approval Limit</th>
                  <th class="no-content">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($levels as $level)
                <tr data-id="{{$level->id}}">
                  <td>{{ $level->name }}</td>
                  <td>{{ $level->website_limit }}</td>
                  <td>{{ $level->business_limit }}</td>
                  </td>
                  <td>{{ $level->approval_hours }}</td>
                  <td>{{ $level->approval_limit }}</td>
                  <td>
                    <div class="dropdown">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                          <circle cx="12" cy="12" r="1"></circle>
                          <circle cx="19" cy="12" r="1"></circle>
                          <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                      </a>

                      <div class="dropdown-menu" data-popper-placement="bottom-end" aria-labelledby="dropdownMenuLink2">
                        <!-- <a class="dropdown-item" href="javascript:void(0);">View</a> -->
                        <a data-bs-toggle="modal" class="dropdown-item view-details" data-bs-target="#editModal" href="#" data-level_id="{{ $level->id }}" data-name="{{ $level->name }}" data-website_limit="{{ $level->website_limit }}" data-business_limit="{{ $level->business_limit }}" data-approval_hours="{{ $level->approval_hours }}" data-approval_limit="{{ $level->approval_limit }}" onclick='editModal(
                                    {{ $level->id }},
                                    "{{ $level->name }}",
                                    {{ $level->website_limit }},
                                    {{ $level->business_limit }},
                                    {{ $level->approval_hours }},
                                    {{ $level->approval_limit }}
                                    );'>
                          Edit

                        </a>
                        {{-- <a class="text-danger delete-shortcode-btn" href="" data-target="#delete"><i class="fas fa-trash-alt"></i></a> --}}
                        <a class="dropdown-item" href="/admin/user-levels/destroy?id={{ $level->id }}">Delete</a>
                      </div>
                    </div>




                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <!-- Create Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24" viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width=" 2" stroke-linecap="round" stroke-linejoin="round" class="feafeather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1x2="18" y2="18"></line>
                      </svg>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                    <form method="post" action='/admin/user-levels/store' id="userLevelCreateForm">
                      @csrf
                      <div class="form-group">

                        <label for="exampleFormControlInput1">Level Name</label>
                        <input required type="text" name="name" class="form-control" id="exampleFormControlInput1" value="">
                        <label for="exampleFormControlInput1">Website Limit</label>
                        <input required type="text" name="website_limit" class="form-control" id="exampleFormControlInput1" value="">
                        <label for="exampleFormControlInput1">Business Limit</label>
                        <input required type="text" name="business_limit" class="form-control" id="exampleFormControlInput1" value="">
                        <label for="exampleFormControlInput1">Approval Hours</label>
                        <input required type="text" name="approval_hours" class="form-control" id="exampleFormControlInput1" value="">
                        <label for="exampleFormControlInput1">Approval Limit</label>
                        <input required type="text" name="approval_limit" class="form-control" id="exampleFormControlInput1" value="">


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
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Website</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24" viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width=" 2" stroke-linecap="round" stroke-linejoin="round" class="feafeather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1x2="18" y2="18"></line>
                      </svg>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                    <form method="post" action='/admin/user-levels/update' id="userLevelEditForm">
                      @csrf
                      <input type="hidden" id="level_id" name="id">
                      <div class="form-group">
                        <label for="name">Level Name</label>
                        <input required type="text" name="name" class="form-control" id="name" value="">
                        <label for="website_limit">Website Limit</label>
                        <input required type="text" name="website_limit" class="form-control" id="website_limit" value="">
                        <label for="business_limit">Business Limit</label>
                        <input required type="text" name="business_limit" class="form-control" id="business_limit" value="">
                        <label for="approval_hours">Approval Hours</label>
                        <input required type="text" name="approval_hours" class="form-control" id="approval_hours" value="">
                        <label for="approval_limit">Approval Limit</label>
                        <input required type="text" name="approval_limit" class="form-control" id="approval_limit" value="">


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

          function editModal(id, name, website_limit, business_limit, approval_hours, approval_limit) {
            document.getElementById("name").value = name;
            document.getElementById("website_limit").value = website_limit;
            document.getElementById("business_limit").value = business_limit;
            document.getElementById("approval_hours").value = approval_hours;
            document.getElementById("approval_limit").value = approval_limit;
            document.getElementById("level_id").value = id;
          }

          document.getElementById('userLevelCreateForm').addEventListener('submit', function(event) {
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

                var name = newRow.insertCell(0);
                var website_limit = newRow.insertCell(1);
                var business_limit = newRow.insertCell(2);
                var approval_limit = newRow.insertCell(3);
                var approval_hours = newRow.insertCell(4);
                var action = newRow.insertCell(5);

                name.innerHTML = response.name;
                website_limit.innerHTML = response.website_limit;
                business_limit.innerHTML = response.business_limit;
                approval_limit.innerHTML = response.approval_limit;
                approval_hours.innerHTML = response.approval_hours;
                action.innerHTML = `<div class="dropdown">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                          <circle cx="12" cy="12" r="1"></circle>
                          <circle cx="19" cy="12" r="1"></circle>
                          <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                      </a></div>`

                // Clear the form inputs
                document.getElementById('userLevelCreateForm').reset();
                // Close the modal
                $("#exampleModalCenter").modal('hide');
              } else {
                // Handle error cases
                console.log(xhr.responseText);
              }
            };

            xhr.send(formData);
            return false;
          });

          const editForm = document.getElementById('userLevelEditForm');

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
                                editForm.elements['website_limit'].value = response.website_limit;
                                editForm.elements['business_limit'].value = response.business_limit;
                                editForm.elements['approval_limit'].value = response.approval_limit;
                                editForm.elements['approval_hours'].value = response.approval_hours;

                                var tableBody = document.querySelector('table[data-table="myTable"] tbody');
                                var rowToUpdate = tableBody.querySelector('[data-id="' + response.id + '"]');
                                // Update the cells with the new values
                                var name = rowToUpdate.cells[0];
                                name.textContent = response.name;

                                var website_limit = rowToUpdate.cells[1];
                                website_limit.textContent = response.website_limit;

                                var business_limit = rowToUpdate.cells[2];
                                business_limit.textContent = response.business_limit;

                                var approval_limit = rowToUpdate.cells[3];
                                approval_limit.textContent = response.approval_limit;

                                var approval_hours = rowToUpdate.cells[4];
                                approval_hours.textContent = response.approval_hours;

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