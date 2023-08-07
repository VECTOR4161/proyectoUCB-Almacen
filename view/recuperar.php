<!DOCTYPE html>
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
    <div class = "container-md">
        <div class="auth-full-page-content d-flex p-sm-5 p-4">
            <div class="w-100">
                <div class="d-flex flex-column h-100">
                    <div class="auth-content my-auto">
                        <div class="mb-4 mb-md-5 text-center">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="../public/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">Omega</span>
                            </a>
                            </div>
                                <div class="text-center">
                                    <h5 class="mb-0">Recuperacion de Contraseña</h5>
                                    <p class="text-muted mt-2">Ingresa tu correo para recuperar tu contraseña</p>
                                </div>
                                <form class="custom-form mt-4 pt-2" id="frmAcceso">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Correo Electronico</label>
                                            </div>    
                                        </div>
                                                
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="text" class="form-control" id="usuarioLogin" name="clavea" placeholder="Ingrese Su Correo Electronico" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>                                            
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" onclick="verificarUsuario()" type="button">Ingresa tu correo electronico</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> UCB | Sistema de Compras y Ventas. Modulo de recuperacion diseñado por Fernando Ichazo Cisneros</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>                   
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
    <script type="text/javascript" src="script/recuperar.js"></script>                           
</body>
</html>