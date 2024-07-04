<?php
    require_once(__DIR__."/../../vendor/autoload.php");
    require_once(__DIR__."/../../src/controller/UserController.php");
    require_once(__DIR__."/../../src/Layout.php");

    use Controller\UserController;

    $userController = new UserController();

    $layout = new Layout();
    $layout->setTitle("회원가입")->csrf()->apply("default");

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "Login";
    }
?>
<div class="container">
    <h1>팀짱 - 회원가입</h1>
    <form action="./join.php" method="post">
        <label for="username">로그인</label>
        <input id="username" type="text" name="username" placeholder="아이디">
        <label for="password">비밀번호</label>
        <input id="password" type="password" name="password">

        <input type="submit" value="로그인하기">
    </form>
</div>
<script type="text/javascript">
    var noti = new Noti();
    noti.queue('sdfsdf', 'sdfsdf');
    noti.queue('sdfsdf', 'sdfsdf');
    noti.queue('sdfsdf', 'sdfsdf');
</script>