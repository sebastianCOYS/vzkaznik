
<?php 
// require_once("../../../wp-load.php");
global $wpdb;
$error = 0;
if(!isset($_POST['message']) OR !isset($_POST['email'])){
    $error++;
} 

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error++;
}

if (empty($_POST['message']) OR strlen($_POST['message']) < 20 OR strlen($_POST['message']) > 1000 ) {
    $error++;
}
if ($error === 0){
    $message = $_POST['message'];
    $email = $_POST['email'];
    $date = date('Y-m-d H:i:s');
    
    $table_name = $wpdb->prefix . "vzkaznik";
    $wpdb->insert($table_name, array('time' => $date, 'email' => $email, 'text' => $message ));
}

$home = home_url();
header("location:". $home);
exit;

