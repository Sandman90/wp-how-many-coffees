<?php
/**
 * Plugin Name: How Many Coffees
 * Plugin URI: https://www.sandbay.it/gallery-tools/asset-tool/wp-how-many-coffees/
 * Description: How many coffees spent to finish a certain task? Now you can quantify them thanks to the widget associated with each post. You can also use this widget to quantify other quantities such as sugar, for example, or the amount of spoons of a certain ingredient needed.
 * Version: 1.0.0
 * Author: Andrea Epifano (aka Sandman)
 * Author URI: https://www.sandbay.it/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 **/
// BASIC SECURITY
defined( 'ABSPATH' ) or die( 'Unauthorized Access!' );



if ( !defined('HMCOFFEES_PLUGIN_DIR') ) {

  //DEFINE SOME USEFUL CONSTANTS
  define('HMCOFFEES_PLUGIN_VER', '1.0.0');
  define('HMCOFFEES_PLUGIN_DIR', plugin_dir_path(__FILE__));
  define('HMCOFFEES_PLUGINS_URL', plugins_url('', __FILE__));
  define('HMCOFFEES_PLUGINS_BASENAME', plugin_basename(__FILE__));
  define('HMCOFFEES_PLUGIN_FILE', __FILE__);
  define('HMCOFFEES_PLUGIN_PACKAGE', 'Free'); //DONT CHANGE THIS - BREAKS AUTO UPDATER

  require_once(HMCOFFEES_PLUGIN_DIR . 'includes/icons.php');

  if (!function_exists('hmcoffees_add_to_single_content')) {
    function hmcoffees_add_to_single_content($the_content)
    {
      $hmcoffees_options = get_option('hmcoffees_options');
      $hmcoffees_meta = get_post_meta(get_the_ID(), 'hmcoffees_meta', true);
      if (is_single() && in_the_loop() && !empty($hmcoffees_options) && !empty($hmcoffees_meta)) {
        $total_difficulty = '';
        $difficulty_icon = (!empty($hmcoffees_options['hmcoffees_custom_icon']) && strlen($hmcoffees_options['hmcoffees_custom_icon']) > 1)
            ? '<i class="' . $hmcoffees_options['hmcoffees_custom_icon'] . '"></i>'
            : hmcoffees_get_icons(isset($hmcoffees_options['hmcoffees_icon']) ? $hmcoffees_options['hmcoffees_icon'] : 'coffee');
        $label = isset($hmcoffees_options['hmcoffees_label']) ? $hmcoffees_options['hmcoffees_label'] . ' ' : '';
        $classes = isset($hmcoffees_options['hmcoffees_custom_classes']) ? $hmcoffees_options['hmcoffees_custom_classes'] . ' ' : '';
        $quantity = $hmcoffees_meta['difficulty'] ? $hmcoffees_meta['difficulty'] : 0;
        if ($quantity > 0) {
          for ($x = 0; $x < $quantity; $x++) {
            $total_difficulty .= $difficulty_icon;
          }
          $hmcoffees_content =  '<div id="hmc-content" class="' . $hmcoffees_options['hmcoffees_position'] . ' ' . $classes . '" title="' . $hmcoffees_options['hmcoffees_tooltip'] . '">';
          $hmcoffees_content .=   (!empty($label) ? '<span>' . $label . '</span>' : '')
                            . $total_difficulty . hmcoffees_get_fontawesome_copy_license();
          $hmcoffees_content .= '</div>';
          $the_content = $hmcoffees_options['hmcoffees_position'] === 'top' ? ($hmcoffees_content . $the_content) : ($the_content . $hmcoffees_content);
        }
      }
      return $the_content;
    }
  }
  add_filter('the_content', 'hmcoffees_add_to_single_content', 20);

  function hmcoffees_load_plugin_css() {
    $plugin_url = plugin_dir_url(__FILE__);
    wp_enqueue_style('all', $plugin_url . 'css/all.css');
  }
  add_action('wp_enqueue_scripts', 'hmcoffees_load_plugin_css');

  require_once(HMCOFFEES_PLUGIN_DIR . 'includes/admin.php');
}
