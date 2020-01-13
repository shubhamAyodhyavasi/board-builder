<?php
/**
 * The WordPress Board Builder Plugin.
 *
 * The plugin to design your custom board
 *
 * @package   Board_Builder
 * @author    Ratnesh Choudhary <ratnesh3rde@gmail.com>
 * @copyright 2018 WP3.in & Third Essential Team
 * @license   GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt *
 * @link      http://thirdessential.com
 *
 * @wordpress-plugin
 * Plugin Name:			Board Builder
 * Plugin URI: 			http://www.thirdessential.com/
 * Description: 		This plugin helps in design the custom board.
 * Version: 			1.0.0
 * Author: 				Third Essential Team
 * Author URI: 			http://www.thirdessential.com/
 * License: 			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace BoradBuilder;

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'TE_BB_DIR', WP_PLUGIN_DIR . '/' . plugin_basename( dirname( __FILE__ ) ) );

define( 'TE_BB_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
define( 'TE_BB_NAME', plugin_basename( dirname( __FILE__ ) ) );
define( 'TE_BB_PLUGIN_VERSION', '1.0.0' );

require_once( trailingslashit( dirname( __FILE__ ) ) . 'includes/autoloader.php' );

$bbfunctions = new Includes\Board_Builder_Functions( __FILE__ );
$bbadmin = new Includes\Board_Builder_Admin( __FILE__ );

require_once dirname( __FILE__ ) . '/activate.php';
register_activation_hook( __FILE__, [ 'BB_Activate', 'bb_plugin_table_install' ] );
register_uninstall_hook( __FILE__, [ 'BB_Activate', 'bb_plugin_uninstall' ] );
add_action( 'plugins_loaded', array( '\BoradBuilder\Includes\Board_Builder_Template', 'get_instance' ) );
