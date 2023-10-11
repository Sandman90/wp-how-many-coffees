<?php
/**
 * Plugin Name: How Many Coffees
 * Plugin URI: https://www.sandbay.it/gallery-tools/asset-tool/wp-how-many-coffees/
 * Description: How many coffees spent to finish a certain task? Now you can quantify them thanks to the widget associated with each post. You can also use this widget to quantify other quantities such as sugar, for example, or the amount of spoons of a certain ingredient needed.
 * Version: 1.0.0
 * Author: Andrea Epifano (aka Sandman)
 * Author URI: https://www.sandbay.it/home/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 **/
// BASIC SECURITY
defined( 'ABSPATH' ) or die( 'Unauthorized Access!' );



if ( !defined('HMC_PLUGIN_DIR') ) {

  //DEFINE SOME USEFUL CONSTANTS
  define('HMC_PLUGIN_VER', '1.0.0');
  define('HMC_PLUGIN_DIR', plugin_dir_path(__FILE__));
  define('HMC_PLUGINS_URL', plugins_url('', __FILE__));
  define('HMC_PLUGINS_BASENAME', plugin_basename(__FILE__));
  define('HMC_PLUGIN_FILE', __FILE__);
  define('HMC_PLUGIN_PACKAGE', 'Free'); //DONT CHANGE THIS - BREAKS AUTO UPDATER

  require_once(HMC_PLUGIN_DIR . 'includes/icons.php');

  if (!function_exists('hmc_add_to_single_content')) {
    function hmc_add_to_single_content($the_content)
    {
      $hmc_options = get_option('hmc_options');
      $hmc_meta = get_post_meta(get_the_ID(), 'hmc_meta', true);
      if (is_single() && in_the_loop() && !empty($hmc_options) && !empty($hmc_meta)) {
        $total_difficulty = '';
        $difficulty_icon = (!empty($hmc_options['hmc_custom_icon']) && strlen($hmc_options['hmc_custom_icon']) > 1)
            ? '<i class="' . $hmc_options['hmc_custom_icon'] . '"></i>'
            : hmc_get_icons(isset($hmc_options['hmc_icon']) ? $hmc_options['hmc_icon'] : 'coffee');
        $label = isset($hmc_options['hmc_label']) ? $hmc_options['hmc_label'] . ' ' : '';
        $classes = isset($hmc_options['hmc_custom_classes']) ? $hmc_options['hmc_custom_classes'] . ' ' : '';
        $quantity = $hmc_meta['difficulty'] ? $hmc_meta['difficulty'] : 0;
        if ($quantity > 0) {
          for ($x = 0; $x < $quantity; $x++) {
            $total_difficulty .= $difficulty_icon;
          }
          $hmc_content =  '<div id="hmc-content" class="' . $hmc_options['hmc_position'] . ' ' . $classes . '" title="' . $hmc_options['hmc_tooltip'] . '">';
          $hmc_content .=   (!empty($label) ? '<span>' . $label . '</span>' : '')
                            . $total_difficulty . hmc_get_fontawesome_copy_license();
          $hmc_content .= '</div>';
          $the_content = $hmc_options['hmc_position'] === 'top' ? ($hmc_content . $the_content) : ($the_content . $hmc_content);
        }
      }
      return $the_content;
    }
  }
  add_filter('the_content', 'hmc_add_to_single_content', 20);

  function hmc_load_plugin_css() {
    $plugin_url = plugin_dir_url(__FILE__);
    wp_enqueue_style('all', $plugin_url . 'css/all.css');
  }
  add_action('wp_enqueue_scripts', 'hmc_load_plugin_css');

  require_once(HMC_PLUGIN_DIR . 'includes/admin.php');
}
