@extends('dashboard.layouts.master')
@section('title', __('cruds.FinancialTransactions.Title') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('cruds.FinancialTransactions.Title') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a >{{ __('cruds.FinancialTransactions.Title') }}</a>
                </small>
            </div>
            @if($transactions->total() > 0)
                @if(@Auth::user()->permissionsGroup->webmaster_status)
                    <div class="row p-a pull-right" style="margin-top: -70px;">
                        <div class="col-sm-12">
                            <a class="btn btn-fw primary" href="{{route("financialTransactionsCreate")}}">
                                <i class="material-icons">&#xe7fe;</i>
                                &nbsp; {{ __('cruds.FinancialTransactions.SendPayment') }}
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            @if($transactions->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('backend.noData') }}
                            <br>
                            @if(@Auth::user()->permissionsGroup->webmaster_status)
                                <br>
                                <a class="btn btn-fw primary" href="{{route("financialTransactionsCreate")}}">
                                    <i class="material-icons">&#xe7fe;</i>
                                    &nbsp; {{ __('cruds.FinancialTransactions.SendPayment') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($transactions->total() > 0)
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
                            {{-- <th class="text-center" style="width:220px;">{{ __('cruds.FinancialTransactions.Name') }}</th> --}}
                            <th class="text-center" style="width:220px;">{{ __('cruds.FinancialTransactions.CopyOfTheBankTransfer') }}</th>
                            <th class="text-center">{{ __('cruds.FinancialTransactions.Notes') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($transactions as $transaction)
                            <tr>
                                <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $transaction->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$transaction->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td>
                                {{-- <td class="h6 text-center">
                                    {!! $transaction->user->name   !!} 
                                </td> --}}
                                <td class="h6 text-center">
                                    <a href="javascript:;" data-toggle="modal" data-target="#preview-image_{{ $transaction->id }}">

                                        <img src="uploads/financial-transactions/{{ $transaction->image }}" width="30px" height="30px" alt="" >
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="preview-image_{{$transaction->id }}" tabindex="-1" aria-labelledby="preview-imageLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="preview-imageLabel">{{ __('cruds.FinancialTransactions.CopyOfTheBankTransfer') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="uploads/financial-transactions/{{ $transaction->image }}" class="w-100" alt="" >
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('backend.close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="h6 text-center">
                                    {!! $transaction->notes ?? '-'   !!}
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm success"
                                       href="{{ route("financialTransactionsEdit",["id"=>$transaction->id]) }}">
                                        <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}
                                        </small>
                                    </a>
                                    @if(@Auth::user()->permissionsGroup->webmaster_status)
                                        <button class="btn btn-sm warning" data-toggle="modal"
                                                data-target="#delete-{{ $transaction->id }}" ui-toggle-class="bounce"
                                                ui-target="#animate">
                                            <small><i class="material-icons">&#xe872;</i> {{ __('backend.delete') }}
                                            </small>
                                        </button>
                                    @endif


                                </td>
                            </tr>
                            <!-- .modal -->
                            <div id="delete-{{ $transaction->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ __('backend.confirmationDeleteMsg') }}
                                                <br>
                                                <strong>[ {{ $transaction->name }} ]</strong>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ __('backend.no') }}</button>
                                            <a href="{{ route("financialTransactionsDestroy",["id"=>$transaction->id]) }}"
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
