@extends('teacher.layouts.master')
@section('title', Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/flags.css') }}" type="text/css" />
@endpush
@section('content')

    <div class="padding p-b-0">
        <div class="margin">
            <h5 class="m-b-0 _300">{{ __('backend.hi') }} <span class="text-primary">{{ Auth::user()->name }}</span>,
                {{ __('backend.welcomeBack') }}
            </h5>
        </div>



        <div class="row">
            <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="box-color p-a-3 warn" onclick="location.href='{{ route('childrens.index') }}'">
                    <div class="pull-right m-l">
                        <span class="w-56 dker text-center rounded">
                            <i class="text-lg material-icons">&#xe54b;</i>
                        </span>
                    </div>
                    <div class="clear" onclick="location.href='{{ route('childrens.index') }}'">
                        <h3 class="m-a-0 text-lg"><a href="{{ route('childrens.index') }}"></a></h3>
                        <small class="text-muted">{{ __('backend.childrens') }}</small>
                    </div>
                </div>
            </div>

        </div>



        <div class="row">
            <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="box-color p-a-3 primary" onclick="location.href='{{ route('TeacherPackages') }}'">
                    <div class="pull-right m-l">
                        <span class="w-56 dker text-center rounded">
                            <i class="text-lg material-icons">&#xe7fb;</i>
                        </span>
                    </div>
                    <div class="clear">
                        <h3 class="m-a-0 text-lg"><a href></a></h3>
                        <small class="text-muted">{{ __('backend.packages') }}</small>
                    </div>
                </div>

            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="box-color p-a-3 warn" onclick="location.href='{{ route('TeacherProfile') }}'">
                    <div class="pull-right m-l">
                        <span class="w-56 dker text-center rounded">
                            <i class="text-lg material-icons">&#xe54b;</i>
                        </span>
                    </div>
                    <div class="clear" onclick="location.href='{{ route('TeacherProfile') }}'">
                        <h3 class="m-a-0 text-lg"><a href="{{ route('TeacherProfile') }}"></a></h3>
                        <small class="text-muted">{{ __('backend.profile') }}</small>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @endsection
