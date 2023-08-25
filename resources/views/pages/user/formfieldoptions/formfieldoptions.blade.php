<x-base-layout :scrollspy="false">

  <x-slot:pageTitle>
  </x-slot>

  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <x-slot:headerFiles>
      <!--  BEGIN CUSTOM STYLE FILE  -->
      <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
      @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
      @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
      @vite(['resources/scss/light/assets/components/modal.scss'])
      @vite(['resources/scss/dark/assets/components/modal.scss'])
      <!--  END CUSTOM STYLE FILE  -->
  </x-slot>
  <!-- END GLOBAL MANDATORY STYLES -->

  <!-- BREADCRUMB -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="page-meta">
      <nav class="breadcrumb-style-one" aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">User Form Field Options</a></li>
              <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
          </ol>
      </nav>
  </div>
  <!-- /BREADCRUMB -->

  <div class="row layout-top-spacing">

      <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
          <div class="widget-content widget-content-area br-8">
          <table id="zero-config" class="table dt-table-hover" style="width:100%">
              <thead>
                  <tr role="row">
                      <th>{{__('User Email')}}</th>
                      <th>{{__('Activated')}}</th>
                      <th>{{__('Deactivated')}}</th>
                      <th>{{__('Action')}}</th>
                  </tr>
              </thead>
              <tbody>

              @forelse ($lastResult as $key => $userForm)
              <tr>
                  <td class="pl-3">{{$userForm['email']}}</td>
                  <td class="pl-3">{{$userForm['activated']}}</td>
                  <td class="pl-3">{{$userForm['deactivated']}}</td>
                  <td class="pl-3">
                      <button data-bs-toggle="modal" data-bs-target="#editModal"class='btn btn-outline-info'
                      onclick='editModal(
                          "{{$userForm['email']}}"
                          )'>
                          Edit Options
                      </button>
                  </td>
              </tr>

              @empty
                  <tr><td>No Data Available</td></tr>
              @endforelse
              </tbody>
          </table>
              @include('pages.admin.formfieldoptions.edit_options')
          </div>
      </div>
  </div>

  <!--  BEGIN CUSTOM SCRIPTS FILE  -->
  <x-slot:footerFiles>
      <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
      <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
      <script>
          $('#zero-config').DataTable({
              "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
          "<'table-responsive'tr>" +
          "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
              "oLanguage": {
                  "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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

          function editModal(email) {
              if(email){

                  // AJAX request
                  var url = "{{ url('admin/user-field-options/:email') }}";
                  url = url.replace(':email',email);

              // Empty modal data
              $('#ufo tbody').empty();

              $.ajax({
                  url: url,
                  dataType: 'json',
                  success: function(response){
                      // Add employee details
                      console.log(response);
                      $('#ufo tbody').html(response.html);
                  }
              });
              }
          }

          function updateStatus(lKey=null, fKey = null, status=0) {
              var url = "{{ url('admin/user-field-options/update') }}";
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              $.ajax({
                  type:'POST',
                  url: url,
                  data:{lKey:lKey, fKey:fKey, status:status},
                  success:function(data){
                      var tableBody = document.querySelector('table[data-table="myTable"] tbody');
                      var rowToUpdate = tableBody.querySelector('[data-id="' + fKey + '"]');

                      var status = rowToUpdate.cells[1];
                      status.textContent = data.status == '1' ? 'Activated' : 'Deactivated';

                      var action = rowToUpdate.cells[2];
                      action.innerHTML = data.status == '1' ? '<div class="align-items-baseline"><a href="#" onclick="updateStatus('+"'"+lKey+"'"+','+"'"+fKey+"'"+', 0)"class="text-danger delete-website-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-dash-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/></svg></a></div>' : '<div class="align-items-baseline"><a href="#" onclick="updateStatus('+"'"+lKey+"'"+','+"'"+fKey+"'"+', 1)"class="text-danger delete-website-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></a></div>';
                  }
              });
          }
      </script>
  </x-slot>
  <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
