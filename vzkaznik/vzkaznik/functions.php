<?php
function create_vzkaznik_menu() {
    add_menu_page("vzkaznik","vzkazník", "administrator", "vzkaznik","gen_vzkaznik");
}
function create_vzkaznik_settings_menu() {
    add_options_page("vzkaznik_settings","nastavení vzkazníku", "administrator", "vzkaznik_settings","gen_vzkaznik_settings");
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}
//vzkaznik menu page
function gen_vzkaznik(){
    global $wpdb;
    $table_name = $wpdb->prefix."vzkaznik";
    $fetch_data = $wpdb->get_results("SELECT * from $table_name");
    foreach ($fetch_data as $data){ 
        echo "</br>";?>
        <p><?php echo esc_html($data->id)."."; ?></p> <!-- esc_html proti XSS-->
        <b><p><?php echo esc_html($data->email); ?></p></b>
        <p> <?php echo esc_html($data->time); ?></p>
        <p><?php echo esc_html($data->text); ?></p>
        
    <?php  }
    
}

//vzkaznik settings menu page
function gen_vzkaznik_settings(){
    global $wpdb;
    echo "Ahoj světe, já jsem Vzkazník settings :)";
}

//Vytvoří formu
function vzkaznik(){
    echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">
    <input type="hidden" name="action" value="vzkaznik_form">
    <label for="email">email:</label>
    <input type="email" id="email" name="email" required/>
    <label for="message">message:</label>
    <textarea id="message" name="message" title="between 20 and 1000 characters" minlength="20" maxlength="1000" required></textarea>
    <input type="submit" />
  </form>';
}

//******************************************************************- */
// Vytvoří tabulku ve wordpress $DB
function create_vzkaznik_table_in_db(){
    global $wpdb;
    $table_name = $wpdb->prefix."vzkaznik";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    email varchar(255) NOT NULL,
    text text NOT NULL,
    PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
/****************************************************************** */
//WP hook form handling via wp-admin
//pouzil jsem https://www.sitepoint.com/handling-post-requests-the-wordpress-way/
//ale místo theme functions.php je tento kod v plugin functions.php
function prefix_post_data_to_db() {
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
        date_default_timezone_set('Europe/Prague');
        $date = date('Y-m-d H:i:s');
        
        $table_name = $wpdb->prefix . "vzkaznik";
        $wpdb->insert($table_name, array('time' => $date, 'email' => $email, 'text' => $message ));
    }

    $home = home_url();
    header("location:". $home);

}

add_action( 'admin_post_nopriv_vzkaznik_form', 'prefix_post_data_to_db' );
add_action( 'admin_post_vzkaznik_form', 'prefix_post_data_to_db' );