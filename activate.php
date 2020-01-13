<?php
/**
 * Installation and activation of anspress, register hooks that are fired when the plugin is activated.
 *
 * @package     AnsPress
 * @copyright   Copyright (c) 2013, Rahul Aryan
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registration Activation hook class.
 */
class BB_Activate {
    /**
	 * Page create on plugin activation.
	 *
	 * @return void
	 */
    public static function bb_page_create() {
        $board_page = get_option( 'hclpage' );
		if ( ! $board_page ) {
            $my_post = array(
                'post_title'    => wp_strip_all_tags( 'Board Builder' ),
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => 'page',
            );
            $newvalue = wp_insert_post( $my_post, false );
            if ( $newvalue && ! is_wp_error( $newvalue ) ) {
                update_post_meta( $newvalue, '_wp_page_template', 'board-builder-template.php' );
            }
            update_option( 'hclpage', $newvalue );
        }
    }

    /**
	 * Remove Page created on plugin deactivation.
	 *
	 * @return void
	 */
    public static function bb_page_remove() {
        $the_page_id = get_option( 'hclpage' );
        $pdf_page_id = get_option( 'boardpdfpage' );
        if ( $the_page_id ) {
            wp_delete_post( $the_page_id, true );
            delete_option( 'hclpage' );
        }
        if ( $pdf_page_id ) {
            wp_delete_post( $pdf_page_id, true );
            delete_option( 'boardpdfpage' );
        }
    }

    /**
	 * Add folder to WordPress Uploads on plugin activation.
	 *
	 * @return void
	 */
    public static function bb_pdf_folder_create() {
        $upload = wp_upload_dir();
        $upload_dir = $upload['basedir'];
        $upload_dir = $upload_dir . '/bb-pdf';
        if ( ! is_dir($upload_dir ) ) {
           mkdir( $upload_dir, 0700 );
        }
    }

     /**
	 * Remove folder to WordPress Uploads on plugin deactivation.
	 *
	 * @return void
	 */
    public static function bb_pdf_folder_remove() {
        $upload = wp_upload_dir();
        $upload_dir = $upload['basedir'];
        $upload_dir = $upload_dir . '/bb-pdf';
        if ( ! is_dir( $upload_dir ) ) {
            rmdir( $upload_dir );
        }
    }

    /**
	 * Add Table on plugin activation.
	 *
	 * @return void
	 */
    public static function bb_plugin_table_install() {
        global $wpdb;
        global $charset_collate;

        // add pages.
		self::bb_page_create();

		// add folder.
		self::bb_pdf_folder_create();

        $table_name = $wpdb->prefix . 'bb_order_details';
         $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `order_id` bigint(20) NOT NULL,
            `order_amount` float(11) NOT NULL,
            `transection_id` bigint(25) NOT NULL,
            `order_type` int(11) NOT NULL,
            `order_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `client_email` varchar(255) NOT NULL,
            `pdf_name` varchar(255) NOT NULL,
            `board_details` text NOT NULL,
            PRIMARY KEY (`id`)
        )$charset_collate;";
         require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
         dbDelta( $sql );
    }

    /**
	 * Plugin un-installation hook, called by WP while removing AnsPress
	 */
	public static function bb_plugin_uninstall() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		global $wpdb;
		// Remove question CPT.
		self::bb_page_remove();
		// Removes answer CPT.
		self::bb_pdf_folder_remove;

		// remove tables
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}bb_order_details" );
	}
}