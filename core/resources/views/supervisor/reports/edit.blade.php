@extends('supervisor.layouts.master')
@section('title', __('cruds.Reports.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.Reports.EditReport') }}</h3>
                <small>
                    <a href="{{ route('supervisorHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('SChildrenReports',$children_id) }}">{{ __('cruds.Reports.Title') }}</a> /
                    <a href="">{{ __('cruds.Reports.EditReport') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route('SChildrenReports',$children_id)}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['SReportUpdate',$report->id],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="target"
                           class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Target_AR') : __('cruds.Reports.Target_EN') }}
                    </label>
                    <div class="col-sm-10">
                        {{ Form::hidden('children_id', $report->id) }}
                        {!! Form::text('target',$report->target , array('placeholder' => '','class' => 'form-control','id'=>'target','required'=>'')) !!}
                    </div>
                </div>

                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Help_AR') : __('cruds.Reports.Help_EN') }}
                        </label>
                        <div class="col-sm-10">
                            
                                <div class="box p-a-xs">
                                    {!! Form::textarea('help_method','<div dir='.@$ActiveLanguage->direction.'><br>'.$report->help_method.'</div>', array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
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
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Behaviours_AR') : __('cruds.Reports.Behaviours_EN') }}
                        </label>
                        <div class="col-sm-10">
                            
                                <div class="box p-a-xs">
                                    {!! Form::textarea('behaviours','<div dir='.@$ActiveLanguage->direction.'><br>'.$report->behaviours.'</div>', array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                            onImageUpload: function(files, editor, welEditable) {
                                                sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                            }
                                        }}'))
                                    !!}
                                </div>
                            
                        </div>
                    </div>
                                        
                    <div class="form-group row">
                        <label for="target"
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.SuccessNumber_AR') : __('cruds.Reports.SuccessNumber_EN') }}
                        </label>
                        <div class="col-sm-10">
                            {!! Form::number('success_number',$report->success_number, array('placeholder' => '','class' => 'form-control','id'=>'success_number','required'=>'')) !!}
                        </div>
                </div>
                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.update') !!}</button>
                        <a href="{{route('SChildrenReports', $children_id)}}"
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
    @include('supervisor.layouts.editor')
@endpush
