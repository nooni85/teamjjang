<?php

namespace Controller;

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../repository/UserRepository.php");

use Model\User;
use Repository\UserRepository;

class UserController
{
    public function create(string $username, string $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);

        $userRepository = new UserRepository();
        $userRepository->create($user);
    }
}
