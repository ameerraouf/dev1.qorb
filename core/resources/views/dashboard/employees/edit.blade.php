@extends('dashboard.layouts.master')
@section('title', __('backend.employees'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="">{{ __('backend.employees') }}</a> /
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("employees")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['employeesUpdate',$employee->id],'method'=>'POST', 'files' => true])}}

                <div class="form-group row">
                    <label for="name"
                           class="col-sm-2 form-control-label">{!!  __('backend.fullName') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('name',$employee->name, array('placeholder' => '','class' => 'form-control','id'=>'name','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email"
                           class="col-sm-2 form-control-label">{!!  __('backend.loginEmail') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::email('email',$employee->email, array('placeholder' => '','class' => 'form-control','id'=>'email','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone"
                           class="col-sm-2 form-control-label">{!!  __('backend.phone') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('phone',$employee->phone, array('placeholder' => '','class' => 'form-control','id'=>'phone','required'=>'')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password"
                           class="col-sm-2 form-control-label">{!!  __('backend.loginPassword') !!}
                    </label>
                    <div class="col-sm-10">
                        <input type="password" name="password" minlength="6" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="photo_file"
                           class="col-sm-2 form-control-label">{!!  __('backend.topicPhoto') !!}</label>
                    <div class="col-sm-10">
                        @if($employee->photo!="")
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="user_photo" class="col-sm-4 box p-a-xs">
                                        <a target="_blank"
                                           href="{{ asset('uploads/employees/'.$employee->photo) }}"><img
                                                src="{{ asset('uploads/employees/'.$employee->photo) }}"
                                                class="img-responsive">
                                            {{ $employee->photo }}
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
                        <label for="permissions1"
                               class="col-sm-2 form-control-label">{!!  __('backend.role') !!}</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <select name="role" id="role_id" required
                                        class="form-control c-select">
                                    <option value="{{ $employee->role  }}" hidden>{{ $employee->role  }}</option>
                                    <option value="specialist">{!!  __('backend.Specialist') !!}</option>
                                    <option value="supervisor">{!!  __('backend.Supervisor') !!}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.update') !!}</button>
                        <a href="{{route("employees")}}"
                           class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
