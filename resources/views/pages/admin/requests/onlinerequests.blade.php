<x-base-layout :scrollspy="false">
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
      <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Online Requests</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
          </ol>
        </nav>
      </div>
      <!-- /BREADCRUMB -->

      <div class="row layout-top-spacing">

        <div class="col-sm-12 pb-3 d-flex justify-content-end">
          <!-- <button class="btn btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Approve all</button> -->
          <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#approve_all_modal">Approve All</button>
          <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#decline_all_modal">Decline All</button>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
          <div class="widget-content widget-content-area br-8">
            <table id="zero-config" class="table dt-table-hover" style="width:100%, " data-table="myTable">


              <thead>
                <tr>
                  <th>Date Requested</th>
                  <th>User Name</th>
                  @foreach($shortcodeInColumn as $key => $item)
                  @if($item == 'website_id')
                  <th>{{__('Website Name')}}</th>
                  @elseif($item == 'name')
                  <th>{{ __('Business Name') }}</th>
                  @elseif($item == 'business_email')
                  <th>{{ __('Business Email') }}</th>
                  @else
                  <th>{{ucwords(str_replace('_', ' ', $item))}}</th>
                  @endif

                  @endforeach
                  <th>Business URL</th>
                  <th class="no-content">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($businesses as $business)
                @if(isset($business->website))
                <tr  data-id="{{$business->id}}">
                  <td>{{$business->created_at->format('M d, Y')}}</td>
                  <td>{{$business->website->user['name']}}</td>
                  @foreach($shortcodeInColumn as $key => $item)

                  @if($item == 'website_id')
                  <td><a href="{{$business->website['url'].'?business_code='.$business->business_code}}">{{$business->Website['name']}}</a></td>

                  @elseif ($item == 'business_email')
                  <td>{{$business[$item]}}</td>
                  @else
                  @if($item == 'status')
                  <td><span class="{{$business[$item] == 'approved' ? 'alert alert-success p-1 rounded-lg' : 'alert alert-danger p-1 rounded-lg'}}">{{$business[$item]}}</span></td>
                  @else
                  <td>{{$business[$item]}}</td>
                  @endif

                  @endif

                  @endforeach
                  <td><a title="{{$business->website['url'].'?business_code='.$business->business_code}}" target="_blank" href="{{$business->website['url'].'?business_code='.$business->business_code}}">{{ substr($business->website['url'].'?business_code='.$business->business_code, 0, 20)}}
                      ...</a>
                  </td>
                  <td class="text-center">
                    <div class="dropleft">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                          <circle cx="12" cy="12" r="1"></circle>
                          <circle cx="19" cy="12" r="1"></circle>
                          <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                        <!-- <a class="dropdown-item" href="javascript:void(0);">View</a> -->
                        <a class="dropdown-item" href="#" onclick="approveStatus({{$business->id}})">Approve</a>
                        <a class="dropdown-item" href="#" onclick="declineStatus({{$business->id}})">Decline</a>
                      </div>
                    </div>
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>

            <!-- Approve All Modal -->
            <div class="modal fade" id="approve_all_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure to approve all requests ?</h5> -->
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
                    <form method="post" action='/admin/online_request/approve/all/requests'>
                      @csrf
                      <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure to approve all Pending requests ?</h5>
                  </div>
                  <div class="modal-footer">
                    <a class="btn btn-light-dark" data-bs-dismiss="modal">No</a>
                    <button type="submit" class="btn btn-primary">Yes</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Decline All Modal -->
            <div class="modal fade" id="decline_all_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure to approve all requests ?</h5> -->
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
                    <form method="post" action='/admin/online_request/decline/all/requests'>
                      @csrf
                      <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure to Decline all Pending requests ?</h5>
                  </div>
                  <div class="modal-footer">
                    <a class="btn btn-light-dark" data-bs-dismiss="modal">No</a>
                    <button type="submit" class="btn btn-primary">Yes</button>
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
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
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

          function approveStatus(id) {
            console.log('hahahahhaha: ', id);
            var url = "{{ url('admin/online_request/approve') }}";
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
              type: 'POST',
              url: url,
              data: {
                id: id
              },
              success: function(data) {
                var tableBody = document.querySelector('table[data-table="myTable"] tbody');
                var rowToUpdate = tableBody.querySelector('[data-id="' + id + '"]');

                var status = rowToUpdate.cells[6];
                status.innerHTML = data.status == 'approved' ? '<span class="alert alert-success p-1 rounded-lg">approved</span>' : '<span class="alert alert-danger p-1 rounded-lg">pending</span>';
             }
            });
          }

          function declineStatus(id) {
            var url = "{{ url('admin/online_request/decline') }}";
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
              type: 'POST',
              url: url,
              data: {
                id: id
              },
              success: function(data) {
                var tableBody = document.querySelector('table[data-table="myTable"] tbody');
                var rowToUpdate = tableBody.querySelector('[data-id="' + id + '"]');

                var status = rowToUpdate.remove(0);
                // status.innerHTML = data.status == 'approved' ? '<span class="alert alert-success p-1 rounded-lg">approved</span>' : '<span class="alert alert-danger p-1 rounded-lg">pending</span>';
             }
            });
          }
        </script>
        </x-slot>
        <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>