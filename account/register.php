
<?php
    include '../static/Header.php';

    // Include the function definition (assuming Create_Account() is defined elsewhere)
    // Ensure this path is correct relative to your current PHP file
    include '../functions/Account.php'; 

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Call Create_Account function
        $message = Create_Account();

        // Display or use $message as needed (e.g., show success/error message to the user)
    }
?>

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

    /* Add additional custom styling as needed */
</style>

<?=HeaderStatic("Ekay's Scents - Register")?>

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="../../logo.avif" alt="logo">
                                    <hr>
                                    <h4 class="mt-1 mb-5 pb-1">Sign Up</h4>
                                </div>

                                <!-- Error Message Display -->
                                <div class="errMsg text-center text-danger mb-3"><?=$message?></div>

                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">

                                    <div class="form-outline row mb-4">
                                        <div class="col-lg-6 col-12">
                                            <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" required>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name" required>
                                        </div>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="tel" id="contact" name="contact" class="form-control" placeholder="Contact Number">
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <input type="submit" name="submit" class="btn text-white btn-block fa-lg gradient-custom-2 mb-3" value="Sign Up">
                                        <a class="text-muted" href="#!">Forgot password?</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Already have an account?</p>
                                        <a href="../login/" class="btn btn-outline-danger">Login</a>
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

<script>
    function validateForm() {
        var firstName = document.getElementById('firstName').value.trim();
        var lastName = document.getElementById('lastName').value.trim();
        var email = document.getElementById('email').value.trim();
        var contact = document.getElementById('contact').value.trim();
        var password = document.getElementById('password').value;

        var errMsg = document.querySelector(".errMsg");
        errMsg.textContent = ""; // Clear previous error messages

        // Basic validation for required fields
        if (firstName === '') {
            errMsg.textContent = 'Please enter First Name';
            return false;
        }
        if (lastName === '') {
            errMsg.textContent = 'Please enter Last Name';
            return false;
        }
        if (email === '' || !isValidEmail(email)) {
            errMsg.textContent = 'Please enter a valid Email';
            return false;
        }
        if (password === '') {
            errMsg.textContent = 'Please enter a password';
            return false;
        }
        
        // Password strength validation
        if (password.length < 8) {
            errMsg.textContent = 'Password must be at least 8 characters long';
            return false;
        }
        if (!containsUpperCase(password) || !containsLowerCase(password) || !containsNumber(password)) {
            errMsg.textContent = 'Password must contain at least one uppercase letter, one lowercase letter, and one number';
            return false;
        }

        // Additional validation for contact number, if needed

        return true;
    }

    function isValidEmail(email) {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function containsUpperCase(str) {
        return /[A-Z]/.test(str);
    }

    function containsLowerCase(str) {
        return /[a-z]/.test(str);
    }

    function containsNumber(str) {
        return /\d/.test(str);
    }
</script>
