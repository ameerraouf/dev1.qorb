@extends('dashboard.layouts.master')
@section('title', __('cruds.SetChild'))
@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3>{{ __('backend.setChildToParent') }}</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                <a >{{ __('backend.setChildToParent') }}</a>
            </small>
        </div>
        @if($childrens->total() > 0)
            @if(@Auth::user()->permissionsGroup->webmaster_status)
                <div class="row p-a pull-right" style="margin-top: -70px;">
                    <div class="col-sm-12">
                        <a class="btn btn-fw primary" href="{{route("SetChildPage")}}">
                            <i class="material-icons">&#xe7fe;</i>
                            &nbsp; {{ __('cruds.SetChild') }}
                        </a>
                    </div>
                </div>
            @endif
        @endif
        @if($childrens->total() == 0)
            <div class="row p-a">
                <div class="col-sm-12">
                    <div class=" p-a text-center ">
                        {{ __('backend.noData') }}
                        <br>
                        @if(@Auth::user()->permissionsGroup->webmaster_status)
                            <br>
                            <a class="btn btn-fw primary" href="{{route("SetChild")}}">
                                <i class="material-icons">&#xe7fe;</i>
                                &nbsp; {{ __('cruds.SetChild') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($childrens->total() > 0)
            {{Form::open(['route'=>'financialTransactionsUpdateAll','method'=>'post'])}}
            <div class="table-responsive">
                <table class="table table-bordered m-a-0">
                    <thead class="dker">
                    <tr>
                        <th  class="width20 dker">
                            <label class="ui-check m-a-0">
                                <input id="checkAll" type="checkbox"><i></i>
                            </label>
                        </th>
                        <th class="text-center" style="width:220px;">{{ __('cruds.Childrens.childrenname') }}</th>
                        <th class="text-center" style="width:220px;">{{ __('cruds.Childrens.Teacher') }}</th>
                        <th class="text-center" style="width:220px;">{{ __('cruds.Childrens.Specialist') }}</th>
                        <th class="text-center">{{ __('cruds.Childrens.Supervisor') }}</th>
                        <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($childrens as $child)
                        <tr>
                            <td class="dker"><label class="ui-check m-a-0">
                                    <input type="checkbox" name="ids[]" value="{{ $child->id }}"><i
                                        class="dark-white"></i>
                                    {!! Form::hidden('row_ids[]',$child->id, array('class' => 'form-control row_no')) !!}
                                </label>
                            </td>
                            <td class="h6 text-center">
                                {!! $child->name !!}
                            </td>
                            <td class="h6 text-center">
                                {!! $child->mother->name ?? '-'   !!}
                            </td>
                            
                            <td class="h6 text-center">
                                {!! $child->specialist->name ?? '-'   !!}
                            </td>

                            <td class="h6 text-center">
                                {!! $child->supervisor->name ?? '-'   !!}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm success"
                                   href="{{ route("SetChildEditPage",["id"=>$child->id]) }}">
                                    <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}
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
                                            <strong>[ {{ $child->name }} ]</strong>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark-white p-x-md"
                                                data-dismiss="modal">{{ __('backend.no') }}</button>
                                        <a href="{{ route("financialTransactionsDestroy",["id"=>$child->id]) }}"
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