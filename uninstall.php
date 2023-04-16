<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  die;
}

$option_name = 'hmc_options';
delete_option( $option_name );
// For site options in Multisite.
delete_site_option( $option_name );
delete_metadata( 'post', 0, 'hmc_meta', false, true );
