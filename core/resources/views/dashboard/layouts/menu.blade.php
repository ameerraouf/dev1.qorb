<?php
// Current Full URL
$fullPagePath = Request::url();
// Char Count of Backend folder Plus 1
$envAdminCharCount = strlen(env('BACKEND_PATH')) + 1;
// URL after Root Path EX: admin/home
$urlAfterRoot = substr($fullPagePath, strpos($fullPagePath, env('BACKEND_PATH')) + $envAdminCharCount);
$mnu_title_var = "title_" . @Helper::currentLanguage()->code;
$mnu_title_var2 = "title_" . env('DEFAULT_LANGUAGE');
?>

<div id="aside" class="app-aside modal fade folded md nav-expand">
    <div class="left navside dark dk" layout="column">
        <div class="navbar navbar-md no-radius">
            <!-- brand -->
            <a class="navbar-brand" href="{{ route('adminHome') }}">
                <img src="{{ asset('assets/dashboard/images/logo.png') }}" alt="Control">
                <span class="hidden-folded inline">{{ __('backend.control') }}</span>
            </a>
            <!-- / brand -->
        </div>
        <div flex class="hide-scroll">
            <nav class="scroll nav-active-primary">

                <ul class="nav" ui-nav>
                    <li class="nav-header hidden-folded">
                        <small class="text-muted">{{ __('backend.main') }}</small>
                    </li>

                    <li>
                        <a href="{{ route('adminHome') }}" onclick="location.href='{{ route('adminHome') }}'">
                  <span class="nav-icon">
                    <i class="material-icons">&#xe3fc;</i>
                  </span>
                            <span class="nav-text">{{ __('backend.dashboard') }}</span>
                        </a>
                    </li>




                    @if (env('GEOIP_STATUS', false))
                        {{-- @if(Helper::GeneralWebmasterSettings("analytics_status")) --}}
                            @if(@Auth::user()->permissionsGroup->analytics_status)
                                <?php
                                $currentFolder = "analytics"; // Put folder name here
                                $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));

                                $currentFolder2 = "ip"; // Put folder name here
                                $PathCurrentFolder2 = substr($urlAfterRoot, 0, strlen($currentFolder2));

                                $currentFolder3 = "visitors"; // Put folder name here
                                $PathCurrentFolder3 = substr($urlAfterRoot, 0, strlen($currentFolder3));
                                ?>
                                <li {{ ($PathCurrentFolder==$currentFolder || $PathCurrentFolder2==$currentFolder2  || $PathCurrentFolder3==$currentFolder3) ? 'class=active' : '' }}>
                                    <a>
                                        <span class="nav-caret">
                                            <i class="fa fa-caret-down"></i>
                                        </span>
                                                                <span class="nav-icon">
                                            <i class="material-icons">&#xe1b8;</i>
                                        </span>
                                        <span class="nav-text">{{ __('backend.visitorsAnalytics') }}</span>
                                    </a>
                                    <ul class="nav-sub">
                                        <li>
                                            <a onclick="location.href='{{ route('analytics', 'date') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsBydate') }}</span>
                                            </a>
                                        </li>

                                        <?php
                                        $currentFolder = "analytics/country"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'country') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByCountry') }}</span>
                                            </a>
                                        </li>

                                        <?php
                                        $currentFolder = "analytics/city"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'city') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByCity') }}</span>
                                            </a>
                                        </li>

                                        <?php
                                        $currentFolder = "analytics/os"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'os') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByOperatingSystem') }}</span>
                                            </a>
                                        </li>

                                        <?php
                                        $currentFolder = "analytics/browser"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'browser') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByBrowser') }}</span>
                                            </a>
                                        </li>

                                        {{--<?php
                                        $currentFolder = "analytics/referrer"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'referrer') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByReachWay') }}</span>
                                            </a>
                                        </li> --}}
                                        <?php
                                        $currentFolder = "analytics/hostname"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'hostname') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByHostName') }}</span>
                                            </a>
                                        </li>
                                        <?php
                                        $currentFolder = "analytics/org"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('analytics', 'org') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsByOrganization') }}</span>
                                            </a>
                                        </li>
                                        <?php
                                        $currentFolder = "visitors"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a onclick="location.href='{{ route('visitors') }}'">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsVisitorsHistory') }}</span>
                                            </a>
                                        </li>
                                        <?php
                                        $currentFolder = "ip"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                            <a href="{{ route('visitorsIP') }}">
                                            <span
                                                class="nav-text">{{ __('backend.visitorsAnalyticsIPInquiry') }}</span>
                                            </a>
                                        </li>


                                    </ul>
                                </li>
                            @endif
                        {{-- @endif --}}
                    @endif
                    {{-- @if(Helper::GeneralWebmasterSettings("newsletter_status")) --}}
                        @if(@Auth::user()->permissionsGroup->newsletter_status)
                            <?php
                            $currentFolder = "contacts"; // Put folder name here
                            $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                            ?>
                            <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                <a href="{{ route('contacts') }}">
                                    <span class="nav-icon">
                                        <i class="material-icons">&#xe7ef;</i>
                                    </span>
                                    <span class="nav-text">{{ __('backend.newsletter') }}</span>
                                </a>
                            </li>
                        @endif
                    {{-- @endif --}}

                    {{-- @if(Helper::GeneralWebmasterSettings("inbox_status")) --}}
                        @if(@Auth::user()->permissionsGroup->inbox_status)
                            <?php
                            $currentFolder = "webmails"; // Put folder name here
                            $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                            ?>
                            <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                <a href="{{ route('webmails') }}">
                  <span class="nav-icon">
                    <i class="material-icons">&#xe156;</i>
                  </span>
                                    <span class="nav-text">{{ __('backend.siteInbox') }}
                                        @if( @$webmailsNewCount >0)
                                            <badge class="label warn m-l-xs">{{ @$webmailsNewCount }}</badge>
                                        @endif
                                    </span>

                                </a>
                            </li>
                        @endif
                    {{-- @endif --}}

                    {{-- @if(Helper::GeneralWebmasterSettings("calendar_status")) --}}
                        @if(@Auth::user()->permissionsGroup->calendar_status)
                            <?php
                            $currentFolder = "calendar"; // Put folder name here
                            $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                            ?>
                            <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                <a href="{{ route('calendar') }}" onclick="location.href='{{ route('calendar') }}'">
                  <span class="nav-icon">
                    <i class="material-icons">&#xe5c3;</i>
                  </span>
                                    <span class="nav-text">{{ __('backend.calendar') }}</span>
                                </a>
                            </li>
                        @endif
                    {{-- @endif --}}
                    @if(\Helper::checkPermission(1))
                    <li class="nav-header hidden-folded">
                        <small class="text-muted">{{ __('backend.siteData') }}</small>
                    </li>
                    @endif
                    <?php
                    $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
                    ?>

                    <?php
                        $currentFolder = "packages"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(1))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('packages') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.packages') }}</span>
                        </a>
                    </li>
                    @endif
                    <?php
                    $currentFolder = "financial-transactions"; // Put folder name here
                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(2))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('financial-transactions') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('cruds.FinancialTransactions.Title') }}</span>
                        </a>
                    </li>
                    @endif

                    <?php
                    $currentFolder = "purchase-transactions"; // Put folder name here
                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(3))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('PurchaseTransactions') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('cruds.FinancialTransactions.Purchases') }}</span>
                        </a>
                    </li>
                    @endif

                    <?php
                    $currentFolder = "banners"; // Put folder name here
                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(4))

                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('Banners') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.adsBanners') }}</span>
                        </a>
                    </li>

                    @endif

                    <?php
                        $currentFolder = "clients"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(5))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('clients') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.clients') }}</span>
                        </a>
                    </li>
                    @endif
                    <?php
                        $currentFolder = "set-child-to"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(6))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('SetChildTo') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.setChildToParent') }}</span>
                        </a>
                    </li>
                    @endif

                    <?php
                        $currentFolder = "early-detection-reports"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(7))
                    <li {{ ($PathCurrentFolder==$currentFolder ) ? 'class=active' : '' }} >
                        <a href="{{ route('EarlyDetectionReports') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('cruds.EarlyDetectionReports.Title') }}</span>
                        </a>
                    </li>
                    @endif
                    <?php
                        $currentFolder = "employees"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(8))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a >
                            <span class="nav-caret"><i class="fa fa-caret-down"></i></span>
                            <span class="nav-icon"><i class="material-icons">&#xe1b8;</i></span>
                            <span class="nav-text">{{ __('backend.employees') }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li><a href="{{ route('employeesCreate') }}"><span class="nav-text">{{ __('backend.add') }}</span></a></li>
                            <li><a href="{{ route('employees') }}"><span class="nav-text">{{ __('backend.employees') }}</span></a></li>
                        </ul>
                    </li>
                    @endif

                    <?php
                    $currentFolder = "common-questions"; // Put folder name here
                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(9))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('CommonQuestions') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('cruds.CommonQuestions.Title') }}</span>
                        </a>
                    </li>
                    @endif
                    <?php
                    $currentFolder = "societies"; // Put folder name here
                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    @if(\Helper::checkPermission(10))
                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                        <a href="{{ route('societies') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe433;</i>
                            </span>
                            <span class="nav-text">{{ __('cruds.Society.Title') }}</span>
                        </a>
                    </li>
                    @endif
                    <?php
                        $currentFolder = "main-services"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                        
                        $currentFolder2 = "sub-services"; // Put folder name here
                        $PathCurrentFolder2 = substr($urlAfterRoot, 0, strlen($currentFolder2));
                        
                    ?>
                    @if(\Helper::checkPermission(11))
                    <li {{ ($PathCurrentFolder==$currentFolder || $PathCurrentFolder2==$currentFolder2) ? 'class=active' : '' }}>
                        <a>
                            <span class="nav-caret"><i class="fa fa-caret-down"></i></span>
                            <span class="nav-icon"><i class="material-icons">&#xe1b8;</i></span>
                            <span class="nav-text">{{ __('backend.services') }}</span>
                        </a>
                        <ul class="nav-sub">
                      
                            <li><a href="{{ route('MainServices') }}"><span class="nav-text">{{ __('cruds.MainServices.Title') }}</span></a></li>
                           
                            <li><a href="{{ route('SubServices') }}"><span class="nav-text">{{ __('cruds.SubServices.Title') }}</span></a></li>
                        </ul>
                    </li>
                    @endif
                    <?php
                        $currentFolder = "users"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    
                        $currentFolder2 = "new-roles"; // Put folder name here
                        $PathCurrentFolder2 = substr($urlAfterRoot, 0, strlen($currentFolder2));
                    
                    ?>
                    @if(\Helper::checkPermission(11))
                    <li {{ ($PathCurrentFolder==$currentFolder || $PathCurrentFolder2==$currentFolder2) ? 'class=active' : '' }} >
                        <a >
                            <span class="nav-caret"><i class="fa fa-caret-down"></i></span>
                            <span class="nav-icon"><i class="material-icons">&#xe1b8;</i></span>
                            <span class="nav-text">{{ __('backend.Admins') }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                <a href="{{ route('users') }}">
                                    <span class="nav-icon">
                                        <i class="material-icons">&#xe7ef;</i>
                                    </span>
                                    <span class="nav-text">{{ __('backend.Admins') }}</span>
                                </a>
                            </li>
                            <li {{ ($PathCurrentFolder== 'new-roles') ? 'class=active' : '' }}>
                                <a href="{{ route('roles') }}">
                                    <span class="nav-icon">
                                        <i class="material-icons">&#xe3fc;</i>
                                    </span>
                                    <span class="nav-text">{{ __('backend.roles') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif



                    @foreach($GeneralWebmasterSections as $index => $GeneralWebmasterSection)
                        @if(in_array($GeneralWebmasterSection->id,$data_sections_arr))
                            <?php
                            if ($GeneralWebmasterSection->$mnu_title_var != "") {
                                $GeneralWebmasterSectionTitle = $GeneralWebmasterSection->$mnu_title_var;
                            } else {
                                $GeneralWebmasterSectionTitle = $GeneralWebmasterSection->$mnu_title_var2;
                            }

                            $LiIcon = "&#xe2c8;";
                            if ($GeneralWebmasterSection->type == 3) {
                                $LiIcon = "&#xe050;";
                            }
                            if ($GeneralWebmasterSection->type == 2) {
                                $LiIcon = "&#xe63a;";
                            }
                            if ($GeneralWebmasterSection->type == 1) {
                                $LiIcon = "&#xe251;";
                            }
                            if ($GeneralWebmasterSection->type == 0) {
                                $LiIcon = "&#xe2c8;";
                            }
                            if ($GeneralWebmasterSection->id == 1) {
                                $LiIcon = "&#xe3e8;";
                            }
                            if ($GeneralWebmasterSection->id == 7) {
                                $LiIcon = "&#xe02f;";
                            }
                            if ($GeneralWebmasterSection->id == 2) {
                                $LiIcon = "&#xe540;";
                            }
                            if ($GeneralWebmasterSection->id == 3) {
                                $LiIcon = "&#xe307;";
                            }
                            if ($GeneralWebmasterSection->id == 8) {
                                $LiIcon = "&#xe8f6;";
                            }

                            // get 9 char after root url to check if is "webmaster"
                            $is_webmaster = substr($urlAfterRoot, 0, 9);
                            ?>
                            @if($GeneralWebmasterSection->sections_status > 0 && @Auth::user()->permissionsGroup->view_status == 0 )

                                @if ($GeneralWebmasterSection->id !== 2 && $GeneralWebmasterSection->id !== 3 && $GeneralWebmasterSection->id !==5 && $GeneralWebmasterSection->id !==6 && $GeneralWebmasterSection->id !==8 && $GeneralWebmasterSection->id !==10 && $GeneralWebmasterSection->id !==11 && $GeneralWebmasterSection->id !==12 )
                                <li {{ ($GeneralWebmasterSection->id == @$WebmasterSection->id && $is_webmaster != "webmaster") ? 'class=active' : '' }}>
                                    @if( \Helper::checkPermission(12))
                                        <a>
                                            <span class="nav-caret">
                                                <i class="fa fa-caret-down"></i>
                                            </span>
                                                                    <span class="nav-icon">
                                                <i class="material-icons">{!! $LiIcon !!}</i>
                                            </span>
                                            <span
                                                class="nav-text">{!! $GeneralWebmasterSectionTitle !!}
                                            </span>
                                        </a>
                                    @endif
                                    <ul class="nav-sub">
                                        @if($GeneralWebmasterSection->sections_status > 0)

                                            <?php
                                            $currentFolder = "categories"; // Put folder name here
                                            $PathCurrentFolder = substr($urlAfterRoot,
                                                (strlen($GeneralWebmasterSection->id) + 1), strlen($currentFolder));
                                            ?>
                                            <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                                                <a href="{{ route('categories',$GeneralWebmasterSection->id) }}">
                                                    <span
                                                        class="nav-text">{{ __('backend.sectionsOf') }} {{ $GeneralWebmasterSectionTitle }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        <?php
                                        $currentFolder = "topics"; // Put folder name here
                                        $PathCurrentFolder = substr($urlAfterRoot,
                                            (strlen($GeneralWebmasterSection->id) + 1), strlen($currentFolder));
                                        ?>
                                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                                            <a href="{{ route('topics',$GeneralWebmasterSection->id) }}">
                                                <span
                                                    class="nav-text">{!! $GeneralWebmasterSectionTitle !!}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                            @else
                                @if ($GeneralWebmasterSection->id !== 3 && $GeneralWebmasterSection->id !== 2 && $GeneralWebmasterSection->id !==5 && $GeneralWebmasterSection->id !==6 && $GeneralWebmasterSection->id !==8 && $GeneralWebmasterSection->id !==10 && $GeneralWebmasterSection->id !==11 && $GeneralWebmasterSection->id !==12)
                                    @if( \Helper::checkPermission(12))
                                    <li {{ ($GeneralWebmasterSection->id== @$WebmasterSection->id) ? 'class=active' : '' }}>
                                        <a href="{{ route('topics',$GeneralWebmasterSection->id) }}">
                                            <span class="nav-icon">
                                                <i class="material-icons">{!! $LiIcon !!}</i>
                                            </span>
                                                                    <span
                                            class="nav-text">{!! $GeneralWebmasterSectionTitle !!}</span>
                                        </a>
                                    </li>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endforeach



                    {{-- @if(Helper::GeneralWebmasterSettings("banners_status"))
                        @if(@Auth::user()->permissionsGroup->banners_status)--}}
                            <?php
                            // $currentFolder = "banners";
                            // $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                            ?>
                            {{--<li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }} >
                                <a href="{{ route('Banners') }}">
                                    <span class="nav-icon">
                                        <i class="material-icons">&#xe433;</i>
                                    </span>
                                    <span class="nav-text">{{ __('backend.adsBanners') }}</span>
                                </a>
                            </li>
                        @endif
                    @endif --}}

                    {{-- @if(Helper::GeneralWebmasterSettings("settings_status")) --}}
                        @if(@Auth::user()->permissionsGroup->settings_status)
                            @if(\Helper::checkPermission(15) || \Helper::checkPermission(16))

                            <li class="nav-header hidden-folded">
                                <small class="text-muted">{{ __('backend.settings') }}</small>
                            </li>
                            @endif
                            <?php
                            $currentFolder = "settings"; // Put folder name here
                            $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));

                            $currentFolder2 = "menus"; // Put folder name here
                            $PathCurrentFolder2 = substr($urlAfterRoot, 0, strlen($currentFolder2));

                            // $currentFolder3 = "users"; // Put folder name here
                            // $PathCurrentFolder3 = substr($urlAfterRoot, 0, strlen($currentFolder3));

                            $currentFolder4 = "file-manager"; // Put folder name here
                            $PathCurrentFolder4 = substr($urlAfterRoot, 0, strlen($currentFolder4));
                            ?>
                            @if(\Helper::checkPermission(15))

                            <li {{ ($PathCurrentFolder==$currentFolder || $PathCurrentFolder2==$currentFolder2 || $PathCurrentFolder4==$currentFolder4 ) ? 'class=active' : '' }}>
                                <a>
                                <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                                </span>
                                                                    <span class="nav-icon">
                                <i class="material-icons">&#xe8b8;</i>
                                </span>
                                    <span class="nav-text">{{ __('backend.generalSiteSettings') }}</span>
                                </a>
                                <ul class="nav-sub">
                                    <?php
                                    $currentFolder = "settings"; // Put folder name here
                                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                    ?>
                                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                        <a href="{{ route('settings') }}"
                                           onclick="location.href='{{ route('settings') }}'">
                                            <span class="nav-text">{{ __('backend.generalSettings') }}</span>
                                        </a>
                                    </li>
                                    <?php
                                    $currentFolder = "menus"; // Put folder name here
                                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                    ?>
                                    {{---
                                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                        <a href="{{ route('menus') }}">
                                            <span class="nav-text">{{ __('backend.siteMenus') }}</span>
                                        </a>
                                    </li>--}}

                                    {{--<?php
                                    $currentFolder = "file-manager"; // Put folder name here
                                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                    ?>
                                    <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                                        <a href="{{ route('FileManager') }}">
                                            <span class="nav-text">{{ __('backend.fileManager') }}</span>
                                        </a>
                                    </li>--}}
                                </ul>
                            </li>
                            @endif
                        @endif
                    {{-- @endif --}}


                    @if(@Auth::user()->permissionsGroup->webmaster_status && \Helper::checkPermission(16))
                        <?php
                        $currentFolder = "webmaster"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                        ?>
                        <li {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                            <a>
                                <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                                </span>
                                <span class="nav-icon">
                                <i class="material-icons">&#xe8be;</i>
                                </span>
                                <span class="nav-text">{{ __('backend.webmasterTools') }}</span>
                            </a>
                            <ul class="nav-sub">
                                <?php
                                $PathCurrentSubFolder = substr($urlAfterRoot, 0, (strlen($currentFolder) + 1));
                                ?>
                                <li {{ ($PathCurrentFolder==$PathCurrentSubFolder) ? 'class=active' : '' }}>
                                    <a href="{{ route('webmasterSettings') }}"
                                       onclick="location.href='{{ route('webmasterSettings') }}'">
                                        <span class="nav-text">{{ __('backend.generalSettings') }}</span>
                                    </a>
                                </li>
                                {{--<?php
                                $currentSubFolder = "sections"; // Put folder name here
                                $PathCurrentSubFolder = substr($urlAfterRoot, (strlen($currentFolder) + 1),
                                    strlen($currentSubFolder));
                                ?>
                                <li {{ ($PathCurrentSubFolder==$currentSubFolder) ? 'class=active' : '' }}>
                                    <a href="{{ route('WebmasterSections') }}">
                                        <span class="nav-text">{{ __('backend.siteSectionsSettings') }}</span>
                                    </a>
                                </li> --}}
                                {{--<?php
                                $currentSubFolder = "banners"; // Put folder name here
                                $PathCurrentSubFolder = substr($urlAfterRoot, (strlen($currentFolder) + 1),
                                    strlen($currentSubFolder));
                                ?>
                                <li {{ ($PathCurrentSubFolder==$currentSubFolder) ? 'class=active' : '' }}>
                                    <a href="{{ route('WebmasterBanners') }}">
                                        <span class="nav-text">{{ __('backend.adsBannersSettings') }}</span>
                                    </a>
                                </li>--}}

                            </ul>
                        </li>

                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
