<html lang="es">
<?php
    $title = "Inicio";
    include("includes/head.php");
?>
<?
if (isset($_GET)) {
  include_once("php/msg.php");
}
?>
<body>
    <?php
        include("includes/header.php");
        include("includes/preloader.php");
        include("modules/index.php");
        include("includes/redes.php");
        include("includes/footer.php");
        include("includes/scripts.php");
    ?>

</body>

</html>