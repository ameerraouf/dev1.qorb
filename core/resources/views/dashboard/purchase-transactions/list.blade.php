@extends('dashboard.layouts.master')
@section('title',__('backend.packages'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('backend.packages') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="">{{ __('backend.packages') }}</a>
                </small>
            </div>
            @if($transactions->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                            <br>
                        </div>
                    </div>
                </div>
            @endif

            @if($transactions->total() > 0)
                {{Form::open(['route'=>'packagesUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            {{-- <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th> --}}
                            <th class="text-center" style="width:100px;">{{ __('cruds.Childrens.childrenname') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('cruds.EarlyDetectionReports.TeacherName') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('cruds.Packages.packageTitle') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('cruds.Packages.price') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('cruds.MainServices.Title') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('cruds.SubServices.Title') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.SubscriptionDate') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('cruds.Packages.PackageStatus') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($transactions as $value)
                            <tr>
                                {{-- <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $value->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$value->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td> --}}
                                <td class="text-center">
                                    @foreach ($value->children_names as $index => $child)
                                        {!! $child !!}
                                        @if ($index < count($value->children_names) - 1)
                                            {!! ',' !!}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $value->teacher->name }}</td>
                                <td class="text-center">{{  (app()->getLocale() == 'ar') ? $value->package->title_ar : $value->package->title_en }}</td>
                                <td class="text-center">{!! $value->price , ' ' ,__('cruds.Packages.currency')!!}</td>
                                <td class="text-center">{{  (app()->getLocale() == 'ar') ? $value->main_service->name_ar : $value->main_service->name_en }}</td>
                                @if ($value->sub_service_id)
                                    <td class="text-center">{{  (app()->getLocale() == 'ar') ? $value->sub_service->title_ar : $value->sub_service->title_en }}</td>
                                @else
                                    <td class="text-center"> - </td>
                                @endif
                                <td class="text-center">{{ $value->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a class="btn btn-xs primary" href="{{ route("PurchaseTransactionsChangeStatus",["id"=>$value->id]) }}">
                                        <h5><i class="fa fa-exchange "></i></h5>
                                    </a>
                                    <strong>{{ $value->package_status == 1 ? __('backend.active') :  __('backend.disable') }}</strong>
                                </td>
                            </tr>
                            {{-- <!-- .modal -->
                            <div id="show-{{ $value->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.viewDetails') }} : <strong>[ {{ $value->title }} ]</strong></h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <ul class="list-group">
                                                <li class="list-group-item active">{{ __('backend.advantages') }}</li>
                                                <li class="list-group-item">
                                                @php
                                                $advantages = strtok($value->advantages, ",");

                                                while ($advantages !== false)
                                                    {
                                                    echo '<span class="btn btn-xs btn-primary" style="margin:0px 5px">' . $advantages . '</span>';
                                                    $advantages = strtok(",");
                                                    }
                                            @endphp
                                                </li>
                                                <li class="list-group-item">{{ __('backend.price') }} : <strong>[ {{ $value->price }} ]</strong></li>
                                              </ul>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.cancel') }}</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal --> --}}
                            <!-- .modal -->
                            {{-- <div id="delete-{{ $value->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ __('backend.confirmationDeleteMsg') }}
                                                <br>
                                                <strong>[ {{ $value->title }} ]</strong>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.no') }}</button>
                                            <a href="{{ route("packagesDestroy",["id"=>$value->id]) }}"
                                               class="btn danger p-x-md">{{ __('backend.yes') }}</a>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div> --}}
                            <!-- / .modal -->
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <footer class="dker p-a">
                    <div class="row">
                        {{-- <div class="col-sm-3 hidden-xs">
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
                        </div> --}}

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $transactions->firstItem() }}
                                -{{ $transactions->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $transactions->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $transactions->links() !!}
                        </div>
                    </div>
                </footer>
                {{Form::close()}}
            @endif
        </div>
    </div>
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
