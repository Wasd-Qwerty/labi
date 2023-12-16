<?
  session_start();
  include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Авторизация</title>
</head>
<body>
  <?
  if(isset($_POST['doLogin'])) {
    $data = $_POST;
    if(trim($data['lPassword']) != "" && trim($data['lLogin']) != ""){
      $login = $data['lLogin'];
      $password = md5($data['lPassword']);
      
      $query = "SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password'";
      $result = mysqli_query($link, $query);
      
      if (mysqli_num_rows($result) == 1) {
        $_SESSION['logged_user'] = mysqli_fetch_assoc($result);
      }
      else {
        $_POST['loginForm'] = 1;
        echo "Неверный логин или пароль!";
      }
    }
    else {
      $_POST['loginForm'] = 1;
      echo "Поле логина или пароля пустое!";
    }
  }
  
  $regularCapitalLetter = '/[A-Z]/';
  $regularQuantity = '/\w{8,}/';
  $regularSymbols = '/[!@#$%^&*()\/\<>]/';
  if(isset($_POST['doSignup']) && !isset($_SESSION['logged_user'])){
    $data = $_POST;
    if(isset($data['sName']) &&  trim($data['sLogin']) != "" && trim($data['sPassword']) != "" && trim($data['sPassword2']) != ""){
      $name = $data['sName'];
      $login = $data['sLogin'];
      $password = $data['sPassword'];
      $password2 = $data['sPassword2'];
      if ($password == $password2) {
        if (preg_match($regularQuantity, $password)) {
          if (preg_match($regularCapitalLetter, $password)) {
            if (preg_match($regularSymbols, $password)) {
              $password = md5($password);
              $query = "SELECT * FROM `users` WHERE `login` = '$login'";
              $result = mysqli_query($link, $query);
              if (($result && mysqli_num_rows($result)) == 0) {
                $query = "INSERT INTO `users` (`name`, `login`, `password`) VALUES ('$name', '$login','$password')";
                $result = mysqli_query($link, $query);
                if ($result) {
                  $query = "SELECT * FROM `users` WHERE `login` = '$login'";
                  $result = mysqli_query($link, $query);
                  if($result){
                    $_SESSION['logged_user'] = mysqli_fetch_assoc($result);
                  }
                } 
                else {
                  $_POST['signupForm'] = 1;
                  echo "Ошибка при регистрации пользователя!"  . mysqli_error($link) . "<br><br>";
                }
              } 
              else {
                $_POST['signupForm'] = 1;
                echo "Пользователь с именем '$login' уже существует!" . "<br><br>";
              }
            } 
            else {
              $_POST['signupForm'] = 1;
              echo "Пароль должен содержать хотя бы один символ" . "<br><br>";
            }
          } 
          else {
            $_POST['signupForm'] = 1;
            echo "Пароль должен содержать хотя бы одну заглавную букву" . "<br><br>";
          }
        } 
        else {
          $_POST['signupForm'] = 1;
          echo "Длинна пароля должна быть больше 8" . "<br><br>";
        }
      } 
      else {
        $_POST['signupForm'] = 1;
        echo "Пароли должны совпадать!" . "<br><br>";
      }
    }
    else{
      $_POST['signupForm'] = 1;
      echo "Поле логина или пароля пустое!";
    }
  }

  if(isset($_POST['doRecovery'])){
    $data = $_POST;
    if (trim($data['rLogin']) && trim($data['rPassword1']) != "" && isset($data['rPassword2'])) {
      $login = $data['rLogin'];
      $password1 = $data['rPassword1'];
      $password2 = $data['rPassword2'];
      
      if ($password1 == $password2) {
        if (preg_match($regularQuantity, $password1)) {
          if (preg_match($regularCapitalLetter,$password1)) {
            if (preg_match($regularSymbols, $password1)) {
              $password1 = md5($password1);
              $query = "UPDATE `users` SET `password` = '$password1' WHERE `login` = '$login'";
              $result = mysqli_query($link, $query);
              $_POST['loginForm'] = 1;
            } 
            else {
              echo "Пароль должен содержать хотя бы один символ" . "<br><br>";
            }
          } 
          else {
            echo "Пароль должен содержать хотя бы одну заглавную букву" . "<br><br>";
          }
        } 
        else {
          echo "Длинна пароля должна быть больше 8" . "<br><br>";
        }
      } 
      else {
        echo "Пароли не совпадают!" . "<br><br>";
      }
    }
  }

  mysqli_close($link);
  
  if(isset($_POST['signOut']) && isset($_SESSION['logged_user'])){
    unset($_SESSION['logged_user']);
  }
  
?>

<form action = "" method = "post">
<?
  if (isset($_SESSION['logged_user'])) :?>
    <?echo "Привет, ".$_SESSION['logged_user']['name']?>
    <button name="signOut" type="submit">Выйти</button>
    <?else:?>
      <button name="loginForm" type="submit" >Войти</button>
      <button name="signupForm" type="submit" >Зарегистрироваться</button>
      <?endif
?>
  <?if(isset($_POST['loginForm'])):?>
    <h1>Вход</h1>
    <input name="lLogin" type="text" placeholder="Логин" value="<?= $_POST['lLogin']?>"><br><br>
    <input name="lPassword" type="password" placeholder="Пароль" value="<?= $_POST['lPassword']?>" ><br><br>
    <button name="doLogin" type="submit">Войти</button>
    <br><br>
    <button name="recoveryForm" type="submit">Восстановить пароль</button>
    
    <?elseif(isset($_POST['signupForm'])):?>
      <h1>Регистрация</h1>
      <input name="sName" type="text" placeholder="Имя" value="<?=$_POST['sName']?>"><br><br>
      <input name="sLogin" type="text" placeholder="Логин" value="<?=$_POST['sLogin']?>"><br><br>
      <label>Сгенерированный пароль:</label>
      <script> 
      var abc = "AaBbCcDdEeFfGgHhIiJiKkLlMmNnJjPpQqRrSsTtUuVvWwXxYyZz";
      var numbers = "0123456789";
      var sings = "-_@()#$%^&*";
      var symbols = abc + numbers + sings;
      var letters = abc + numbers;
      var password = "";
      getPassword();
      function getPassword () {
        var Fpart = abc;
        var Spart = symbols;
        var Tpart = letters; 
        password += Fpart[Math.floor(Math.random() * Fpart.length)];
        for (var i = 0; i <= 10; i++) {
          password += Spart[Math.floor(Math.random() * Spart.length)];
        }
        password += Tpart[Math.floor(Math.random() * Tpart.length)];
        document.writeln(password);
      }
      </script>
    <br>
    <button name="signupForm" type="submit">Перегенирировать</button>
    <br><br>
    <input name="sPassword" type="password" placeholder="Пароль" value="<?=$_POST['sPassword']?>"><br><br>
    <input name="sPassword2" type="password" placeholder="Повторите пароль" value="<?=$_POST['sPassword2']?>"><br><br>
    <button name="doSignup" type="submit">Зарегистрироваться</button>
  <?elseif(isset($_POST['recoveryForm'])):?>
    <h1>Восстановление пароля</h1>
    <input name = "rLogin" type="text" placeholder="Логин" value="<?= $_POST['rLogin']?>"><br><br>
    <input name = "rPassword1" type="password" placeholder="Новый пароль" value="<?= $_POST['rPassword1']?>"><br><br>
    <input name = "rPassword2" type="password" placeholder="Введите новый пароль ещё раз" value="<?= $_POST['rPassword2']?>"><br><br>
    <button name="doRecovery" type="submit">Войти</button>  
  <?endif?>
</form>
</body>

     