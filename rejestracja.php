<?php
    session_start();
     
    if(isset($_POST['email'])){
        // Udana walidacja
        $good = true;

        // Nickname check
        $nick = $_POST['nick'];
        // length check
        if(strlen($nick)<3 || strlen($nick)>20){
            $good = false;
            $_SESSION['e_nick'] ="Nick musi posiadać od 3 do 20 znaków"; 
        }
        if(!ctype_alnum($nick)){
            $good = false;
            $_SESSION['e_nick'] = "Nick może zawierać tylko cyfry i litery alfabetu łacińskiego ";
        }
       
        // e-mail check
        $email = $_POST['email'];
        $email_good = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email_good,FILTER_VALIDATE_EMAIL) || $email_good != $email ){
            $good = false;
            $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
        }

        // password check
        $password = $_POST['pass1'];
        $password_c = $_POST['pass2'];
        if(strlen($password) < 8 || strlen($password) > 20){
            $good = false;
            $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
        }
        if($password != $password_c){
            $good = false;
            $_SESSION['e_password_c'] = "Hasła muszą być identyczne";
        }

        $password_hash = password_hash($password,PASSWORD_DEFAULT);

        // checkbox check
        if(!isset($_POST['check'])){
            $good = false;
            $_SESSION['e_checkbox'] = "Zaakceptuj regulamin";
        }

        // captcha check
        $captcha_secret = "6LfG7LImAAAAABwgHLrEFDY2tAtOc5v4hzFdk-Re";
        $captcha_check = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret.'&response='.$_POST['g-recaptcha-response']);
        $answer = json_decode($captcha_check);

        if($answer->success==false){
            $good = false;
            $_SESSION['e_captcha'] = "Zaakceptuj captche";
        }

        // * zapamiętaj poprawne dane
        $_SESSION['fr-nick'] = $nick;
        $_SESSION['fr-email'] = $email;
        $_SESSION['fr-password'] = $password;
        $_SESSION['fr-password_c'] = $password_c;
        if(isset($_POST['check'])) $_SESSION['fr-check'] = true;
        require_once "conn.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
               
            $conn = new mysqli($ip,$user,$haslo,$db);
            if($conn->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }else{
                $result = $conn->query("SELECT id FROM uzytkownicy WHERE email='$email'");
                if(!$result) throw new Exception($conn->error);
                $email_amount = $result->num_rows;
                if($email_amount>0){
                    $good = false;
                    $_SESSION['e_email'] = "Istnieje już konto o podanym adresie email";

                }
                // Nick check
                $result = $conn->query("SELECT id FROM uzytkownicy WHERE user='$nick'");
                if(!$result) throw new Exception($conn->error);
                $nick_amount = $result->num_rows;
                if($nick_amount>0){
                    $good = false;
                    $_SESSION['e_nick'] = "Istnieje już gracz o podanym nicku";

                }
                if($good==true){
                    //it works!
                    if($conn->query("INSERT INTO uzytkownicy VALUES(NULL,'$nick','$password_hash','$email', 100, 100, 100, 14)")){
                        $_SESSION['everythingIsGood'] = true;
                        header('Location: witamy.php');

                    }else{
                        throw new Exception($conn->error);
                    }
                    
                }

                $conn->close();
            }

        }catch(Exception $e){
            echo "<span class='error'> Błąd serewera. Przepraszamy za utrudnienia.</span>";
            echo $e;
        }

        
    }
    
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer ></script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfG7LImAAAAAB7MfliCnw7U-hno6WCX-VgzIAA2"></script>
    <style>
        .error{
            color:red;
            margin-top:10px ;
            margin-bottom: 10px;
        }
    </style>

    <title>Document</title>
</head>
<body>
    <h1>Tylko martwi ujżeli koniec wojny.</h1>
    <p>Masz już konto? <a href="index.php"><b>Zaloguj się</b></a></p>
    <form method="POST">
        <label for="nick">Nickname <br><input type="text" value="<?php 
            if(isset($_SESSION['fr-nick'])){
                echo $_SESSION['fr-nick'];
                unset($_SESSION['fr-nick']);
            }
        ?>" name="nick" id="nick"></label> <br>
            <?php 
                if(isset($_SESSION['e_nick'])){
                echo "<span class='error'>".$_SESSION['e_nick']."</span>" ;
                unset($_SESSION['e_nick']);
                }
            ?>
        <br>
        <label for="email">E-mail  <br><input type="email" value="<?php 
            if(isset($_SESSION['fr-email'])){
                echo $_SESSION['fr-email'];
                unset($_SESSION['fr-email']);
            }
        ?>" name="email" id="email"></label><br>
            <?php 
                if(isset($_SESSION['e_email'])){
                echo "<span class='error'>".$_SESSION['e_email']."</span>" ;
                unset($_SESSION['e_email']);
                }
            ?>
        <br>
        <label for="pass1">Twoje hasło <br><input type="password" value="<?php 
            if(isset($_SESSION['fr-password'])){
                echo $_SESSION['fr-password'];
                unset($_SESSION['fr-password']);
            }
        ?>" name="pass1" id="pass1"></label><br>
            <?php 
                if(isset($_SESSION['e_password'])){
                echo "<span class='error'>".$_SESSION['e_password']."</span>" ;
                unset($_SESSION['e_password']);
                }
        ?>
        <br>
        <label for="pass2">Powtórz hasło <br><br><input type="password" value="<?php 
            if(isset($_SESSION['fr-password_c'])){
                echo $_SESSION['fr-password_c'];
                unset($_SESSION['fr-passwor_c']);
            }
        ?>" name="pass2" id="pass2"></label><br>
            <?php 
                if(isset($_SESSION['e_password_c'])){
                echo "<span class='error'>".$_SESSION['e_password_c']."</span>" ;
                unset($_SESSION['e_password_c']);
                }
            ?>
        <br>
        <label for="check"><input type="checkbox" name="check" <?php
            if(isset($_SESSION['fr-check']))
            echo "checked";
            unset($_SESSION['fr-check']);
        
        ?> id="check">Akceptuje regulamin</label><br>
            <?php 
                if(isset($_SESSION['e_checkbox'])){
                echo "<span class='error'>".$_SESSION['e_checkbox']."</span>" ;
                unset($_SESSION['e_checkbox']);
                }
            ?>
        <br>
        <div class="g-recaptcha" data-sitekey="6LfG7LImAAAAAB7MfliCnw7U-hno6WCX-VgzIAA2"></div>
            <?php 
                if(isset($_SESSION['e_captcha'])){
                echo "<span class='error'>".$_SESSION['e_captcha']."</span>" ;
                unset($_SESSION['e_captcha']);
                }
            ?>
        <br>
        <input type="submit" value="Zarejestruj się">
    </form>

   
</body>
</html>