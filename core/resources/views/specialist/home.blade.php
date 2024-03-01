@extends('specialist.layouts.master')
@section('title', Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/flags.css') }}" type="text/css" />
    <link href="{{ asset('assets/dashboard/js/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"
        type="text/css" />
@endpush

@section('content')

    <div class="padding p-b-0">
        <div class="margin">
            <h5 class="m-b-0 _300">{{ __('backend.hi') }} <span class="text-primary">{{ Auth::user()->name }}</span>,
                {{ __('backend.welcomeBack') }}
            </h5>
        </div>
        <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <a href="#" class="box-color box-flex p-a-2 primary">
                <div class="pull-right m-l">
                    <span class="w-56 dker text-center rounded d-inline-flex align-items-center justify-content-center">
                    <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="clear">
                    <h3 class="m-a-0 text-lg">{{ $childrenCount }}</h3>
                    <small class="text-muted">{{__('backend.ChildrenCount')}}</small>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('Childrens') }}" class="box-color box-flex p-a-2 blue">
                <div class="pull-right m-l">
                    <span class="w-56 dker text-center rounded d-inline-flex align-items-center justify-content-center">
                    <i class="fa fa-child fa-2x" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="clear">
                    <h3 class="m-a-0 text-lg"></h3>
                    <small class="text-muted">{{__('cruds.Childrens.Title')}}</small>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('FTransactions') }}" class="box-color box-flex p-a-2 accent">
                <div class="pull-right m-l">
                    <span class="w-56 dker text-center rounded d-inline-flex align-items-center justify-content-center">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="clear">
                    <h3 class="m-a-0 text-lg"></h3>
                    <small class="text-muted">{{__('cruds.FinancialTransactions.Title')}}</small>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('Profile') }}" class="box-color box-flex p-a-2 warn">
                <div class="pull-right m-l">
                    <span class="w-56 dker text-center rounded d-inline-flex align-items-center justify-content-center">
                    <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="clear">
                    <h3 class="m-a-0 text-lg"></h3>
                    <small class="text-muted">{{__('backend.profile')}}</small>
                </div>
            </a>
        </div>
    </div>


    </div>

    @endsection
