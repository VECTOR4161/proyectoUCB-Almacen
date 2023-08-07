<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>UCB | Sistema de Compras y Ventas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../public/images/favicon.ico">

        <!-- preloader css -->
        <link rel="stylesheet" href="../public/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="../public/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../public/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../public/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="../public/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index.html" class="d-block auth-logo">
                                            <img src="../public/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">Omega</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Bienvenido de vuelta...</h5>
                                            <p class="text-muted mt-2">Ingresa tus credenciales para utilizar UCB | Sistema de Compras y Ventas</p>
                                        </div>
                                        <form class="custom-form mt-4 pt-2" id="frmAcceso">
                                            <div class="mb-3">
                                                <label class="form-label">Usuario</label>
                                                <input type="text" class="form-control" id="logina" name="logina" placeholder="Ingrese el nombre de Usuario">
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Contraseña</label>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="">
                                                            <a href="recuperar.php" class="text-muted">¿Necesitas recuperar tu contraseña?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" id="clavea" name="clavea" placeholder="Ingrese el nombre de Contraseña" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>                                            
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> UCB | Sistema de Compras y Ventas. Desarrollado por <i class="mdi mdi-heart text-danger"></i> Helmer Fellman Mendoza Jurado</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <!-- end carouselIndicators -->
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“No es sobre las ideas. Sino sobre hacer que estas se vuelvan realidad.”
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Scott Belsky
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Cofundador de Behance</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Nunca tenés que iniciar un negocio solo para ‘hacer dinero’. Empezá un negocio para hacer una diferencia.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Marie Forleo
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Emprendedora</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“La manera de empezar es dejar de hablar y empezar a hacer.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Walt Disney</h5>
                                                                    <p class="mb-0 text-white-50">empresario, guionista y productor de cine
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel-inner -->
                                        </div>
                                        <!-- end review carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>


        <!-- JAVASCRIPT -->
        <script src="../public/libs/jquery/jquery.min.js"></script>
        <script src="../public/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../public/libs/metismenu/metisMenu.min.js"></script>
        <script src="../public/libs/simplebar/simplebar.min.js"></script>
        <script src="../public/libs/node-waves/waves.min.js"></script>
        <script src="../public/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="../public/libs/pace-js/pace.min.js"></script>
        <!-- password addon init -->
        <script src="../public/js/pages/pass-addon.init.js"></script>
        <script src="../public/libs/sweetalert2/sweetalert2.min.js"></script>
        <script type="text/javascript" src="script/login.js"></script>
    </body>

</html>