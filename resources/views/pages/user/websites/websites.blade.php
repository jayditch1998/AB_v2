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
                <li class="breadcrumb-item"><a href="#">Websites</a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row layout-top-spacing">

        <div class="col-sm-12 pb-3 d-flex justify-content-end">
            <button class="btn btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Add Website</button>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">


                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Website Name</th>
                            <th>Category</th>
                            <th>Website URL</th>
                            <th>Status</th>
                            <th>Businesses Count</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $website)
                        <tr>
                            <td>{{$website->user->name}}</td>
                            <td>{{$website->name}}</td>
                            <td>{{$website->category_name}}</td>
                            <td><a target="_blank" href="{{$website->url}}">{{ __('Visit Website') }}</td>
                            <td>
                                @if ($website->status != 1)
                                <span class="alert alert-danger p-1 rounded-lg">{{ __('Inactive') }}</span>
                                @else
                                <span class="alert alert-success p-1 rounded-lg">{{ __('Active') }}</span>
                                @endif
                            </td>
                            <td>{{$website->business_count}} Businesses</td>
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
                                                data-website_id="{{$website->id}}" 
                                                data-name="{{$website->name}}" 
                                                data-category_id="{{$website->category_id}}" 
                                                data-url="{{$website->url}}"
                                                data-websites_categories="{{$categories}}"
                                                onclick='editModal(
                                                    {{$website->id}},
                                                    "{{$website->name}}",
                                                    {{$website->category_id}},
                                                    "{{$website->category_name}}",
                                                    "{{$website->url}}",
                                                    {{$website->user_id}},
                                                    "{{$website->user->name}}"
                                                    )'
                                            >Edit</a>
                                            <!-- <a class="dropdown-item" href="javascript:void(0);">View Response</a> -->
                                            <a class="dropdown-item" href="/admin/websites/delete?id={{$website->id}}">Delete</a>
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
                                <form method="post" action='/admin/websites/create'>
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Website Name</label>
                                        <input required type="text" name="name" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput2">Website Category</label>
                                        <!-- <input required type="text" name="website_category" class="form-control" id="exampleFormControlInput2" value=""> -->
                                        <select id="category" class="form-control" name="category_id">
                                            <option value="all" selected>Select Category</option>
                                            @foreach($categories as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                            <!-- <option>lkfdsjlkfds</option> -->
                                        </select>
                                        <label for="exampleFormControlInput3">Website url</label>
                                        <input required type="text" name="url" class="form-control" id="exampleFormControlInput3" value="">

                                        <label for="exampleFormControlInput4">Assign a User</label>
                                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                                        <select id="website_user" class="form-control" name="user_id">
                                            <option value="all" selected>Select User</option>
                                            @foreach($users as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                            <!-- <option>lkfdsjlkfds</option> -->
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
                                <form method="post" action='/admin/websites/update'>
                                    @csrf
                                    <input type="hidden" id="website_id" name="id">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Website Name</label>
                                        <input id="name" required type="text" name="name" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput2">Website Category</label>
                                        <select  class="form-control" name="category_id">
                                            <option id="category_id" value="all" selected>Select Category</option>
                                            @foreach($categories as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="exampleFormControlInput3">Website url</label>
                                        <input id="url" required type="text" name="url" class="form-control" id="exampleFormControlInput3" value="">

                                        <label for="exampleFormControlInput4">Assign a User</label>
                                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
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

            function editModal(id, name, category_id, category_name, url, user_id, user_name) {
                document.getElementById("name").value = name;
                const cat = document.getElementById("category_id");
                cat.value = category_id;
                cat.text = category_name;
                document.getElementById("url").value = url;
                const owner =document.getElementById("user_id");
                owner.value = user_id;
                owner.text = user_name;
                document.getElementById("website_id").value = id;
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
