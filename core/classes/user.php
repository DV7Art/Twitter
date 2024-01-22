<?php
class User
{
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkInput($input)
    {
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        $input = trim($input);

        return $input;
    }

    function login($email, $password)
    {
        $id = 0;
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE `email` = :email AND `password` = :password");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
    }
}
