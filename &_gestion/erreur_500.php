
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title><?php include('titre_ent_1.php'); ?> | Erreur 404</title>
        <?php include('meta.php'); ?>
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    
    <body>

    <!-- <body data-layout="horizontal"> -->

        <div class="authentication-bg min-vh-100">
            <div class="bg-overlay bg-white"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center py-5">
                            <h1 class="display-1 fw-normal error-text">500</h1>
                            <h4 class="text-uppercase text-muted">ERREUR SERVER</h4>
                            <div class="mt-5 text-center">
                                <a class="btn btn-primary" href="accueil.php">Tableau de bord</a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end authentication section -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>

    </body>

</html>