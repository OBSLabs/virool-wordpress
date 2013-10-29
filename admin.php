<?php
add_action( 'admin_menu', 'virool_admin_menu' );

function virool_admin_menu() {
  add_options_page( 'Virool Options', 'Virool', 'manage_options', 'options-virool', 'virool_options' );
}

function virool_options() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }

  // POST request
  if ( isset($_POST["Y"]) && $_POST['Y'] == '1' ) {
    update_option( 'virool_site_key', $_POST[ 'virool_site_key' ] );
    update_option( 'virool_integration', $_POST[ 'virool_integration' ] );
    update_option( 'virool_widget_width', $_POST[ 'virool_widget_width' ] );
    update_option( 'virool_widget_height', $_POST[ 'virool_widget_height' ] );
    update_option( 'virool_widget_header_text', $_POST[ 'virool_widget_header_text' ] );
    update_option( 'virool_widget_close_text', $_POST[ 'virool_widget_close_text' ] );
    update_option( 'virool_widget_timer_text', $_POST[ 'virool_widget_timer_text' ] );
    update_option( 'virool_widget_close_after', $_POST[ 'virool_widget_close_after' ] );

?>

  <div class="updated"><p><strong>Settings saved</strong></p></div>
<?php
  }

// Read in existing option value from database
$virool_site_key = get_option( 'virool_site_key' );
$virool_integration = get_option( 'virool_integration' );

?>
  <div class="wrap">
  <h2>Virool Widget Settings</h2>
  <p>You can learn more about WordPress integration here <a href="http://www.virool.com/docs/wordpress-integration">WordPress integration with Virool</a></p>

  <form name="form1" method="post" action="">
    <input type="hidden" name="Y" value="1" />
    <p>
      Virool Site key
      <input type="text" name="virool_site_key" value="<?php echo $virool_site_key; ?>" size="30"/>
    </p>

    <div>Integration:</div>
    <label>
      <input type="radio" name="virool_integration" value="" <?php if (empty($virool_integration)) { echo 'checked'; } ?> />
      Disabled
    </label>
    <br/>
    <label>
      <input type="radio" name="virool_integration" value="overlay_on_every_page" 
        <?php if ($virool_integration == 'overlay_on_every_page') { echo 'checked'; } ?> />
      Show overlay widget on every page
    </label>
    <br/>
    <label>
      <input type="radio" name="virool_integration" value="autowidget_in_post"
        <?php if ($virool_integration == 'autowidget_in_post') { echo 'checked'; } ?> />
      Add auto-widget to end of each post
    </label>

    <p>Widget settings:</p>
    <p>
      Widget width:
      <input type="text" name="virool_widget_width" value="<?php echo $virool_widget_width; ?>" size="20"/>
    </p>
    <p>
      Widget height:
      <input type="text" name="virool_widget_height" value="<?php echo $virool_widget_height; ?>" size="20"/>
    </p>

    <p>
      Header text:
      <input type="text" name="virool_widget_header_text" value="<?php echo $virool_widget_header_text; ?>" size="80"/>
    </p>
    <p>
      Close text:
      <input type="text" name="virool_widget_close_text" value="<?php echo $virool_widget_header_text; ?>" size="80"/>
    </p>
    <p>
      Timer text:
      <input type="text" name="virool_widget_timer_text" value="<?php echo $virool_widget_timer_text; ?>" size="80"/>
    </p>

    <p>
      Close after:
      <input type="text" name="virool_widget_close_after" value="<?php echo $virool_widget_close_after; ?>" size="20"/>
    </p>

    <hr/>

    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    </p>
  </form>
</div>

<?php
 
}

?>