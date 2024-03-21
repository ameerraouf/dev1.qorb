<div class="tab-pane {{  ( Session::get('active_tab') == 'paymentSettingsTab') ? 'active' : '' }}"
     id="tab-13">
    <div class="p-a-md"><h5>Payment</h5></div>

    <div class="p-a-md col-md-12">
        <div class="row">
            <div class="col-sm-5 form-group">
                <label>Payment Gateway</label>
                <select name="payment_gateway" id="payment_gateway" class="form-control c-select">
                    <option value="">
                        None
                    </option>
                    <option  value="clickpay">
                        Click Pay
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="p-x-md col-md-12 clickpay">
        <div class="form-group">
            <span class="pull-right"></span>
            <label>Status</label>
            <select name="CLICK_PAY_STATUS" id="CLICK_PAY_STATUS" class="form-control c-select">
                <option value="1" {{ env('CLICK_PAY_STATUS') == 1 ? 'selected' : '' }}> Enabled </option>
                <option value="0" {{ env('CLICK_PAY_STATUS') == 0 ? 'selected' : '' }}> Disabled </option>
            </select>
        </div>
        <div class="form-group">
            <span class="pull-right"></span>
            <label>Server Key</label>
            {!! Form::text('CLICK_PAY_SERVER_KEY',env('CLICK_PAY_SERVER_KEY'), array('class' => 'form-control')) !!}
        </div>
        <div class="form-group">
            <span class="pull-right"></span>
            <label>Client Key</label>
            {!! Form::text('CLICK_PAY_CLIENT_KEY',env('CLICK_PAY_CLIENT_KEY'), array('class' => 'form-control','required')) !!}
        </div>
        <div class="form-group">
            <span class="pull-right"></span>
            <label>Currency</label>
            {!! Form::text('CLICK_PAY_CURRENCY',env('CLICK_PAY_CURRENCY'), array('class' => 'form-control','required')) !!}
        </div>
        <div class="form-group">
            <span class="pull-right"></span>
            <label>Conversion Rate</label>
            {!! Form::number('CLICK_PAY_CONVERSION_RATE',env('CLICK_PAY_CONVERSION_RATE'), array('class' => 'form-control','required','min'=>'0')) !!}
        </div>
        <div class="form-group">
            <span class="pull-right"></span>
            <label>Mode</label>
            {!! Form::text('CLICK_PAY_MODE',env('CLICK_PAY_MODE'), array('class' => 'form-control','readonly')) !!}
        </div>
    </div>
</div>
