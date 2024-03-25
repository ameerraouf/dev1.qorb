@extends('dashboard.layouts.master')
@section('title', __('cruds.SetChild') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('cruds.SetChild') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('SetChildTo') }}">{{ __('cruds.SetChild') }}</a> /
                    <a href="">{{ __('cruds.SetChild') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("SetChildTo")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['UpdateSetChild', $children->id],'method'=>'POST', 'files' => true ])}}

                <div class="form-group row">
                    <label for="image"
                           class="col-sm-2 form-control-label">{{ __('cruds.Childrens.childrenname') }}</label>
                    <div class="col-sm-10">
                        <select name="child" id="" class="form-control">
                            <option value="" selected disabled hidden>{{ $children->name }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="User"
                           class="col-sm-2 form-control-label">{{ __('cruds.Childrens.Specialist') }}
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" name="specialist" required>
                            <option value="" selected disabled hidden>{{ $children->specialist->name }}</option>    
                            @foreach ($specialists as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="User"
                           class="col-sm-2 form-control-label">{{ __('cruds.Childrens.Supervisor') }}
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" name="supervisor" required>
                            <option value="" selected disabled hidden>{{ $children->supervisor->name }}</option>    
                            @foreach ($supervisors as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.add') !!}</button>
                        <a href="{{route("SetChildTo")}}"
                           class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
