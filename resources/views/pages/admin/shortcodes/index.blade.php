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
                <li class="breadcrumb-item"><a href="#">ShortCodes</a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page">Basic</li> -->
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row layout-top-spacing">

        <div class="col-sm-12 pb-3 d-flex justify-content-end">
            <button class="btn btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Add Shortcode</button>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">


                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Shortcode</th>
                            <th>Category</th>
                            <th>Required</th>
                            <th>Enable</th>
                            <th>Show to Dashboard</th>
                            <th>Display on WP</th>
                            <th>Position</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($shortcodes as $shortcode)                                                                      
                        <tr>                            
                                    
                            <td class="pl-3">{{$shortcode->name}}</td>
                            <td class="pl-3">{{$shortcode->shortcode}}</td>
                            <td class="pl-3">{{$shortcode->shortcodeCategory['name']}}</td>
                            <td class="pl-4">
                            <div class="form-check form-check-primary form-check-inline">
                                @if( $shortcode->required == 1 )                                    
                                    <input class="form-check-input" type="checkbox" name="required" value="1" checked disabled>
                                @else
                                    <input class="form-check-input" type="checkbox" name="required" value="0" disabled >
                                @endif
                            </div>
                            </td> 
                            <td class="pl-4">
                            <div class="form-check form-check-primary form-check-inline">
                                @if( $shortcode->enable == 1 )                                    
                                    <input class="form-check-input" type="checkbox" name="enable" value="1" checked disabled>
                                @else
                                    <input class="form-check-input" type="checkbox" name="enable" value="0" disabled >
                                @endif
                            </div>
                            </td>
                            <td class="pl-4 hide-in-mobile">
                            <div class="form-check form-check-primary form-check-inline">
                                @if( $shortcode->show_to_dashboard == 1 )                                    
                                    <input class="form-check-input" type="checkbox" name="show_to_dashboard" value="1" checked disabled>
                                @else
                                    <input class="form-check-input" type="checkbox" name="checkbox" value="0" disabled >
                                @endif
                            </div>
                            </td>
                            <td class="pl-4 hide-in-mobile">
                            <div class="form-check form-check-primary form-check-inline">
                                @if( $shortcode->display_on_wp == 1 )                                    
                                    <input class="form-check-input" type="checkbox" name="display_on_wp" value="1" checked disabled>
                                @else
                                    <input class="form-check-input" type="checkbox" name="checkbox" value="0" disabled >
                                @endif
                            </div>
                            </td>
                            <td class="pl-4 hide-in-mobile">{{$shortcode->position}}</td>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <!-- <a class="dropdown-item" href="javascript:void(0);">View</a> -->
                                        <a
                                            class="dropdown-item view-details" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editDialog" 
                                            href="#"
                                            onclick='editModal(
                                                {{$shortcode->id}},
                                                {{$shortcode->shortcode_category_id}},
                                                "{{$shortcode->name}}",
                                                "{{$shortcode->shortcode}}",
                                                "{{$shortcode->shortcodeCategory["name"]}}",
                                                "{{$shortcode->type}}",
                                                {{$shortcode->position}},
                                                {{$shortcode->required}},
                                                {{$shortcode->enable}}, 
                                                {{$shortcode->show_to_dashboard}}, 
                                                {{$shortcode->display_on_wp}}, 
                                                {{$shortcode->full}},
                                                "{{$shortcode->business_column}}"
                                                )'
                                        >Edit</a>
                                        <!-- <a class="dropdown-item" href="/admin/websites/delete?id=$category->id">Delete</a> -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                                
                    @endforeach
                    </tbody>
                </table>



                <!-- Edit Modal -->
                <div class="modal fade" id="editDialog" tabindex="-1" role="dialog" aria-labelledby="editDialogTitle" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDialogTitle">Edit Shortcode</h5>
                            </div>
                            <div class="modal-body">
                                <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                                <form method="post" action='/admin/shortcodes/update'>
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="business_column" name="oldColumn"/>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Shortcode Name</label>
                                        <input id="name" type="text" name="name" class="form-control" id="exampleFormControlInput1" value="" >

                                        <label for="exampleFormControlInput3">Shortcode</label>
                                        <input id="shortcode" required type="text" name="shortcode" class="form-control" id="exampleFormControlInput3" value="" disabled>
                                        
                                        <label for="exampleFormControlInput3">Shortcode Category</label>
                                        <select class="form-control" name="shortcode_category_id">
                                            <option id="shortcode_category_id" value="all" selected>Select Category</option>
                                            @foreach($shortcode_categories as $item)
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        <label for="exampleFormControlInput3">Shortcode Type</label>
                                        <select class="form-control" name="type">
                                            <option id="type" value="" disabled ></option>                                        
                                            <option value="image">Image</option>
                                            <option value="text">Text</option>
                                        </select>

                                        <label for="exampleFormControlInput3">Position</label>
                                        <input id="position" required type="text" name="position" class="form-control" value="">
                                        
                                        <hr>

                                        <div  class="form-check form-check-primary form-check-inline">
                                            <div class="form-check mr-5">                                    
                                                <input id="required" type="checkbox" onclick="$(this).val(this.checked ? '1' : '0')" class="form-check-input" name="required" value="">
                                                <label for="required" class="form-check-label">{{ __('Required') }}</label>
                                            </div>

                                            <div class="form-check mr-5">                                    
                                                <input id="enable" type="checkbox" onclick="$(this).val(this.checked ? 1 : 0)" class="form-check-input" name="enable" value="">
                                                <label for="enable" class="form-check-label">{{ __('Enable') }}</label>
                                            </div>

                                            <div class="form-check mr-5">                                    
                                                <input id="show_to_dashboard" type="checkbox" onclick="$(this).val(this.checked ? 1 : 0)" class="form-check-input" name="show_to_dashboard" value="">
                                                <label for="show_to_dashboard" class="form-check-label">{{ __('Show on dashboard') }}</label>
                                            </div>

                                            <div class="form-check mr-5">                                    
                                                <input id="display_on_wp" type="checkbox" onclick="$(this).val(this.checked ? 1 : 0)" class="form-check-input" name="display_on_wp" value="">
                                                <label for="display_on_wp" class="form-check-label">{{ __('Display on WP') }}</label>
                                            </div>

                                            <div class="form-check mr-5">                                    
                                                <input id="full" type="checkbox" onclick="$(this).val(this.checked ? 1 : 0)" class="form-check-input" name="full" value="">
                                                <label for="full" class="form-check-label">{{ __('Full') }}</label>
                                            </div>
                                        </div>
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

                <!-- Create Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="false">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Add New Shortcode</h5>
                            </div>
                            <div class="modal-body">
                                <!-- <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                                <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudilacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharlacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor sceleriporttitor.</p> -->
                                <form method="post" action='/admin/shortcodes/create'>
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Shortcode Name</label>
                                        <input required type="text" name="name" class="form-control" id="exampleFormControlInput1" value="">
                                        
                                        <label for="exampleFormControlInput3">Shortcode Type</label>
                                        <select id="type" class="form-control" name="type" required>
                                            <option value="" disabled selected>Select Type</option>                                        
                                            <option value="image">Image</option>
                                            <option value="text">Text</option>
                                        </select>
                                        <label for="exampleFormControlInput3">Shortcode Category</label>
                                        <select class="form-control" name="shortcode_category_id">
                                            <option id="shortcode_category_id" value="all" selected>Select Category</option>
                                            @foreach($shortcode_categories as $item)
                                            <option value="{{ $item->id }}" {{ (request()->get('category') == $item->id  ? "selected":"") }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-group row">                   
                                    <div  class="form-check form-check-primary form-check-inline">
                                        <div class="form-check mr-5">                                    
                                            <input id="required" type="checkbox" onclick="$(this).val(this.checked ? 1 : 0)" class="form-check-input" name="required" value="1">
                                            <label for="required" class="form-check-label">{{ __('Required') }}</label>
                                        </div>
                                        <div class="form-check mr-5">                                    
                                            <input id="enable" type="checkbox" onclick="$(this).val(this.checked ? 1 : 0)" class="form-check-input" name="enable" value="1">
                                            <label for="enable" class="form-check-label">{{ __('Enable') }}</label>
                                        </div>
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
                            shortcode_category_id,
                            name,
                            shortcode,
                            shortcodeCategory,
                            type,
                            position,
                            required,
                            enable,
                            show_to_dashboard,
                            display_on_wp,
                            full,
                            business_column
                        ) {
                            alert('wew');
                console.log(shortcode_category_id, shortcodeCategory, business_column);
                document.getElementById("id").value = id;
                document.getElementById("business_column").value = business_column;

                document.getElementById("name").value = name;
                document.getElementById("shortcode").value = shortcode;
                const shortcode_cat =document.getElementById("shortcode_category_id");
                shortcode_cat.value = shortcode_category_id;
                shortcode_cat.text = shortcodeCategory;

                const shortcode_type =document.getElementById("type");
                shortcode_type.value = type;
                shortcode_type.text = type;
                document.getElementById("position").value = position;
                // document.getElementById("required").checked =true;
                const isRequired = document.getElementById("required");
                isRequired.value = required
                required === 1 ? isRequired.checked =true : isRequired.checked =false;

                const isEnabled = document.getElementById("enable");
                isEnabled.value = enable
                enable === 1 ? isEnabled.checked =true : isEnabled.checked =false;

                const can_show_to_dashboard = document.getElementById("show_to_dashboard");
                can_show_to_dashboard.value = show_to_dashboard
                show_to_dashboard === 1 ? can_show_to_dashboard.checked =true : can_show_to_dashboard.checked =false;

                const can_display_on_wp = document.getElementById("display_on_wp");
                can_display_on_wp.value = display_on_wp
                display_on_wp === 1 ? can_display_on_wp.checked =true : can_display_on_wp.checked =false;

                const is_full = document.getElementById("full");
                is_full.value = full
                full === 1 ? is_full.checked =true : is_full.checked =false;
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
