@extends('dashboard.layouts.master')
@section('title', __('cruds.MainServices.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.MainServices.EditMainService') }} </h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('MainServices') }}">{{ __('cruds.MainServices.Title') }}</a> /
                    <a href=""> {{ __('cruds.MainServices.EditMainService') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("MainServices")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['MainServicesUpdate',$main_service->id],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="name_en"
                           class="col-sm-2 form-control-label">{{ __('cruds.MainServices.MainService_EN') }}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('name_en',$main_service->name_en, array('placeholder' => '','class' => 'form-control','id'=>'name_en','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name_ar"
                           class="col-sm-2 form-control-label">{{ __('cruds.MainServices.MainService_AR') }}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('name_ar',$main_service->name_ar, array('placeholder' => '','class' => 'form-control','id'=>'name_ar','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.update') !!}</button>
                        <a href="{{route("MainServices")}}"
                           class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@push("after-scripts")
    <script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
    @include('dashboard.layouts.editor')
@endpush
