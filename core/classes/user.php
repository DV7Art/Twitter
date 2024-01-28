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

    public function search($search)
    {
        $stmt = $this->pdo->prepare("SELECT user_id, username, screenName, profileImage, profileCover FROM users WHERE username LIKE ?  OR screenName LIKE ?");
        $stmt->bindValue(1, $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(2, $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function register($email, $screenName, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (email,password,screenName,profileImage, profileCover) 
                                        VALUES (:email,:password,:screenName, 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png')");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":screenName", $screenName, PDO::PARAM_STR);
        $stmt->bindParam(":password",  md5($password), PDO::PARAM_STR);
        $stmt->execute();

        $user_id = $this->pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
    }

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();

        if ($count > 0) {
            $_SESSION['user_id'] = $user->user_id;
            header('Location: home.php');
            exit();
        } else {
            return false;
        }
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php');
        exit();
    }

    public function userData($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    public function create($table, $fields = array())
    {
        $columns = implode(',', array_keys($fields));
        $values = ':' . implode(', :', array_keys($fields));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        if ($stmt = $this->pdo->prepare($sql)) {
            foreach ($fields as $key => $data) {
                $stmt->bindValue(':' . $key, $data);
            }
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }
    }

    public function update($table, $user_id, $fields = array())
    {
        $columns = '';
        $i = 1;
        foreach ($fields as $name => $value) {
            $columns .= "{$name} = :{$name}";
            if ($i < count($fields)) {
                $columns .= ', ';
            }
            $i++;
        }
        $sql = "UPDATE {$table} SET {$columns} WHERE user_id = {$user_id}";
        if ($stmt = $this->pdo->prepare($sql)) {
            foreach ($fields as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        }
    }

    public function delete($table, $array)
    {
        $sql = "DELETE FROM {$table}";
        $where = " WHERE ";

        foreach ($array as $name => $value) {
            $sql .= "{$where} {$name} = :{$name}";
            $where = " AND ";
        }
        if ($stmt = $this->pdo->prepare($sql)) {
            foreach ($array as $name => $value) {
                $stmt->bindValue(':' . $name, $value);
            }
            $stmt->execute();
        }
    }

    public function checkEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        return $count > 0;
    }
    public function checkUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        return $count > 0;
    }

    public function checkPassword($password)
    {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE password = :password");
        $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        return $count > 0;
    }

    public function userIdByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->user_id;
    }

    public function loggetIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function uploadImage($file)
    {
        $fileName = basename($file['name']);
        $fileTemp = $file['tmp_name'];
        $fileSize = $file['size'];
        $error = $file['error'];

        $ext = explode('.', $fileName);
        $ext = strtolower(end($ext));
        $allowed_ext = array('jpg', 'png', 'jpeg');
        if (in_array($ext, $allowed_ext)) {
            if ($error === 0) {
                if ($fileSize <= 209_272_152) {
                    $fileRoot = 'users/' . $fileName;
                    move_uploaded_file($fileTemp, $_SERVER['DOCUMENT_ROOT'] . '/' . $fileRoot);
                    return $fileRoot;
                } else {
                    $GLOBALS['imageError'] = "The file size is too large!";
                }
            }
        } else {
            $GLOBALS['imageError'] = "The extension is not allowed!";
        }
    }

    public function timeAgo($datetime)
    {
        $time = strtotime($datetime);
        $current = time();
        $seconds = $current - $time;
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $months = round($seconds / 2600640);

        if ($seconds <= 60) {
            if ($seconds == 0) {
                return 'now';
            }
        } else if ($minutes <= 60) {
            return $minutes . "m";
        } else if ($hours <= 24) {
            return $hours . "h";
        } else if ($months <= 12) {
            return date('M j', $time);
        } else {
            return date('j M Y', $time);
        }
    }
}
