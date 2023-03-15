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
                <li class="breadcrumb-item"><a href="#">Businesses</a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row layout-top-spacing">

        <div class="col-sm-12 pb-3 d-flex justify-content-end">
            <button class="btn btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Add Business</button>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">


                    <thead>
                        <tr>
                            <th style="width: 100px">User</th>
                            <th class="w-25">Website Name</th>
                            <th class="w-25">Bussiness Name</th>
                            <th class="w-25">Bussiness Owner</th>
                            <th class="w-25">Bussiness Email</th>
                            <th class="w-25">Code</th>
                            <th class="w-25">Status</th>
                            <th class="w-25">URL</th>
                            <th class="no-content col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($businesses as $business)
                        <tr>
                            <td class="w-25">{{$business->user_name}}</td>
                            <td class="w-25">
                            <a 
                                target="_blank" 
                                href="{{$business->website_url.'?business_code='.$business->business_code}}"
                                title="{{$business->website_url.'?business_code='.$business->business_code}}" 
                            >{{$business->business_name}}</a></td>
                            <td class="w-25">{{$business->business_name}}</td>
                            <td class="w-25">{{$business->business_owner}}</td>
                            <td class="w-25">{{$business->business_email}}</td>
                            <td class="w-25">{{$business->business_code}}</td>
                            <td class="w-25">{{$business->status}}</td>
                            <td class="w-25">
                                <a 
                                title="{{$business->website_url.'?business_code='.$business->business_code}}" 
                                target="_blank" href="{{$business->website_url.'?business_code='.$business->business_code}}">{{ substr($business->website_url.'?business_code='.$business->business_code, 0, 20)}}
                                ...
                                </a>
                            </td>
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
                                                data-website_id="{{$business->id}}" 
                                                data-name="{{$business->name}}" 
                                                data-category_id="{{$business->category_id}}" 
                                                data-url="{{$business->url}}"
                                                data-websites_categories="{{$categories}}"
                                                onclick='editModal(
                                                    {{$business->id}},
                                                    {{$business->user_id}},
                                                    {{$business->website_id}},
                                                    "{{$business->user_name}}",
                                                    "{{$business->website_name}}",
                                                    "{{$business->business_name}}",
                                                    "{{$business->business_owner}}",
                                                    "{{$business->business_email}}",
                                                    "{{$business->business_phone}}",
                                                    "{{$business->business_address}}",
                                                    "{{$business->business_city}}",
                                                    "{{$business->business_logo}}",
                                                    "{{$business->price_1}}",
                                                    "{{$business->price_2}}",
                                                    "{{$business->review1}}",
                                                    "{{$business->monday}}",
                                                    "{{$business->tuesday}}",
                                                    "{{$business->wednesday}}",
                                                    "{{$business->thursday}}",
                                                    "{{$business->friday}}",
                                                    "{{$business->saturday}}",
                                                    "{{$business->sunday}}",
                                                    "{{$business->facebook}}",
                                                    "{{$business->twitter}}",
                                                    "{{$business->image1}}",
                                                    "{{$business->image2}}",
                                                    "{{$business->image3}}"
                                                    )'
                                            >Edit</a>
                                            <!-- <a class="dropdown-item" href="javascript:void(0);">View Response</a> -->
                                            <a class="dropdown-item" href="/admin/websites/delete?id={{$business->id}}">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Create Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Add New Business</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width=height="24" viewBox="0 0 24 24" fill="none" stroke="currentCostroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feafeather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                                <form method="post" action='/admin/businesses/update' enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleFormControlInput4">Assign a User</label>
                                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                                        <select id="website_user" class="form-control" name="user_id">
                                            <option value="all" selected>Select User</option>
                                            @foreach($users as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                            <!-- <option>lkfdsjlkfds</option> -->
                                        </select>

                                        <label for="exampleFormControlInput4">Select Websites</label>
                                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                                        <select id="website_user" class="form-control" name="website_id">
                                            <option value="all" selected>Select Website</option>
                                            @foreach($websites as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                            <!-- <option>lkfdsjlkfds</option> -->
                                        </select>

                                        <label for="exampleFormControlInput1">Business Name</label>
                                        <input required type="text" name="business_name" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Owner</label>
                                        <input required type="text" name="business_owner" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Email</label>
                                        <input required type="text" name="business_email" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Phone</label>
                                        <input required type="text" name="business_phone" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Address</label>
                                        <input required type="text" name="business_address" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business City</label>
                                        <input required type="text" name="business_city" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Logo</label>
                                        <input required type="file" accept="image/png, image/jpeg, image/gif" name="business_logo" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Price 1</label>
                                        <input required type="text" name="price_1" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Price 2</label>
                                        <input required type="text" name="price_2" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Review 1</label>
                                        <input required type="text" name="review1" class="form-control" id="exampleFormControlInput1" value="">
                                        <hr>
                                        <h5>Business Hours</h5>
                                        <label for="exampleFormControlInput1">Monday</label>
                                        <input required type="text" name="monday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Tuesday</label>
                                        <input required type="text" name="tuesday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Wednesday</label>
                                        <input required type="text" name="wednesday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Thursday</label>
                                        <input required type="text" name="thursday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Friday</label>
                                        <input required type="text" name="friday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Saturday</label>
                                        <input required type="text" name="saturday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Sunday</label>
                                        <input required type="text" name="sunday" class="form-control" id="exampleFormControlInput1" value="">
                                        <hr>
                                        <h5>Social Media</h5>
                                        <label for="exampleFormControlInput1">Facebook</label>
                                        <input required type="text" name="facebook" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Twitter</label>
                                        <input required type="text" name="twitter" class="form-control" id="exampleFormControlInput1" value="">
                                        <hr>
                                        <h5>Images</h5>
                                        <label for="exampleFormControlInput1">Image 1</label>
                                        <input required type="file" name="image1" accept="image/png, image/jpeg, image/gif" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Image 2</label>
                                        <input required type="file" name="image2" accept="image/png, image/jpeg, image/gif" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Image 3</label>
                                        <input required type="file" name="image3" accept="image/png, image/jpeg, image/gif" class="form-control" id="exampleFormControlInput1" value="">

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
                                <form method="post" action='/admin/businesses/update'>
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <div class="form-group">
                                    <label for="exampleFormControlInput4">Assign a User</label>
                                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                                        <select class="form-control" name="user_id">
                                            <option id="user_id" value="all" selected>Select User</option>
                                            @foreach($users as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                            <!-- <option>lkfdsjlkfds</option> -->
                                        </select>

                                        <label for="exampleFormControlInput4">Select Websites</label>
                                        <!-- <input required type="text" name="website_user" class="form-control" id="exampleFormControlInput4" value=""> -->
                                        <select class="form-control" name="website_id">
                                            <option id="website_id" value="all" selected>Select Website</option>
                                            @foreach($websites as $item) 
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                            <!-- <option>lkfdsjlkfds</option> -->
                                        </select>

                                        <label for="exampleFormControlInput1">Business Name</label>
                                        <input required id="business_name" type="text" name="business_name" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Owner</label>
                                        <input required id="business_owner" type="text" name="business_owner" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Email</label>
                                        <input required id="business_email" type="text" name="business_email" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Phone</label>
                                        <input required id="business_phone" type="text" name="business_phone" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business Address</label>
                                        <input required id="business_address" type="text" name="business_address" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Business City</label>
                                        <input required id="business_city" type="text" name="business_city" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <!-- <label for="exampleFormControlInput1">Business Logo</label>
                                        <input required id="business_logo" type="file" accept="image/png, image/jpeg, image/gif" name="business_logo" class="form-control" id="exampleFormControlInput1" value=""> -->
                                        
                                        <label for="exampleFormControlInput1">Price 1</label>
                                        <input required id="price_1" type="text" name="price_1" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput1">Price 2</label>
                                        <input required id="price_2" type="text" name="price_2" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Review 1</label>
                                        <input required id="review1" type="text" name="review1" class="form-control" id="exampleFormControlInput1" value="">
                                        <hr>
                                        <h5>Business Hours</h5>
                                        <label for="exampleFormControlInput1">Monday</label>
                                        <input required id="monday" type="text" name="monday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Tuesday</label>
                                        <input required id="tuesday" type="text" name="tuesday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Wednesday</label>
                                        <input required id="wednesday" type="text" name="wednesday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Thursday</label>
                                        <input required id="thursday" type="text" name="thursday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Friday</label>
                                        <input required id="friday" type="text" name="friday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Saturday</label>
                                        <input required id="saturday" type="text" name="saturday" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Sunday</label>
                                        <input required id="sunday" type="text" name="sunday" class="form-control" id="exampleFormControlInput1" value="">
                                        <hr>
                                        <h5>Social Media</h5>
                                        <label for="exampleFormControlInput1">Facebook</label>
                                        <input required id="facebook" type="text" name="facebook" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Twitter</label>
                                        <input required id="twitter" type="text" name="twitter" class="form-control" id="exampleFormControlInput1" value="">
                                        <hr>
                                        <!-- <h5>Images</h5>
                                        <label for="exampleFormControlInput1">Image 1</label>
                                        <input required id="image1" type="file" name="image1" accept="image/png, image/jpeg, image/gif" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Image 2</label>
                                        <input required id="image2" type="file" name="image2" accept="image/png, image/jpeg, image/gif" class="form-control" id="exampleFormControlInput1" value="">

                                        <label for="exampleFormControlInput1">Image 3</label>
                                        <input required id="image3" type="file" name="image3" accept="image/png, image/jpeg, image/gif" class="form-control" id="exampleFormControlInput1" value=""> -->

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

            function editModal(
                        id,
                        user_id,
                        website_id,
                        user_name,
                        website_name,
                        business_name,
                        business_owner,
                        business_email,
                        business_phone,
                        business_address,
                        business_city,
                        business_logo,
                        price_1,
                        price_2,
                        review1,
                        monday,
                        tuesday,
                        wednesday,
                        thursday,
                        friday,
                        saturday,
                        sunday,
                        facebook,
                        twitter,
                        image1,
                        image2,
                        image3
                    ) {
                document.getElementById("id").value = id;
                // document.getElementById("user_id").value = user_id;
                const user = document.getElementById("user_id");
                user.value = user_id;
                user.text = user_name;

                const web = document.getElementById("website_id");
                web.value = website_id;
                web.text = website_name;

                // document.getElementById("name").value = name;
                // document.getElementById("url").value = url;

                document.getElementById("business_name").value = business_name;
                document.getElementById("business_owner").value = business_owner;
                document.getElementById("business_email").value = business_email;
                document.getElementById("business_phone").value = business_phone;
                document.getElementById("business_address").value = business_address;
                document.getElementById("business_city").value = business_city;
                // document.getElementById("business_logo").value = business_logo;
                document.getElementById("price_1").value = price_1;
                document.getElementById("price_2").value = price_2;
                document.getElementById("review1").value = review1;
                document.getElementById("monday").value = monday;
                document.getElementById("tuesday").value = tuesday;
                document.getElementById("wednesday").value = wednesday;
                document.getElementById("thursday").value = thursday;
                document.getElementById("friday").value = friday;
                document.getElementById("saturday").value = saturday;
                document.getElementById("sunday").value = sunday;
                document.getElementById("facebook").value = facebook;
                document.getElementById("twitter").value = twitter;
                // document.getElementById("image1").value = image1;
                // document.getElementById("image2").value = image2;
                // document.getElementById("image3").value = image3;
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
