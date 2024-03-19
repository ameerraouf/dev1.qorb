@extends('dashboard.layouts.master')
@section('title',__('backend.roles'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('backend.roles') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="">{{ __('backend.roles') }}</a>
                </small>
            </div>
            @if($roles->count() > 0)
                @if(@Auth::user()->permissionsGroup->webmaster_status)
                    <div class="row p-a pull-right" style="margin-top: -70px;">
                        <div class="col-sm-12">
                            <a class="btn btn-fw primary" href="{{route("rolesCreate")}}">
                                <i class="fa fa-plus"></i>{{ __('backend.add') }}
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            @if($roles->count() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                            <br>
                            @if(@Auth::user()->permissionsGroup->webmaster_status)
                                <br>
                                <a class="btn btn-fw primary" href="{{route("rolesCreate")}}">
                                    <i class="fa fa-plus"></i>{{ __('backend.add') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($roles->count() > 0)
                {{Form::open(['route'=>'rolesUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th>
                            <th class="text-center" style="width:100px;">{{ __('backend.role') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($roles as $value)
                            <tr>
                                <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $value->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$value->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td>
                                <td class="text-center">
                                    @if(app()->getLocale() == 'ar')
                                        {{ $value->name_ar }}
                                    @else
                                        {{ $value->name_en }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm success"
                                        href="{{ route("rolesEdit",["id"=>$value->id]) }}">
                                        <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}
                                        </small>
                                    </a>
                                    @if(@Auth::user()->permissionsGroup->webmaster_status)
                                        <button class="btn btn-sm warning" data-toggle="modal"
                                                data-target="#delete-{{ $value->id }}" ui-toggle-class="bounce"
                                                ui-target="#animate">
                                            <small><i class="material-icons">&#xe872;</i> {{ __('backend.delete') }}
                                            </small>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            <!-- .modal -->
                            <div id="delete-{{ $value->id }}" class="modal fade" data-backdrop="true">
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
                                            <a href="{{ route("rolesDestroy",["id"=>$value->id]) }}"
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

                        {{-- <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $roles->firstItem() }}
                                -{{ $roles->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $roles->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $roles->links() !!}
                        </div> --}}
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
