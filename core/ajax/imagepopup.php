<?php
include "../init.php";
if (isset($_POST['showImage']) && !empty($_POST['showImage'])) {
    $tweet_id = $_POST['showImage'];
    $user_id = $_SESSION['user_id'];
    $tweet = $getFromT->getPopupTweet($tweet_id);
    $likes = $getFromT->likes($user_id, $tweet_id);
    $retweet = $getFromT->checkRetweet($tweet_id, $user_id);
?>
    <div class="img-popup">
        <div class="wrap6">
            <span class="colose">
                <button class="close-imagePopup"><i class="fa fa-times" aria-hidden="true"></i></button>
            </span>
            <div class="img-popup-wrap">
                <div class="img-popup-body">
                    <img src="<? echo BASE_URL . $tweet->tweetImage ?>" />
                </div>
                <div class="img-popup-footer">
                    <div class="img-popup-tweet-wrap">
                        <div class="img-popup-tweet-wrap-inner">
                            <div class="img-popup-tweet-left">
                                <img src="<? echo BASE_URL . $tweet->profileImage ?>" />
                            </div>
                            <div class="img-popup-tweet-right">
                                <div class="img-popup-tweet-right-headline">
                                    <a href="<? echo BASE_URL . $tweet->username ?>"><? echo $tweet->screenName ?></a><span>@<? echo $tweet->username . '-' . $tweet->postedOn ?></span>
                                </div>
                                <div class="img-popup-tweet-right-body">
                                    <? echo $getFromT->getTweetLinks($tweet->status) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="img-popup-tweet-menu">
                        <div class="img-popup-tweet-menu-inner">
                            <ul>
                                <? if ($getFromU->loggetIn()) {
                                    echo ' <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>    
                                            <li>' . (($tweet->tweetID ?? '' === $retweet['retweetID']) ? '<button class="retweeted" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCounter">' . $tweet->retweetCount . '</span></button>' : '<button class="retweet" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCounter">' . (($tweet->retweetCount > 0) ? $tweet->retweetCount : '') . '</span></button>') . '</li>
                                            <li>' . (($likes['likeOn'] ?? '' === $tweet->tweetID) ? '<button class="unlike-btn" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">' . $tweet->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">' . (($tweet->likesCount > 0) ? $tweet->likesCount : '') . '</span></button>') . '</li>
                                           ' . (($tweet->tweetBy === $user_id) ? '
                                            <li><label for="img-popup-menu"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></label>
                                                <input id="img-popup-menu" type="checkbox" />
                                                <div class="img-popup-footer-menu">
                                                    <ul>
                                                        <li><label class="deleteTweet" data-tweet="' . $tweet->tweetID . '">Delete Tweet</label></li>
                                                    </ul>
                                                </div>
                                            </li>' : '');
                                } else {
                                    echo '  <li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
                                            <li><button class="retweet"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount"></span></button></li>
                                            <li><button class="like-btn"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter"></span></button></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Image PopUp ends-->
<?php

}
?>