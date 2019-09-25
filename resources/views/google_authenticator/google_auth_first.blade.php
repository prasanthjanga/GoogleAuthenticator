@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Google Auth First Time</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('google_auth_first') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="account_key" value="{{strtoupper($google_aoth_qr['secret']) ?? 0}}">

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Account Key</label>

                            <div class="col-md-6">
                                {{strtoupper($google_aoth_qr['secret'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">QR Code</label>

                            <div class="col-md-6">
                                <img src="{{$google_aoth_qr['qr_code_url']}}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                            <label for="otp" class="col-md-4 control-label">OTP</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="otp" value="" required autofocus>

                                @if ($errors->has('otp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-md-4 control-label text-danger">Note</label>

                            <div class="col-md-6">
                                Requested to scan QR using google authonicater and enter the OTP which is generated in the app
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
