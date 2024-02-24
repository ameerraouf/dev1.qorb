@extends('teacher.layouts.master')
@section('title', Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/flags.css') }}" type="text/css" />
@endpush
@section('content')

<div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('cruds.Reports.Title') }}</h3>
                <small>
                    <a href="{{ route('teacher.teacherhome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('childrens.index') }}">{{ __('cruds.Childrens.Title') }}</a> /
                    <a >{{ __('cruds.Reports.Title') }}</a>
                </small>
            </div>
        
            @if($reports->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                        </div>
                    </div>
                </div>
            @endif

            @if($reports->total() > 0)
                {{Form::open(['route'=>'CommonQuestionsUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Date_AR') : __('cruds.Reports.Date_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Target_AR') : __('cruds.Reports.Target_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Help_AR') : __('cruds.Reports.Help_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Behaviours_AR') : __('cruds.Reports.Behaviours_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.SuccessNumber_AR') : __('cruds.Reports.SuccessNumber_EN') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($reports as $report)
                            <tr>
                            <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $report->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$report->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td>
                                <td class="h6 text-center">
                                        {{ $report->created_at->format('Y-m-d') }}
                                </td>
                                <td class="h6 text-center">
                                        {{ $report->target }}
                                </td>
                                <td class="h6 text-center">
                                    {!! strlen($report->help_method) > 40 ? substr($report->help_method, 0, 40) . '...' : $report->help_method !!}
                                </td>
                                <td class="h6 text-center">
                                    {!! strlen($report->behaviours) > 40 ? substr($report->behaviours, 0, 40) . '...' : $report->behaviours !!}
                                </td>
                                <td class="h6 text-center">
                                    {{ $report->success_number }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm primary"data-toggle="modal"
                                            data-target="#report-show{{ $report->id }}" ui-toggle-class="bounce"
                                            ui-target="#animate" data-dismiss="modal">
                                        <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.show') }}
                                        </small>
                                    </button>
                                </td>
                            </tr>
                            <!-- .modal -->
                            <div id="report-show{{ $report->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('cruds.Reports.Title') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <div class="form-group row">
                                                <h6
                                                    class="col-sm-4 form-control-label text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Target_AR') : __('cruds.Reports.Target_EN') }}
                                                </h6><br>
                                                <div class="col-sm-8">
                                                    <p>{{$report->target}}</p>
                                                </div>
                                            </div><hr>
                                                <div class="form-group row">
                                                    <h6
                                                        class="col-sm-4 form-control-label text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Help_AR') : __('cruds.Reports.Help_EN') }}
                                                    </h6><br>
                                                    <div class="col-sm-8">
                                                        <p>{!! $report->help_method !!}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <h6
                                                        class="col-sm-4 form-control-label text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.Behaviours_AR') : __('cruds.Reports.Behaviours_EN') }}
                                                    </h6><br>
                                                    <div class="col-sm-8">
                                                            <p>{!! $report->behaviours !!}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <h6
                                                        class="col-sm-4 form-control-label text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Reports.SuccessNumber_AR') : __('cruds.Reports.SuccessNumber_EN') }}
                                                    </h6><br>
                                                    <div class="col-sm-8">
                                                        <h6>{{$report->success_number}}</h6>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.close') }}</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs">
                            <!-- .modal -->
                            <div id="m-all" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ __('backend.confirmationDeleteMsg') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.no') }}</button>
                                            <button type="submit"
                                                    class="btn danger p-x-md">{{ __('backend.yes') }}</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->
                                {{-- <select name="action" id="action" class="form-control c-select w-sm inline v-middle"
                                        required>
                                    <option value="">{{ __('backend.bulkAction') }}</option>
                                    <option value="delete">{{ __('backend.deleteSelected') }}</option>
                                </select>
                                <button type="submit" id="submit_all"
                                        class="btn white">{{ __('backend.apply') }}</button>
                                <button id="submit_show_msg" class="btn white" data-toggle="modal"
                                        style="display: none"
                                        data-target="#m-all" ui-toggle-class="bounce"
                                        ui-target="#animate">{{ __('backend.apply') }}
                                </button> --}}
                        </div>

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $reports->firstItem() }}
                                -{{ $reports->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $reports->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $reports->links() !!}
                        </div>
                    </div>
                </footer>
                {{Form::close()}}
            @endif
        </div>
    </div>

@endsection
