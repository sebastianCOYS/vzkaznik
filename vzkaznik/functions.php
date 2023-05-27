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
    echo '<form method="post" action="'. plugins_url() .'/vzkaznik/form_action.php">
    <label for="email">email:</label>
    <input type="email" id="email" name="email" required/>
    <label for="message">message:</label>
    <input type="textarea" id="message" name="message" title="between 20 and 1000 characters" minlength="20" maxlength="1000" required/>
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