 <?php
   session_start();

   if(!isset($_POST['login']) || !isset($_POST['haslo'])){
      header('Location: index.php');
      exit();
   }

   require_once "conn.php";
  
try{
    $connection = new mysqli($ip, $user, $haslo, $db);
if($connection->connect_errno!=0){
   throw new Exception(mysqli_connect_errno());
}else{
   $login = $_POST['login'];
   $haslo = $_POST['haslo'];

   $login= htmlentities($login, ENT_QUOTES,"UTF-8");   
  // $haslo= htmlentities($haslo, ENT_QUOTES,"UTF-8"); 
   
   if($result = $connection->query(sprintf("SELECT * FROM  uzytkownicy WHERE user='%s'",mysqli_real_escape_string($connection,$login)))){
      $ile = $result->num_rows;
      if($ile == 1){
         $row = $result->fetch_assoc();
         if(password_verify($haslo,$row['pass'])){   
            $_SESSION['logged'] = true;
         
            $_SESSION['id'] = $row['id'];
            $_SESSION['user'] = $row['user'];
            $_SESSION['drewno'] = $row['drewno'];
            $_SESSION['kamien'] = $row['kamien'];
            $_SESSION['zboze'] = $row['zboze'];
            $_SESSION['dnipremium'] = $row['dnipremium'];
            
            unset($_SESSION['error']);
            $result->free_result();
            header('Location: gra.php');
         }else{
            $_SESSION['error'] = "<span style='color:red'>Nieprawidłowy login lub hasło</span>";
            header('Location: index.php');
         }
      }else{
         
         $_SESSION['error'] = "<span style='color:red'>Nieprawidłowy login lub hasło</span>";
         header('Location: index.php');
          
      }
   }
    $connection->close();
}
   }catch(Exception $e){
      
      $_SESSION['blad_d'] = $e;
      $_SESSION['blad'] = '<span style="color red">Wystąpił problem z logowaniem.</span><br>';
      header('Location: index.php');
   }

   ?>
    
