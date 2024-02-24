@extends('teacher.layouts.master')
@section('title', __('backend.packages'))
@section('content')
    <style>
        .container {
            padding: 0 20px 0 20px;
            position: relative;
        }

        .content-row-no-bg {
            position: relative;
            background: #fff;
            padding: 50px 0 40px 0;
        }

        .top-line {
            background: #f0f0f0;
            border-top: 1px solid #f0f0f0
        }

        .row,
        .row-fluid {
            margin-bottom: 20px;
        }

        .row .row,
        .row-fluid .row-fluid {
            margin-bottom: 20px;
        }

        .home-row-head {
            text-align: center;
            margin-bottom: 20px;
        }

        .home-row-head h2 {
            padding: 0;
            margin: 0;
        }

        .home-row-head h2 {
            padding: 0;
            margin: 0;
        }

        .row-gap-24 {
            row-gap: 24px;
        }


        .box-package {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            display: flex;
            box-shadow: 0 0 10px 0 #00000012;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .box-package .title {
            margin: 0 0 1.5rem;
            font-size: 15px;
            border-radius: 4px;
        }

        .box-package .price {
            font-size: 42px;
            display: flex;
            gap: 2px;
            margin: 0 0 1rem;
        }

        .box-package .price span {
            font-size: 18px;
            font-weight: normal;
        }

        .box-package .list {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 0.5rem;
            font-size: 15px;
            margin: 0 0 1rem;
        }

        .box-package .list li {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .box-package .list li .icon {
            background-color: #17bd17;
            color: white;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 12px;
            padding-top: 3px;
        }

        .box-package .btn-box {
            display: block;
            width: 100%;
            background-color: #0cbaa4;
            color: white;
            padding: 0.8rem 1rem;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>

    @if ($packages->count() > 0)
        <section class="content-row-no-bg top-line">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="home-row-head">
                            <h2 class="heading">
                                {{ __('cruds.Packages.Title') }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 row row-gap-24">
                        @foreach ($packages as $item)
                            
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="box-package">
                                <h3 class="title">
                                    {{ $item->title }}
                                </h3>
                                <h4 class="price">
                                    {{ $item->price }}
                                    <span>
                                        {{ __('cruds.Packages.currency') }}
                                    </span>
                                </h4>
                                <ul class="list">
                                    @foreach ($item->advantages as $adv)
                                        <li>
                                            <span class="icon">
                                                &#10003;
                                            </span>
                                            {{ $adv }}
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="" class="btn-box">
                                    {{ __('cruds.Packages.Subscribe') }}
                                </a>
                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        {!! $packages->links() !!}

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
                            @if (@Auth::user()->permissionsGroup->webmaster_status)
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
@push('js')
    <script type="text/javascript">
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $("#action").change(function() {
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
