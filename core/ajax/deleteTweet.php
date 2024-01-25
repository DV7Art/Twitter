<?php
include "../init.php";
if (isset($_POST['deleteTweet']) && !empty($_POST['deleteTweet'])) {
    $tweetID = $_POST['deleteTweet'];
    $user_id = $_SESSION['user_id'];
    $tweet = $getFromT->delete('tweets', array('tweetID' => $tweetID, 'tweetBy' => $user_id));
}
if (isset($_POST['showpopup']) && !empty($_POST['showpopup'])) {
    $tweetID = $_POST['showpopup'];
    $user_id = $_SESSION['user_id'];
    //$user = $getFromU->userData($user_id);
    $tweet = $getFromT->getPopupTweet($tweetID);
    //$likes = $getFromT->likes($user_id, $tweetID);
    //$retweet = $getFromT->checkRetweet($tweetID, $user_id);
    //$comments = $getFromT->comments($tweetID);
?>
    <div class="retweet-popup">
        <div class="wrap5">
            <div class="retweet-popup-body-wrap">
                <div class="retweet-popup-heading">
                    <h3>Are you sure you want to delete this Tweet?</h3>
                    <span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
                </div>
                <div class="retweet-popup-inner-body">
                    <div class="retweet-popup-inner-body-inner">
                        <div class="retweet-popup-comment-wrap">
                            <div class="retweet-popup-comment-head">
                                <img src="<? echo BASE_URL . $tweet->profileImage ?>" />
                            </div>
                            <div class="retweet-popup-comment-right-wrap">
                                <div class="retweet-popup-comment-headline">
                                    <a><? echo $tweet->screenName ?> </a><span>‏@<? echo $tweet->username . ' - ' . $tweet->postedOn ?></span>
                                </div>
                                <div class="retweet-popup-comment-body">
                                    <? echo $tweet->status . ' ' . $tweet->tweetImage ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="retweet-popup-footer">
                    <div class="retweet-popup-footer-right">
                        <button class="cancel-it f-btn">Cancel</button><button class="delete-it" type="submit">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>