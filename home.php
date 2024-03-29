<?php
include 'core/init.php';
$user_id = $_SESSION['user_id'];
$user = $getFromU->userData($user_id);
if ($getFromU->loggetIn() === false) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['tweet'])) {
    $status = $getFromU->checkInput($_POST['status']);
    $tweetImage = '';

    if (!empty($status) || !empty($_FILES['file']['name'][0])) {
        //если переменная $status не пуста или хотя бы одно имя файла в массиве $_FILES['file']['name'] не пусто
        if (!empty($_FILES['file']['name'][0])) {
            $tweetImage = $getFromU->uploadImage($_FILES['file']);
        }

        if (strlen($status) > 140) {
            $error = "The text of your tweet is too long";
        }
        $tweet_id = $getFromU->create('tweets', array('status' => $status, 'tweetBy' => $user_id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
        preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
        if (!empty($hashtag)) {
            $getFromT->addTrend($status);
        }
        //fix: refresh of the page the last tweet tweets again.
        header("Location:home.php");
        exit;
    } else {
        $error = "Type or choose image to tweet";
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Hi, <? echo $user->screenName; ?></title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" />
    <link rel="stylesheet" href="assets/css/style-complete.css" />
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <!-- header wrapper -->
        <div class="header-wrapper">

            <div class="nav-container">
                <!-- Nav -->
                <div class="nav">

                    <div class="nav-left">
                        <ul>
                            <li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                            <?php if ($getFromU->loggetIn() === true) { ?>
                                <li><a href="<?php echo BASE_URL; ?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
                                <li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
                            <?php } ?>

                        </ul>
                    </div>

                    <div class="nav-right">
                        <ul>
                            <li>
                                <input type="text" placeholder="Search" class="search" />
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <div class="search-result">
                                </div>
                            </li>

                            <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo $user->profileImage ?>" /></label>
                                <input type="checkbox" id="drop-wrap1">
                                <div class="drop-wrap">
                                    <div class="drop-inner">
                                        <ul>
                                            <li><a href="<?php echo $user->username ?>"><?php echo $user->username ?></a></li>
                                            <li><a href="settings/account">Settings</a></li>
                                            <li><a href="includes/logout.php">Log out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li><label class="addTweetBtn">Tweet</label></li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
        <script src="assets/js/search.js"></script>
        <script src="assets/js/hashtag.js"></script>
        <!---Inner wrapper-->

        <div class="inner-wrapper">
            <div class="in-wrapper">
                <div class="in-full-wrap">
                    <div class="in-left">
                        <div class="in-left-wrap">
                            <div class="info-box">
                                <div class="info-inner">
                                    <div class="info-in-head">
                                        <!-- PROFILE-COVER-IMAGE -->
                                        <img src="<?php echo $user->profileCover ?>" />
                                    </div>
                                    <div class="info-in-body">
                                        <div class="in-b-box">
                                            <div class="in-b-img">
                                                <!-- PROFILE-IMAGE -->
                                                <img src="<?php echo $user->profileImage ?>" />
                                            </div>
                                        </div>
                                        <div class="info-body-name">
                                            <div class="in-b-name">
                                                <div><a href="<?php echo $user->username ?>"><?php echo $user->screenName ?></a></div>
                                                <span><small><a href="<?php echo $user->username ?>">@<?php echo $user->username ?></a></small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-in-footer">
                                        <div class="number-wrapper">
                                            <div class="num-box">
                                                <div class="num-head">
                                                    TWEETS
                                                </div>
                                                <div class="num-body">
                                                    <? $getFromT->countTweets($user_id) ?>
                                                </div>
                                            </div>
                                            <div class="num-box">
                                                <div class="num-head">
                                                    FOLLOWING
                                                </div>
                                                <div class="num-body">
                                                    <span class="count-following"><?php echo $user->following ?></span>
                                                </div>
                                            </div>
                                            <div class="num-box">
                                                <div class="num-head">
                                                    FOLLOWERS
                                                </div>
                                                <div class="num-body">
                                                    <span class="count-followers"><?php echo $user->followers ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--==TRENDS==-->


                        </div>
                    </div>
                    <div class="in-center">
                        <div class="in-center-wrap">
                            <!--TWEET WRAPPER-->
                            <div class="tweet-wrap">
                                <div class="tweet-inner">
                                    <div class="tweet-h-left">
                                        <div class="tweet-h-img">
                                            <!-- PROFILE-IMAGE -->
                                            <img src="<?php echo $user->profileImage ?>" />
                                        </div>
                                    </div>
                                    <div class="tweet-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <textarea class="status" name="status" placeholder="Type Something here!" rows="4" cols="50" maxlength="140"></textarea>
                                            <div class="hash-box">
                                                <ul>
                                                </ul>
                                            </div>
                                    </div>
                                    <div class="tweet-footer">
                                        <div class="t-fo-left">
                                            <ul>
                                                <input type="file" name="file" id="file" />
                                                <li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                                    <span class="tweet-error"><? if (isset($error)) {
                                                                                    echo $error;
                                                                                } elseif (isset($imageError)) {
                                                                                    echo $imageError;
                                                                                } ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="t-fo-right">
                                            <span id="count">140</span>
                                            <input type="submit" name="tweet" value="tweet" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tweets">
                                <? $getFromT->tweets($user_id, 10) ?> <!--10 - limit for displaying tweets -->
                            </div>

                            <!--TWEETS SHOW WRAPPER-->
                            <div class="loading-div">
                                <img id="loader" src="assets/images/loading.svg" style="display: none;" />
                            </div>
                            <div class="popupTweet"></div>
                            <script src="assets/js/like.js"></script>
                            <script src="assets/js/retweet.js"></script>
                            <script src="assets/js/popup.js"></script>
                            <script src="assets/js/comment.js"></script>
                            <script src="assets/js/delete.js"></script>
                            <script src="assets/js/popupForm.js"></script>
                            <script src="assets/js/fetch.js"></script>
                            <script src="assets/js/messages.js"></script>
                            <script src="assets/js/postMessage.js"></script>
                        	</div><!-- in left wrap-->
		</div><!-- in center end -->

		<div class="in-right">
			<div class="in-right-wrap">

		 	<!--Who To Follow-->
		 	 <?php $getFromF->whoToFollow($user_id, $user_id); ?>
      		<!--Who To Follow-->

 			</div><!-- in left wrap-->
 			 <script type="text/javascript" src="assets/js/follow.js"></script>
		</div><!-- in right end -->

	</div><!--in full wrap end-->
 </div><!-- in wrappper ends-->
</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>

</html>