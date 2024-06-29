<?php
    require_once(__DIR__."/../../vendor/autoload.php");
    require_once(__DIR__."/../../src/controller/UserController.php");
    require_once(__DIR__."/../../src/Layout.php");


    use Controller\UserController;

    $userController = new UserController();

    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
    } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_REQUEST['csrf'])) {
            if (hash_equals($_SESSION['csrf'], $_REQUEST['csrf'])) {
                $userController->create($_REQUEST['username'], $_REQUEST['password']);
            } else {
                // Log this as a warning and keep an eye on these attempts
                echo("폼이 유효하지 않습니다.");
            }
        }
    }


    $layout = new Layout();
    $layout->setTitle("회원가입")
        ->plugin("noti")
        ->apply("default");
?>
<div class="container">
    <h1>팀짱 - 회원가입</h1>
    <form action="./join.php" method="post">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <label for="username">로그인</label>
        <input id="username" type="text" name="username" placeholder="아이디">
        <label for="password">비밀번호</label>
        <input id="password" type="password" name="password">

        <input type="submit" value="로그인하기">
    </form>
</div>
