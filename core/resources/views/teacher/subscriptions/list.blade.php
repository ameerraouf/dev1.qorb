@extends('teacher.layouts.master')
@section('title', __('cruds.FinancialTransactions.Purchases') )
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('cruds.FinancialTransactions.Purchases') }}</h3>
                <small>
                    <a href="{{ route('teacher.teacherhome') }}">{{ __('backend.home') }}</a> /
                    <a >{{ __('cruds.FinancialTransactions.Purchases') }}</a>
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
                {{Form::open(['route'=>'financialTransactionsUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                        <tr>
                            {{-- <th  class="width20 dker">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th> --}}
                            <th class="text-center" style="width:220px;">{{ __('cruds.Packages.Title') }}</th>
                            <th class="text-center" style="width:220px;">{{ __('cruds.Packages.price') }}</th>
                            <th class="text-center" style="width:220px;">{{ __('backend.main_services') }}</th>
                            <th class="text-center" style="width:220px;">{{ __('backend.sub_services') }}</th>
                            <th class="text-center" style="width:220px;">{{ __('cruds.Childrens.childrenname') }}</th>
                            <th class="text-center" style="width:220px;">{{ __('backend.SubscriptionDate') }}</th>
                            <th class="text-center" style="width:220px;">{{ __('cruds.Packages.PackageStatus') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($transactions as $transaction)
                            <tr>
                                {{-- <td class="dker"><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $transaction->id }}"><i
                                            class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$transaction->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td> --}}
                                <td class="h6 text-center">
                                    {!! app()->getLocale() == 'ar' ? $transaction->package->title_ar : $transaction->package->title_en !!}
                                </td>

                                <td class="h6 text-center">
                                    {!! $transaction->price , ' ' ,__('cruds.Packages.currency')!!}
                                </td>

                                <td class="h6 text-center">
                                    @if (app()->getLocale() == 'ar')
                                        {!! $transaction->main_service->name_ar !!}
                                    @else
                                        {!! $transaction->main_service->name_en !!}
                                    @endif
                                </td>

                                <td class="h6 text-center">
                                    @if (app()->getLocale() == 'ar')
                                        {!! $transaction->sub_service->title_ar ?? '' !!}
                                    @else
                                        {!! $transaction->sub_service->title_en ?? '' !!}
                                    @endif
                                </td>

                                <td class="h6 text-center">
                                    @foreach ($transaction->children_names as $index => $child)
                                        {!! $child !!}
                                        @if ($index < count($transaction->children_names) - 1)
                                            {!! ',' !!}
                                        @endif
                                    @endforeach
                                </td>

                                <td class="h6 text-center">
                                    @if (isset($transaction->created_at))
                                     {!! $transaction->created_at->format('Y-m-d') ?? '' !!}
                                    @else

                                    @endif
                                </td>

                                <td class="h6 text-center">
                                    {{ $transaction->package_status == 1 ? __('backend.active') : __('backend.disable') }}
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-sm primary"data-toggle="modal"
                                                data-target="#transaction-show{{ $transaction->id }}" ui-toggle-class="bounce"
                                                ui-target="#animate" data-dismiss="modal">
                                            <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.show') }}
                                            </small>
                                        </button>
                                </td>
                            </tr>
                            <div id="transaction-show{{ $transaction->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('cruds.FinancialTransactions.Purchases') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">

                                            <div class="form-group row">
                                                <h6
                                                    class="col-sm-4 form-control-label text-center">{{ __('backend.BilledFrom') }}
                                                </h6><br>
                                                <div class="col-sm-8">
                                                    قرب
                                                </div>
                                            </div><hr>

                                            <div class="form-group row">
                                                <h6
                                                    class="col-sm-4 form-control-label text-center"> {{ __('backend.BilledTo') }}
                                                </h6><br>
                                                <div class="col-sm-8">
                                                    {{ auth()->user()->name }}
                                                </div>
                                            </div><hr>
                                                <div class="form-group row">
                                                    <h6
                                                        class="col-sm-4 form-control-label text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Packages.price') : __('cruds.Packages.price') }}
                                                    </h6><br>
                                                    <div class="col-sm-8">
                                                            <p>{!! $transaction->price !!}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <h6
                                                        class="col-sm-4 form-control-label text-center">{{ __('cruds.Childrens.Title') }}
                                                    </h6><br>
                                                    <div class="col-sm-8">
                                                        @foreach ($transaction->children_names as $index => $child)
                                                            {!! $child !!}
                                                            @if ($index < count($transaction->children_names) - 1)
                                                                {!! '-' !!}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div><hr>
                                                <div class="form-group row">
                                                    <h6
                                                        class="col-sm-4 form-control-label text-center">{{ app()->getLocale() === 'ar' ? __('cruds.Packages.purchaseDate') : __('cruds.Packages.purchaseDate') }}
                                                    </h6><br>
                                                    <div class="col-sm-8">
                                                        @if (isset($transaction->created_at))
                                                            {!! $transaction->created_at->format('Y-m-d') ?? '' !!}
                                                        @else

                                                       @endif
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
