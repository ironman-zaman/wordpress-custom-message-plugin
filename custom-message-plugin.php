<?php
/**
 * Plugin Name: Custom Message Plugin
 * Plugin URI: https://aktaruzzaman.com
 * Description: A simple plugin that displays a custom message via shortcode
 * Version: 1.0.0
 * Author: Aktaruzzaman
 * Author URI: https://aktaruzzaman.com
 * License: GPL2
 * License URI: https://www.gnu.org/license/gpl-2.0.html
 * Text Domain: custom-message-plugin
 */

 //Exit if accessed directly
 if (!defined('ABSPATH')) {
    exit;
 }

//function to display custom message
function display_custom_message($atts){
  //get default message from settings
  $default_message = get_option('cmp_default_message', 'Hello, this is a custom message');
  //Attributes and Defaults
  $attributes = shortcode_atts(
    array(
        'message' => $default_message
    ),
    $atts
  );
  //Output
  return '<div class="custom-message">'.esc_html($attributes["message"]).'</div>';

}

//Register the shortcode
add_shortcode("custom_message","display_custom_message");

//Add Admin Menu
function cmp_add_admin_menu(){
  add_options_page(
    'Custom Message Settings', //page title
    'Custom Message', //Menu title
    'manage_options', //capability
    'custom-message-plugin', //menu slug
    'cmp_settings_page_html'
  );
}
add_action("admin_menu","cmp_add_admin_menu");

//Register Settings
function cmp_register_settings(){
  register_setting('cmp_settings','cmp_default_message');

  add_settings_section(
    'cmp_section', //ID
    'Custom Message Settings', //Title
    null, //callback function null
    'custom-message-plugin' //page slug
  );

  add_settings_field(
    'cmp_default_message', //id
    'Default Message', //Title(Label)
    'cmp_default_message_field_html', //callback function to return the field
    'custom-message-plugin', //page slug
    'cmp_section', //Section ID (matches the section created above)
  );
}
add_action("admin_init",'cmp_register_settings');

//Settings page HTML
function cmp_settings_page_html(){
?>
<div class="wrap">
<h1>Custom Message Settings</h1>
<form action="options.php" method="post">
  <?php
  settings_fields('cmp_settings');
  do_settings_sections('custom-message-plugin');
  submit_button();
  ?>
</form>
</div>
<?php
}

function cmp_default_message_field_html(){
  $default_message = get_option('cmp_default_message', 'Hello, this is a custom message');
  ?>
<input type="text" name="cmp_default_message" value="<?php echo esc_attr($default_message);  ?>" size="50">
  <?php
}
?>