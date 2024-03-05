@extends('dashboard.layouts.master')
@section('title', __('cruds.FinancialTransactions.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i>{{ __('cruds.FinancialTransactions.EditPayment') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('financial-transactions') }}">{{ __('cruds.FinancialTransactions.Title') }}</a> /
                    <a>{{ __('cruds.FinancialTransactions.EditPayment') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("financial-transactions")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['financialTransactionsUpdate',$transaction->id],'method'=>'POST', 'files' => true])}}

                {{-- <div class="form-group row">
                    <label for="name"
                           class="col-sm-2 form-control-label">{{ __('cruds.FinancialTransactions.Name') }}</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', $transaction->name ,array('class' => 'form-control','id'=>'name','required'=>'')) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <label for="name"
                           class="col-sm-2 form-control-label">{{ __('cruds.FinancialTransactions.Name') }}
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" name="user">
                            <option value="" selected disabled hidden>Choose a user</option>    
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="photo_file"
                           class="col-sm-2 form-control-label">{{ __('cruds.FinancialTransactions.CopyOfTheBankTransfer') }}</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="transaction_image" class="col-sm-4 box p-a-xs">
                                    <a target="_blank"
                                        href="{{ asset('uploads/financial-transactions/'.$transaction->image) }}"><img
                                            src="{{ asset('uploads/financial-transactions/'.$transaction->image) }}"
                                            class="img-responsive">
                                        {{ $transaction->image }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {!! Form::file('image', array('class' => 'form-control','id'=>'image','accept'=>'image/*')) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!!  __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="permissions1"
                           class="col-sm-2 form-control-label">{{ __('cruds.FinancialTransactions.Notes') }}</label>
                    <div class="col-sm-10">
                        {!! Form::textarea('notes',$transaction->notes, array('placeholder' => '','class' => 'form-control','id'=>'notes','rows'=>'3')) !!}
                    </div>
                </div>

                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.update') !!}</button>
                        <a href="{{route("financial-transactions")}}"
                           class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
