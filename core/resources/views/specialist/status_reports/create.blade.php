@extends('specialist.layouts.master')
@section('title', __('cruds.Reports.Status') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.Reports.NewReport') }}</h3>
                <small>
                    <a href="{{ route('specialistHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('ChildrenStatusReports', $child_id) }}">{{ __('cruds.Reports.Status') }}</a> /
                    <a href="">{{ __('cruds.Reports.NewReport') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route('ChildrenStatusReports',$child_id)}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['StatustoreVbmap',$child_id],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="target"
                           class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Companion_AR') : __('cruds.Reports.Companion_EN') }}
                    </label>
                    <div class="col-sm-10">
                        {{ Form::hidden('children_id', $child_id) }}
                        {!! Form::text('companion','', array('placeholder' => '','class' => 'form-control','id'=>'type','required'=>'')) !!}
                    </div>
                </div>
                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Status_type_AR') : __('cruds.Reports.Status_type_EN') }}
                        </label>
                        <div class="col-sm-10">
                                <div class="box p-a-xs">
                                    <select name="status_type" class="form-control">
                                        <option value="" selected hidden disabled>{{ __('cruds.Reports.ChooseStatus') }}</option>
                                        <option value="online">Online</option>
                                        <option value="Offline">Offline</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.StrengthWeakness_AR') : __('cruds.Reports.StrengthWeakness_EN') }}
                        </label>
                        <div class="col-sm-10">
                                <div class="box p-a-xs">
                                    {!! Form::textarea('strength_weakness','<div dir='.@$ActiveLanguage->direction.'><br></div>', array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                            onImageUpload: function(files, editor, welEditable) {
                                                sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                            }
                                        }}'))
                                    !!}
                                </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Reinforcers_AR') : __('cruds.Reports.Reinforcers_EN') }}
                        </label>
                        <div class="col-sm-10">
                                <div class="box p-a-xs">
                                    {!! Form::textarea('reinforcers','<div dir='.@$ActiveLanguage->direction.'><br></div>', array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                            onImageUpload: function(files, editor, welEditable) {
                                                sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                            }
                                        }}'))
                                    !!}
                                </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Target_AR') : __('cruds.Reports.Target_EN') }}
                        </label>
                        <div class="col-sm-10">
                                <div class="box p-a-xs">
                                    {!! Form::textarea('status_target','<div dir='.@$ActiveLanguage->direction.'><br></div>', array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                            onImageUpload: function(files, editor, welEditable) {
                                                sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                            }
                                        }}'))
                                    !!}
                                </div>
                        </div>
                    </div>
                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.add') !!}</button>
                        <a href="{{route('ChildrenStatusReports', $child_id)}}"
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
    @include('specialist.layouts.editor')
@endpush
