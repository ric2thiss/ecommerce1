<?php
    include '../Account.php';
     function SecureRoute() {
        // session_start(); // Start the session

        // Check if the user is logged in
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: account/login.php'); // Redirect to the login page
            exit(); // Ensure no further code is executed
        }
    }


    function Navbar(){

        SecureRoute();
        

        // print_r($_SESSION);  
        ?> 

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container d-flex justify-content-between px-4 px-lg-5">
                        <a href="../index.php">
                            <picture>
                                <img src="../logo.avif" alt="" class="img-fluid">
                            </picture>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">Shop</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="../about.php">About</a></li> -->
                            </ul>

                            <?php
                            if(isset($_SESSION["logged_in"])){
                                $firstName = getAccountDetails($_SESSION["email"]);

                                ?>
                                <a class="mx-2 btn btn-default" href="../account/profile.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                        <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span><?php echo $firstName["FirstName"] ?></span>
                                </a>
                                <a href="../account/logout.php" class="btn">Logout</a>


                                <?php
                            }else{
                                ?>
                                <a href="../account/login/" class="mx-2 btn btn-default">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                </svg>
                                <span>Log In</span>
                            </a>

                                <?php
                            }
                            
                            ?>
                            <form class="d-flex" action="profile.php">
                                <button class="btn btn-outline-dark" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    Cart
                                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?=getCartCount()?></span>
                                </button>

                            </form>
                        </div>
                    </div>
                </nav>

        <?php

    }

?>