<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laba3</title>
</head>
<body>
    <a href="?id=1">Страница 1</a>
    <a href="?id=2">Страница 2</a>
    <a href="?id=3">Страница 3</a>

    <?
        include "db.php";
        $data = $_GET;
        if(trim($data['id']) != ""){
            $query = "SELECT * FROM `tags` WHERE `id` = '{$data['id']}'";
            $result = mysqli_query($link, $query);
            if ($result){
                echo mysqli_fetch_assoc($result)['tags'];
            } 
        }
    ?>
</body>
</html>