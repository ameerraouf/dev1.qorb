@extends('supervisor.layouts.master')
@section('title', __('cruds.Reports.FinalReport') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.Reports.NewReport') }}</h3>
                <small>
                    <a href="{{ route('supervisorHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('showChildrenFinalReports', $child_id) }}">{{ __('cruds.Reports.FinalReport') }}</a> /
                    <a href="">{{ __('cruds.Reports.NewReport') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route('showChildrenFinalReports',$child_id)}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['storeFinalReport',$child_id],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="target"
                           class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Target_AR') : __('cruds.Reports.Target_EN') }}
                    </label>
                    <div class="col-sm-10">
                        {{ Form::hidden('children_id', $child_id) }}
                        {!! Form::text('target','', array('placeholder' => '','class' => 'form-control','id'=>'target','required'=>'')) !!}

                    </div>
                </div>
               

                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Develop') : __('cruds.Reports.Develop') }}
                        </label>
                        <div class="col-sm-10">
                            
                                <div class="box p-a-xs">
                                    {{ Form::number('develop', '' , array('placeholder' => '','class' => 'form-control','id'=>'type','required'=>'')) }}
                                </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                            class="col-sm-2 form-control-label">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Recommend') : __('cruds.Reports.Recommend') }}
                        </label>
                        <div class="col-sm-10">
                            
                                <div class="box p-a-xs">
                                    {!! Form::text('recommends' , '' ,array('placeholder' => '','class' => 'form-control','id'=>'type','required'=>'')) !!}
                                </div>
                        </div>
                    </div> 

                  
                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.add') !!}</button>
                        <a href="{{route('showChildrenFinalReports', $child_id)}}"
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
