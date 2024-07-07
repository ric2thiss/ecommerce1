<?php
// Start the session at the beginning of the script
session_start();

include "Account.php";
// Require necessary files
require_once '../Header.php';
require('../components/Header.php');
$user = getAccountDetails($_SESSION["email"]);
// Check if the user is logged in
if (empty($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}

?>

<?=HeaderStatic("Something Went Wrong!")?>
        <style>
            .card:hover{
                box-shadow: 0px 8px 22px 0px rgba(0,0,0,0.1);
            }
            .profile_details{
                display: flex;
                align-items: center;
            }
         </style>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container d-flex justify-content-between px-4 px-lg-5">
                    <a href="index.php">
                        <picture>
                            <source srcset="https://purebloom.ch/cdn/shop/files/PureBloom_Logo.png?v=1697338824&width=400" media="(min-width: 768px)">
                            <img src="https://purebloom.ch/cdn/shop/files/PureBloom_Logo.png?v=1697338824&width=400" alt="logo">
                        </picture>
                    </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Shop</a></li>
                                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                            </ul>

                            <?php
                            if(isset($_SESSION["logged_in"])){
                                $firstName = getAccountDetails($_SESSION["email"]);

                                ?>
                                <a href="./account/profile.php" class="mx-2 btn btn-default">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                        <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span><?php echo $firstName["FirstName"] ?></span>
                                </a>
                                <a href="account/logout.php" class="btn">Logout</a>


                                <?php
                            }else{
                                ?>
                                <a href="../account/login.php" class="mx-2 btn btn-default">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                </svg>
                                <span>Log In</span>
                            </a>

                                <?php
                            }
                            
                            ?>
                            <a href="account/profile.php" class="d-flex text-decoration-none">
                                <button class="btn btn-outline-dark">
                                    <i class="bi bi-cart-fill me-1"></i>
                                    Cart
                                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?= getCartCount() ?></span>
                                </button>
                            </a>

                        </div>
                    </div>
                </nav>

        <!-- Header-->
        
        <div class="container p-5 mt-5 mb-5" style="background-color: #FE9FB3;">
            <!-- <h1 class="text-white">Profile</h1> -->
            <div class="profile_details text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="white" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <div class="p-2">
                    <h3><?php echo $user["FirstName"] .  " " . $user["LastName"] ?></h3>
                    <span><?php echo ($user["Role"]) ? "Admin": "Member"; ?> since <?php echo $user["RegDate"] ?></span>
                </div>
            </div>
        </div>
        <div class="container pb-5 pt-5">
            <a href="profile.php">Go back</a>
            <h1 class="pb-5 pt-5">Something went wrong. Try again!</h1>
        </div>
        <?php
        include 'components/Footer.php';
        ?>
    </body>
</html>
