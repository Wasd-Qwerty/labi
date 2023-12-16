<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>laba1</title>
</head>
<body>
  <?
        if(isset($_POST['findResult'])){
            $sum = 0;
            $N = $_POST['N'];
            $x = $_POST['x']; 
            if(is_finite($x)){
                for($n = 0; $n <= $N; $n++){
                    $facN = 1;
                    if($n == 0) $facN = 1;
                    for($i = 1; $i <= $n; $i++){
                        $facN *= $i;
                    }
                    $sum += ((-1)**$n*($x**$n))/$facN;
                }
                echo $sum;
            } else{
                echo "Введённое значение X не соответствует условию ";
            }
        }
    ?>
        <form method="post">
            <input type = "text" placeholder="Введите n" name = "N">
            <input type = "text" placeholder="Введите x" name = "x">
            <button name="findResult" type="sumbit">Посчитать</button>
        </form>
</body>
</html>