@extends('dashboard.layouts.master')
@section('title',__('backend.clients'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('backend.clients') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="">{{ __('backend.clients') }}</a>
                </small>
            </div>

            @if($clients->total() > 0)
                {{Form::open(['route'=>'clientsUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th>
                            <th class="text-center" style="width:100px;">{{ __('backend.fullName') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.topicPhoto') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.loginEmail') }}</th>
                            <th class="text-center" style="width:100px;">{{ __('backend.phone') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($clients as $value)
                            <tr>
                                <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $value->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$value->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td>
                                <td class="text-center">{{ $value->name }}</td>
                                <td class="text-center"><img src="uploads/users/{{ $value->photo }}" width="30px" height="30px" alt="">
                                </td>
                                <td class="text-center">{{ $value->email }}</td>
                                <td class="text-center">{{ $value->phone }}</td>

                                <td class="text-center">
                                    <button class="btn btn-sm info" data-toggle="modal"
                                            data-target="#show-{{ $value->id }}" ui-toggle-class="bounce"
                                            ui-target="#animate" data-toggle="tooltip" data-original-title="{{ __('backend.showing') }}">
                                        <small><i class="material-icons">&#xe8f4;</i> {{ __('backend.showing') }}
                                        </small>
                                    </button>

                                </td>
                            </tr>

                            <!-- .modal -->
                            <div id="show-{{ $value->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $value->name }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">


                                            <div class="card" style="width: 100%">
                                                <img class="img-thumbnail rounded" style="width: 30%" src="uploads/clients/{{ $value->photo }}" alt="{{ $value->name }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $value->name }}</h5>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <div class="card-header">{{ __('backend.viewDetails') }}</div>
                                                    <li class="list-group-item">{{ $value->email }}</li>
                                                    <li class="list-group-item">{{ $value->phone }}</li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.cancel') }}</button>
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

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }} {{ $clients->firstItem() }}
                                -{{ $clients->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $clients->total()  }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $clients->links() !!}
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
