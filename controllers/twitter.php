<?php
include(__DIR__ . '/../vendor/twitteroauth/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class twitter_controller
{
    function __construct($params = null) {}
    
    function tweet_now($tweet)
    {
        // $a = get_declared_classes();
        // echo "<pre>"; print_r($a); echo "</pre>";
        
        $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);
        // $content = $connection->get("account/verify_credentials");
        $status = $connection->post("statuses/update", ["status" => $tweet]);
        
        if(@$status->created_at) echo "\nTweet successfully sent OK.\n";
        else
        {
            echo "\nError: Tweet not sent\n";
            print_r($status);
        }
    }

}
?>
