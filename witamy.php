<?php
    session_start();
    if(!isset($_SESSION['everythingIsGood'])){
        header("Location: index.php");
        exit();
    }else{
        unset($_SESSION['everythingIsGood']);
    }
    // usuwamy zmiene pamiętające zmienne przy nie udanej walidacji
    if(isset($_SESSION['fr-nick'])) unset($_SESSION['fr-nick']);
    if(isset($_SESSION['fr-email'])) unset($_SESSION['fr-email']);
    if(isset($_SESSION['fr-password'])) unset($_SESSION['fr-password']);
    if(isset($_SESSION['fr-password_c'])) unset($_SESSION['fr-password_c']);
    if(isset($_SESSION['fr-check'])) unset($_SESSION['fr-check']);

    // usuwanie błędów rejestracji
    if(isset( $_SESSION['e_nick'])) unset($_SESSION['e_nick']);
    if(isset( $_SESSION['e_email'])) unset($_SESSION['e_email']);
    if(isset( $_SESSION['e_password'])) unset($_SESSION['e_password']);
   // if(isset( $_SESSION['e_password_c'])) unset($_SESSION['e_password_c']);
    if(isset( $_SESSION['e_checkbox'])) unset($_SESSION['e_checkbox']);
    if(isset( $_SESSION[$_SESSION['e_captcha']])) unset($_SESSION['e_captcha']);

    
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
    <h1>Dziękujemy za rejestrację</h1>
    <form action="zaloguj.php" method="POST">
    Login:<input name="login"><br><br>
    Hasło:<input type="password" name="haslo"><br><br>
    <input type="submit" value="Zaloguj się">

    </form>
<?php
    if(isset($_SESSION['error'])) echo $_SESSION['error'];
?>
    
</body>
</html>