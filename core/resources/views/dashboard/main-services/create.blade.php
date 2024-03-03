@extends('dashboard.layouts.master')
@section('title', __('cruds.MainServices.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.MainServices.NewMainService') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('MainServices') }}">{{ __('cruds.MainServices.Title') }}</a> /
                    <a href="">{{ __('cruds.MainServices.NewMainService') }}</a>
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
                {{Form::open(['route'=>['MainServicesStore'],'method'=>'POST' ])}}

                <div class="form-group row">
                    <label for="main_service_en"
                           class="col-sm-2 form-control-label">{{ __('cruds.MainServices.MainService_EN') }}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('main_service_en','', array('placeholder' => '','class' => 'form-control','id'=>'main_service_en','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="main_service_ar"
                           class="col-sm-2 form-control-label">{{ __('cruds.MainServices.MainService_AR') }}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('main_service_ar','', array('placeholder' => '','class' => 'form-control','id'=>'main_service_ar','required'=>'')) !!}
                    </div>
                </div>

                @foreach(Helper::languagesList() as $ActiveLanguage)
                    @if($ActiveLanguage->box_status)
                        <div class="form-group row">
                            <label
                                class="col-sm-2 form-control-label">{{ $ActiveLanguage->code === 'ar' ? __('cruds.SubServices.Description_AR') : __('cruds.SubServices.Description_EN') }} {!! @Helper::languageName($ActiveLanguage) !!}
                            </label>
                            <div class="col-sm-10">
                                @if (Helper::GeneralWebmasterSettings("text_editor") == 2)
                                    <div>
                                        {!! Form::textarea('description_'.@$ActiveLanguage->code,'<div dir='.@$ActiveLanguage->direction.'><br></div>', array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                    </div>
                                @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                    <div>
                                        {!! Form::textarea('description_'.@$ActiveLanguage->code,'<div dir='.@$ActiveLanguage->direction.'><br></div>', array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                    </div>
                                @else
                                    <div class="box p-a-xs">
                                        {!! Form::textarea('description_'.@$ActiveLanguage->code,'<div dir='.@$ActiveLanguage->direction.'><br></div>', array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                                onImageUpload: function(files, editor, welEditable) {
                                                    sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                                }
                                            }}'))
                                        !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.add') !!}</button>
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
