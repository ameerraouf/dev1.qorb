@extends('frontEnd.layout')

@section('content')

    <section id="inner-headline">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('Home') }}"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i>
                        </li>
                        <li class="active">{{ __('cruds.Society.Title') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="content">
        <div class="container">
            <!-- بداية صفحة المجتمع -->
            <section class="content-row-no-bg" style="margin-top:2%; padding: 0 0 0 0">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="home-row-head">
                                <h2 class="heading">{{ __('cruds.MainServices.Title') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="panel-group mian-accordion" id="accordion">
                                <div class="boxes-faq">
                                    <div class="">
                                        <div class="content">
                                            <h3 class="title">
                                                @if(app()->getLocale() == 'ar')
                                                    {{ $main_service->name_ar }}
                                                @else
                                                    {{ $main_service->name_en }}
                                                @endif
                                            </h3>
                                        </div>

                                        <div class="content">
                                            <p class="title">
                                                @if(app()->getLocale() == 'ar')
                                                    {!! $main_service->description_ar !!}
                                                @else
                                                    {!!  $main_service->description_en !!}
                                                @endif
                                            </p>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="home-row-head">
                                <h2 class="heading">{{ __('cruds.SubServices.Title') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="panel-group mian-accordion" id="accordion">
                                <div class="boxes-faq">
                                    @foreach ($main_service->subServices as $sub_service)
                                        <div class="">
                                            <div class="content">
                                                <h3 class="title">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{ $sub_service->title_ar }}
                                                    @else
                                                        {{ $sub_service->title_en }}
                                                    @endif
                                                </h3>
                                            </div>

                                            <div class="content">
                                                <p class="title">
                                                    @if(app()->getLocale() == 'ar')
                                                        {!! $sub_service->description_ar !!}
                                                    @else
                                                        {!! $sub_service->description_en !!}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- نهاية صفحة المجتمع -->
        </div>
    </section>

@endsection
