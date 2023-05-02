<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
      {{ $title }}
      </x-slot>
  
      <!-- BEGIN GLOBAL MANDATORY STYLES -->
      <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
  
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
  
  
          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 mx-auto layout-spacing">
            <div class="row widget-statistic">
              <div id="chartDonut" class="col-xl-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                    <div class="user-profile">
                      <div class="widget-content widget-content-area">
                        <form method="post" action='{{route('admin.form-generator.generate')}}'>
                          @csrf
                          <div class="input-group mb-3">
                            <select class="form-control" name="website">
                              <option id="website" value="all" selected>Select Category</option>
                              @foreach ($websites as $item)
                                <option value="{{ $item->id }}"
                                  {{ request()->get('category') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                              @endforeach
                            </select>
                          </div>
  
                          <div class="input-group mb-3">
                            <textarea rows="20" cols="100" name="usrtxt" wrap="hard" class="form-control" aria-label="With textarea">@isset($LKey)<iframe src="https://app.agencybuilderdev.io/form/{{$website}}/{{$LKey}}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                              @endisset</textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> Generate Form</button>
                          </div>
                        </form>
                      </div>
                    </div>
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
              }, 10);
          </script>
          </x-slot>
          <!--  END CUSTOM SCRIPTS FILE  -->
  </x-base-layout>
  