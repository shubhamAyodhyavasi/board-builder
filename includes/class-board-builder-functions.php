<?php
/**
 * Holds all fucntions of theme.
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
 * The hooks class of BB
 *
 * @since 2.0.0
 */
class Board_Builder_Functions {

    /**
	 * The public constructor.
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'bb_load_scripts' ) );
        add_shortcode( 'board_builder', array( $this, 'builder_code' ) );
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            add_action( 'wp_ajax_password_change', array( $this, 'builder_password_change' ) );
            add_action( 'wp_ajax_pdf_save', array( $this, 'builder_pdf_save' ) );
		}
    }

    /**
	 * Enqueue registered script and styles.
	 *
	 * @return void
	 */
    public static function bb_load_scripts() {
        $dir = TE_BB_URL . '/assets/';
        if ( is_page( 'board-builder' ) ) {
            wp_register_style( 'plugin-stylesheet', $dir . 'css/style.css' );
            wp_enqueue_style( 'plugin-stylesheet' );
            wp_register_script( 'konva-js', $dir . 'js/lib/konva.min.js' );
            wp_enqueue_script( 'konva-js' );
            wp_enqueue_script( 'plugin-custom-js', $dir . 'js/custom.js', array(), '1.0.0', true );
            wp_localize_script( 'plugin-custom-js', 'bb_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
            wp_register_script( 'jspdf-js', $dir . 'js/lib/jspdf.min.js' );
            wp_enqueue_script( 'jspdf-js' );
        }
    }

    /**
	 * Ajax call to change password.
	 *
	 * @return void
	 */
    public static function builder_password_change() {
        global $wpdb;
        if ( isset( $_REQUEST['old_pass'], $_REQUEST['new_pass'], $_REQUEST['pass_change_field'], $_REQUEST['username'] ) && wp_verify_nonce( $_REQUEST['pass_change_field'], 'pass_change_nonce' ) ) {
            $old_pass = sanitize_text_field( wp_unslash( $_REQUEST['old_pass'] ) );
            $new_pass = sanitize_text_field( wp_unslash( $_REQUEST['new_pass'] ) );
            $username = sanitize_text_field( wp_unslash( $_REQUEST['username'] ) );
            $nonce    = sanitize_text_field( wp_unslash( $_REQUEST['pass_change_field'] ) );
            $user     = get_user_by( 'login', $username );
            if ( wp_check_password( $old_pass, $user->data->user_pass, $user->ID ) ) {
                wp_set_password( $new_pass, $user->ID );
                $response = 1;
                $message  = 'Successfull';
            } else {
                $response = 0;
                $message  = 'You Have Entered Wrong Old Password ';
            }
        }
        $json_response = wp_json_encode( array(
            'response' => $response,
            'message'  => $message,
        ) );
	    echo $json_response;
        wp_die();
    }

    /**
	 * Ajax call to PDF SAVE.
	 *
	 * @return void
	 */
    public static function builder_pdf_save() {
        global $wpdb, $current_user;
        $user_details = wp_get_current_user();
        $username = $current_user->user_login;
        $sender_user_email = $current_user->user_email;
        $send_first_name = $current_user->user_firstname;
        $user_id = get_current_user_id();
        $user_download_limit = get_user_meta( $user_id, 'user_download_limit', true );
        $emailid      = $current_user->user_email;
        if ( isset( $_REQUEST['pdfdata'], $_REQUEST['firsrjson'], $_REQUEST['secondjson'], $_REQUEST['embjson'], $_REQUEST['ordertype'], $_REQUEST['expnonce'] ) && wp_verify_nonce( $_REQUEST['expnonce'], 'export-nonce' ) ) {
            $pdfdata = sanitize_text_field( wp_unslash( $_REQUEST['pdfdata'] ) );
            $order_type = sanitize_text_field( wp_unslash( $_REQUEST['ordertype'] ) );
            $first_json = sanitize_text_field( wp_unslash( $_REQUEST['firsrjson'] ) );
            $second_json = sanitize_text_field( wp_unslash( $_REQUEST['secondjson'] ) );
            $emb_json = sanitize_text_field( wp_unslash( $_REQUEST['embjson'] ) );
            $first_json_decode = json_decode( $first_json, true );
            $second_json_decode = json_decode( $second_json, true );
            $emb_json_decode = json_decode( $emb_json, true );
            $final_board_array = array_merge( $first_json_decode, $second_json_decode, $emb_json_decode );
            $final_board_details = wp_json_encode( $final_board_array );
            $data = base64_decode( $pdfdata );
            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/bb-pdf';
            $currenttime = strtotime( 'now' );
            $newfilename = $username . '_' . $currenttime . '.pdf';
            $newfilename = strtolower( $newfilename );
            $myfile = fopen( $upload_dir . '/' . $newfilename, 'w' ) or die( 'Unable to open file!' );
            fwrite( $myfile, $data );
            fclose( $myfile );
            $order_id = rand( 1, 1000 ) . strtotime( 'now' );
            if ( 2 === $order_type ) {
                $order_insert = $wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}bb_order_details( order_id, order_amount, transection_id, order_type, client_email, board_details, pdf_name ) VALUES ( %f, %f, %d, %d, %s, %s, %s )", $order_id, $order_amount, $trans_id, $order_type, $emailid, $final_board_details, $newfilenam ) );
                if ( $order_insert === 1 ) {
                    $download_remain = $user_download_limit - 1;
                    $updated = update_user_meta( $user_id, 'user_download_limit', $download_remain );
                }
            } else {
                $order_insert = $wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}bb_order_details( order_id, order_type, client_email, board_details, pdf_name ) VALUES ( %f, %d, %s, %s, %s )", $order_id, $order_type, $emailid, $final_board_details, $newfilename ) );
                if ( $order_insert === 1 ) {
                    $download_remain = $user_download_limit - 1;
                    $updated = update_user_meta( $user_id, 'user_download_limit', $download_remain );
                    $new_limit = get_user_meta( $user_id, 'user_download_limit', true );
                    //require_once TE_BB_DIR . '/email_template/client_email_template.php';
                    $userMailMessage = "Congratulations! You have successfully submitted your design. Please allow 3-4 weeks for processing of your order. You will receive an email when your order ships. Thanks for designing your personalized name sign with our software, and for joining thePolymathmom family!";
                    wp_mail($emailid,"Your design is submitted to us",$userMailMessage);
					require_once TE_BB_DIR . '/email_template/admin_email_template.php';
                }
            }

        } else {
            echo esc_attr( 'No Data Sent' );
        }
        exit();
    }

    /**
	 * Create Shortcode for page.
	 *
	 * @return string
	 */
    public static function builder_code() {
        global $wpdb, $current_user;
        $user_details = wp_get_current_user();
        $emailid      = $current_user->user_email;
        $username = $current_user->user_login;
        $userid = get_current_user_id();
        $board_code = '<div class="main clearfix">
        <aside class="menu-links">
            <div class="logo">
                <a href="#">
                    <img src="logo.png" alt="">
                </a>
            </div>
            <div class="menu">
                <nav class="main-menu">
                    <ul>';
        if ( is_user_logged_in() ) {
            $board_code .= '<li class="open l1">
            <a href="javascript:void(0)" class="active" data-target="myaccount">
                <i class="fa fa-user-circle"></i> My Account
            </a>
            </li>';
        }
        $board_code .= '<li class="has-submenu l1">
                            <a href="javascript:void(0)" class="">
                                <i class="fa fa-sliders"></i> Make Board
                            </a>
                            <ul>
                                <li class="l2">
                                    <a href="javascript:void(0)"  data-target="choose-design">Choose Design</a>
                                </li>
                                <li class="l2">
                                    <a href="javascript:void(0)"  data-target="select-stain">Select Stain </a>
                                </li>
                                <li class="l2">
                                    <a href="javascript:void(0)"  data-target="edit-text">Edit Text &amp; Font</a>
                                </li>
                                <li class="has-submenu l2">
                                    <a href="javascript:void(0)">Embellishment</a>
                                    <ul>
                                        <li class="l3">
                                            <a href="javascript:void(0)"  data-target="emb-flower">Flowers</a>
                                        </li>
                                        <li class="l3">
                                            <a href="javascript:void(0)"  data-target="emb-cactus">Cactus</a>
                                        </li>
                                        <li class="l3">
                                            <a href="javascript:void(0)"  data-target="emb-wreath">Wreaths</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="l1">
                            <a href="javascript:void(0)"  data-target="preview"> <i class="	fa fa-eye"></i> Preview</a>
                        </li>
                        <li class="has-submenu l1">
                            <a href="javascript:void(0)"  data-target="order"><i class="	fa fa-file-pdf-o"></i> Order</a>
                            <ul>
                                <li class="l2">
                                    <a href="javascript:void(0)"  data-target="export">Export</a>
                                </li>
                                <li class="l2">
                                    <a href="javascript:void(0)"  data-target="send">Send Order</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <aside class="menu-content text-center">';
        if ( is_user_logged_in() ) {
            $classlogin = 'open';
        }
        if ( is_user_logged_in() && function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel() ) {
            $current_user->membership_level = pmpro_getMembershipLevelForUser( $current_user->ID );
            $membership_level = $current_user->membership_level->name;
        }
        $board_code .= '
        <div id="myaccount" class="'.$classlogin.'">
            <h3>' . $username . '<span>' . $emailid .'</span></h3>
        <div>
        <ul class="tabs">
            <li class="active">
                <a href="javascript:void(0)" data-target="tab-info">Info</a>
            </li>
            <li class="">
                <a href="javascript:void(0)"  data-target="tab-settings">Settings</a>
            </li>
            <div class="content">
                <div id="tab-info" class="open">
                    <p>Current plan subscription</p>
                    <p class="text-uppercase"><strong>' .$membership_level.  '</strong></p>
                    <br>
                    <p>plan info based on real details</p>
                    <a href="javascript:void(0)" class="btn pink text-uppercase">Change Plan</a>
                </div>
                <div id="tab-settings" class="">
                    <p>Change password</p>
                    <form action="" class="settings" method="post" id="password_change">
                        <label for="old-psw" class="text-left">Old Password</label>
                        <input type="password" name="old_pass" id="old-psw" value="">
                        <div class="oldpass-error"></div>
                        <label for="new-psw" class="text-left">New Password</label>
                        <input type="password" name="new_pass" id="new-psw" value="">
                        <div class="newpass-error"></div>
                        <input type="hidden" name="username" value="'. $username .'" id="usernameid"/>
                        <input type="button" name="update_btn" id="update-btn" class="btn pink text-uppercase" value="Update">
                    </form>
                </div>';
        return $board_code;
    }
}
