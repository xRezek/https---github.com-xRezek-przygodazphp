<?php
   session_start();
   if(!isset($_SESSION['logged'])) {
    header("Location: index.php");
   }
 ?>  
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy</title>
</head>
<body>
    <?php
    echo "<p>Witaj ".$_SESSION['user']." <a href='logout.php'>Wyloguj się</a></p>";
    echo "<p><b>Drewno: </b> ".$_SESSION['drewno']."</p>";
    echo "<p><b>Kamień: </b> ".$_SESSION['kamien']."</p>";
    echo "<p><b>Zborze: </b> ".$_SESSION['zboze']."</p>";
    echo "<p><b>Dni premium: </b> ".$_SESSION['dnipremium']."</p>";
    
    
    
    
    ?>
    
</body>
</html>