<?php
require 'vendor/autoload.php';
use Bunny\Client;

//Retrieve data from DB
$_wrabbitc_settings = get_option( 'wrabbitc_connection_settings' ); 		// Array of All Options
//$checkbox = $_wrabbitc_settings['checkbox']; 							// checkbox
$queue_name = $_wrabbitc_settings['queue_name']; 						// queue_name
$exange_name = $_wrabbitc_settings['exange_name']; 						// exange_name
$host = $_wrabbitc_settings['host']; 									// host
$vhost = $_wrabbitc_settings['vhost']; 									// vhost
$port = $_wrabbitc_settings['port']; 									// port
$user = $_wrabbitc_settings['user']; 									// user
$password = $_wrabbitc_settings['password']; 							// password
//$amqp_uri = $_wrabbitc_settings['amqp_uri']; 							// amqp_uri

/*
$CONNECTION_PARAMETERS =[
    'host'      => 'whale.rmq.cloudamqp.com',
    'port'      => '5672',
    'vhost'     => 'yokwwklz',    // The default vhost is /
    'user'      => 'yokwwklz', // The default user is guest
    'password'  => 'gcnT7x8-55lbE3z7H-Kv9Wjz62YrHWab', // The default password is guest
];*/

$CONNECTION_PARAMETERS =[
    'host'      => $host,
    'port'      => $port,
    'vhost'     => $vhost,
    'user'      => $user,
    'password'  => $password,
];

//add hoock
add_action( 'wp_ajax_wrabbitc_send_message' , 'wrabbitc_send_message_callback');
add_action( 'wp_ajax_nopriv_wrabbitc_send_message' , 'wrabbitc_send_message_callback' );
    
function wrabbitc_send_message_callback() {
    check_ajax_referer( 'my-special-string', 'security' );
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['proteins'])){
        $name= urldecode($_POST['name']);
        $mail = urldecode( $_POST['email'] );
        $proteins = urldecode( $_POST['proteins'] );
        $message=$name."\n".$mail."\n#".$proteins;
        sendMessage($message);
        $response = "Wellcome ".$name." your requiest(".$proteins.") will be alaborated, you will receive the results at indicated email(".$mail.")";
        echo $response;
    }else{
        echo "Error in submitted data";
    }
    wp_die(); // this is required to return a proper result
    }

function sendMessage($message)
    {
    $bunny = new Client($GLOBALS['CONNECTION_PARAMETERS']);
    $bunny->connect();
    $channel = $bunny->channel();
    $channel->queueDeclare($GLOBALS['queue_name'],false, true, false, false); // Queue name
    $channel->publish(
        $message,    // The message you're publishing as a string
        [],          // Any headers you want to add to the message
        '',          // Exchange name
        $GLOBALS['exange_name'] // Routing key, in this example the queue's name
    );
    $channel->close();
    $bunny->disconnect();
}