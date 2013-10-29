<?php
/*
Plugin Name: Virool Widget
Plugin URI: http://www.virool.com/docs/wordpress-integration
Description: Virool Widget plugin
Author: Virool
Author URI: http://virool.com/
Version: 1.0
*/

if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

if ( is_admin() )
  require_once dirname( __FILE__ ) . '/admin.php';

function virool_init() {
  global $virool_site_key, $virool_integration, $virool_widget_width, $virool_widget_height, $virool_widget_header_text,
    $virool_widget_close_text, $virool_widget_timer_text, $virool_widget_close_after;

  $virool_site_key = get_option('virool_site_key');

  if ( !empty($virool_site_key) ) {
    $virool_integration = get_option('virool_integration');
    $virool_widget_width = get_option('virool_widget_width');
    $virool_widget_height = get_option('virool_widget_height');
    $virool_widget_header_text = get_option('virool_widget_header_text');
    $virool_widget_close_text = get_option('virool_widget_close_text');
    $virool_widget_timer_text = get_option('virool_widget_timer_text');
    $virool_widget_close_after = get_option('virool_widget_close_after');

    $virool_widget_width = (empty($virool_widget_width) ? 640 : $virool_widget_width);
    $virool_widget_height = (empty($virool_widget_height) ? 400 : $virool_widget_height);
  }
}

add_action('init', 'virool_init');

function virool_get_widget_options() {
  global $virool_widget_width, $virool_widget_height;
  return array('%width%' => $virool_widget_width, '%height%' => $virool_widget_height);
}

// append overlay widget to footer
function virool_footer() {
  global $virool_site_key, $virool_integration, $virool_widget_header_text, $virool_widget_close_text,
    $virool_widget_timer_text, $virool_widget_close_after;

  if ( !empty($virool_site_key) ) {
    if ($virool_integration == 'overlay_on_every_page') {
      $widget_options = virool_get_widget_options();

      echo "<script type='text/javascript' src='//virool.at/js/widget.overlay.js'></script>";
      echo "<script>ViroolWidgetModal.open('//api.virool.com/widgets/";
      echo $virool_site_key;
      echo strtr("?width=%width%&height=400', {width: %width%, height: %height%});</script>", $widget_options);
    }
  }
}

add_action( 'wp_footer', 'virool_footer' );

// append auto-widget to each post
function virool_content_filter($content) {
  global $virool_site_key, $virool_integration, $virool_widget_width, $virool_widget_height, $virool_widget_header_text,
    $virool_widget_close_text, $virool_widget_timer_text, $virool_widget_close_after;

  if ( !empty($virool_site_key) ) {
    if ( $virool_integration == 'autowidget_in_post' ) {
      $auto_widget = sprintf(
        "<script type='text/javascript' src='//api.virool.com/widgets/%s?width=640&height=400&format=js'></script>",
        $virool_site_key
      );
      $content = $content . $auto_widget;
    }
  }
  return $content;
}

add_filter( 'the_content', 'virool_content_filter' )

?>