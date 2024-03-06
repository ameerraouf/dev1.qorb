@extends('dashboard.layouts.master')
@section('title',__('cruds.EarlyDetectionReports.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.EarlyDetectionReports.AddReport') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('EarlyDetectionReports') }}">{{__('cruds.EarlyDetectionReports.Title') }}</a> /
                    <a href="">{{ __('cruds.EarlyDetectionReports.AddReport') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("EarlyDetectionReports")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['StoreEarlyDetectionReports'],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="question_en"
                           class="col-sm-2 form-control-label">{{ __('cruds.EarlyDetectionReports.ChildName') }}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::hidden('child_id',$child->id, array('placeholder' => '','class' => 'form-control','id'=>'question_en','readonly'=>'')) !!}
                    </div>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly value="{{ $child->name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="question_ar"
                           class="col-sm-2 form-control-label">{{ __('cruds.EarlyDetectionReports.File') }}
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-12">
                                {!! Form::file('file', array('class' => 'form-control','id'=>'photo','accept'=>'image/*')) !!}
                                <small>
                                    <i class="material-icons">&#xe8fd;</i>
                                    {!!  __('backend.imagesTypes') !!}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.add') !!}</button>
                        <a href="{{route("EarlyDetectionReports")}}"
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
