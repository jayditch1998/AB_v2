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
            <button class="btn btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Button here</button>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">


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
                                    <th class="hide-in-mobile">{{ __('Business Email') }}</th>
                                @else
                                    <th>{{ucwords(str_replace('_', ' ', $item))}}</th>
                                @endif

                            @endforeach
                            <th>Business URL</th>
                            <th>Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($businesses as $item)
                        <tr>
                            <td>{{$business->created_at->format('M d, Y')}}</td>
                            <td>{{$business->website->user['name']}}</td>
                            <td>{{$category->user->name}}</td>
                            <td class="text-center">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                            <!-- <a class="dropdown-item" href="javascript:void(0);">View</a> -->
                                            <a 
                                                class="dropdown-item view-details" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal" 
                                                href="#"
                                                onclick='editModal(
                                                    {{$category->id}},
                                                    "{{$category->name}}",
                                                    "{{$category->description}}",
                                                    {{$category->user_id}},
                                                    "{{$category->user->name}}",
                                                    )'
                                            >Edit</a>
                                            <!-- <a class="dropdown-item" href="javascript:void(0);">View Response</a> -->
                                            <!-- <a class="dropdown-item" href="/admin/websites/delete?id=$category->id">Delete</a> -->
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
                                <h5 class="modal-title" id="exampleModalCenterTitle">Add New Website</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24" viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feafeather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                                <form method="post" action='/admin/categories/create'>
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Category Name</label>
                                        <input required type="text" name="name" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput3">Description</label>
                                        <textarea required name="description" class="form-control" id="exampleFormControlInput3" cols="10" rows="5"></textarea>
                                        
                                        <label for="exampleFormControlInput4">User</label>
                                        <select class="form-control" name="user_id">
                                            <option value="all" selected>Select User</option>
                                            @foreach($users as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
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
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24" viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feafeather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                                <form method="post" action='/admin/categories/update'>
                                    @csrf
                                    <input type="hidden" id="category_id" name="id">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Category Name</label>
                                        <input id="name" required type="text" name="name" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput3">Description</label>
                                        <input id="description" required type="text" name="description" class="form-control" id="exampleFormControlInput3" value="">
                                        
                                        <label for="exampleFormControlInput4">User</label>
                                        <select class="form-control" name="user_id">
                                            <option id="user_id" value="all" selected>Select User</option>
                                            @foreach($users as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>

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

            function editModal(id, name, description, user_id, user_name) {
                document.getElementById("name").value = name;
                document.getElementById("description").value = description;
                const owner =document.getElementById("user_id");
                owner.value = user_id;
                owner.text = user_name;
                document.getElementById("category_id").value = id;
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
