@extends('supervisor.layouts.master')
@section('title', __('cruds.Reports.Vbmap') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.Reports.EditReport') }}</h3>
                <small>
                    <a href="{{ route('supervisorHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('showChildrenVbmap',$children_id) }}">{{ __('cruds.Reports.Vbmap') }}</a> /
                    <a href="">{{ __('cruds.Reports.EditReport') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route('showChildrenVbmap',$children_id)}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['updateVbmap',$report->id],'method'=>'POST', 'files' => true ])}}

                
            <div class="form-group row">
                <label for="photo_file"
                       class="col-sm-2 form-control-label">{!!  __('backend.topicPhoto') !!}</label>
                <div class="col-sm-10">
                    {{ Form::hidden('children_id', $report->id) }}
                    @if($report->file)
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="user_photo" class="col-sm-4 box p-a-xs">
                                    <a target="_blank"
                                       href="{{ asset('uploads/reports/'.$report->file) }}"><img
                                            src="{{ asset('uploads/reports/'.$report->file) }}"
                                            class="img-responsive">
                                        {{ $report->photo }}
                                    </a>
                                    <br>
                                    <a onclick="document.getElementById('user_photo').style.display='none';document.getElementById('photo_delete').value='1';document.getElementById('undo').style.display='block';"
                                       class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                </div>
                                <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                    <a onclick="document.getElementById('user_photo').style.display='block';document.getElementById('photo_delete').value='0';document.getElementById('undo').style.display='none';">
                                        <i class="material-icons">&#xe166;</i> {!!  __('backend.undoDelete') !!}
                                    </a>
                                </div>

                                {!! Form::hidden('photo_delete','0', array('id'=>'photo_delete')) !!}
                            </div>
                        </div>
                    @endif

                    {!! Form::file('file', array('class' => 'form-control','id'=>'photo','accept'=>'image/*')) !!}
                    <small>
                        <i class="material-icons">&#xe8fd;</i>
                        {!!  __('backend.imagesTypes') !!}
                    </small>
                </div>
            </div>
                
                  
                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.update') !!}</button>
                        <a href="{{route('showChildrenVbmap', $children_id)}}"
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
