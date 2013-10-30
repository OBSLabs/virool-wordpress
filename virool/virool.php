<?php
/*
Plugin Name: Virool Widget
Plugin URI: http://www.virool.com/docs/wordpress-integration
Description: Virool Widget plugin
Author: Virool
Author URI: http://virool.com/
Version: 1.0.0
*/

if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

define('VIROOL_VERSION', '1.0.0');
define('VIROOL_PLUGIN_URL', plugin_dir_url( __FILE__ ));

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

add_action( 'admin_enqueue_scripts', 'virool_load_js_and_css' );
function virool_load_js_and_css() {
  wp_register_script( 'virool.js', VIROOL_PLUGIN_URL . 'virool.js', array('jquery'), '1.0.0' );
  wp_enqueue_script( 'virool.js' );
}

function virool_get_widget_options() {
  global $virool_site_key, $virool_widget_width, $virool_widget_height;
  return array(
    '%width%' => $virool_widget_width, 
    '%height%' => $virool_widget_height,
    '%site_key%' => $virool_site_key
  );
}

// append overlay widget to footer
function virool_footer() {
  global $virool_site_key, $virool_widget_width, $virool_widget_height, $virool_integration, $virool_widget_header_text,
    $virool_widget_close_text, $virool_widget_timer_text, $virool_widget_close_after;

  if ( !empty($virool_site_key) ) {
    if ($virool_integration == 'overlay') {
      $options = array();

      if (!empty($virool_widget_width))
        array_push($options, array('width', $virool_widget_width));
      if (!empty($virool_widget_height))
        array_push($options, array('height', $virool_widget_height));
      if (!empty($virool_widget_header_text))
        array_push($options, array('headerText', stripslashes($virool_widget_header_text)));
      if (!empty($virool_widget_close_text))
        array_push($options, array('closeText', stripslashes($virool_widget_close_text)));
      if (!empty($virool_widget_timer_text))
        array_push($options, array('timerText', stripslashes($virool_widget_timer_text)));
      if (!empty($virool_widget_close_after))
        array_push($options, array('closeAfter', $virool_widget_close_after));

      echo "<script type='text/javascript' src='//virool.at/js/widget.overlay.js'></script>";
      echo "<script type='text/javascript'>";
      echo "ViroolWidgetModal.open('//api.virool.com/widgets/" . $virool_site_key . "', { ";

      for ($i = 0; $i < sizeof($options); $i++) {
        $key = $options[$i][0];
        $value = $options[$i][1];

        echo $key . ": " . json_encode($value);

        if ($i + 1 != sizeof($options))
          echo ", ";
      }
      echo "});";
      echo "</script>";
    }
  }
}

add_action( 'wp_footer', 'virool_footer' );

// append auto-widget to each post
function virool_content_filter($content) {
  global $virool_site_key, $virool_integration;

  if ( !empty($virool_site_key) ) {
    if ( $virool_integration == 'autowidget_in_post' ) {
      $widget_options = virool_get_widget_options();

      $auto_widget = strtr(
        "<script type='text/javascript' src='//api.virool.com/widgets/%site_key%?width=%width%&height=%height%&format=js'></script>", 
        $widget_options
      );

      $content = $content . $auto_widget;
    }
  }
  return $content;
}

add_filter( 'the_content', 'virool_content_filter' )

?>