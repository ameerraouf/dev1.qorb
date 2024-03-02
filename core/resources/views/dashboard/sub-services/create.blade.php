@extends('dashboard.layouts.master')
@section('title', __('cruds.SubServices.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.SubServices.NewSubService') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('SubServices') }}">{{ __('cruds.SubServices.Title') }}</a> /
                    <a href="">{{ __('cruds.SubServices.NewSubService') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("SubServices")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">

                {{Form::open(['route'=>['SubServicesStore'],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="MainServices"
                            class="col-sm-2 form-control-label">{{ __('cruds.SubServices.MainService') }}
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" required name="main_service_id">
                            <option value="" selected disabled hidden>{{ __('cruds.SubServices.SelectMainService') }}</option>
                            @foreach ($main_services as $main_service)
                                <option value="{{ $main_service->id }}">{{ $main_service->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="title_en"
                    class="col-sm-2 form-control-label">{{ __('cruds.SubServices.Title_EN') }}</label>
                    <div class="col-sm-10">
                        {!! Form::text('title_en', '' ,array('class' => 'form-control','id'=>'title_en','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">{{ __('cruds.SubServices.Title_AR') }}</label>
                    <div class="col-sm-10">
                        {!! Form::text('title_ar', '' ,array('class' => 'form-control','id'=>'title_ar','required'=>'')) !!}
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
                        <a href="{{route("SubServices")}}"
                           class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
