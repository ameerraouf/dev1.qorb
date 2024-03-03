@extends('dashboard.layouts.master')
@section('title',  __('cruds.EarlyDetectionReports.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('cruds.EarlyDetectionReports.Title') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a >{{ __('cruds.EarlyDetectionReports.Title') }}</a>
                </small>
            </div>

            @if($children->total() > 0)
                {{Form::open(['route'=>'CommonQuestionsUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            {{-- <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th> --}}
                            <th class="text-center">{{ __('cruds.EarlyDetectionReports.ChildName') }}</th>
                            <th class="text-center">{{ __('cruds.EarlyDetectionReports.TeacherName') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('cruds.EarlyDetectionReports.ConvertToEarlyDetectionReport') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($children as $child)
                            <tr>
                                {{-- <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $child->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$child->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td> --}}
                                <td class="h6 text-center">
                                        {!! strlen($child->name) > 40 ? substr($child->name, 0, 40) . '...' : $child->name!!}
                                </td>
                                <td class="h6 text-center">
                                        {!! $child->mother->name !!}
                                </td>
                                <td class="text-center">
                                    <button id="toggleButton" class="convert-to-early-detection btn btn-sm success" data-child-id="{{ $child->id }}">
                                        <small>
                                            {{ __('cruds.EarlyDetectionReports.Convert') }}                                        </small>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm success"
                                       href="{{ route("ShowEarlyDetectionReports",["id"=>$child->id]) }}">
                                        <small>{{ __('cruds.EarlyDetectionReports.Title') }}
                                        </small>
                                    </a>
                                </td>
                            </tr>
                            <!-- .modal -->
                            <div id="delete-{{ $child->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ __('backend.confirmationDeleteMsg') }}
                                                <br>
                                                <strong>[
                                                    @if(app()->getLocale() == 'ar')
                                                        {!! strlen($child->question_ar) > 40 ? substr($child->question_ar, 0, 40) . '...' : $child->question_ar!!}
                                                    @else
                                                        {!! strlen($child->question_en) > 40 ? substr($child->question_en, 0, 40) . '...' : $child->question_en!!}
                                                    @endif
                                                ]</strong>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.no') }}</button>
                                            <a href="{{ route("CommonQuestionsDestroy",["id"=>$child->id]) }}"
                                               class="btn danger p-x-md">{{ __('backend.yes') }}</a>
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
                            {{-- @if(@Auth::user()->permissionsGroup->webmaster_status)
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
                            @endif --}}
                        </div>

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $children->firstItem() }}
                                -{{ $children->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $children->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $children->links() !!}
                        </div>
                    </div>
                </footer>
                {{Form::close()}}
            @endif
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).on('click','.convert-to-early-detection',function() {
            event.preventDefault();
                var childId = $(this).data('child-id');
                console.log(childId);
                $.ajax({
                    url: 'admin/early-detection-reports-ajax-create/' + childId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var investorId = response.investorId;
                        var $button = $('[data-child-id="' + childId + '"]');
                        if (response.message == 'Added') {
                            $button.css({
                                'background-color': '#1e91bd',
                                'color': '#ffffff',
                                'border-color': '#ffffff'
                            }).prop('disabled', true).text("{{ __('cruds.EarlyDetectionReports.Converted') }}");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Handle errors
                    }
                });
            });
    </script>
@endsection
@push("after-scripts")
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
