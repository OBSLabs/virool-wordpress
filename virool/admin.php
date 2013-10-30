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
$virool_widget_width = get_option( 'virool_widget_width' );
$virool_widget_height = get_option( 'virool_widget_height' );
$virool_widget_header_text = get_option( 'virool_widget_header_text' );
$virool_widget_close_text = get_option( 'virool_widget_close_text' );
$virool_widget_timer_text = get_option( 'virool_widget_timer_text' );
$virool_widget_close_after = get_option( 'virool_widget_close_after' );

?>
  <div class="wrap">
  <h2>Virool Widget Settings</h2>
  <p>You can learn more about WordPress integration with Virool here <a href="http://www.virool.com/docs/wordpress-integration" target="_blank">WordPress integration with Virool</a></p>

  <form method="post" action="">
    <input type="hidden" name="Y" value="1" />

    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row"><label for="virool_site_key">Virool API key</label></th>
          <td>
            <input type="text" name="virool_site_key" value="<?php echo $virool_site_key; ?>" size="30" class="regular-text"/>
            <p class="description">Required. Your api key. Copy it from <a href="https://www.virool.com/sites" target="_blank">https://www.virool.com/sites</a></p>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Virool integration:</th>
          <td>
            <label>
              <input type="radio" name="virool_integration" value="" <?php if (empty($virool_integration)) { echo 'checked'; } ?> />
              Disabled
            </label>

            <br/>

            <label>
              <input type="radio" name="virool_integration" value="overlay" 
                <?php if ($virool_integration == 'overlay') { echo 'checked'; } ?> />
              Show overlay widget on every page
              (<a href="http://www.virool.com/docs/widget-overlay-embed" target="_blank">Widget Overlay</a>)
            </label>

            <br/>

            <label>
              <input type="radio" name="virool_integration" value="autowidget_in_post"
                <?php if ($virool_integration == 'autowidget_in_post') { echo 'checked'; } ?> />
              Add auto-widget to end of each post
              (<a href="http://www.virool.com/docs/widget-api" target="_blank">Auto-Widget</a>)
            </label>
          </td>
        </tr>

        <tr valign="top" class="virool-widget-settings base-settings" <?php if (empty($virool_integration)) { echo "style='display: none;'"; } ?>>
          <th scope="row"><label for="virool_widget_width">Widget width:</label></th>
          <td>
            <input type="text" name="virool_widget_width" id="virool_widget_width" value="<?php echo $virool_widget_width; ?>" size="10"/>
            <p class="description">Optional. Widget width in pixels. (default: 640)</p>
          </td>
        </tr>

        <tr valign="top" class="virool-widget-settings base-settings" <?php if (empty($virool_integration)) { echo "style='display: none;'"; } ?>>
          <th scope="row"><label for="virool_widget_height">Widget height:</label></th>
          <td>
            <input type="text" name="virool_widget_height" id="virool_widget_height" value="<?php echo $virool_widget_height; ?>" size="10"/>
            <p class="description">Optional. Widget height in pixels. (default: 400)</p>
          </td>
        </tr>

        <tr valign="top" class="virool-widget-settings overlay-settings" <?php if ($virool_integration != 'overlay') { echo "style='display: none;'"; } ?>>
          <th scope="row"><label for="virool_widget_header_text">Header text:</label></th>
          <td>
            <input type="text" name="virool_widget_header_text" id="virool_widget_header_text" value="<?php echo stripslashes($virool_widget_header_text); ?>" size="80"/>
            <p class="description">Optional. Text above the widget. (default: 'Please support this site by watching this video')</p>
          </td>
        </tr>

        <tr valign="top" class="virool-widget-settings overlay-settings" <?php if ($virool_integration != 'overlay') { echo "style='display: none;'"; } ?>>
          <th scope="row"><label for="virool_widget_close_text">Close text:</label></th>
          <td>
            <input type="text" name="virool_widget_close_text" id="virool_widget_close_text" value="<?php echo stripslashes($virool_widget_close_text); ?>" size="80"/>
            <p class="description">Optional. Close link text. (default: 'Skip Ad')</p>
          </td>
        </tr>

        <tr valign="top" class="virool-widget-settings overlay-settings" <?php if ($virool_integration != 'overlay') { echo "style='display: none;'"; } ?>>
          <th scope="row"><label for="virool_widget_timer_text">Timer text:</label></th>
          <td>
            <input type="text" name="virool_widget_timer_text" id="virool_widget_timer_text" value="<?php echo stripslashes($virool_widget_timer_text); ?>" size="80"/>
            <p class="description">Optional. Countdown text. [COUNT] is a placeholder which will be replaced with remaining seconds. (default: 'Return to site in [COUNT] sec')</p>
          </td>
        </tr>

        <tr valign="top" class="virool-widget-settings overlay-settings" <?php if ($virool_integration != 'overlay') { echo "style='display: none;'"; } ?>>
          <th scope="row"><label for="virool_widget_close_after">Close after:</label></th>
          <td>
            <input type="text" name="virool_widget_close_after" id="virool_widget_close_after" value="<?php echo $virool_widget_close_after; ?>" size="10"/>
            <p class="description">Optional. Seconds before widget overlay will close. Passing 0 as value will disable countdown. (default: 60)</p>
          </td>
        </tr>

      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    </p>
  </form>
</div>

<?php
 
}

?>