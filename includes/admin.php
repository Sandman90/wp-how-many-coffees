<?php
// BASIC SECURITY
defined( 'ABSPATH' ) or die( 'Unauthorized Access!' );

/******************************************************************
 * Admin
 *
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * Custom option and settings.
 */
function hmc_settings_init() {
  // Register a new setting for "hmc" page.
  register_setting( 'hmc', 'hmc_options' );

  // Register a new section in the "hmc" page.
  add_settings_section(
      'hmc_section_developers',
      __( 'Widget to quantify everything.', 'how-many-coffees' ), 'hmc_section_developers_callback',
      'hmc'
  );

  // Register a new field in the "hmc_section_developers" section, inside the "hmc" page.
  add_settings_field(
      'hmc_position', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Widget position', 'how-many-coffees' ),
      'hmc_position_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_position',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  );
  add_settings_field(
      'hmc_icon', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Quantity Icon', 'how-many-coffees' ),
      'hmc_icon_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_icon',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  );
  add_settings_field(
      'hmc_label', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Widget label', 'how-many-coffees' ),
      'hmc_text_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_label',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  );
  add_settings_field(
      'hmc_tooltip', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Widget tooltip', 'how-many-coffees' ),
      'hmc_text_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_tooltip',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  );
  add_settings_field(
      'hmc_custom_icon', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Custom icon from Fontawesome or other icons libraries', 'how-many-coffees' ),
      'hmc_text_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_custom_icon',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  );
  add_settings_field(
      'hmc_custom_classes', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Optional classes', 'how-many-coffees' ),
      'hmc_text_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_custom_classes',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  );

  /* TODO Style variants.
  add_settings_field(
      'hmc_variants', // As of WP 4.6 this value is used only internally.
      // Use $args' label_for to populate the id inside the callback.
      __( 'Style variants', 'hmc' ),
      'hmc_variants_cb',
      'hmc',
      'hmc_section_developers',
      array(
          'label_for'         => 'hmc_variants',
          'class'             => 'hmc_row',
          'hmc_custom_data' => 'custom',
      )
  ); */
}

/**
 * Register our hmc_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'hmc_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */


/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function hmc_section_developers_callback( $args ) {
  ?>
  <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e(
      'How many coffees spent to finish a certain task? Now you can quantify them thanks to the widget associated with each post.',
      'how-many-coffees' ); ?></p>
  <?php
}

/**
 * Position field callback function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function hmc_position_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
  $options = get_option( 'hmc_options' );
  ?>
  <select
      id="<?php echo esc_attr( $args['label_for'] ); ?>"
      data-custom="<?php echo esc_attr( $args['hmc_custom_data'] ); ?>"
      name="hmc_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
    <option value="top" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ esc_attr( $args['label_for'] ) ], 'top', false ) ) : ( '' ); ?>>
      <?php esc_html_e( 'top', 'how-many-coffees' ); ?>
    </option>
    <option value="bottom" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ esc_attr( $args['label_for'] ) ], 'bottom', false ) ) : ( '' ); ?>>
      <?php esc_html_e( 'bottom', 'how-many-coffees' ); ?>
    </option>
  </select>
  <p class="description">
    <?php esc_html_e( 'Widget position inside your post content.', 'how-many-coffees' ); ?>
  </p>
  <?php
}

/**
 * Icon to be shown in widget.
 * @param array $args
 */
function hmc_icon_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
  $options = get_option( 'hmc_options' );
  ?>
  <select
      id="<?php echo esc_attr( $args['label_for'] ); ?>"
      data-custom="<?php echo esc_attr( $args['hmc_custom_data'] ); ?>"
      name="hmc_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
    <?php $hmc_get_icons = hmc_get_icons();
      foreach ($hmc_get_icons as $icon => $value) { ?>
    <option value="<?php echo $icon ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ esc_attr( $args['label_for'] ) ],
        $icon, false ) ) : ( '' ); ?>>
      <?php esc_html_e( $icon, 'how-many-coffees' ); ?>
    </option>
    <?php } ?>
<!--    <option value="sugar" --><?php //echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'sugar', false ) ) : ( '' ); ?><!-->-->
<!--      --><?php //esc_html_e( 'sugar', 'hmc' ); ?>
<!--    </option>-->
  </select>
  <p class="description">
    <?php esc_html_e( 'Choosee your icon.', 'how-many-coffees' ); ?>
  </p>
  <?php
}

/**
 * Admin - text inputs.
 * @param array $args
 */
