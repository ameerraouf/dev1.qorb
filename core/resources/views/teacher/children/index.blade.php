@extends('teacher.layouts.master')
@section('title',__('backend.childrens'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('backend.childrens') }}</h3>
                <small>
                    <a href="{{ route('teacher.teacherhome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('childrens.index') }}">{{ __('backend.childrens') }}</a>
                </small>
            </div>
            {{-- @if($packages->total() > 0) --}}
                {{-- @if(@Auth::user()->permissionsGroup->webmaster_status) --}}
                    <div class="row p-a pull-right" style="margin-top: -70px;">
                        <div class="col-sm-12">
                            <a class="btn btn-fw primary" href="{{route("childrens.create")}}">
                                <i class="fa fa-plus"></i>{{ __('backend.add') }}
                            </a>
                        </div>
                    </div>
                {{-- @endif --}}
            {{-- @endif --}}

            {{-- @if($packages->total() == 0) --}}
                {{-- <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                            <br>
                            @if(@Auth::user()->permissionsGroup->webmaster_status)
                                <br>
                                <a class="btn btn-fw primary" href="{{route("childrens.create")}}">
                                    <i class="fa fa-plus"></i>{{ __('backend.add') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div> --}}
            {{-- @endif --}}

            @if($childrens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th>
                            <th class="text-center" style="width:100px;">#</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.childname') }}</th>
                            <th class="text-center" style="width:50px;">{{ __('backend.childage') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.childproblem') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.attachment') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.reports') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($childrens as $index=>$child)
                                <tr>
                                    <td class="dker"><label class="ui-check m-a-0">
                                            <input type="checkbox" name="ids[]" value="{{ $child->id }}"><i
                                                class="dark-white"></i>
                                            {!! Form::hidden('row_ids[]',$child->id, array('class' => 'form-control row_no')) !!}
                                        </label>
                                    </td>
                                    <td class="h6 text-center">{{ $index +1 }}</td>
                                    {{-- <td class="h6 text-center" title="{{ app()->getLocale() == 'ar' ? strip_tags($child->name_ar) : strip_tags($child->name_en)}}">
                                        @if(app()->getLocale() == 'ar')
                                            {!! strlen($child->name_ar) > 40 ? substr($child->name_ar, 0, 40) . '...' : $child->name_ar!!}
                                        @else
                                            {!! strlen($child->name_en) > 40 ? substr($child->name_en, 0, 40) . '...' : $child->name_en!!}
                                        @endif
                                    </td> --}}
                                    <td class="h6 text-center" title="{{ strip_tags($child->name)}}">
                                            {!! strlen($child->name) > 40 ? substr($child->name, 0, 40) . '...' : $child->name!!}
                                    </td>
                                    <td class="h6 text-center">{{ $child->age }} {{ __('backend.year') }}</td>
                                    <td class="h6 text-center" title="{{strip_tags($child->problem) }}">
                                            {!! strlen($child->problem) > 40 ? substr($child->problem, 0, 40) . '...' : $child->problem!!}
                                    </td>
                                    {{-- <td class="h6 text-center" title="{{ app()->getLocale() == 'ar' ? strip_tags($child->problem_ar) : strip_tags($child->problem_en)}}">
                                        @if(app()->getLocale() == 'ar')
                                            {!! strlen($child->problem_ar) > 40 ? substr($child->problem_ar, 0, 40) . '...' : $child->problem_ar!!}
                                        @else
                                            {!! strlen($child->problem_en) > 40 ? substr($child->problem_en, 0, 40) . '...' : $child->problem_en!!}
                                        @endif
                                    </td> --}}
                                    <td class="h6 text-center">
                                        @if($child->media()->count() > 0)
                                            @foreach($child->media as $key=>$media)
                                                <div class="col-md-6 " style="padding: 10px;">
                                                    @if (in_array($media->file_type, ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'], true))
                                                        <a href="{{ asset('uploads/children/' . $media->file_name) }}" class="btn btn-warning btn-sm " >
                                                            {{ __('backend.image') }}{{ $key+1 }}
                                                        </a>
                                                    @elseif ($media->file_type === 'application/pdf')
                                                        <a href="{{ asset('uploads/children/' . $media->file_name) }}" target="_blank" class="btn btn-primary btn-sm" >
                                                            {{ __('backend.file') }}{{ $key+1 }}
                                                        </a>
                                                    @else
                                                        <a href="{{ asset('uploads/children/' . $media->file_name) }}" target="_blank">{{ $media->file_name }}</a><br>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class=" h6 text-center">
                                        <div class="dropdown" >
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              {{ __('backend.reports') }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                                              {{-- <a class="dropdown-item" href="#">{{ __('backend.reports') }}</a> --}}
                                              <a class="dropdown-item" href="{{ route('TeacherReports',$child->id) }}">{{ __('backend.SessionReports') }}</a>
                                              <a class="dropdown-item" href="{{ route('TeacherStatusReports', $child->id) }}">{{ __('backend.CaseReports') }}</a>
                                              <a class="dropdown-item" href="{{ route('TeacherConsultingReports',$child->id) }}">{{ __('backend.ConsultationReports') }}</a>
                                              <a class="dropdown-item" href="{{ route('TshowChildrenTreatmentPlan',$child->id) }}">{{ __('backend.TreatmentPlan') }}</a>
                                              <a class="dropdown-item" href="{{ route('TshowChildrenVbmap',$child->id) }}">{{ __('backend.VBMAPEvaluation') }}</a>
                                              <a class="dropdown-item" href="{{ route('TshowChildrenFinalReports',$child->id) }}">{{ __('backend.FinalReport') }}</a>
                                              <a class="dropdown-item" href="#">{{ __('backend.EarlyDetectionReport') }}</a>


                                            </div>
                                          </div>

                                    </td>

                                    <td class="h6 text-center">
                                        @include('teacher.children.action')
                                    </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $childrens->links() !!}
                </div>
                {{-- <footer class="dker p-a">
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
                            @if(@Auth::user()->permissionsGroup->webmaster_status)
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
                            @endif
                        </div>

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $packages->firstItem() }}
                                -{{ $packages->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $packages->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $packages->links() !!}
                        </div>
                    </div>
                </footer> --}}
                {{-- {{Form::close()}} --}}
            @else
             <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push("js")
    <script type="text/javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $("#action").change(function () {
            if (this.value == "delete") {
                $("#submit_all").css("display", "none");
                $("#submit_show_msg").css("display", "inline-block");
            } else {
                $("#submit_all").css("display", "inline-block");
                $("#submit_show_msg").css("display", "none");
            }
        });
    </script>
@endpush
