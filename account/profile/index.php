
<?php
// Require
require_once '../../static/Header.php';

require('../../components/Navbar.php');
require('../../components/Header.php');

?>

<?=HeaderStatic("Home")?>
    <body>
        <!-- Navigation-->
        <?php  
        echo Navbar();
        
        ?>
        <!-- Header-->
        <?php
        echo Headers();
        ?>
        
    
        <?php
        include '../../components/Footer.php';
        ?>
    </body>
</html>