function hmc_text_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
  $options = get_option( 'hmc_options' );
  ?>
    <input type="text"
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           data-custom="<?php echo esc_attr( $args['hmc_custom_data'] ); ?>"
           name="hmc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo isset( $options[ $args['label_for'] ] ) ? $options[ esc_attr( $args['label_for'] ) ] : ( '' ); ?>" />
  <p class="description">
    <?php
    switch($args['label_for']) {
      case 'hmc_label':
        esc_html_e( 'Label for your widget. Leave blank to not have a label.', 'how-many-coffees' );
        break;

      case 'hmc_tooltip':
        esc_html_e( 'Tooltip for your widget on hover. Leave blank to not have a tooltip.', 'how-many-coffees' );
        break;

      case 'hmc_custom_icon':
        esc_html_e( 'You can also use icons of your choice by retrieving them from Fontawesome or other icons libraries. To do this you must necessarily install the Fontawesome library on your blog and search for the icon that interests you, inserting the necessary classes. For example for the coffee icon you could use: "fa-solid fa-mug-hot".', 'how-many-coffees' );
        break;

      case 'hmc_custom_classes':
        esc_html_e( 'Custom classes for your widget container.', 'how-many-coffees' );
        break;
    } ?>
  </p>
  <?php
}

/**
 * Admin - style variants.
 * @param array $args
 */
function hmc_variants_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
//  $options = get_option( 'hmc_options' );
  ?>
  <table>
    <tbody>
      <tr>
        <td class="cell-singular">
          <input type="radio" value="on"
              name="hmc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
              id="<?php echo esc_attr( $args['label_for'] ); ?>"
<?php //checked( $options[ $args['label_for'] ],'prova', true ); ?>
          />
          <span id="hmc-content">Style 1</span>
        </td>
      </tr>
    </tbody>
  </table>
  <p class="description">
    <?php esc_html_e( 'Style variants', 'how-many-coffees' ); ?>
  </p>
  <?php
}

/**
 * Add the top level menu page.
 */
function hmc_options_page() {
  add_submenu_page(
      'options-general.php',
      'How Many Coffees',
      'How Many Coffees',
      'manage_options',
      'hmc',
      'hmc_options_page_html'
  );
}


/**
 * Register our hmc_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'hmc_options_page' );


/**
 * Top level menu callback function
 */
function hmc_options_page_html() {
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }

  // TODO Icons in select for icons.
  // wp_enqueue_style("functions", 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css', false, "1.0", "all");

  // show error/update messages
  settings_errors( 'hmc_messages' );
  ?>
  <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
      <?php
      // output security fields for the registered setting "hmc"
      settings_fields( 'hmc' );
      // output setting sections and their fields
      // (sections are registered for "hmc", each field is registered to a specific section)
      do_settings_sections( 'hmc' );
      // output save settings button
      submit_button( 'Save Settings' );
      ?>
    </form>
  </div>
  <?php
}



/******************************************************************
 * Admin Meta box
 *
 */

// register the meta box
add_action( 'add_meta_boxes', 'hmc_difficulty_checkboxes' );
function hmc_difficulty_checkboxes() {
  add_meta_box(
      'hmc_meta_box_id',          // this is HTML id of the box on edit screen
      'How Many Coffees',    // title of the box
      'hmc_difficulty_box_content',   // function to be called to display the checkboxes, see the function below
      'post',        // on which edit screen the box should appear
      'normal',      // part of page where the box should appear
      'default'      // priority of the box
  );
}

// display the metabox
function hmc_difficulty_box_content() {
  // nonce field for security check, you can have the same
  // nonce field for all your meta boxes of same plugin
  $hmc_meta = get_post_meta(get_the_ID(), 'hmc_meta', true);
  wp_nonce_field( plugin_basename( __FILE__ ), 'hmc_nonce' );
  echo '<label for="hmc_difficulty">Set quantity of coffees or difficulty for this post:</label><br />'
        . '<input id="hmc_difficulty" type="number" name="hmc_meta[difficulty]" value="'
        . (!empty($hmc_meta) ? $hmc_meta['difficulty'] : '')
        . '" /><br />';
}

// save data from checkboxes
add_action( 'save_post', 'hmc_difficulty_data' );
function hmc_difficulty_data($post_id) {

  // check if this isn't an auto save
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    return;

  // security check
  if ( isset( $_POST['hmc_nonce'] ) )
    if ( !wp_verify_nonce( wp_unslash($_POST['hmc_nonce']), plugin_basename( __FILE__ ) ) ) // spelling fix
      return;

  // further checks if you like,
  // for example particular user, role or maybe post type in case of custom post types

  // now store data in custom fields based on checkboxes selected
  if ( isset( $_POST['hmc_meta'] ) &&  !empty($_POST['hmc_meta']['difficulty']) ) {
    $hmc_meta = array(
        'difficulty' => (int) sanitize_text_field(wp_unslash($_POST['hmc_meta']['difficulty']))
    );
    update_post_meta( $post_id, 'hmc_meta', $hmc_meta );
  }
}
