<?php
class Follow extends User
{
    protected $tweet;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->tweet = new Tweet($this->pdo);
    }

    public function checkFollow($followerID, $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :user_id AND receiver = :followerID");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':followerID', $followerID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function followBtn($profileID, $user_id, $followID)
    {
        $data = $this->checkFollow($profileID, $user_id);
        if ($this->loggetIn()) {
            if ($profileID != $user_id) {
                if (!empty($data['receiver']) == $profileID) {
                    //followinf btn
                    return "<button class='f-btn following-btn follow-btn' data-follow='" . $profileID . "' data-profile='" . $followID . "'>Following</button>";
                } else {
                    //follow btn
                    return "<button class='f-btn follow-btn' data-follow='" . $profileID . "' data-profile='" . $followID . "'><i class='fa fa-user-plus'></i>Follow</button>";
                }
            } else {
                //edit button
                return "<button class='f-btn' onclick=location.href='profileEdit.php'>Edit Profile</button>";
            }
        } else {
            return "<button class='f-btn' onclick=location.href='index.php'><i class='fa fa-user-plus'></i>Follow</button>";
        }
    }

    public function follow($followID, $user_id, $profileID)
    {
        $this->create('follow', array('sender' => $user_id, 'receiver' => $followID, 'followOn' => date("Y:m:d H:i:s")));
        $this->addFollowCount($followID, $user_id);
        $stmt = $this->pdo->prepare("SELECT user_id, `following`, followers FROM users LEFT JOIN follow ON sender = :user_id AND CASE WHEN receiver = :user_id THEN sender = user_id END WHERE user_id = :profileID");
        $stmt->execute(array("user_id" => $user_id, "profileID" => $profileID));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }

    public function addFollowCount($followID, $user_id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET `following` = `following` + 1 WHERE user_id = :user_id; UPDATE users SET followers = followers + 1 WHERE user_id = :followID");
        $stmt->execute(array("user_id" => $user_id, "followID" => $followID));
    }

    public function unfollow($followID, $user_id, $profileID)
    {
        $this->delete('follow', array('sender' => $user_id, 'receiver' => $followID));
        $this->removeFollowCount($followID, $user_id);
        $stmt = $this->pdo->prepare("SELECT user_id, `following`, followers FROM users LEFT JOIN follow ON sender = :user_id AND CASE WHEN receiver = :user_id THEN sender = user_id END WHERE user_id = :profileID");
        $stmt->execute(array("user_id" => $user_id, "profileID" => $profileID));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }

    public function removeFollowCount($followID, $user_id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET `following` = `following` - 1 WHERE user_id = :user_id; UPDATE users SET followers = followers - 1 WHERE user_id = :followID");
        $stmt->execute(array("user_id" => $user_id, "followID" => $followID));
    }

    public function followingList($profileID, $user_id, $followID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` LEFT JOIN follow ON receiver = user_id AND CASE WHEN sender = :profileID THEN receiver = user_id END WHERE sender IS NOT NULL ");
		$stmt->bindParam(":profileID", $profileID, PDO::PARAM_INT);
        $stmt->execute();
        $followings = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($followings as $following) {
            echo '<div class="follow-unfollow-box">
                        <div class="follow-unfollow-inner">
                            <div class="follow-background">
                                <img src="' . BASE_URL . $following->profileCover . '"/>
                            </div>
                            <div class="follow-person-button-img">
                                <div class="follow-person-img"> 
                                    <img src="' . BASE_URL . $following->profileImage . '"/>
                                </div>
                                <div class="follow-person-button">
                                    <!-- FOLLOW BUTTON -->
                                    ' . $this->followBtn($following->user_id, $user_id, $followID) . '
                                </div>
                            </div>
                            <div class="follow-person-bio">
                                <div class="follow-person-name">
                                    <a href="' . BASE_URL . $following->username . '">' . $following->screenName . '</a>
                                </div>
                                <div class="follow-person-tname">
                                    <a href="' . BASE_URL . $following->username . '">' . $following->username . '</a>
                                </div>
                                <div class="follow-person-dis">
                                ' . $this->tweet->getTweetLinks($following->bio) . '
                                </div>
                            </div>
                        </div>
                    </div>';
        }
    }

    public function followersList($profileID, $user_id, $followID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users LEFT JOIN follow ON sender = user_id AND CASE WHEN receiver = :profileID THEN sender = user_id END WHERE user_id and receiver IS NOT NULL");
		$stmt->bindParam(":profileID", $profileID, PDO::PARAM_INT);
        $stmt->execute();
        $followings = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($followings as $following) {
            echo '<div class="follow-unfollow-box">
                        <div class="follow-unfollow-inner">
                            <div class="follow-background">
                                <img src="' . BASE_URL . $following->profileCover . '"/>
                            </div>
                            <div class="follow-person-button-img">
                                <div class="follow-person-img"> 
                                    <img src="' . BASE_URL . $following->profileImage . '"/>
                                </div>
                                <div class="follow-person-button">
                                    <!-- FOLLOW BUTTON -->
                                    ' . $this->followBtn($following->user_id, $user_id, $followID) . '
                                </div>
                            </div>
                            <div class="follow-person-bio">
                                <div class="follow-person-name">
                                    <a href="' . BASE_URL . $following->username . '">' . $following->screenName . '</a>
                                </div>
                                <div class="follow-person-tname">
                                    <a href="' . BASE_URL . $following->username . '">' . $following->username . '</a>
                                </div>
                                <div class="follow-person-dis">
                                ' . $this->tweet->getTweetLinks($following->bio) . '
                                </div>
                            </div>
                        </div>
                    </div>';
        }
    }
}
