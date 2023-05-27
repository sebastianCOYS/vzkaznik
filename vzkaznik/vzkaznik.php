<?php
/*
* Plugin Name: Vzkazník
* Description: Vzkazník ve footeru vaší webové stránky. Nechte si poradit od uživatelů.
* Author: Sebastian T. Nguyen
* version: 0.1
*/
include_once("functions.php");
//Vytvoří menu v admin side-panelu
add_action("admin_menu", "create_vzkaznik_menu");
add_action("admin_menu", "create_vzkaznik_settings_menu");
//přidá "vzkazník"(formulář) do footeru
add_action("wp_footer", "vzkaznik");
//vytvoří table se vzkazy při aktivaci pluginu
register_activation_hook( __FILE__, 'create_vzkaznik_table_in_db' );


//BETTER
//..post it*****
//..get it(securely)*******
//query  to $DB
//on vzkaznik page pull the message and loop them all on the page


//LATER 
//add DELETE
//.. DOWNLOAD as a TXT
//.. SAVE to important (there's gonna be 2 folders, all and saved);
//.. přidat TIMESTAMP odeslání

//SETTINGS*****************************

//DECENTw
//ON or OFF(dictates if this plugin is active or not)
//mandatory/optional name, surname, email...
//max length of a message
//


//0.1 VERZEEEEEEEEEEEEEEEEEEEE


/*
Jednoduchá forma - (jméno, zpráva)
1. post******
2. get it*****
3. query it**********
4. display it


Co vechno tu bude?? 
1. security
2. querry do DB********
3. header back to page(ideálně pa zobrazit error/hotovo zprávu )*********


Vzkaznik DB????********************
1.ID
2.date-time
3.email
4.message(the text)
(alternatively name, surname too later, does it work now though?)





MORE NOTES


use esc_html() for every user generated output(echo...)
ADD
1.activation, deactivation, uninstall.php(it's better than uninstall hook)

*/