<meta name="token" content="{{ csrf_token() }}">

@if (Helper::GeneralWebmasterSettings('header_menu_id') > 0)
    <?php
    // Get list of footer menu links by group Id
    $HeaderMenuLinks = Helper::MenuList(Helper::GeneralWebmasterSettings('header_menu_id'));
    // dd($HeaderMenuLinks);
    ?>

    @if (count($HeaderMenuLinks) > 0)

        <?php
        // Current Full URL
        $fullPagePath = Request::url();
        // Char Count of Backend folder Plus 1
        $envAdminCharCount = strlen(env('BACKEND_PATH')) + 1;
        // URL after Root Path EX: admin/home
        $urlAfterRoot = substr($fullPagePath, strpos($fullPagePath, env('BACKEND_PATH')) + $envAdminCharCount);
        ?>
        <?php
        $category_title_var = 'title_' . @Helper::currentLanguage()->code;
        $category_title_var2 = 'title_' . env('DEFAULT_LANGUAGE');
        $slug_var = 'seo_url_slug_' . @Helper::currentLanguage()->code;
        $slug_var2 = 'seo_url_slug_' . env('DEFAULT_LANGUAGE');
        ?>
        <div class="navbar-collapse collapse ">
            <ul class="nav navbar-nav">
                @foreach ($HeaderMenuLinks as $HeaderMenuLink)
                    <?php
                    if ($HeaderMenuLink->$category_title_var != '') {
                        $link_title = $HeaderMenuLink->$category_title_var;
                    } else {
                        $link_title = $HeaderMenuLink->$category_title_var2;
                    }
                    ?>
                    @if ($HeaderMenuLink->type == 3)
                        <?php
                        // Section with drop list
                        ?>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown"
                                data-hover="dropdown" data-delay="0" data-close-others="true">{{ $link_title }} <i
                                    class="fa fa-angle-down"></i></a>

                            @if (count($HeaderMenuLink->webmasterSection->sections) > 0)
                                {{-- categories drop down --}}
                                <ul class="dropdown-menu">
                                    @foreach ($HeaderMenuLink->webmasterSection->sections as $MnuCategory)
                                        @if ($MnuCategory->father_id == 0)
                                            @if ($MnuCategory->status)
                                                <?php
                                                if ($MnuCategory->$category_title_var != '') {
                                                    $category_title = $MnuCategory->$category_title_var;
                                                } else {
                                                    $category_title = $MnuCategory->$category_title_var2;
                                                }
                                                ?>
                                                <li>
                                                    <a href="{{ Helper::categoryURL($MnuCategory->id) }}">
                                                        @if ($MnuCategory->icon != '')
                                                            <i class="fa {{ $MnuCategory->icon }}"></i> &nbsp;
                                                        @endif
                                                        {{ $category_title }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @elseif(count($HeaderMenuLink->webmasterSection->topics) > 0)
                                {{-- topics drop down --}}
                                <ul class="dropdown-menu">
                                    @foreach ($HeaderMenuLink->webmasterSection->topics as $MnuTopic)
                                        @if ($MnuTopic->status)
                                            @if ($MnuTopic->expire_date == '' || ($MnuTopic->expire_date != '' && $MnuTopic->expire_date >= date('Y-m-d')))
                                                <?php
                                                if ($MnuTopic->$category_title_var != '') {
                                                    $category_title = $MnuTopic->$category_title_var;
                                                } else {
                                                    $category_title = $MnuTopic->$category_title_var2;
                                                }
                                                ?>
                                                <li>
                                                    <a href="{{ Helper::topicURL($MnuTopic->id) }}">
                                                        @if ($MnuTopic->icon != '')
                                                            <i class="fa {{ $MnuTopic->icon }}"></i> &nbsp;
                                                        @endif
                                                        {{ $category_title }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                        </li>
                    @elseif($HeaderMenuLink->type == 2)
                        <?php
                        // Section Link
                        ?>
                        <li>
                            <a href="{{ Helper::sectionURL($HeaderMenuLink->cat_id) }}">{{ $link_title }}</a>
                        </li>
                    @elseif($HeaderMenuLink->type == 1)
                        <?php
                        // Direct Link
                        $this_link_url = '';
                        if ($HeaderMenuLink->link != '') {
                            if (@Helper::currentLanguage()->code != env('DEFAULT_LANGUAGE')) {
                                $f3c = mb_substr($HeaderMenuLink->link, 0, 3);
                                if ($f3c == 'htt' || $f3c == 'www') {
                                    $this_link_url = $HeaderMenuLink->link;
                                } else {
                                    $this_link_url = url(@Helper::currentLanguage()->code . '/' . $HeaderMenuLink->link);
                                }
                            } else {
                                $this_link_url = url($HeaderMenuLink->link);
                            }
                        }
                        ?>
                        <li><a href="{{ $this_link_url }}">{{ $link_title }}</a></li>
                        @if ($HeaderMenuLink->link === 'home')
                            <li><a href="{{ route('FrontendPackagesByLang') }}">{{ __('cruds.Packages.Title') }}</a>
                            </li>
                        @endif
                    @else
                        <?php
                        // Main title ( have drop down menu )
                        ?>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown"
                                data-hover="dropdown" data-delay="0" data-close-others="true">{{ $link_title }}</a>
                            @if (count($HeaderMenuLink->subMenus) > 0)
                                <ul class="dropdown-menu">
                                    @foreach ($HeaderMenuLink->subMenus as $subMenu)
                                        <?php
                                        if ($subMenu->$category_title_var != '') {
                                            $subMenu_title = $subMenu->$category_title_var;
                                        } else {
                                            $subMenu_title = $subMenu->$category_title_var2;
                                        }
                                        ?>
                                        @if ($subMenu->type == 3)
                                            <?php
                                            // sub menu - Section will drop list
                                            ?>
                                            <li><a href="javascript:void(0)" class="dropdown-toggle "
                                                    data-toggle="dropdown" data-hover="dropdown" data-delay="0"
                                                    data-close-others="true">{{ $subMenu_title }}</a>
                                                <?php
                                                // make list
                                                // - check is categories list
                                                // - or pages list
                                                ?>

                                                @if (count($subMenu->webmasterSection->sections) > 0)
                                                    {{-- categories drop down --}}
                                                    <ul class="dropdown-menu">
                                                        @foreach ($subMenu->webmasterSection->sections as $SubMnuCategory)
                                                            @if ($SubMnuCategory->father_id == 0)
                                                                @if ($SubMnuCategory->status)
                                                                    <?php
                                                                    if ($SubMnuCategory->$category_title_var != '') {
                                                                        $SubMnuCategory_title = $SubMnuCategory->$category_title_var;
                                                                    } else {
                                                                        $SubMnuCategory_title = $SubMnuCategory->$category_title_var2;
                                                                    }
                                                                    ?>
                                                                    <li>
                                                                        <a
                                                                            href="{{ Helper::categoryURL($SubMnuCategory->id) }}">
                                                                            @if ($SubMnuCategory->icon != '')
                                                                                <i
                                                                                    class="fa {{ $SubMnuCategory->icon }}"></i>
                                                                                &nbsp;
                                                                            @endif
                                                                            {{ $SubMnuCategory_title }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @elseif(count($subMenu->webmasterSection->topics) > 0)
                                                    {{-- topics drop down --}}
                                                    <ul class="dropdown-menu">
                                                        @foreach ($subMenu->webmasterSection->topics as $SubMnuTopic)
                                                            @if ($SubMnuTopic->status)
                                                                @if ($SubMnuTopic->expire_date == '' || ($SubMnuTopic->expire_date != '' && $SubMnuTopic->expire_date >= date('Y-m-d')))
                                                                    <?php
                                                                    if ($SubMnuTopic->$category_title_var != '') {
                                                                        $SubMnuTopic_title = $SubMnuTopic->$category_title_var;
                                                                    } else {
                                                                        $SubMnuTopic_title = $SubMnuTopic->$category_title_var2;
                                                                    }
                                                                    ?>
                                                                    <li>
                                                                        <a
                                                                            href="{{ Helper::topicURL($SubMnuTopic->id) }}">{{ $SubMnuTopic_title }}</a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif

                                            </li>
                                        @elseif($subMenu->type == 2)
                                            <?php
                                            // sub menu - Section Link
                                            ?>
                                            <li>
                                                <a
                                                    href="{{ Helper::sectionURL($subMenu->cat_id) }}">{{ $subMenu_title }}</a>
                                            </li>
                                        @elseif($subMenu->type == 1)
                                            <?php
                                            // sub menu - Direct Link
                                            $this_link_url = '';
                                            if ($subMenu->link != '') {
                                                if (@Helper::currentLanguage()->code != env('DEFAULT_LANGUAGE')) {
                                                    $f3c = mb_substr($subMenu->link, 0, 3);
                                                    if ($f3c == 'htt' || $f3c == 'www') {
                                                        $this_link_url = $subMenu->link;
                                                    } else {
                                                        $this_link_url = url(@Helper::currentLanguage()->code . '/' . $subMenu->link);
                                                    }
                                                } else {
                                                    $this_link_url = url($subMenu->link);
                                                }
                                            }
                                            ?>
                                            <li><a href="{{ $this_link_url }}">{{ $subMenu_title }}</a>
                                            </li>
                                        @else
                                            <?php
                                            // sub menu - Main title ( have drop down menu )
                                            ?>
                                            <li><a href="javascript:void(0)">{{ $subMenu_title }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                {{--<li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown"
                        data-hover="dropdown"data-delay="0" data-close-others="true">{{ __('frontend.ourservices') }}
                        <i class="fa fa-angle-down"></i></a>

                    <ul class="dropdown-menu">
                        @foreach ($main_services as $main_service)
                            <li class="mainservices" id="ms-{{ $main_service->id }}" msid="{{ $main_service->id }}">
                                <a href="{{ route('showMainService', $main_service->id) }}">
                                    <i class="fa fa-ambulance"></i> &nbsp;
                                    @if (app()->getLocale() == 'ar')
                                        {{ $main_service->name_ar }}
                                    @else
                                        {{ $main_service->name_en }}
                                    @endif
                                </a>

                            </li>
                            @endforeach
                            <ul class="dropdown-menu" id="sub" @if(app()->getLocale() == 'ar') style="position: absolute; top: 0; margin-right: 150px; margin-top: -1px" @else style="position: absolute; top: 0;margin-left: 150px; margin-top: -1px" @endif>

                            </ul>

                    </ul>


                </li>--}}
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown"
                        data-hover="dropdown"data-delay="0" data-close-others="true">{{ __('frontend.ourservices') }}
                        <i class="fa fa-angle-down"></i></a>

                    <ul class="dropdown-menu">
                        @foreach ($main_services as $main_service)
                            <li class="mainservices dropdown" class="dropdown-toggle" id="ms-{{ $main_service->id }}">
                                <a href="{{ route('showMainService', $main_service->id) }}"
                                    data-toggle="dropdown" data-hover="dropdown"data-delay="0" data-close-others="true">
                                    @if (app()->getLocale() == 'ar')
                                        {{ $main_service->name_ar }}
                                    @else
                                        {{ $main_service->name_en }}
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ( $main_service->subServices  as $item)
                                        <li class="mainservices">
                                            <a href="{{ route('showMainService', $main_service->id) }}">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $item->title_ar }}
                                                @else
                                                    {{ $item->title_en }}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                    {{-- <li class="mainservices">
                                        <a href="{{ route('showMainService', $main_service->id) }}">
                                            Test
                                        </a>
                                    </li>
                                    <li class="mainservices">
                                        <a href="{{ route('showMainService', $main_service->id) }}">
                                            Test
                                        </a>
                                    </li>
                                    <li class="mainservices">
                                        <a href="{{ route('showMainService', $main_service->id) }}">
                                            Test
                                        </a>
                                    </li> --}}
                                </ul>

                            </li>
                            @endforeach

                    </ul>


                </li>
                <li><a href="{{ route('FrontendCommonQuestionsByLang') }}">{{ __('cruds.CommonQuestions.Title') }}</a>
                </li>
                <li><a href="{{ route('FrontendSocietyByLang') }}">{{ __('cruds.Society.Title') }}</a></li>

            </ul>
        </div>
    @endif
@endif
{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(".mainservices").on('mouseover', function() {
        let msid = $(this).attr("msid")
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=token]').attr('content')}
        });
        $.ajax({
            url: "{{ route('GetSubService') }}",
            type: 'POST',
            data: {'_token': '{{ csrf_token() }}', msid: msid},
            dataType: 'json',
            success: function(data){
                $("#sub").html("")
                data.data.map(el => {
                    $("#sub").append("<li class='subservice'><a href='show-main-service/"+el.main_service_id+"'><i class='fa fa-ambulance'></i>&nbsp;."+@if(app()->getLocale() == 'ar') el.title_ar @else el.title_en @endif +".</a></li>");
                });

            }
        })
    })
    $("#sub").on('mouseleave', function() {
        let msid = $(this).attr("msid")
            $("#sub").html("")
    })
</script> --}}
