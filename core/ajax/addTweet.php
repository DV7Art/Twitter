<?php
include "../init.php";
if (isset($_POST) && !empty($_POST)) {
    $status = $getFromU->checkInput($_POST['status']);
    $user_id = $_SESSION['user_id'];
    $tweetImage = '';

    if (!empty($status) || !empty($_FILES['file']['name'][0])) {
        //если переменная $status не пуста или хотя бы одно имя файла в массиве $_FILES['file']['name'] не пусто
        if (!empty($_FILES['file']['name'][0])) {
            $tweetImage = $getFromU->uploadImage($_FILES['file']);
        }

        if (strlen($status) > 140) {
            $error = "The text of your tweet is too long";
        }
        $getFromU->create('tweets', array('status' => $status, 'tweetBy' => $user_id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
        preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
        if (!empty($hashtag)) {
            $getFromT->addTrend($status);
        }
        $result['success'] = "Yuor tweet has been posted :)";
        echo json_encode($result);
        // //fix: refresh of the page the last tweet tweets again.
        // header("Location:home.php");
        // exit;
    } else {
        $error = "Type or choose image to tweet";
    }

    if (isset($error)) {
        $result['error'] = $error;
        echo json_encode($result);
    }
}
