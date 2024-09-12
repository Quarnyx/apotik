<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

    <head>
        
        <title><?php echo $language["Error_404"]; ?> | Symox - Admin & Dashboard Template</title>

        <?php include 'layouts/head.php'; ?>

        <?php include 'layouts/head-style.php'; ?>

    </head>

    <?php include 'layouts/body.php'; ?>

    <div class="authentication-bg min-vh-100" style="background: url(./assets/images/auth-bg.jpg) bottom;" >
        <div class="bg-overlay bg-light"></div>
        <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="home-wrapper text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-9">
                                        <div class="error-img">
                                            <img src="assets/images/404-img.png" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="text-uppercase mt-5">Sorry, page not found</h4>
                            <p class="text-muted">It will be as simple as Occidental in fact, it will be Occidental</p>
                            <div class="mt-5">
                                <a class="btn btn-primary waves-effect waves-light" href="index.php">Back to Dashboard</a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end authentication section -->

        <?php include 'layouts/vendor-scripts.php'; ?>

    </body>
</html>
