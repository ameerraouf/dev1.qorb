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


                .boxes-package {
            gap: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
            margin-bottom: 24px;
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
            margin-top: auto;
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
                    <div class="boxes-package">
                        @foreach ($packages as $item)
                            <div class="box-package">
                                <h3 class="title">
                                    {{ app()->getLocale() == 'ar' ? $item->title_ar : $item->title_en }}
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
                                <button id="submit_show_msg_{{ $item->id }}" class="btn-box" data-toggle="modal"
                                        style="display: inline-block"
                                        data-package="{{ $item }}"
                                        data-target="#m-all" ui-toggle-class="bounce"
                                        ui-target="#animate">
                                    {{ __('cruds.Packages.Subscribe') }}
                                </button>
                            </div>
                            @endforeach
                            <!-- .modal -->
                            <div id="m-all" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    {{Form::open(['route'=>'SubscribePackage','method'=>'post'])}}
                                        <div class="modal-content">
                                            <div class="modal-header d-flex justify-content-center">
                                                <h5 class="modal-title package-name"></h5>
                                            </div>
                                            <div class="modal-body text-center p-lg">
                                                <div class="form-group row">
                                                    <label for="children_ids"
                                                        class="col-sm-2 form-control-label">{{ __('cruds.Childrens.Title') }}</label>
                                                    <div class="col-sm-10">
                                                        <select name="children_ids[]" id="children_ids" class="form-control select2-multiple" multiple ui-jp="select2" ui-options="{theme: 'bootstrap'}" required>
                                                            @foreach ($user->childrens as $child)
                                                                <option value="{{ $child->id }}">{{ $child->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="main_service"
                                                        class="col-sm-2 form-control-label">{{ __('cruds.MainServices.Title') }}</label>
                                                    <div class="col-sm-10">
                                                        <select name="main_service_id" id="main_service" class="form-control select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}" required>
                                                            <option value="">{{ __('cruds.SubServices.SelectMainService') }}</option>
                                                            @foreach ($main_services as $main_service)
                                                                <option value="{{ $main_service->id }}">{{ app()->getLocale() == 'ar' ? $main_service->name_ar : $main_service->name_en }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="sub_service_div" style="display: none;">
                                                    <label for="sub_service" class="col-sm-2 form-control-label">{{ __('cruds.SubServices.Title') }}</label>
                                                    <div class="col-sm-10">
                                                        <select name="sub_service_id" id="sub_service" class="form-control select2-multiple" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                                                            <option value="">{{ __('cruds.SubServices.SelectSubService') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <h5 class="modal-title package-price"></h5>
                                                <input type="hidden" id="package_id" name="package_id" value="">
                                                <input type="hidden" id="price" name="price" value="">
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="submit" class="btn danger p-x-md">{{ __('backend.Pay') }}</button>
                                                <button type="button" class="btn dark-white p-x-md"
                                                        data-dismiss="modal">{{ __('backend.cancel') }}</button>
                                            </div>
                                        </div>
                                    {{Form::close()}}
                                    <!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->
                    </div>
                </div>
            </div>
        </section>
        {!! $packages->links() !!}
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
    var price = 0;
    @foreach ($packages as $pakage)
        $("#submit_show_msg_{{ $pakage->id }}").click(function() {

            value = $(this).data('package');
            price = value.price;
            $('.package-name').text(value[app.locale == 'ar' ? 'title_ar' : 'title_en']);
            $('#package_id').val(value.id);
            $('#price').val(value.price);
            var selectedOptionsCount = $("#children_ids").find("option:selected").length;
            if(selectedOptionsCount == 0 ){
                $('.package-price').text('{{ __('cruds.Packages.PackagePrice') }}: '+value.price+" {{ __('cruds.Packages.currency') }}");
                $('#price').val(value.price);
            }else{
                $('#price').val(value.price*selectedOptionsCount);
                $('.package-price').text('{{ __('cruds.Packages.PackagePrice') }}: '+value.price*selectedOptionsCount+" {{ __('cruds.Packages.currency') }}");
            }
        });
    @endforeach
    $("#children_ids").change(function() {
        var bh = $(this).data('package');
        var selectedOptionsCount = $(this).find("option:selected").length;
        if(selectedOptionsCount == 0 ){
            $('.package-price').text('{{ __('cruds.Packages.PackagePrice') }}: '+value.price+" {{ __('cruds.Packages.currency') }}");
            $('#price').val(value.price);
        }else{
            $('#price').val(value.price*selectedOptionsCount);
            $('.package-price').text('{{ __('cruds.Packages.PackagePrice') }}: '+value.price*selectedOptionsCount+" {{ __('cruds.Packages.currency') }}");
        }
    });
    $('#main_service').change(function() {
        var mainServiceId = $(this).val();
        console.log(mainServiceId);
        if (mainServiceId) {
            $('#sub_service_div').show();
            $.ajax({
                url: 'teacher/getSubServices/' + mainServiceId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#sub_service').empty();
                    $('#sub_service').append('<option value="">{{__('cruds.SubServices.SelectSubService')}}</option>');
                    $.each(data, function(key, value) {
                        $('#sub_service').append('<option value="' + value.id + '">' + value[app.locale == 'ar' ? 'title_ar' : 'title_en'] + '</option>');
                    });
                }
            });
        } else {
            $('#sub_service_div').hide();
            $('#sub_service').empty();
            $('#sub_service').append('<option value="">{{__('cruds.SubServices.SelectSubService')}}</option>');
        }
    });
    </script>
@endpush
