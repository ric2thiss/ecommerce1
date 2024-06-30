
<?php
// Require
require_once '../../static/Header.php';

require('../../components/Navbar.php');
// require('../../components/Header.php');

?>

<?=HeaderStatic("Home")?>
    <body>
        <!-- Navigation-->
        <?php  
        echo Navbar();
        
        ?>
        <!-- Header-->
        <div class="container bg-prime">
            <h1>Profile</h1>
        </div>
        
    
        <?php
        include '../../components/Footer.php';
        ?>
    </body>
</html>
