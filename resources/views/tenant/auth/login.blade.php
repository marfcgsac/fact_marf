@extends('tenant.layouts.auth')


@section('content')
    <div class="body" style="background-image: url(/logo/fondo_log.jpg);background-size: cover;">
        <section class="body-sign">
            <div class="center-sign " >
                <div class="">


                         <div class="card-body" style=" margin: 40px;">


                        <div style="padding: inherit;text-align: center">
                            <img src="/logo/logo_fact.jpg" class="img-fluid" style="max-height: 90px;margin: auto;width: 72%;">
                        </div>


                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-6">

                                <!-- Esto es otro comentario <label>Correo electrónico</label>-->
                                <div class="input-group">
                               <span class="input-group-append">
                                    <span class="input-group-text" style="border-left: none;
    border-right: none;
    border-top: none;
    background: none;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </span>
                                    <!-- <input id="login" type="login" name="login" class="form-control form-control-lg" value="{{ old('login') }}" placeholder="Login" style="border-left: none;
    border-right: none;
    border-top: none;
    background: none;"> -->
    <div class="form-group{{ $errors->has('login') ?' has-error' : '' }}"
    >
    <div class="form-group mb-6">
<input id="login" type="login" class="form-control form-control-lg" name="login" value="{{ old('login') }}" required autofocus placeholder="E-Mail o Usuario" style="border-left: none;
    border-right: none;
    border-top: none;
    background: none;">
<!-- <label for="login" class="col-md-4 control-label">E-Mail o Usuario</label> -->
@if ($errors->has('login'))
<span class="help-block">
<strong>{{ $errors->first('login') }}</strong>
</span>
@endif
</div>
</div>



                                </div>
                                <!-- @if ($errors->has('login'))
                                    <label class="error">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </label>
                                @endif -->
                            </div>
                            <div class="form-group mb-3 {{ $errors->has('password') ? ' error' : '' }}">
                                <!-- Esto es otro comentario<label>Contraseña</label> -->
                                <div class="input-group">
                               <span class="input-group-append">
                                    <span class="input-group-text" style="border-left: none;
    border-right: none;
    border-top: none;
    background: none;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </span>
                                    <input name="password" type="password" class="form-control form-control-lg" placeholder="Password" style="border-left: none;
    border-right: none;
    border-top: none;
    background: none;">

                                </div>
                                @if ($errors->has('password'))
                                    <label class="error">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </label>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="checkbox-custom checkbox-default">
                                        <input name="remember" id="RememberMe" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="RememberMe">Recordarme</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-lg btn-primary" style=" padding-right: 60px; padding-left: 60px;
">INGRESAR</button>
                                    <p class="text-center text-muted mt-3 mb-3" >&copy; Copyright {{ date('Y') }}. Todos los derechos reservados</p>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- <script src="//code.tidio.co/8txsjuzw2uthkcsbyrwynuffhsdzpbwi.js"></script>--< -->
        </section>
        <div>
@endsection

<!-- GetButton.io widget -->
<!-- <script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "51999035338", // WhatsApp number
            call_to_action: "Soporte MARF !", // Call to action
            position: "right", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script> -->
<!-- /GetButton.io widget -->