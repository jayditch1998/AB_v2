<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
      {{ $title }}
      </x-slot>
  
      <!-- BEGIN GLOBAL MANDATORY STYLES -->
      <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/apex/apexcharts.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
  
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])
  
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
  
        @vite(['resources/scss/light/plugins/apex/custom-apexcharts.scss'])
        @vite(['resources/scss/dark/plugins/apex/custom-apexcharts.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/users/user-profile.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/users/user-profile.scss'])
        @vite(['resources/scss/light/assets/components/font-icons.scss'])
        @vite(['resources/scss/dark/assets/components/font-icons.scss'])
        <!--  END CUSTOM STYLE FILE  -->
        </x-slot>
        <!-- END GLOBAL MANDATORY STYLES -->
  
        <!-- Analytics -->
  
        <div class="row layout-top-spacing">
  
          {{-- <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-six title="Statistics"/>
          </div>
          
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-card-four title="Expenses"/>
          </div>  
      
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-card-five title="Total Balance" balance="$41,741.42" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
          </div>
      
          <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-chart-three title="Unique Visitors"/>
          </div>
      
          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-activity-five title="Activity Log"/>
          </div>
      
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
               <x-widgets._w-four title="Visitors by Browser"/>
          </div> --}}
  
          <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <x-widgets._w-hybrid-one all-website="{{ $all_website->count() }}"
              all-website-inactive="{{ $all_inactive_website }}" all-website-active="{{ $all_active_website }}"
              all-business="{{ $all_business->count() }}" all-business-inactive="{{ $all_inactive_business }}"
              all-business-active="{{ $all_active_business }}" title="Followers" chart-id="allWebsite" />
          </div>
  
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="row widget-statistic">
              <div id="chartDonut" class="col-xl-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                    <div class="user-profile">
                      <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                          <h3 class="ms-4 mt-3">Profile</h3>
                          <a data-bs-toggle="modal" data-bs-target="#editModal" href="#"
                            data-name="{{ auth()->user()->name }}" data-phone="{{ auth()->user()->mobile }}"
                            data-email="{{ auth()->user()->email }}"
                            onclick='editModal(
                      "{{ auth()->user()->name }}",
                      "{{ auth()->user()->mobile }}",
                      "{{ auth()->user()->email }}"
                      )'
                            class="mt-2 edit-profile view-details me-4 mt-wzx"> <svg xmlns="http://www.w3.org/2000/svg"
                              width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                              class="feather feather-edit-3">
                              <path d="M12 20h9"></path>
                              <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg></a>
                        </div>
                        <div class="text-center user-info">
                          <img src="{{ Vite::asset('resources/images/profile-3.jpeg') }}" alt="avatar">
                          <p class="">{{ str(auth()->user()->name)->title }}</p>
                        </div>
                        <div class="user-info-list">
  
                          <div class="">
                            <ul class="contacts-block list-unstyled">
  
                              <li class="contacts-block__item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" class="feather feather-users me-3">
                                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                  <circle cx="9" cy="7" r="4"></circle>
                                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>{{ str(auth()->user()->role->name)->title }}
                              </li>
                              <li class="contacts-block__item">
                                <a href="mailto:example@mail.com"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-mail me-3">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                  </svg>{{auth()->user()->email}}</a>
                              </li>
                              <li class="contacts-block__item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" class="feather feather-phone me-3">
                                  <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                  </path>
                                </svg> {{auth()->user()->mobile}}
                              </li>
                              <li class="contacts-block__item">
                                
                                  <i data-feather="key" class="me-3" color="#888ea8"></i>
                             {{ str(Str::of(auth()->user()->license_key)->substr(8, 20))->title }}...
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
  
          </div>
  
          <!-- Edit Modal -->
          <div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Edit Profile</h5>
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
                  <form method="post" action='/admin/dashboard/update'>
                    @csrf
                    <input type="hidden" id="user_id" name="id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input id="name" required type="text" name="name" class="form-control">
  
  
                      <label for="email">Email</label>
                      <input id="email" required type="email" name="email" class="form-control">
  
                      <label for="phone">Phone</label>
                      <input id="phone" required type="text" name="mobile" class="form-control">
  
  
  
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
          {{-- 
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-card-one title="Jimmy Turner"/>
          </div>
      
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <x-widgets._w-card-two title="Dev Summit - New York"/>
          </div> --}}
  
        </div>
  
        <!--  BEGIN CUSTOM SCRIPTS FILE  -->
        <x-slot:footerFiles>
          <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
  
  
          {{-- Analytics --}}
          <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
          <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
  
          @vite(['resources/assets/js/widgets/_wSix.js'])
          @vite(['resources/assets/js/widgets/_wChartThree.js'])
          @vite(['resources/assets/js/widgets/_wHybridOne.js'])
          @vite(['resources/assets/js/widgets/_wActivityFive.js'])
          <script>
            var all_website = {!! json_encode($all_website->count()) !!};
  
            var all_active_website = {!! json_encode($all_active_website) !!};
            var all_inactive_website = {!! json_encode($all_inactive_website) !!};
            var all_business = {!! json_encode($all_business->count()) !!};
            var all_inactive_business = {!! json_encode($all_inactive_business) !!};
            var all_active_business = {!! json_encode($all_active_business) !!};
  
            function editModal(name, phone, email) {
              document.getElementById("name").value = name;
              document.getElementById("email").value = email;
              document.getElementById("phone").value = phone;
            }
          </script>
          <script src="{{ asset('plugins/apex/custom-apexcharts.js') }}"></script>
          <script type="module" src="{{asset('plugins/font-icons/feather/feather.min.js')}}"></script>
      
          <script type="module">
              setTimeout(() => {
                  feather.replace();
              }, 10);
          </script>
          </x-slot>
          <!--  END CUSTOM SCRIPTS FILE  -->
  </x-base-layout>
  