{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-hybrid-one/>.
* 
*/

--}}
<div class="row widget-statistic">
  <div id="chartDonut" class="col-xl-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
      <div class="widget-header">
        <div class="row">
          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
            <h4>Agency Builder Chart</h4>
          </div>
        </div>
      </div>
      <div class="widget-content widget-content-area">
        <div id="AB-chart" class=""></div>
      </div>
    </div>
  </div>
</div>

<div class="row widget-statistic">
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
    <div class="widget widget-one_hybrid widget-followers">
      <div class="widget-heading">
        <div class="w-title">
          <div class="w-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="rgb(0, 143, 251)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-globe">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
              </path>
            </svg>
          </div>
          <div class="">
            <p class="w-value">{{ $allWebsite }}</p>
            <h5 class="">All Website</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
    <div class="widget widget-one_hybrid widget-followers">
      <div class="widget-heading">
        <div class="w-title">
          <div class="w-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="rgb(0, 227, 150)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-globe">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
              </path>
            </svg>
          </div>
          <div class="">
            <p class="w-value">{{ $allWebsiteActive }}</p>
            <h5 class="">All Active Website</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
    <div class="widget widget-one_hybrid widget-followers">
      <div class="widget-heading">
        <div class="w-title">
          <div class="w-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="rgb(254, 176, 25)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-globe">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
              </path>
            </svg>
          </div>
          <div class="">
            <p class="w-value">{{ $allWebsiteInactive }}</p>
            <h5 class="">All Inacvite Websites</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="row widget-statistic">
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
    <div class="widget widget-one_hybrid widget-followers">
      <div class="widget-heading">
        <div class="w-title">
          <div class="w-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="rgb(255, 69, 96)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-shopping-cart">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
          </div>
          <div class="">
            <p class="w-value">{{ $allBusiness }}</p>
            <h5 class="">All Business</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
    <div class="widget widget-one_hybrid widget-followers">
      <div class="widget-heading">
        <div class="w-title">
          <div class="w-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="rgb(119, 93, 208)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-shopping-cart">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
          </div>
          <div class="">
            <p class="w-value">{{ $allBusinessActive }}</p>
            <h5 class="">All Active Business</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
    <div class="widget widget-one_hybrid widget-followers">
      <div class="widget-heading">
        <div class="w-title">
          <div class="w-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="rgb(0, 143, 251)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-shopping-cart">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
          </div>
          <div class="">
            <p class="w-value">{{ $allBusinessInactive }}</p>
            <h5 class="">All Inacvite Business</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- {{-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-referral">
            <div class="widget-heading">
                <div class="w-title">
                    <div class="w-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    </div>
                    <div class="">
                        <p class="w-value">1,900</p>
                        <h5 class="">Referral</h5>
                    </div>
                </div>
            </div>
            <div class="widget-content">    
                <div class="w-chart">
                    <div id="hybrid_followers1"></div>
                </div>
            </div>
        </div>
    </div> --}}
  {{-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-engagement">
            <div class="widget-heading">
                <div class="w-title">
                    <div class="w-icon" color="blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </div>
                    <div class="">
                        <p class="w-value">18.2%</p>
                        <h5 class="">Engagement</h5>
                    </div>
                </div>
            </div>
            <div class="widget-content">    
                <div class="w-chart">
                    <div id="hybrid_followers3"></div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
