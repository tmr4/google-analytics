<?php
/*

Plugin Name: Google Analytics
Version: 3
Description: Adds Google Analytics to header on every page

*/

// WordPress seems to confuse this plugin with another and notes it needs updated unless my plugin has a higher version number
// *** Find out what WordPress uses to diferentiate plugins as changing Plugin Name doesn't seem to solve this problem ***

/*
    Use:
        - create an account w/ Google Analytics at https://www.google.com/analytics; get tracking id
        - install plugin and activate (deactivate to turn tracking off)
        - copy tracking id to Settings -> Analytics; save settings

    Analytics: https://analytics.google.com
    Info: https://analytics.google.com/analytics/academy/
    Support: https://support.google.com/analytics/answer/1008015?hl=en
*/

defined( 'ABSPATH' ) ? : die();

/*
  Add Google Analytics code in the header of every page/post

  Code within function below is from: https://analytics.google.com/analytics/web/#/.../admin/tracking/tracking-code/
  - except tracking ID set from database
  IP anonymization modification from: https://developers.google.com/analytics/devguides/collection/gtagjs/ip-anonymization

*/

function psp_add_googleanalytics() { ?>
     
  <!-- Global site tag (gtag.js) - Google Analytics - IP Anonymized -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo get_option('ga_tracking_id'); ?>"></script>

  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag( 'config', '<?php echo get_option('ga_tracking_id'); ?>', { 'anonymize_ip' : true } );
  </script>
 
<?php }
add_action('wp_head', 'psp_add_googleanalytics');

/*
  Google Analytics settings
*/

function create_analytics_settings_page() {
  // Add the menu item and page
  $page_title = 'Google Analytics Settings Page';
  $menu_title = 'Analytics';
  $capability = 'manage_options';
  $slug = 'google_analytics_fields';
  $callback = 'google_analytics_page_content';
  $position = 101;

  add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback, $position );

  add_action( 'admin_init', 'analytics_page_setup' );
}
add_action( 'admin_menu', 'create_analytics_settings_page' );

function analytics_page_setup() {
  add_settings_section( 'google_analytics', 'Google Analytics', false, 'google_analytics_fields' );
  add_settings_field( 'ga_tracking_id', 'Tracking ID', 'ga_tracking_id_callback', 'google_analytics_fields', 'google_analytics' );
  register_setting( 'google_analytics_fields', 'ga_tracking_id' );
}

function google_analytics_page_content() { ?>
  <div class="wrap">
      <h2>Google Analytics Settings Page</h2>
      <form method="post" action="options.php">
          <?php
              settings_fields( 'google_analytics_fields' );
              do_settings_sections( 'google_analytics_fields' );
              submit_button();
          ?>
      </form>
  </div> <?php
}

function ga_tracking_id_callback( $arguments ) {
  echo '<input name="ga_tracking_id" id="ga_tracking_id" type="text" value="' . get_option( 'ga_tracking_id' ) . '" />';
}

?>
