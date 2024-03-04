@extends('teacher.layouts.master')
@section('title', Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/flags.css') }}" type="text/css" />
@endpush
@section('content')

<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3><i class="material-icons">&#xe3c9;</i> {{ __('backend.editUser') }}</h3>
            <small>
                <a href="{{ route('teacher.teacherhome') }}">{{ __('backend.home') }}</a> /
                <a href="">{{ __('backend.profile') }}</a>
                
            </small>
        </div>
       
        <div class="box-body">
            {{Form::open(['route'=>['teacherProfileUpdate'],'method'=>'POST', 'files' => true])}}

            <div class="form-group row">
                <label for="name"
                       class="col-sm-2 form-control-label">{!!  __('backend.fullName') !!}
                </label>
                <div class="col-sm-4">
                    {!! Form::text('name',$user->name, array('placeholder' => '','class' => 'form-control','id'=>'name','required'=>'')) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="photo_file"
                       class="col-sm-2 form-control-label">{!!  __('backend.topicPhoto') !!}</label>
                <div class="col-sm-4">
                    @if($user->photo)
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="user_photo" class="col-sm-4 box p-a-xs">
                                    <a target="_blank"
                                       href="{{ asset('uploads/users/'.$user->photo) }}"><img
                                            src="{{ asset('uploads/users/'.$user->photo) }}"
                                            class="img-responsive">
                                        {{ $user->photo }}
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

                    {!! Form::file('photo', array('class' => 'form-control','id'=>'photo','accept'=>'image/*')) !!}
                    <small>
                        <i class="material-icons">&#xe8fd;</i>
                        {!!  __('backend.imagesTypes') !!}
                    </small>
                </div>
            </div>
         
            <div class="form-group row">
                <label for="email"
                       class="col-sm-2 form-control-label">{!!  __('backend.loginEmail') !!}
                </label>
                <div class="col-sm-4">
                    {!! Form::email('email',$user->email, array('placeholder' => '','class' => 'form-control','id'=>'email','required'=>'')) !!}
                </div>
            </div>  
            
            <div class="form-group row">
                <label for="phone"
                       class="col-sm-2 form-control-label">{!!  __('backend.phone') !!}
                </label>
                <div class="col-sm-4">
                    {!! Form::text('phone',$user->phone, array('placeholder' => '','class' => 'form-control','id'=>'phone','required'=>'')) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="password"
                       class="col-sm-2 form-control-label">{!!  __('backend.loginPassword') !!}
                </label>
                <div class="col-sm-4">
                    <input type="password" name="password" minlength="6" class="form-control">
                </div>
            </div>



            <div class="form-group row m-t-md">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                            &#xe31b;</i> {!! __('backend.update') !!}</button>
                    {{-- <a href="{{route("Profile")}}"
                       class="btn btn-default m-t"><i class="material-icons">
                            &#xe5cd;</i> {!! __('backend.cancel') !!}</a> --}}
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>

@endsection
