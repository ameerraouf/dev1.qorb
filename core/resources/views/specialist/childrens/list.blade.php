@extends('specialist.layouts.master')
@section('title', Helper::GeneralSiteSettings('site_title_' . @Helper::currentLanguage()->code))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/flags.css') }}" type="text/css" />
@endpush
@section('content')

<div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('cruds.Childrens.Title') }}</h3>
                <small>
                    <a href="{{ route('specialistHome') }}">{{ __('backend.home') }}</a> /
                    <a >{{ __('cruds.Childrens.Title') }}</a>
                </small>
            </div>
           
            @if($childrens->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                            <br>
                            @if(@Auth::user()->permissionsGroup->webmaster_status)
                                <br>
                                <a class="btn btn-fw primary" href="{{route("ChildrenCreate")}}">
                                    <i class="material-icons">&#xe7fe;</i>
                                    &nbsp; {{ __('cruds.childrens.NewChildren') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($childrens->total() > 0)
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
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Childrens.Name_AR') : __('cruds.Childrens.Name_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Childrens.Age_AR') : __('cruds.Childrens.Age_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Childrens.Problem_AR') : __('cruds.Childrens.Problem_EN') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Childrens.Files') : __('cruds.Childrens.Files') }}</th>
                            <th class="text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Childrens.Reports_AR') : __('cruds.Childrens.Reports_EN') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($childrens as $children)
                            <tr>
                            <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $children->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$children->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td>
                                <td class="h6 text-center">
                                        {{ $children->name }}
                                </td>
                                <td class="h6 text-center">
                                        {{ $children->age }}
                                </td>
                                <td class="h6 text-center">
                                {!! strlen($children->problem) > 40 ? substr($children->problem, 0, 40) . '...' : $children->problem !!}
                                </td>
                                <td class="h6 text-center">
                                    @foreach($children->media as $media)
                                        <a href="{{ route('DownloadFile',$media->file_name) }}" class="btn btn-primary" style="display: block;">{{ $media->file_name }}</a></br>                                
                                    @endforeach
                                </td>
                                <td class="h6 text-center">
                                    <a href="{{ route('ChildrenReports' , $children->id) }}" class="btn btn-primary" style="display: block;">{{ __('cruds.Reports.Title') }}</a><br>
                                    <a href="{{ route('ChildrenConsultingReports', $children->id) }}" class="btn btn-primary" style="display: block;">{{ __('cruds.Reports.Consulting') }}</a><br>
                                    <a href="{{ route('ChildrenStatusReports', $children->id) }}" class="btn btn-primary" style="display: block;">{{ __('cruds.Reports.Status') }}</a><br>
                                </td>
                            </tr>
                           
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
                                <select name="action" id="action" class="form-control c-select w-sm inline v-middle"
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
                                </button>
                        </div>

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $childrens->firstItem() }}
                                -{{ $childrens->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $childrens->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $childrens->links() !!}
                        </div>
                    </div>
                </footer>
                {{Form::close()}}
            @endif
        </div>
    </div>

@endsection
