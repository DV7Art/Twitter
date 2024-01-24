<?php
include "../init.php";
if (isset($_POST['showpopup']) && !empty($_POST['showpopup'])) {
    $tweetID = $_POST['showpopup'];
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    $tweet = $getFromT->getPopupTweet($tweetID);
    $likes = $getFromT->likes($user_id, $tweetID);
    $retweet = $getFromT->checkRetweet($tweetID, $user_id);
?>
    <div class="tweet-show-popup-wrap">
        <input type="checkbox" id="tweet-show-popup-wrap">
        <div class="wrap4">
            <label for="tweet-show-popup-wrap">
                <div class="tweet-show-popup-box-cut">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </label>
            <div class="tweet-show-popup-box">
                <div class="tweet-show-popup-inner">
                    <div class="tweet-show-popup-head">
                        <div class="tweet-show-popup-head-left">
                            <div class="tweet-show-popup-img">
                                <img src="<? echo BASE_URL . $tweet->profileImage ?>" />
                            </div>
                            <div class="tweet-show-popup-name">
                                <div class="t-s-p-n">
                                    <a href="<? echo BASE_URL . $tweet->username ?>">
                                        <? echo $tweet->screenName ?>
                                    </a>
                                </div>
                                <div class="t-s-p-n-b">
                                    <a href="<? echo BASE_URL . $tweet->username ?>">
                                        @<? echo $tweet->username ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tweet-show-popup-head-right">
                            <button class="f-btn"><i class="fa fa-user-plus"></i> Follow </button>
                        </div>
                    </div>
                    <div class="tweet-show-popup-tweet-wrap">
                        <div class="tweet-show-popup-tweet">
                            <? echo $getFromT->getTweetLinks($tweet->status) ?>
                        </div>
                        <div class="tweet-show-popup-tweet-ifram">
                            <? if (!empty($tweet->tweetImage)) { ?>
                                <img src="<? echo BASE_URL . $tweet->tweetImage ?>" />
                            <? } ?>
                        </div>
                    </div>
                    <div class="tweet-show-popup-footer-wrap">
                        <div class="tweet-show-popup-retweet-like">
                            <div class="tweet-show-popup-retweet-left">
                                <div class="tweet-retweet-count-wrap">
                                    <div class="tweet-retweet-count-head">
                                        RETWEET
                                    </div>
                                    <div class="tweet-retweet-count-body">
                                        <? echo $tweet->retweetCount ?>
                                    </div>
                                </div>
                                <div class="tweet-like-count-wrap">
                                    <div class="tweet-like-count-head">
                                        LIKES
                                    </div>
                                    <div class="tweet-like-count-body">
                                        <? echo $tweet->likesCount ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tweet-show-popup-retweet-right">

                            </div>
                        </div>
                        <div class="tweet-show-popup-time">
                            <span><? echo $tweet->postedOn ?></span>
                        </div>
                        <div class="tweet-show-popup-footer-menu">
                            <ul>
                                <? if ($getFromU->loggetIn()) {
                                    echo '<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>    
                                            <li>' . (($tweet->tweetID ?? '' === $retweet['retweetID']) ? '<button class="retweeted" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCounter">' . $tweet->retweetCount . '</span></button>' : '<button class="retweet" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCounter">' . (($tweet->retweetCount > 0) ? $tweet->retweetCount : '') . '</span></button>') . '</li>
                                            <li>' . (($likes['likeOn'] ?? '' === $tweet->tweetID) ? '<button class="unlike-btn" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">' . $tweet->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">' . (($tweet->likesCount > 0) ? $tweet->likesCount : '') . '</span></button>') . '</li>
                                                <li>
                                                <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                <ul> 
                                                <li><label class="deleteTweet">Delete Tweet</label></li>
                                                </ul>
                                            </li>';
                                } else {
                                ?>
                                    <li><button type="buttton"><i class="fa fa-share" aria-hidden="true"></i></button></li>
                                    <li><button type="button"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">RETWEET-COUNT</span></button></li>
                                    <li><button type="button"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCount">LIKES-COUNT</span></button></button></li>

                                <? } ?>
                                <!-- <li>
                                    <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                    <ul>
                                        <li><label class="deleteTweet">Delete Tweet</label></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div><!--tweet-show-popup-inner end-->
                <? if ($getFromU->loggetIn()) { ?>
                    <div class="tweet-show-popup-footer-input-wrap">
                        <div class="tweet-show-popup-footer-input-inner">
                            <div class="tweet-show-popup-footer-input-left">
                                <img src="<? echo BASE_URL . $user->profileImage ?>" />
                            </div>
                            <div class="tweet-show-popup-footer-input-right">
                                <input id="commentField" type="text" name="comment" placeholder="Reply to @username">
                            </div>
                        </div>
                        <div class="tweet-footer">
                            <div class="t-fo-left">
                                <ul>
                                    <li>
                                        <!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
		 				<input type="file" id="t-show-file"> -->
                                    </li>
                                    <li class="error-li">
                                    </li>
                                </ul>
                            </div>
                            <div class="t-fo-right">
                                <input type="submit" id="postComment">
                            </div>
                        </div>
                    </div><!--tweet-show-popup-footer-input-wrap end-->
                <? } ?>
                <div class="tweet-show-popup-comment-wrap">
                    <div id="comments">
                        <!--COMMENTS-->
                    </div>

                </div>
                <!--tweet-show-popup-box ends-->
            </div>
        </div>

    <?php
}
    ?>