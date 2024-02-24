@extends('supervisor.layouts.master')
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
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="box p-a" style="cursor: pointer"
                onclick="location.href='#'">
                <a href="#">
                    <div class="pull-left m-r">
                        <i
                            class="material-icons text-2x m-y-sm"></i>
                    </div>
                    <div class="clear">
                        <div class="text-muted">{{__('backend.ChildrenCount')}}</div>
                        <h4 class="m-a-0 text-md _600">
                            {{ $childrenCount }}</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="box p-a" style="cursor: pointer"
                onclick="location.href='{{ route('Childrens') }}'">
                <a href="{{ route('Childrens') }}">
                    <div class="pull-left m-r">
                        <i
                            class="material-icons text-2x m-y-sm"></i>
                    </div>
                    <div class="clear">
                        <div class="text-muted">{{__('cruds.Childrens.Title')}}</div>
                        <h4 class="m-a-0 text-md _600"></h4>
                    </div>
                </a>
            </div>
        </div> 
        
        <div class="col-xs-3">
            <div class="box p-a" style="cursor: pointer"
                onclick="location.href='{{ route('FTransactions') }}'">
                <a href="{{ route('FTransactions') }}">
                    <div class="pull-left m-r">
                        <i
                            class="material-icons text-2x m-y-sm"></i>
                    </div>
                    <div class="clear">
                        <div class="text-muted">{{__('cruds.FinancialTransactions.Title')}}</div>
                        <h4 class="m-a-0 text-md _600"></h4>
                    </div>
                </a>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="box p-a" style="cursor: pointer"
                onclick="location.href='{{ route('Profile') }}'">
                <a href="{{ route('Profile') }}">
                    <div class="pull-left m-r">
                        <i
                            class="material-icons text-2x m-y-sm"></i>
                    </div>
                    <div class="clear">
                        <div class="text-muted">{{__('backend.profile')}}</div>
                        <h4 class="m-a-0 text-md _600"></h4>
                    </div>
                </a>
            </div>
        </div>
    </div> 
        

@endsection
