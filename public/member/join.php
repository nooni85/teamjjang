<?php
    require_once("../../vendor/autoload.php");
    require_once("../../src/model/User.php");
    require_once("../../src/repository/UserRepository.php");

    use Repository\UserRepository;
    use Model\User;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usr = new User();
        $usr->setUsername($_POST['username']);
        $usr->setPassword($_POST['password']);

        $userRepository = new UserRepository();
        $userRepository->create($usr);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./join.php" method="post">
        <input type="text" name="username">
        <input type="password" name="password">
        <input type="submit" value="login">
    </form>
</body>
</html>