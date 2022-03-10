<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Регистрация
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>
<body>
    <div class="page-wrapper auth">
        <div class="page-inner bg-brand-gradient">
            <div class="page-content-wrapper bg-transparent m-0">
                <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                    <div class="d-flex align-items-center container p-0">
                        <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                <span class="page-logo-text mr-1">Users BOOK</span>
                            </a>
                        </div>
                        <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                            Уже зарегистрированы?
                        </span>
                        <a href="{{ route('login') }}" class="btn-link text-white ml-auto ml-sm-0">
                            Войти
                        </a>
                    </div>
                </div>
                <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                    <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                        <div class="row">
                            <div class="col-xl-12">
                                <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                    Регистрация
                                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                                        Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                                        <br> 
                                        По своей сути рыбатекст является альтернативой традиционному lorem ipsum   
                                    </small>
                                </h2>
                            </div>
                            <div class="col-xl-6 ml-auto mr-auto">
                                <div class="card p-4 rounded-plus bg-faded">


                                    <form  action="{{ route('register') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label class="form-label" for="name">{{ __('Имя') }}<br></label>
                                            <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"  autofocus>
                                            
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                            <div class="help-block">Укажите ваше имя и фамилию</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="emailverify">Email</label>
                                            <input type="text" name="email" id="emailverify" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
                                            
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            <div class="help-block">Эл. адрес будет вашим логином при авторизации</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">{{ __('Пароль') }}<br></label>
                                            <input type="password" name="password" id="userpassword" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                            
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                            <div class="help-block">Это будет вашим паролем при авторизации</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="password_confirm"><br></label>
                                            <input type="password" name="password_confirmation" id="password-confirm" class="form-control">
                                            <div class="invalid-feedback">Заполните поле.</div>
                                            <div class="help-block">Подтвердите пароль для регистрации</div>
                                        </div>

                                        <input type="text" name="role" hidden class="form-control" value="user">
                                       
                                        <div class="row no-gutters">
                                            <div class="col-md-4 ml-auto text-right">
                                                <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn-lg mt-3">{{ __('Регистрация') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/vendors.bundle.js"></script>
    <script>
        $("#js-login-btn").click(function(event)
        {

            // Fetch form to apply custom Bootstrap validation
            var form = $("#js-login")

            if (form[0].checkValidity() === false)
            {
                event.preventDefault()
                event.stopPropagation()
            }

            form.addClass('was-validated');
            // Perform ajax submit here...
        });

    </script>
</body>
</html>
