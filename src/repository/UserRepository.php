<?php

namespace Repository;

require_once(__DIR__.'/../model/User.php');
require_once(__DIR__.'/../Config.php');
require_once(__DIR__.'/../Error/Error.php');

use Model\User;
use Error\Error;

class UserRepository
{
    public function create(User $user)
    {
        $cfg = new \Config();
        $db = $cfg->getDatabaseString()['database'];
        $conn = null;

        try {
            $conn = mysqli_connect($db['host'], $db['username'], $db['password'], $db['dbname']);
            $stmt = mysqli_prepare($conn, "INSERT INTO user (username, password, updated_at, created_at) VALUES (?,?, now(), now())");

            try {
                $stmt->bind_param("ss", $user->getUsername(), $user->getPassword());
                $stmt->execute();
            } finally {
                $stmt->close();
            }
        } catch (\Exception $e) {
            Error::SendServerError($e->getMessage());
        } finally {
            if ($conn!= null) {
                mysqli_close($conn);
            }
        }
    }
}