<?php
/**
 * Holds all fucntions for plugin Admin.
 *
 * @author Ratnesh Choudhary <ratnesh3rde@gmail.com>
 * @since 1.0.0
 * @package Board_Builder
 */
namespace BoradBuilder\Includes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin hooks for board builder plugin
 *
 * @since 1.0.0
 */
class Board_Builder_Admin {

    /**
	 * The public constructor.
	 */
	public function __construct() {
        add_action( 'admin_menu', array( $this, 'bb_admin_menu_register' ) );
        add_action( 'admin_init', array( $this, 'bb_plugin_option_settings' ) );
    }

     /**
	 * Enqueue registered script and styles.
	 *
	 * @return void
	 */
    public static function bb_admin_menu_register() {
        add_menu_page( 'Board Builder', 'Board Builder', 'manage_options', 'boardbuilder', array ( __CLASS__, 'bb_admin_menu_setting' ), plugin_dir_path( dirname( __FILE__ ) ) . 'admin/images/1461946112_Basket.png', 73 );
    }

   /**
	 * Print page output.
	 *
	 * @wp-hook toplevel_page_bb-admin In wp-admin/admin.php do_action($page_hook).
	 * @return  void
	 */
    public static function bb_admin_menu_setting() {
    ?>
        <div class="wrap">
            <h2>Board Builder Settings</h2>
            <div class="csv_export_main">
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'bb-admin-data-setting' );
                    do_settings_sections( 'bb-admin-data-setting' );
                    ?>
                    <label>Letter Price</label><br/>
                    <input type="number" name="letter_price" class="letter_price" placeholder="Enter Letter Price " value="<?php echo esc_attr( get_option( 'letter_price' ) ); ?>"/><br/>
                    <label>Embellishment Price</label><br/>
                    <input type="number" name="embellishment_price" class="embellishment_price" placeholder="Enter Embellishment Price" value="<?php echo esc_attr( get_option( 'embellishment_price' ) ); ?>"/><br/><br/>
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>
    <?php
    }

    /**
	 * Register option settings for plugin.
	 *
	 * @return  void
	 */
    public static function bb_plugin_option_settings() {
        register_setting( 'bb-admin-data-setting', 'letter_price' );
        register_setting( 'bb-admin-data-setting', 'embellishment_price' );
    }
}
