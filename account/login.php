

<style>
    .gradient-custom-2 {
        background: #ee9ca7;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #FF89A4, #ee9ca7);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #FF89A4, #ee9ca7); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    @media (min-width: 768px) {
        .gradient-form {
            height: 100vh !important;
        }
    }
    @media (min-width: 769px) {
        .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
    }
</style>

<?php
    include '../Header.php';

    include '../Account.php'; 

    session_start();

    $login_error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validate credentials (example logic, replace with your actual validation)
        if (Validate_Login($email, $password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            
            $mail = getAccountDetails($email);
            
            // Ensure $mail contains the UserID key
            if (isset($mail['UserID'])) {
                $_SESSION['UserID'] = $mail['UserID'];
            } else {
                // Handle the case where UserID is not set in $mail
                $login_error = 'User details not found. Please contact support.';
            }
            
            // Redirect to dashboard or any other page after successful login
            header('Location: profile.php');
            exit;
        } else {
            // Handle invalid credentials scenario
            $login_error = 'Invalid email or password. Please try again.';
        }
    }

    if (!empty($_SESSION["email"]) && $_SESSION["logged_in"]) {
        header('Location: profile.php');
        exit;
    }

?>

<?=HeaderStatic("Ekay's Scents - Log In")?>

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="../logo.avif" alt="logo" class="img-fluid">
                                    <hr>
                                    <h4 class="mt-1 mb-5 pb-1">Log In</h4>
                                </div>

                                <form method="POST">

                                    <!-- Display login error message if present -->
                                    <?php if (!empty($login_error)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $login_error ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log In</button>
                                        <a class="text-muted" href="#!">Forgot password?</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Don't have an account?</p>
                                        <a href="../account/register.php" class="btn btn-outline-danger">Create new</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">We are more than just a company</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
