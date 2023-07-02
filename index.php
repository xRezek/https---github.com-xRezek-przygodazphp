<?php
    session_start();
    if((isset($_SESSION['logged'])) && $_SESSION['logged']==true){
        header("Location: gra.php");
        exit();
    }
    
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tylko martwi ujrzeli koniec wojny.</h1>
    <p>Nie masz konta? <a href="rejestracja.php"><b>Zarejestuj się</b></a></p>
    <form action="zaloguj.php" method="POST">
    Login:<input name="login"><br><br>
    Hasło:<input type="password" name="haslo"><br><br>
    <input type="submit" value="Zaloguj się">

    </form>
<?php
    if(isset($_SESSION['error'])) echo $_SESSION['error'];
    if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
   // if(isset($_SESSION['blad_d'])) echo $_SESSION['blad_d'];
?>
    
</body>
</html>