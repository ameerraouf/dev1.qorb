@extends('frontEnd.layout')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- start Home Slider -->
    @include('frontEnd.includes.slider')
    <!-- end Home Slider -->

    @if (!empty($HomePage))
        @if (@$HomePage->{'details_' . @Helper::currentLanguage()->code} != '')
            <section class="content-row-no-bg home-welcome">
                <div class="container">
                    {!! @$HomePage->{'details_' . @Helper::currentLanguage()->code} !!}
                </div>
            </section>
        @endif
    @endif

    @if (count($TextBanners) > 0)
        @foreach ($TextBanners->slice(0, 1) as $TextBanner)
            <?php
            try {
                $TextBanner_type = $TextBanner->webmasterBanner->type;
            } catch (Exception $e) {
                $TextBanner_type = 0;
            }
            ?>
        @endforeach
        <?php
        $title_var = 'title_' . @Helper::currentLanguage()->code;
        $title_var2 = 'title_' . env('DEFAULT_LANGUAGE');
        $details_var = 'details_' . @Helper::currentLanguage()->code;
        $details_var2 = 'details_' . env('DEFAULT_LANGUAGE');
        $file_var = 'file_' . @Helper::currentLanguage()->code;
        $file_var2 = 'file_' . env('DEFAULT_LANGUAGE');

        $col_width = 12;
        if (count($TextBanners) == 2) {
            $col_width = 6;
        }
        if (count($TextBanners) == 3) {
            $col_width = 4;
        }
        if (count($TextBanners) > 3) {
            $col_width = 3;
        }
        ?>
        {{-- <section class="content-row-no-bg p-b-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row" style="margin-bottom: 0;">
                            @foreach ($TextBanners as $TextBanner)
                                <?php
                                if ($TextBanner->$title_var != '') {
                                    $BTitle = $TextBanner->$title_var;
                                } else {
                                    $BTitle = $TextBanner->$title_var2;
                                }
                                if ($TextBanner->$details_var != '') {
                                    $BDetails = $TextBanner->$details_var;
                                } else {
                                    $BDetails = $TextBanner->$details_var2;
                                }
                                if ($TextBanner->$file_var != '') {
                                    $BFile = $TextBanner->$file_var;
                                } else {
                                    $BFile = $TextBanner->$file_var2;
                                }
                                ?>
                                <div class="col-lg-{{$col_width}}">
                                    <div class="box">
                                        <div class="box-gray aligncenter">
                                            @if ($TextBanner->code != '')
                                                {!! $TextBanner->code !!}
                                            @else
                                                @if ($TextBanner->icon != '')
                                                    <div class="icon">
                                                        <i class="fa {{$TextBanner->icon}} fa-3x"></i>
                                                    </div>
                                                @elseif($BFile !="")
                                                    <img src="{{ URL::to('uploads/banners/'.$BFile) }}"
                                                         alt="{{ $BTitle }}"/>
                                                @endif
                                                <h4>{!! $BTitle !!}</h4>
                                                @if ($BDetails != '')
                                                    <p>{!! nl2br($BDetails) !!}</p>
                                                @endif
                                            @endif

                                        </div>
                                        @if ($TextBanner->link_url != '')
                                            <div class="box-bottom">
                                                <a href="{!! $TextBanner->link_url !!}">{{ __('frontend.moreDetails') }}</a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <!-- بداية صفحة الباقات -->
        <section class="content-row-no-bg top-line">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('cruds.Packages.Title') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="swiper swiper-packages" style="position: relative; overflow:hidden;">
                    <div class="swiper-wrapper">
                        @foreach ($packages as $item)
                            <div class="swiper-slide">
                                <div class="box-package">
                                    <h3 class="title">
                                        {{ app()->getLocale() == 'ar' ? $item->title_ar : $item->title_en }}
                                    </h3>
                                    <h4 class="price">
                                        {{ $item->price }}
                                        <span>
                                            {{ __('cruds.Packages.currency') }}
                                        </span>
                                    </h4>
                                    <ul class="list">
                                        @foreach ($item->advantages as $adv)
                                            <li>
                                                <span class="icon">
                                                    &#10003;
                                                </span>
                                                {{ $adv }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ auth()->guard('teacher')->check() ? route('TeacherPackages') : route('teacher.login') }}" class="btn-box">
                                        {{ __('cruds.Packages.Subscribe') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
                <div class="more-btn">
                    <a href="{{ route('FrontendPackages') }}" class="btn btn-theme"><i class="fa fa-angle-left"></i>&nbsp;
                        {{ __('frontend.viewMore') }}
                        &nbsp;<i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </section>
        <!-- نهاية صفحة الباقات -->
    @endif

    <!-- بداية صفحة الخدمات -->
    <section class="content-row-no-bg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="home-row-head">
                        <h2 class="heading">{{ __('cruds.MainServices.Title') }}</h2>
                    </div>
                </div>
            </div>
            <div class="swiper-services" style="position: relative; overflow:hidden;">
                <div class="swiper-wrapper">
                    @foreach ($main_services as $main_service)
                        <div class="swiper-slide">
                            <a href="{{ route('showMainService', $main_service->id) }}" style="text-decoration: none;">
                                <div class="box-serv">
                                    <span class="icon">
                                        <i class="fa fa-television" aria-hidden="true"></i>
                                    </span>
                                    <h3 class="title">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $main_service->name_ar }}
                                        @else
                                            {{ $main_service->name_en }}
                                        @endif
                                    </h3>
                                    <p class="content">
                                        @if (app()->getLocale() == 'ar')
                                            {!! strlen(strip_tags($main_service->description_ar)) > 180
                                                ? substr(strip_tags($main_service->description_ar), 0, 250) . '...'
                                                : strip_tags($main_service->description_ar) !!}
                                        @else
                                            {!! strlen(strip_tags($main_service->description_en)) > 180
                                                ? substr(strip_tags($main_service->description_en), 0, 250) . '...'
                                                : strip_tags($main_service->description_en) !!}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <br><br>
            <div class="more-btn">
                <a href="{{ route('FrontendMainServices') }}" class="btn btn-theme"><i class="fa fa-angle-left"></i>&nbsp;
                    {{ __('frontend.viewMore') }}
                    &nbsp;<i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </section>

    <!-- نهاية صفحة الخدمات -->

    <!-- بداية صفحة  الخدمات الفرعية -->
    <section class="content-row-no-bg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="home-row-head">
                        <h2 class="heading">{{ __('cruds.SubServices.Title') }}</h2>
                    </div>
                </div>
            </div>
            <div class="swiper-services2" style="position: relative; overflow:hidden;">
                <div class="swiper-wrapper">
                    @foreach ($sub_services as $item)
                        <div class="swiper-slide">
                            <a href="" style="text-decoration: none;">
                                <div class="box-serv">
                                    <span class="icon">
                                        <i class="fa fa-television" aria-hidden="true"></i>
                                    </span>
                                    <div class="small-title">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $item->main_service->name_ar }}
                                        @else
                                            {{ $item->main_service->name_en }}
                                        @endif
                                    </div>
                                    <h3 class="title">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $item->title_ar }}
                                        @else
                                            {{ $item->title_en }}
                                        @endif
                                    </h3>
                                    <p class="content">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $item->description_ar }}
                                        @else
                                            {{ $item->description_en }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <br><br>
            <div class="more-btn">
                <a href="{{ route('FrontendMainServices') }}" class="btn btn-theme"><i class="fa fa-angle-left"></i>&nbsp;
                    {{ __('frontend.viewMore') }}
                    &nbsp;<i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </section>
    <!-- نهاية صفحة  الخدمات الفرعية -->

    @if (count($HomeTopics) > 0)
        <section class="content-row-no-bg top-line">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('frontend.homeContents1Title') }}</h2>
                            <small>{{ __('frontend.homeContents1desc') }}</small>
                        </div>
                        <div id="owl-slider" class="owl-carousel owl-theme listing">
                            <?php
                            $title_var = 'title_' . @Helper::currentLanguage()->code;
                            $title_var2 = 'title_' . env('DEFAULT_LANGUAGE');
                            $details_var = 'details_' . @Helper::currentLanguage()->code;
                            $details_var2 = 'details_' . env('DEFAULT_LANGUAGE');
                            $section_url = '';
                            ?>
                            @foreach ($HomeTopics as $HomeTopic)
                                <?php
                                if ($HomeTopic->$title_var != '') {
                                    $title = $HomeTopic->$title_var;
                                } else {
                                    $title = $HomeTopic->$title_var2;
                                }
                                if ($HomeTopic->$details_var != '') {
                                    $details = $details_var;
                                } else {
                                    $details = $details_var2;
                                }
                                if ($section_url == '') {
                                    $section_url = Helper::sectionURL($HomeTopic->webmaster_id);
                                }
                                ?>
                                <div class="item">
                                    <h4>
                                        @if ($HomeTopic->icon != '')
                                            <i class="fa {!! $HomeTopic->icon !!} "></i>&nbsp;
                                        @endif
                                        {{ $title }}
                                    </h4>
                                    @if ($HomeTopic->photo_file != '')
                                        <img src="{{ URL::to('uploads/topics/' . $HomeTopic->photo_file) }}"
                                            alt="{{ $title }}" />
                                    @endif

                                    {{-- Additional Feilds --}}
                                    @if (count($HomeTopic->webmasterSection->customFields->where('in_listing', true)) > 0)
                                        <div class="row">
                                            <div class="col-12">
                                                <div>
                                                    <?php
                                                    $cf_title_var = 'title_' . @Helper::currentLanguage()->code;
                                                    $cf_title_var2 = 'title_' . env('DEFAULT_LANGUAGE');
                                                    ?>
                                                    @foreach ($HomeTopic->webmasterSection->customFields->where('in_listing', true) as $customField)
                                                        <?php
                                                        // check permission
                                                        $view_permission_groups = [];
                                                        if ($customField->view_permission_groups != "") {
                                                            $view_permission_groups = explode(",", $customField->view_permission_groups);
                                                        }
                                                        if (in_array(0, $view_permission_groups) || $customField->view_permission_groups == "") {
                                                        // have permission & continue
                                                        ?>
                                                        @if ($customField->in_listing)
                                                            <?php
                                                            if ($customField->$cf_title_var != '') {
                                                                $cf_title = $customField->$cf_title_var;
                                                            } else {
                                                                $cf_title = $customField->$cf_title_var2;
                                                            }

                                                            $cf_saved_val = '';
                                                            $cf_saved_val_array = [];
                                                            if (count($HomeTopic->fields) > 0) {
                                                                foreach ($HomeTopic->fields as $t_field) {
                                                                    if ($t_field->field_id == $customField->id) {
                                                                        if ($customField->type == 7) {
                                                                            // if multi check
                                                                            $cf_saved_val_array = explode(', ', $t_field->field_value);
                                                                        } else {
                                                                            $cf_saved_val = $t_field->field_value;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            ?>

                                                            @if (
                                                                ($cf_saved_val != '' || count($cf_saved_val_array) > 0) &&
                                                                    ($customField->lang_code == 'all' || $customField->lang_code == @Helper::currentLanguage()->code))
                                                                @if ($customField->type == 12)
                                                                    {{-- Vimeo Video Link --}}
                                                                @elseif($customField->type == 11)
                                                                    {{-- Youtube Video Link --}}
                                                                @elseif($customField->type == 10)
                                                                    {{-- Video File --}}
                                                                @elseif($customField->type == 9)
                                                                    {{-- Attach File --}}
                                                                @elseif($customField->type == 8)
                                                                    {{-- Photo File --}}
                                                                @elseif($customField->type == 7)
                                                                    {{-- Multi Check --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            <?php
                                                                            $cf_details_var = 'details_' . @Helper::currentLanguage()->code;
                                                                            $cf_details_var2 = 'details_' . env('DEFAULT_LANGUAGE');
                                                                            if ($customField->$cf_details_var != '') {
                                                                                $cf_details = $customField->$cf_details_var;
                                                                            } else {
                                                                                $cf_details = $customField->$cf_details_var2;
                                                                            }
                                                                            $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                                                            $line_num = 1;
                                                                            ?>
                                                                            @foreach ($cf_details_lines as $cf_details_line)
                                                                                @if (in_array($line_num, $cf_saved_val_array))
                                                                                    <span class="badge">
                                                                                        {!! $cf_details_line !!}
                                                                                    </span>
                                                                                @endif
                                                                                <?php
                                                                                $line_num++;
                                                                                ?>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 14)
                                                                    {{-- Checkbox --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-12">
                                                                            {!! $cf_saved_val == 1 ? '&check;' : '&#x2A09;' !!} {!! $cf_title !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 6 || $customField->type == 13)
                                                                    {{-- Select --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            <?php
                                                                            $cf_details_var = 'details_' . @Helper::currentLanguage()->code;
                                                                            $cf_details_var2 = 'details_' . env('DEFAULT_LANGUAGE');
                                                                            if ($customField->$cf_details_var != '') {
                                                                                $cf_details = $customField->$cf_details_var;
                                                                            } else {
                                                                                $cf_details = $customField->$cf_details_var2;
                                                                            }
                                                                            $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                                                            $line_num = 1;
                                                                            ?>
                                                                            @foreach ($cf_details_lines as $cf_details_line)
                                                                                @if ($line_num == $cf_saved_val)
                                                                                    {!! $cf_details_line !!}
                                                                                @endif
                                                                                <?php
                                                                                $line_num++;
                                                                                ?>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 5)
                                                                    {{-- Date & Time --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! date('Y-m-d H:i:s', strtotime($cf_saved_val)) !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 4)
                                                                    {{-- Date --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! date('Y-m-d', strtotime($cf_saved_val)) !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 3)
                                                                    {{-- Email Address --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! $cf_saved_val !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 2)
                                                                    {{-- Number --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! $cf_saved_val !!}
                                                                        </div>
                                                                    </div>
                                                                @elseif($customField->type == 1)
                                                                    {{-- Text Area --}}
                                                                @else
                                                                    {{-- Text Box --}}
                                                                    <div class="row field-row">
                                                                        <div class="col-lg-3">
                                                                            {!! $cf_title !!} :
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            {!! Helper::ParseLinks($cf_saved_val) !!}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        <?php
                                                        }
                                                        ?>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- End of -- Additional Feilds --}}
                                    <p class="text-justify">{!! mb_substr(strip_tags($HomeTopic->$details), 0, 300) . '...' !!}
                                        &nbsp; <a
                                            href="{{ Helper::topicURL($HomeTopic->id) }}">{{ __('frontend.readMore') }}
                                            <i class="fa fa-caret-{{ @Helper::currentLanguage()->right }}"></i></a>
                                    </p>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="more-btn">
                            <a href="{{ url($section_url) }}" class="btn btn-theme"><i
                                    class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                                &nbsp;<i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif

    @if (count($HomePhotos) > 0)
        <section class="content-row-no-bg ">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('frontend.homeContents2Title') }}</h2>
                            <small>{{ __('frontend.homeContents2desc') }}</small>
                        </div>
                        <div class="row">
                            <section id="projects">
                                <ul id="thumbs" class="portfolio">
                                    <?php
                                    $title_var = 'title_' . @Helper::currentLanguage()->code;
                                    $title_var2 = 'title_' . env('DEFAULT_LANGUAGE');
                                    $details_var = 'details_' . @Helper::currentLanguage()->code;
                                    $details_var2 = 'details_' . env('DEFAULT_LANGUAGE');
                                    $section_url = '';
                                    $ph_count = 0;
                                    ?>
                                    @foreach ($HomePhotos as $HomePhoto)
                                        <?php
                                        if ($HomePhoto->$title_var != '') {
                                            $title = $HomePhoto->$title_var;
                                        } else {
                                            $title = $HomePhoto->$title_var2;
                                        }

                                        if ($section_url == '') {
                                            $section_url = Helper::sectionURL($HomePhoto->webmaster_id);
                                        }
                                        ?>
                                        @foreach ($HomePhoto->photos as $photo)
                                            @if ($ph_count < 12)
                                                <li class="col-lg-2 design" data-id="id-0" data-type="web">
                                                    <div class="relative">
                                                        <div class="item-thumbs">
                                                            <a class="hover-wrap fancybox" data-fancybox-group="gallery"
                                                                title="{{ $title }}"
                                                                href="{{ URL::to('uploads/topics/' . $photo->file) }}">
                                                                <span class="overlay-img"></span>
                                                                <span class="overlay-img-thumb"><i
                                                                        class="fa fa-search-plus"></i></span>
                                                            </a>
                                                            <!-- Thumb Image and Description -->
                                                            <img src="{{ URL::to('uploads/topics/' . $photo->file) }}"
                                                                alt="{{ $title }}">
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            <?php
                                            $ph_count++;
                                            ?>
                                        @endforeach
                                    @endforeach

                                </ul>
                            </section>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="more-btn">
                                    <a href="{{ url($section_url) }}" class="btn btn-theme"><i
                                            class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                                        &nbsp;<i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (count($HomePartners) > 0)
        <section class="content-row-no-bg ">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="home-row-head">
                            <h2 class="heading">{{ __('frontend.partners') }}</h2>
                            <small>{{ __('frontend.partnersMsg') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="partners_carousel slide" id="myCarousel" style="direction: ltr">
                        <div class="carousel-inner">
                            <div class="item active">
                                <ul class="thumbnails">
                                    <?php
                                    $ii = 0;
                                    $title_var = 'title_' . @Helper::currentLanguage()->code;
                                    $title_var2 = 'title_' . env('DEFAULT_LANGUAGE');
                                    $details_var = 'details_' . @Helper::currentLanguage()->code;
                                    $details_var2 = 'details_' . env('DEFAULT_LANGUAGE');
                                    $section_url = '';
                                    ?>

                                    @foreach ($HomePartners as $HomePartner)
                                        <?php
                                        if ($HomePartner->$title_var != '') {
                                            $title = $HomePartner->$title_var;
                                        } else {
                                            $title = $HomePartner->$title_var2;
                                        }

                                        if ($section_url == '') {
                                            $section_url = Helper::sectionURL($HomePartner->webmaster_id);
                                        }
                                        $URL = '';
                                        if (count($HomePartner->fields) > 0) {
                                            foreach ($HomePartner->fields as $t_field) {
                                                if ($t_field->field_value != '') {
                                                    if (@filter_var($t_field->field_value, FILTER_VALIDATE_URL)) {
                                                        $URL = $t_field->field_value;
                                                    }
                                                }
                                            }
                                        }

                                        if ($ii == 6) {
                                            echo "
                                                                                            </ul>
                                                                        </div><!-- /Slide -->
                                                                        <div class='item'>
                                                                            <ul class='thumbnails'>
                                                                                            ";
                                            $ii = 0;
                                        }
                                        ?>
                                        <li class="col-sm-2">
                                            <div>
                                                <div class="thumbnail">
                                                    @if ($URL != '')
                                                        <a href="{{ $URL }}" target="_blank">
                                                            <img src="{{ URL::to('uploads/topics/' . $HomePartner->photo_file) }}"
                                                                data-placement="bottom" title="{{ $title }}"
                                                                alt="{{ $title }}">
                                                        </a>
                                                    @else
                                                        <img src="{{ URL::to('uploads/topics/' . $HomePartner->photo_file) }}"
                                                            data-placement="bottom" title="{{ $title }}"
                                                            alt="{{ $title }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        </li>
                                        <?php
                                        $ii++;
                                        ?>
                                    @endforeach

                                </ul>
                            </div><!-- /Slide -->
                        </div>
                        <nav>
                            <ul class="control-box pager">
                                <li><a data-slide="prev" href="#myCarousel" class=""><i
                                            class="fa fa-angle-left"></i></a></li>
                                {{-- <li><a href="{{ url($section_url) }}">{{ __('frontend.viewMore') }}</a> --}}
                                {{-- </li> --}}
                                <li><a data-slide="next" href="#myCarousel" class=""><i
                                            class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
                        <!-- /.control-box -->

                    </div><!-- /#myCarousel -->
                </div>

            </div>

        </section>
    @endif

    <!-- بداية صفحة الأسئلة الشائعة -->
    {{-- <section class="content-row-no-bg">
            <div class="container">
                        <div class="row">
                            <div class="col-12">
                            <div class="home-row-head">
                            <h2 class="heading">الأسئلة الشائعة</h2>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="panel-group mian-accordion" id="accordion">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#collapse1">Section 1
                              <?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="16" height="16"><path d="M12,17.17a5,5,0,0,1-3.54-1.46L.29,7.54A1,1,0,0,1,1.71,6.12l8.17,8.17a3,3,0,0,0,4.24,0l8.17-8.17a1,1,0,1,1,1.42,1.42l-8.17,8.17A5,5,0,0,1,12,17.17Z"/></svg>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                              <p>Content for section 1 goes here.</p>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#collapse2">Section 2
                                <?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="16" height="16"><path d="M12,17.17a5,5,0,0,1-3.54-1.46L.29,7.54A1,1,0,0,1,1.71,6.12l8.17,8.17a3,3,0,0,0,4.24,0l8.17-8.17a1,1,0,1,1,1.42,1.42l-8.17,8.17A5,5,0,0,1,12,17.17Z"/></svg>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                              <p>Content for section 2 goes here.</p>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#collapse3">
                                Section 3
                              <?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="16" height="16"><path d="M12,17.17a5,5,0,0,1-3.54-1.46L.29,7.54A1,1,0,0,1,1.71,6.12l8.17,8.17a3,3,0,0,0,4.24,0l8.17-8.17a1,1,0,1,1,1.42,1.42l-8.17,8.17A5,5,0,0,1,12,17.17Z"/></svg>
                            </a>
                            </h4>
                          </div>
                          <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                              <p>Content for section 3 goes here.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                            </div>
                        </div>
            </div>
    </section> --}}
    <!-- نهاية صفحة الأسئلة الشائعة -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-packages', {
            slidesPerView: 3,
            spaceBetween: 24,
            loop: true,
            grabCursor: true,
            speed: 1500,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                "0": {
                    "slidesPerView": 1,
                },
                "880": {
                    "slidesPerView": 2,
                },
                "1025": {
                    "slidesPerView": 3,
                }
            }
        });
        const swiper2 = new Swiper('.swiper-services', {
            slidesPerView: 3,
            spaceBetween: 24,
            loop: true,
            grabCursor: true,
            speed: 1500,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                "0": {
                    "slidesPerView": 1,
                },
                "880": {
                    "slidesPerView": 2,
                },
                "1025": {
                    "slidesPerView": 3,
                }
            }
        });

        const swiper4 = new Swiper('.swiper-subservices', {
            slidesPerView: 3,
            spaceBetween: 24,
            loop: true,
            grabCursor: true,
            speed: 1500,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                "0": {
                    "slidesPerView": 1,
                },
                "880": {
                    "slidesPerView": 2,
                },
                "1025": {
                    "slidesPerView": 3,
                }
            }
        });
        const swiper3 = new Swiper('.swiper-services2', {
            slidesPerView: 3,
            spaceBetween: 24,
            loop: true,
            grabCursor: true,
            speed: 1500,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                "0": {
                    "slidesPerView": 1,
                },
                "880": {
                    "slidesPerView": 2,
                },
                "1025": {
                    "slidesPerView": 3,
                }
            }
        });
    </script>
@endsection
