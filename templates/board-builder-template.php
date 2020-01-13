<?php
/**
 * Template Name: Board Builder Template
 *
 * @package Board_Builder
 * @subpackage Builder
 * @since 1.0.0 @author Ratnesh Choudhary
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$upload = wp_upload_dir();
$upload_dir = $upload['basedir'];
if( isset( $_REQUEST['file'] ) ) {
    $filename = $_REQUEST['file'];
    $filepath  = $upload_dir . '/bb-pdf/' . $filename;
    header( 'Content-type:application/pdf' );
    header( 'Content-disposition: inline; filename="' . $filename . '"' );
    header( 'content-Transfer-Encoding:binary' );
    header( 'Accept-Ranges:bytes' );
    echo file_get_contents( $filepath );
} else {
    get_header();
    global $wpdb, $current_user;
    $user_details = wp_get_current_user();
    $emailid      = $current_user->user_email;
    $username = $current_user->user_login;

    function echocolor( $id = 'color', $name = 'select-color' ) {
        $colorarr = array( '#f6f3ee', '#eee6db', '#d0d0d0', '#a3a3a3', '#8f9396', '#6e7377', '#58595b', '#414246', '#d4bea7', '#ab9a90', '#8b796b', '#6f5e54', '#564943', '#262628', '#e0955c', '#df6943', '#bf7244', '#b0664b', '#ffd98e', '#ebaf35', '#f8ab1f', '#feb253', '#ffa036', '#c08e35', '#eed6d6', '#f0c6d0', '#e4a4b2', '#e6999f', '#d98cb8', '#cc76a5', '#c76b78', '#fad0c4', '#d7a391', '#ee9587', '#e58183', '#d04838', '#ce353a', '#a33f41', '#b1888e', '#dac1df', '#c39fcb', '#b6a2bb', '#a06583', '#8c5e8f', '#684669', '#5d5f76', '#d0cd96', '#d7cf6d', '#a9a42e', '#568c50', '#6e7d42', '#6e6f43', '#5f6853', '#c1d5b9', '#98d3bf', '#c7efe4', '#71d0ca', '#76ced2', '#01a59c', '#376a6e', '#7ec8e1', '#4ab5d7', '#6c95b1', '#007598', '#3b4859', '#303548', '#d1a86a', '#afafa7', '#a85f3e', '#f3ac8e' );
        $color_count = count( $colorarr );
        for ( $i = 1; $i <= $color_count; $i++ ) {
        ?>  
                <input type="radio" id="<?php echo esc_attr( $id . '-' . $i ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $colorarr[ $i - 1 ] ); ?>" />
                <label for="<?php echo esc_attr( $id . '-' . $i ); ?>" class="color-label">
                    <span class="color-display" style="background-color: <?php echo esc_attr( $colorarr[ $i - 1 ] ); ?>"></span>
                    <span>color: <?php echo($i) ?></span>
                </label>
        <?php
        }
    }

    function echofont( $id = 'font', $name = 'select-font' ) {
        $fontnamearr = array(
            'Acacia' => 'UnicornFlakes',
            'Alisons' => 'ChickenAndWaffles',
            'AMARYLLIS' => 'A Day in September',
            'Amaranth' => 'Lieve Letters',
            'ANEMONE' => 'Linowrite',
            'Angelonia' => 'FISHfingers',
            'Aster' => 'MasanaScript',
            'Azalea' => 'A-DAY-WITHOUT-SUN', 
            'Bougainvillea' => 'BUS STOP',
            'BLOSSOM' => 'KG Rise UP',
            'Buttercup' => 'Jack Lane',
            'Bluebell' => 'TheSofy',
            'Bellflower' => 'Typewriter',
            'CALLA' => 'New Sun',
            'Camellia' => 'Autumn in November',
            'CLOVER' => 'Luna',
            'Columbine' => 'Jolly',
            'Carnation' => 'LolaBelle',
            'DELPHINE' => 'KG Two is Better Than One',
            'Dahlia' => 'Sofia',
            'Elm' => 'Altoys just personal only',
            'Echinops' => 'Mickelmas',
            'EUCHARIS' => 'Bukhari Script',
            'Foxglove' => 'Grand Hotel',
            'FLORIAN' => 'Champagne n Limousines',
            'Forgetmenot' => 'BohoScriptDropW01',
            'Fressia' => 'Amsterdam One',
            'Crocus' => 'Selfie',
            'Gardenia' => 'The Skinny',
            'GLADIOUS' => 'JuliaVintage',
            'Garland' => 'Hickory Jack',
            'HEATHER' => 'Simplicity',
            'hibiscus' => 'NI Fish Taco',
            'JASMINE' => 'Alpine Script',
            'Jonquil' => 'Vayentha Sans Demo',
            'Jacinta' => 'Amarillo',
            'Kalina' => 'Vayentha Script Demo',
            'Laceleaf' => 'Malibu',
            'Leilani' => 'DK Lemon Yellow Sun',
            'LOTUS' => 'Tuesday-Script',
            'LAVANDER' => 'Caviar Dreams',
            'Lilac' => 'bromello',
            'MAGNOLIA' => 'Foxhole', 
            'Matthiola' => 'Madina Clean Alt',
            'MARIGOLD' => 'cinnamon cake',
            'Marjoram' => 'Belta',
            'Marguerite' => 'COFFE n MILK',
            'Nerine' => 'Montreal script_Update',
            'NARCISSA' => 'Dragonfly',
            'Oleander' => 'Andara Script',
            'Orchid' => 'NORTHWEST',
            'Petal' => 'Jasper',
            'posey' => 'Austic',
            'PETUNIA' => 'Tony Tony',
            'PEONY' => 'HipsterishFontNormal',
            'Poppy' => 'Shorelines-Script-Bold',
            'Primrose' => 'KG Satisfied Script',
            'rose' => 'Eggcup',
            'Rosemary' => 'Are You Freakin Serious',
            'Sweetpea' => 'Huffleclaw',
            'Sunflower' => 'Chlakh Demo',
            'snapdragon' => 'LillyBelle',
            'thistle' => 'Carolina',
            'TULIP' => 'Maneo_TRIAL',
            'VERVAIN' => 'Lemon Milk',
            'Violet' =>'Vincentia',
            'Waterlilly' => 'TheSofy',
            'Zinnia' => 'Daydreamer',
            'Zahara' => 'Vendetta',            
    );
        $fontsArr = array( 'A Day in September', 'Aldine', 'Alpine Script', 'Altoys just personal only', 'Amarillo', 'Amsterdam Four', 'Amsterdam One Slant', 'Amsterdam One', 'Amsterdam Three', 'Andara Script', 'Are You Freakin Serious', 'Austic', 'Autumn in November', 'Belta', 'black jack', 'BohoScriptDropW01', 'bromello', 'Bukhari Script', 'BUS STOP', 'Carmensita', 'Carolina', 'Caviar Dreams', 'Caviar Dreams bold', 'Caviar Dreams italic', 'Caviar Dreams bold italic', 'Champagne n Limousines', 'Champagne n Limousines bold', 'Champagne n Limousines italic', 'Champagne n Limousines bold italic', 'ChickenAndWaffles', 'Chlakh Demo', 'cinnamon cake', 'cinnamon cake', 'COFFE n MILK', 'Comfortaa', 'Comfortaa light', 'Comfortaa bold', 'Contento Script', 'Dandelion Soup Demo', 'Daydreamer', 'Daydreamer', 'DK Lemon Yellow Sun', 'Dragonfly', 'Eggcup', 'Eggcup bold', 'FISHfingers', 'Foxhole', 'Grand Hotel', 'Hickory Jack', 'Hickory Jack light', 'HipsterishFontNormal', 'Huffleclaw', 'Jack Lane', 'Jasper', 'Jolly', 'Jolly bold', 'Jolly italic', 'Jolly bold italic', 'JuliaVintage', 'KG Rise UP', 'KG Satisfied Script Alt', 'KG Satisfied Script', 'KG Two is Better Than One', 'Lemon Milk', 'Lieve Letters', 'LillyBelle', 'Linowrite', 'LolaBelle', 'Luna', 'Madina Clean Alt', 'Madina Clean Ornaments', 'Madina Ornaments', 'Madina Script Alt', 'Madina Script', 'Malibu', 'Maneo_TRIAL', 'MasanaScript', 'Melodysta', 'Mickelmas', 'Montreal script_Update', 'New Sun', 'NI Fish Taco', 'NORTHWEST', 'Selfie', 'Simplicity', 'Sofia', 'Special Elite', 'The Skinny', 'The Skinny bold', 'TheSofy', 'Tigerlily', 'Tony Tony', 'Tuesday-Script', 'Typewriter', 'Typewriter bold', 'UnicornFlakes', 'Vayentha Sans Demo', 'Vayentha Script Demo', 'Vendetta', 'Vincentia', 'A-DAY-WITHOUT-SUN', 'Shorelines-Script-Bold' );

        $i = 1;
        foreach( $fontnamearr as $key => $value ) { 
            $arr = explode( ' ', trim( $key ) );
            $words = explode( ' ', $key );
            array_shift( $words );
            $words = implode( ' ', $words );
        ?>
            <input type="radio" id="<?php echo esc_attr( $id . '-' . $i ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>"  >
            <label for="<?php echo esc_attr( $id . '-' . $i ); ?>" style="font-family: <?php echo esc_attr( $value ); ?>"><span><?php echo esc_attr( $arr[0] ); ?></span><?php echo esc_attr( $words ); ?></label>
        <?php
            $i++;
        }
    }
?>
    <div class="main clearfix">
        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/watermark.png' ); ?>" id="water-mark-img" style="display: none" alt="">
        <aside class="menu-links">
                <div class="logo">
                    <a href="javascript:void(0)">
                        <img src="logo.png" alt="">
                    </a>
                </div>
                <div class="menu">
                    <nav class="main-menu">
                        <ul>
                            <?php
                            if ( is_user_logged_in() ) {
                            ?>
                                <li class="open l1">
                                <a href="javascript:void(0)" class="active" data-target="myaccount">
                                    <i class="fa fa-user-circle"></i> My Account
                                </a>
                            </li>
                            <?php
                            }
                            ?>
                            <li class="has-submenu l1" id="make-board">
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
                                            <!-- <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-flower">Flowers</a>
                                            </li> -->
                                            <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-multi">Flowers</a>
                                            </li>
                                            <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-cactus">Cactus</a>
                                            </li>
                                            <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-wreath">Wreaths</a>
                                            </li>
                                            <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-teepee">Teepee</a>
                                            </li>
                                            <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-mountains">Mountains</a>
                                            </li>
                                            <li class="l3">
                                                <a href="javascript:void(0)"  data-target="emb-waves">Waves</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="l1">
                                <a href="javascript:void(0)"  data-target="preview">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/canvasBg.jpg' ); ?>" style="display: none" alt="">
                                <i class="	fa fa-eye"></i> Preview</a>
                            </li>
                            <!-- <li class="l1">
                                <a href="javascript:void(0)"  data-target="payment-detail">
                                <i class="	fa fa-credit-card"></i>Payment details</a>
                            </li> -->
                            <li class="has-submenu l1">
                                <!-- <a href="javascript:void(0)"  data-target="payment-detail" > -->
                                <a href="javascript:void(0)" >
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/canvasBg.jpg' ); ?>" style="display: none" alt="">
                                <i class="	fa fa-file-pdf-o"></i> Order</a>
                                <ul>
                                    <li class="l2">
                                        <a href="javascript:void(0)" id="export-design"  data-target="export">
                                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/canvasBg.jpg' ); ?>" style="display: none" alt="">
                                        Export</a>
                                    </li>
                                    <li class="l2">
                                        <a href="javascript:void(0)"  data-target="send" id="send_order">
                                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/canvasBg.jpg' ); ?>" style="display: none" alt="">                                    
                                        Submit Design</a>
                                        <?php
                                        if ( is_user_logged_in() && function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel() ) {
                                        ?>
                                            <input type="hidden" name="order_type" value="1" id="order_type" />
                                        <?php
                                        } else {
                                        ?>
                                            <input type="hidden" name="order_type" value="2" id="order_type" />
                                        <?php
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <aside class="menu-content text-center">
                <div id="myaccount" class="<?php
                            if ( is_user_logged_in() ) {
                                echo 'open';
                            }
                            ?>">
                    <h3><?php echo esc_attr( $username ); ?>
                        <span><?php echo esc_attr( $emailid ); ?></span>
                    </h3>
                    <div>
                        <ul class="tabs">
                           <!-- <li class="active">
                                <a href="javascript:void(0)" data-target="tab-info">Info</a>
                                
                            </li>
                            <li class="">
                                <a href="javascript:void(0)"  data-target="tab-settings">Settings</a>
                            </li> -->
                            <div class="content">
                                <div id="tab-info" class="open" style="display:none">
                                    <p>Current plan subscription</p>
                                    <p class="text-uppercase"><strong>
                                    <?php
                                    if ( is_user_logged_in() && function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel() ) {
                                        global $current_user;
                                        $current_user->membership_level = pmpro_getMembershipLevelForUser( $current_user->ID );
                                        echo esc_attr( $current_user->membership_level->name );
                                    }
                                    ?>
                                    </strong></p>
                                    <br>
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
                                        <input type="hidden" name="username" value="<?php echo esc_attr( $username ); ?>" id="usernameid"/>
                                        <?php wp_nonce_field( 'pass_change_nonce', 'pass_change_field' ); ?>
                                        <input type="button" name="update_btn" id="update-btn" class="btn pink text-uppercase" value="Update">
                                    </form>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
                <div id="choose-design" class="<?php
                            if ( ! is_user_logged_in() ) {
                                echo 'open';
                            }
                            ?>">
                    <h3>Select size</h3>
                    <div class="">
                        <input type="radio" name="size" id="2" value="24x18">
                        <label for="2">24"</label>
                        <input type="radio" name="size" id="1.5" value="18x14">
                        <label for="1.5">18"</label>
                        <input type="radio" name="size" id="1" value="15x12">
                        <label for="1">15"</label>
                        <br>
                        <h3>Select shape</h3>
                        <input type="radio" id="shape-01" name="select-shape" >
                        <label for="shape-01" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape01.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-02" name="select-shape" >
                        <label for="shape-02" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape02.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-03" name="select-shape" >
                        <label for="shape-03" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape03.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-04" name="select-shape" >
                        <label for="shape-04" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape04.svg' );?>" alt="">
                        </label>
                        <input type="radio" id="shape-05" name="select-shape" >
                        <label for="shape-05" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape05.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-06" name="select-shape" >
                        <label for="shape-06" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape06.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-07" name="select-shape" >
                        <label for="shape-07" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape07.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-08" name="select-shape" >
                        <label for="shape-08" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape08.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-09" name="select-shape" >
                        <label for="shape-09" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape09.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-10" name="select-shape" >
                        <label for="shape-10" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape10.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-11" name="select-shape" >
                        <label for="shape-11" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape11.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-12" name="select-shape" >
                        <label for="shape-12" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape12.svg' ); ?>" alt="">
                        </label>
                        <input type="radio" id="shape-13" name="select-shape" >
                        <label for="shape-13" class="tile">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/shapes/shape13.svg' ); ?>" alt="">
                        </label>
                    </div> 
                </div>
                <div id="select-stain">
                    <h3>Select stain</h3>
                        <br><br><br>
                    <div class="">
                        <input type="radio" id="texture-01" name="select-texture" value="ANTIQUE WHITE" />
                        <label for="texture-01" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/ANTIQUE-WHITE.png' ); ?>" alt="">
                            <br>
                            <p>ANTIQUE WHITE</p>
                        </label>
                        <input type="radio" id="texture-02" name="select-texture" value="BLACK CHERRY" />
                        <label for="texture-02" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLACK-CHERRY.png' ); ?>" alt="">
                            <br>
                            <p>BLACK CHERRY</p>
                        </label>
                        <input type="radio" id="texture-03" name="select-texture" value="BLEACHED BLUE" />
                        <label for="texture-03" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLEACHED-BLUE.png' ); ?>" alt="">
                            <br>
                            <p>BLEACHED BLUE</p>
                        </label>
                        <input type="radio" id="texture-04" name="select-texture" value="BOMBAY MAHOGANY" >
                        <label for="texture-04" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BOMBAY-MAHOGANY.png' ); ?>" alt="">
                            <br>
                            <p>BOMBAY MAHOGANY</p>
                        </label>
                        <input type="radio" id="texture-05" name="select-texture" value="CABERNET" >
                        <label for="texture-05" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CABERNET.png' ); ?>" alt="">
                            <br>
                            <p>CABERNET</p>
                        </label>
                        <input type="radio" id="texture-06" name="select-texture" value="CARBON GREY" >
                        <label for="texture-06" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CARBON-GREY.png' ); ?>" alt="">
                            <br>
                            <p>CARBON GREY</p>
                        </label>
                        <input type="radio" id="texture-07" name="select-texture" value="CLASSIC GREY" >
                        <label for="texture-07" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-GREY.png' ); ?>" alt="">
                            <br>
                            <p>CLASSIC GREY</p>
                        </label>
                        <input type="radio" id="texture-08" name="select-texture" value="CLASSIC OAK" >
                        <label for="texture-08" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-OAK.png' ); ?>" alt="">
                            <br>
                            <p>CLASSIC OAK</p>
                        </label>
                        <input type="radio" id="texture-09" name="select-texture" value="DARK WALNUT" >
                        <label for="texture-09" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/DARK-WALNUT.png' ); ?>" alt="">
                            <br>
                            <p>DARK WALNUT</p>
                        </label>
                        <input type="radio" id="texture-10" name="select-texture" value="EBONY" >
                        <label for="texture-10" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/EBONY.png' ); ?>" alt="">
                            <br>
                            <p>EBONY</p>
                        </label>
                        <input type="radio" id="texture-11" name="select-texture" value="ENGLISH CHESTNUT" >
                        <label for="texture-11" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/ENGLISH-CHESTNUT.png' ); ?>" alt="">
                            <br>
                            <p>ENGLISH CHESTNUT</p>
                        </label>
                        <input type="radio" id="texture-12" name="select-texture" value="EXPRESSO" >
                        <label for="texture-12" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/EXPRESSO.png' ); ?>" alt="">
                            <br>
                            <p>EXPRESSO</p>
                        </label>
                        <input type="radio" id="texture-13" name="select-texture" value="GOLDEN PECAN" >
                        <label for="texture-13" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/GOLDEN-PECAN.png' ); ?>" alt="">
                            <br>
                            <p>GOLDEN PECAN</p>
                        </label>
                        <input type="radio" id="texture-14" name="select-texture" value="GUNSTOCK" >
                        <label for="texture-14" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/GUNSTOCK.png' ); ?>" alt="">
                            <br>
                            <p>GUNSTOCK</p>
                        </label>
                        <input type="radio" id="texture-15" name="select-texture" value="JACOBEAN" >
                        <label for="texture-15" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/JACOBEAN.png' ); ?>" alt="">
                            <br>
                            <p>JACOBEAN</p>
                        </label>
                        <input type="radio" id="texture-16" name="select-texture" value="RUSTIC SAGE" >
                        <label for="texture-16" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/RUSTIC-SAGE.png' ); ?>" alt="">
                            <br>
                            <p>RUSTIC SAGE</p>
                        </label>
                        <input type="radio" id="texture-17" name="select-texture" value="SPECIAL WALNUT" >
                        <label for="texture-17" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/SPECIAL-WALNUT.png' ); ?>" alt="">
                            <br>
                            <p>SPECIAL WALNUT</p>
                        </label>
                        <input type="radio" id="texture-18" name="select-texture" value="VINTAGE AQUA" >
                        <label for="texture-18" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/VINTAGE-AQUA.png' ); ?>" alt="">
                            <br>
                            <p>VINTAGE AQUA</p>
                        </label>
                        <input type="radio" id="texture-19" name="select-texture" value="WHITEWASH" >
                        <label for="texture-19" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/WHITEWASH.png' ); ?>" alt="">
                            <br>
                            <p>WHITEWASH</p>
                        </label>
                        <input type="radio" id="texture-20" name="select-texture" value="WORN NAVY" >
                        <label for="texture-20" class="tile with-img-text">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/WORN-NAVY.png' ); ?>" alt="">
                            <br>
                            <p>WORN NAVY</p>
                        </label>
                    </div>
                </div>
                <div id="edit-text">
                    <h3>Add Text
                        <span>letter Count</span>
                    </h3>
                    <div>
                        <ul class="tabs">
                            <li class="active">
                                <a href="javascript:void(0)" data-target="first-word">1st word
                                    <i class="fa fa-times-circle "></i>
                                </a>
                                
                            </li>
                            <li class="">
                                <a href="javascript:void(0)"  data-target="secound-word"><i class="fa fa-plus-circle"></i> 2nd word</a>
                            </li>
                            <div class="content">
                                <div id="first-word" class="open">
                                    <div class="">
                                    <input type="text" name="board_first_word" id="text-one" style="width: 100%" value="">
                                    <br><br>
                                    <div class="font-size-selector">
                                        <label>Select Size</label>
                                        <input type="number" name="first_word_font_size" id="text-one-font-size" min="15" max="120" value="18" >
                                    </div>

                                    <br><br>
                                        <p>Select Font</p>
                                        <div class="select-type-radio select-fonts">
                                            <?php 
                                            echofont('font', 'select-font');
                                            ?>
                                        </div>
                                        <div class="color-type-radio">
                                        <?php
                                            echocolor('word-1st-color', 'select-color-one');
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="secound-word" class="">
                                    <div class="">
                                        <input type="text" name="board_second_word" id="text-two" style="width: 100%" value="">
                                        <br><br>
                                        <div class="font-size-selector">
                                            <label>Select Size</label>
                                            <input type="number" name="second_word_font_size" id="text-two-font-size" min="15" max="120" value="18" >
                                        </div>
                                        <br><br>
                                        <p>Select Font</p>
                                        <div class="select-type-radio select-fonts">
                                            <?php 
                                                echofont('word-2nd-font', 'word-2nd-select-font');
                                            ?>
                                        </div>
                                        <div class="color-type-radio">
                                        <?php

                                            echocolor('word-2nd-color', 'select-color-two');
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
                <div id="emb-flower">
                    <h3>Select Emblem</h3>
                    <h4>flowers</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-flower-color', 'emb-flower-select-color');
                        ?>
                    </div>
                    <br>
                    <div class="clearfix">
                        <a href="javascript:void(0)" class="remove-flower" class="btn ">Remove Flower</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-flower" id="flower-01" value="flower_a">
                            <label for="flower-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower01.png' );?>" alt="">
                                <p>Emblem A</p>
                            </label>
                            <input type="radio" name="select-emb-flower" id="flower-02" value="flower_b">
                            <label for="flower-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower02.png' );?>" alt="">
                                <p>Emblem B</p>
                            </label>
                            <input type="radio" name="select-emb-flower" id="flower-03" value="flower_c">
                            <label for="flower-03">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower03.png' );?>" alt="">
                                <p>Emblem C</p>
                            </label>
                            <input type="radio" name="select-emb-flower" id="flower-04" value="flower_d">
                            <label for="flower-04">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower04.png' );?>" alt="">
                                <p>Emblem D</p>
                            </label>
                            <input type="radio" name="select-emb-flower" id="flower-05" value="flower_e">
                            <label for="flower-05">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower05.png' );?>" alt="">
                                <p>Emblem E</p>
                            </label>
                            <input type="radio" name="select-emb-flower" id="flower-06" value="flower_f">
                            <label for="flower-06">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower06.png' );?>" alt="">
                                <p>Emblem F</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emb-cactus">
                    <h3>Select Emblem</h3>
                    <h4>Cactus</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-flower-cactus', 'emb-cactus-select-color');
                        ?>
                    </div>
                    <br>
                    <div  class="clearfix">
                        <a href="javascript:void(0)" class="remove-cactus" class="btn ">Remove Cactus</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-cactus" id="cactus-01" value="cactus_a">
                            <label for="cactus-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus01.png' );?>" alt="">
                                <p>Emblem A</p>
                            </label>
                            <input type="radio" name="select-emb-cactus" id="cactus-02" value="cactus_b">
                            <label for="cactus-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus02.png' );?>" alt="">
                                <p>Emblem B</p>
                            </label>
                            <input type="radio" name="select-emb-cactus" id="cactus-03" value="cactus_c">
                            <label for="cactus-03">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus03.png' );?>" alt="">
                                <p>Emblem C</p>
                            </label>
                            <input type="radio" name="select-emb-cactus" id="cactus-04" value="cactus_d">
                            <label for="cactus-04">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus04.png' );?>" alt="">
                                <p>Emblem D</p>
                            </label>
                            <input type="radio" name="select-emb-cactus" id="cactus-05" value="cactus_e">
                            <label for="cactus-05">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus05.png' );?>" alt="">
                                <p>Emblem E</p>
                            </label>
                            <input type="radio" name="select-emb-cactus" id="cactus-06" value="cactus_f">
                            <label for="cactus-06">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus06.png' );?>" alt="">
                                <p>Emblem F</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emb-wreath">
                    <h3>Select Emblem</h3>
                    <h4>wreaths</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-flower-wreaths', 'emb-wreaths-select-color');
                        ?>
                    </div>
                    <br>
                    <div  class="clearfix">
                        <a href="javascript:void(0)" class="remove-wreaths" class="btn ">Remove Wreaths</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-wreaths" id="wreaths-01" value="wreaths_a">
                            <label for="wreaths-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths01.png' );?>" alt="">
                                <p>Emblem A</p>
                            </label>
                            <input type="radio" name="select-emb-wreaths" id="wreaths-02" value="wreaths_b">
                            <label for="wreaths-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths02.png' );?>" alt="">
                                <p>Emblem B</p>
                            </label>
                            <input type="radio" name="select-emb-wreaths" id="wreaths-03" value="wreaths_c">
                            <label for="wreaths-03">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths03.png' );?>" alt="">
                                <p>Emblem C</p>
                            </label>
                            <input type="radio" name="select-emb-wreaths" id="wreaths-04" value="wreaths_d">
                            <label for="wreaths-04">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths04.png' );?>" alt="">
                                <p>Emblem D</p>
                            </label>
                            <input type="radio" name="select-emb-wreaths" id="wreaths-05" value="wreaths_e">
                            <label for="wreaths-05">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths05.png' );?>" alt="">
                                <p>Emblem E</p>
                            </label>
                            <input type="radio" name="select-emb-wreaths" id="wreaths-06" value="wreaths_f">
                            <label for="wreaths-06">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths06.png' );?>" alt="">
                                <p>Emblem F</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emb-multi">
                    <h3>Select Emblem</h3>
                    <h4>Multi</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-multi', 'emb-multi-select-color');
                        ?>
                    </div>
                    <br>
                    <div class="multi-shapes-wrpper">
                        
                    </div>
                    <br>
                    <div>
                        <a href="javascript:void(0)" class="remove-multi" class="btn ">Remove Multi</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-multi" id="flower-m-01">
                            <label for="flower-m-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-01.png' );?>" alt="">
                                <p>Flower 01</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-02">
                            <label for="flower-m-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-02.png' );?>" alt="">
                                <p>Flower 02</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-03">
                            <label for="flower-m-03">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-03.png' );?>" alt="">
                                <p>Flower 03</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-04">
                            <label for="flower-m-04">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-04.png' );?>" alt="">
                                <p>Flower 04</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-05">
                            <label for="flower-m-05">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-05.png' );?>" alt="">
                                <p>Flower 05</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-06">
                            <label for="flower-m-06">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-06.png' );?>" alt="">
                                <p>Flower 06</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-07">
                            <label for="flower-m-07">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-07.png' );?>" alt="">
                                <p>Flower 07</p>
                            </label>
                            <input type="radio" name="select-emb-multi" id="flower-m-08">
                            <label for="flower-m-08">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower-m-08.png' );?>" alt="">
                                <p>Flower 08</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emb-teepee">
                    <h3>Select Emblem</h3>
                    <h4>Modern Teepee</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-teepee', 'emb-teepee-select-color');
                        ?>
                    </div>
                    <br>
                    <div class="teepee-shapes-wrpper">
                        
                    </div>
                    <br>
                    <div>
                        <a href="javascript:void(0)" class="remove-teepee" class="btn ">Remove Multi</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-teepee" id="teepee-01">
                            <label for="teepee-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/teepee-01.png' );?>" alt="">
                                <p>Teepee 01</p>
                            </label>
                            <input type="radio" name="select-emb-teepee" id="teepee-02">
                            <label for="teepee-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/teepee-02.png' );?>" alt="">
                                <p>Teepee 02</p>
                            </label>
                            <input type="radio" name="select-emb-teepee" id="teepee-03">
                            <label for="teepee-03">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/teepee-03.png' );?>" alt="">
                                <p>Teepee 03</p>
                            </label>
                            <input type="radio" name="select-emb-teepee" id="teepee-04">
                            <label for="teepee-04">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/teepee-04.png' );?>" alt="">
                                <p>Teepee 04</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emb-mountains">
                    <h3>Select Emblem</h3>
                    <h4>Modern Mountains</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-mountains', 'emb-mountains-select-color');
                        ?>
                    </div>
                    <br>
                    <div class="stain-selector-mountain" style="display: none; clear: both; overflow: hidden;">
                        <p>stain: </p>
                        <div class="" style="clear: both; ">
                            <input type="radio" id="mountain-texture-01" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/ANTIQUE-WHITE.png' ); ?>" name="select-emb-mountain-texture" value="ANTIQUE WHITE" />
                            <label for="mountain-texture-01" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/ANTIQUE-WHITE.png' ); ?>" alt="">
                                <br>
                                <p>ANTIQUE WHITE</p>
                            </label>
                            <input type="radio" id="mountain-texture-02" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLACK-CHERRY.png' ); ?>" name="select-emb-mountain-texture" value="BLACK CHERRY" />
                            <label for="mountain-texture-02" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLACK-CHERRY.png' ); ?>" alt="">
                                <br>
                                <p>BLACK CHERRY</p>
                            </label>
                            <input type="radio" id="mountain-texture-03" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLEACHED-BLUE.png' ); ?>" name="select-emb-mountain-texture" value="BLEACHED BLUE" />
                            <label for="mountain-texture-03" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLEACHED-BLUE.png' ); ?>" alt="">
                                <br>
                                <p>BLEACHED BLUE</p>
                            </label>
                            <input type="radio" id="mountain-texture-04" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/BOMBAY-MAHOGANY.png' ); ?>" name="select-emb-mountain-texture" value="BOMBAY MAHOGANY" >
                            <label for="mountain-texture-04" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BOMBAY-MAHOGANY.png' ); ?>" alt="">
                                <br>
                                <p>BOMBAY MAHOGANY</p>
                            </label>
                            <input type="radio" id="mountain-texture-05" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CABERNET.png' ); ?>" name="select-emb-mountain-texture" value="CABERNET" >
                            <label for="mountain-texture-05" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CABERNET.png' ); ?>" alt="">
                                <br>
                                <p>CABERNET</p>
                            </label>
                            <input type="radio" id="mountain-texture-06" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CARBON-GREY.png' ); ?>" name="select-emb-mountain-texture" value="CARBON GREY" >
                            <label for="mountain-texture-06" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CARBON-GREY.png' ); ?>" alt="">
                                <br>
                                <p>CARBON GREY</p>
                            </label>
                            <input type="radio" id="mountain-texture-07" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-GREY.png' ); ?>" name="select-emb-mountain-texture" value="CLASSIC GREY" >
                            <label for="mountain-texture-07" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-GREY.png' ); ?>" alt="">
                                <br>
                                <p>CLASSIC GREY</p>
                            </label>
                            <input type="radio" id="mountain-texture-08" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-OAK.png' ); ?>" name="select-emb-mountain-texture" value="CLASSIC OAK" >
                            <label for="mountain-texture-08" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-OAK.png' ); ?>" alt="">
                                <br>
                                <p>CLASSIC OAK</p>
                            </label>
                            <input type="radio" id="mountain-texture-09" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/DARK-WALNUT.png' ); ?>" name="select-emb-mountain-texture" value="DARK WALNUT" >
                            <label for="mountain-texture-09" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/DARK-WALNUT.png' ); ?>" alt="">
                                <br>
                                <p>DARK WALNUT</p>
                            </label>
                            <input type="radio" id="mountain-texture-10" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/EBONY.png' ); ?>" name="select-emb-mountain-texture" value="EBONY" >
                            <label for="mountain-texture-10" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/EBONY.png' ); ?>" alt="">
                                <br>
                                <p>EBONY</p>
                            </label>
                            <input type="radio" id="mountain-texture-11" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/ENGLISH-CHESTNUT.png' ); ?>" name="select-emb-mountain-texture" value="ENGLISH CHESTNUT" >
                            <label for="mountain-texture-11" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/ENGLISH-CHESTNUT.png' ); ?>" alt="">
                                <br>
                                <p>ENGLISH CHESTNUT</p>
                            </label>
                            <input type="radio" id="mountain-texture-12" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/EXPRESSO.png' ); ?>" name="select-emb-mountain-texture" value="EXPRESSO" >
                            <label for="mountain-texture-12" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/EXPRESSO.png' ); ?>" alt="">
                                <br>
                                <p>EXPRESSO</p>
                            </label>
                            <input type="radio" id="mountain-texture-13" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/GOLDEN-PECAN.png' ); ?>" name="select-emb-mountain-texture" value="GOLDEN PECAN" >
                            <label for="mountain-texture-13" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/GOLDEN-PECAN.png' ); ?>" alt="">
                                <br>
                                <p>GOLDEN PECAN</p>
                            </label>
                            <input type="radio" id="mountain-texture-14" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/GUNSTOCK.png' ); ?>" name="select-emb-mountain-texture" value="GUNSTOCK" >
                            <label for="mountain-texture-14" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/GUNSTOCK.png' ); ?>" alt="">
                                <br>
                                <p>GUNSTOCK</p>
                            </label>
                            <input type="radio" id="mountain-texture-15" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/JACOBEAN.png' ); ?>" name="select-emb-mountain-texture" value="JACOBEAN" >
                            <label for="mountain-texture-15" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/JACOBEAN.png' ); ?>" alt="">
                                <br>
                                <p>JACOBEAN</p>
                            </label>
                            <input type="radio" id="mountain-texture-16" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/RUSTIC-SAGE.png' ); ?>" name="select-emb-mountain-texture" value="RUSTIC SAGE" >
                            <label for="mountain-texture-16" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/RUSTIC-SAGE.png' ); ?>" alt="">
                                <br>
                                <p>RUSTIC SAGE</p>
                            </label>
                            <input type="radio" id="mountain-texture-17" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/SPECIAL-WALNUT.png' ); ?>" name="select-emb-mountain-texture" value="SPECIAL WALNUT" >
                            <label for="mountain-texture-17" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/SPECIAL-WALNUT.png' ); ?>" alt="">
                                <br>
                                <p>SPECIAL WALNUT</p>
                            </label>
                            <input type="radio" id="mountain-texture-18" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/VINTAGE-AQUA.png' ); ?>" name="select-emb-mountain-texture" value="VINTAGE AQUA" >
                            <label for="mountain-texture-18" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/VINTAGE-AQUA.png' ); ?>" alt="">
                                <br>
                                <p>VINTAGE AQUA</p>
                            </label>
                            <input type="radio" id="mountain-texture-19" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/WHITEWASH.png' ); ?>" name="select-emb-mountain-texture" value="WHITEWASH" >
                            <label for="mountain-texture-19" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/WHITEWASH.png' ); ?>" alt="">
                                <br>
                                <p>WHITEWASH</p>
                            </label>
                            <input type="radio" id="mountain-texture-20" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/WORN-NAVY.png' ); ?>" name="select-emb-mountain-texture" value="WORN NAVY" >
                            <label for="mountain-texture-20" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/WORN-NAVY.png' ); ?>" alt="">
                                <br>
                                <p>WORN NAVY</p>
                            </label>
                        </div>
                    </div>
                    <div class="mountains-shapes-wrpper">
                        
                    </div>
                    <br>
                    <div>
                        <a href="javascript:void(0)" class="remove-mountains" class="btn ">Remove Multi</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-mountains" id="mountains-01">
                            <label for="mountains-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/mountains-01.png' );?>" alt="">
                                <p>Mountains 01</p>
                            </label>
                            <input type="radio" name="select-emb-mountains" id="mountains-02">
                            <label for="mountains-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/mountains-02.png' );?>" alt="">
                                <p>Mountains 02</p>
                            </label>
                            <input type="radio" name="select-emb-mountains" id="mountains-03">
                            <label for="mountains-03">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/mountains-03.png' );?>" alt="">
                                <p>Mountains 03</p>
                            </label>
                            <input type="radio" name="select-emb-mountains" id="mountains-04">
                            <label for="mountains-04">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/mountains-04.png' );?>" alt="">
                                <p>Mountains 04</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emb-waves">
                    <h3>Select Emblem</h3>
                    <h4>Modern Waves</h4>
                    <br>
                    <div class="color-selector">
                        <p>color :</p>
                        <?php
                        echocolor('emb-waves', 'emb-waves-select-color');
                        ?>
                    </div>
                    <br>
                    <div class="stain-selector-waves" style="display: none; clear: both; overflow: hidden;">
                        <p>stain: </p>
                        <div class="" style="clear: both; ">
                            <input type="radio" id="waves-texture-01" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/ANTIQUE-WHITE.png' ); ?>" name="select-emb-mountain-texture" value="ANTIQUE WHITE" />
                            <label for="waves-texture-01" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/ANTIQUE-WHITE.png' ); ?>" alt="">
                                <br>
                                <p>ANTIQUE WHITE</p>
                            </label>
                            <input type="radio" id="waves-texture-02" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLACK-CHERRY.png' ); ?>" name="select-emb-mountain-texture" value="BLACK CHERRY" />
                            <label for="waves-texture-02" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLACK-CHERRY.png' ); ?>" alt="">
                                <br>
                                <p>BLACK CHERRY</p>
                            </label>
                            <input type="radio" id="waves-texture-03" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLEACHED-BLUE.png' ); ?>" name="select-emb-mountain-texture" value="BLEACHED BLUE" />
                            <label for="waves-texture-03" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BLEACHED-BLUE.png' ); ?>" alt="">
                                <br>
                                <p>BLEACHED BLUE</p>
                            </label>
                            <input type="radio" id="waves-texture-04" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/BOMBAY-MAHOGANY.png' ); ?>" name="select-emb-mountain-texture" value="BOMBAY MAHOGANY" >
                            <label for="waves-texture-04" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/BOMBAY-MAHOGANY.png' ); ?>" alt="">
                                <br>
                                <p>BOMBAY MAHOGANY</p>
                            </label>
                            <input type="radio" id="waves-texture-05" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CABERNET.png' ); ?>" name="select-emb-mountain-texture" value="CABERNET" >
                            <label for="waves-texture-05" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CABERNET.png' ); ?>" alt="">
                                <br>
                                <p>CABERNET</p>
                            </label>
                            <input type="radio" id="waves-texture-06" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CARBON-GREY.png' ); ?>" name="select-emb-mountain-texture" value="CARBON GREY" >
                            <label for="waves-texture-06" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CARBON-GREY.png' ); ?>" alt="">
                                <br>
                                <p>CARBON GREY</p>
                            </label>
                            <input type="radio" id="waves-texture-07" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-GREY.png' ); ?>" name="select-emb-mountain-texture" value="CLASSIC GREY" >
                            <label for="waves-texture-07" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-GREY.png' ); ?>" alt="">
                                <br>
                                <p>CLASSIC GREY</p>
                            </label>
                            <input type="radio" id="waves-texture-08" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-OAK.png' ); ?>" name="select-emb-mountain-texture" value="CLASSIC OAK" >
                            <label for="waves-texture-08" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/CLASSIC-OAK.png' ); ?>" alt="">
                                <br>
                                <p>CLASSIC OAK</p>
                            </label>
                            <input type="radio" id="waves-texture-09" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/DARK-WALNUT.png' ); ?>" name="select-emb-mountain-texture" value="DARK WALNUT" >
                            <label for="waves-texture-09" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/DARK-WALNUT.png' ); ?>" alt="">
                                <br>
                                <p>DARK WALNUT</p>
                            </label>
                            <input type="radio" id="waves-texture-10" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/EBONY.png' ); ?>" name="select-emb-mountain-texture" value="EBONY" >
                            <label for="waves-texture-10" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/EBONY.png' ); ?>" alt="">
                                <br>
                                <p>EBONY</p>
                            </label>
                            <input type="radio" id="waves-texture-11" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/ENGLISH-CHESTNUT.png' ); ?>" name="select-emb-mountain-texture" value="ENGLISH CHESTNUT" >
                            <label for="waves-texture-11" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/ENGLISH-CHESTNUT.png' ); ?>" alt="">
                                <br>
                                <p>ENGLISH CHESTNUT</p>
                            </label>
                            <input type="radio" id="waves-texture-12" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/EXPRESSO.png' ); ?>" name="select-emb-mountain-texture" value="EXPRESSO" >
                            <label for="waves-texture-12" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/EXPRESSO.png' ); ?>" alt="">
                                <br>
                                <p>EXPRESSO</p>
                            </label>
                            <input type="radio" id="waves-texture-13" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/GOLDEN-PECAN.png' ); ?>" name="select-emb-mountain-texture" value="GOLDEN PECAN" >
                            <label for="waves-texture-13" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/GOLDEN-PECAN.png' ); ?>" alt="">
                                <br>
                                <p>GOLDEN PECAN</p>
                            </label>
                            <input type="radio" id="waves-texture-14" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/GUNSTOCK.png' ); ?>" name="select-emb-mountain-texture" value="GUNSTOCK" >
                            <label for="waves-texture-14" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/GUNSTOCK.png' ); ?>" alt="">
                                <br>
                                <p>GUNSTOCK</p>
                            </label>
                            <input type="radio" id="waves-texture-15" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/JACOBEAN.png' ); ?>" name="select-emb-mountain-texture" value="JACOBEAN" >
                            <label for="waves-texture-15" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/JACOBEAN.png' ); ?>" alt="">
                                <br>
                                <p>JACOBEAN</p>
                            </label>
                            <input type="radio" id="waves-texture-16" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/RUSTIC-SAGE.png' ); ?>" name="select-emb-mountain-texture" value="RUSTIC SAGE" >
                            <label for="waves-texture-16" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/RUSTIC-SAGE.png' ); ?>" alt="">
                                <br>
                                <p>RUSTIC SAGE</p>
                            </label>
                            <input type="radio" id="waves-texture-17" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/SPECIAL-WALNUT.png' ); ?>" name="select-emb-mountain-texture" value="SPECIAL WALNUT" >
                            <label for="waves-texture-17" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/SPECIAL-WALNUT.png' ); ?>" alt="">
                                <br>
                                <p>SPECIAL WALNUT</p>
                            </label>
                            <input type="radio" id="waves-texture-18" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/VINTAGE-AQUA.png' ); ?>" name="select-emb-mountain-texture" value="VINTAGE AQUA" >
                            <label for="waves-texture-18" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/VINTAGE-AQUA.png' ); ?>" alt="">
                                <br>
                                <p>VINTAGE AQUA</p>
                            </label>
                            <input type="radio" id="waves-texture-19" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/WHITEWASH.png' ); ?>" name="select-emb-mountain-texture" value="WHITEWASH" >
                            <label for="waves-texture-19" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/WHITEWASH.png' ); ?>" alt="">
                                <br>
                                <p>WHITEWASH</p>
                            </label>
                            <input type="radio" id="waves-texture-20" data-img-value="<?php echo esc_url( TE_BB_URL . '/assets/texture/WORN-NAVY.png' ); ?>" name="select-emb-mountain-texture" value="WORN NAVY" >
                            <label for="waves-texture-20" class="tile with-img-text">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/WORN-NAVY.png' ); ?>" alt="">
                                <br>
                                <p>WORN NAVY</p>
                            </label>
                        </div>
                    </div>
                    <div class="waves-shapes-wrpper">
                        
                    </div>
                    <br>
                    <div>
                        <a href="javascript:void(0)" class="remove-waves" class="btn ">Remove Multi</a>
                    </div>
                    <br>
                    <div class="">
                        <div class="round-tile-radio">
                            <input type="radio" name="select-emb-waves" id="waves-01">
                            <label for="waves-01">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/waves-01.png' );?>" alt="">
                                <p>Waves 01</p>
                            </label>
                            <input type="radio" name="select-emb-waves" id="waves-02">
                            <label for="waves-02">
                                <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/waves-02.png' );?>" alt="">
                                <p>waves 02</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="preview">
                    <h3>Preview
                        Letter Count: <span class="count">0</span>&nbsp;<span class="remain">(50 left)</span>
                    </h3>
                    <br>
                    <h3>Description</h3>
                    <p class="text-left" >Diameter: Approx. 24 inches</p>
                    <p class="text-left" >Base: 1/2 inch thick</p>
                    <p class="text-left" >Weight: Approx. 4 lbs.</p>
                    <p class="text-left" >Letters are cut out of 1/2 inch birch wood, hand sanded, painted, and mounted onto a handcut finished brich round that is stained (the back of the base is unfinished). our unique signs are customizable with a choice of stain, paint color, font and symbols. your one of a kind sign will come with a sawtooth hanger anger.</p>
                    <!-- <p>Total</p> -->
                    <p class="text-left" >we will send you a proof to ensure you are happy with your choices </p>
                    <!-- <p>TOTAL Price: <span id="total-price-on-preview"></span> </p> -->
                </div>
                <div id="export">
                    <h3>Export</h3>
                    <br>
                    <?php
                    if ( is_user_logged_in() && function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel() ) {
                        global $current_user;
                        $current_user->membership_level = pmpro_getMembershipLevelForUser( $current_user->ID );
                        $levelid = $current_user->membership_level->ID;
                        $user_remaing_limit = get_user_meta($current_user->ID, 'user_download_limit', true);
                        if( $user_remaing_limit > 0 ) {
                        ?>
                            <a href="javascript:void(0)" class="btn full" id="export-btn"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp; Export to PDF</a>
                        <?php
                        } else {
                        ?>
                            <p>Your Plans Download Limit has been reached to make more design please Renew your plan </p>
                            <a href="#" class="btn full" id="renew_plan"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp; Change Membership</a>
                        <?php
                        }
                    }
                    ?>
                </div>
                
            </aside>
            <div class="app">
                <input type="hidden" id="c_id" name="c_username" value="<?php echo esc_attr( $username ); ?>"/>
                <input type="hidden" id="ex_nonce" name="check_nonce" value="<?php echo esc_attr( wp_create_nonce( 'export-nonce' ) ); ?>"/>
                <input type="hidden" id="letter_price" value="<?php echo esc_attr( get_option( 'letter_price' ) ); ?>">
                <input type="hidden" id="embellishment_price" value="<?php echo esc_attr( get_option( 'embellishment_price' ) ); ?>">
                <div class="canvas-header">
                    <p id="text-on-board">Text on board: <span></span></p>
                    <p id="letter-count-on-board">Letter Count: <span class="count"></span> <span class="remain"></span></p>
                    <!-- <p id="Price-of-board">Price: <span></span></p> -->
                </div>
                <div class="" id="canvas">
                    
                </div>
            </div>
        </div>
        <div id="payment-detail">
        
            <div class="popup payment-form">
                <a href="javascript:void(0)" class="close"></a>
                <input type="email"  placeholder="Email" id="payment-email" name="payment-email" >
                <input type="text" placeholder="First Name" id="payment-first-name" name="payment-first-name">
                <input type="text" placeholder="Last Name" id="payment-last-name" name="payment-last-name">
                <p class="title">Choose Payment Type </p>
                <input type="radio" name="payment-mode" value="payment-cradit-card" id="payment-cradit-card">
                <label for="payment-cradit-card">Cradit Card</label>
                <input type="radio" name="payment-mode" value="payment-paypal" id="payment-paypal">
                <label for="payment-paypal">Paypal</label>
                <div id="paypal-form">
                    <form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="GET" id="xclick">
                        <input type="hidden" name="amount" placeholder="Enter Donation Amount" class="amounts"/>
                        <input type="hidden" name="cmd" value="_xclick"/>
                        <input type="hidden" name="business" value="<?php echo esc_attr( $adminmain ); ?>"/>
                        <input type="hidden" name="currency_code" value="USD"/>
                        <input type="hidden" name="item_name" value="<?php echo esc_attr( $itemname ); ?>"/> 
                        <input type="hidden" name="return" value="<?php echo esc_url( $paypalreturn ); ?>"/>
                        <input type="hidden" name="cancel_return" value="<?php echo esc_url( $paypalcancelurl ); ?>"/>
                        <input type="hidden" name="custom" value="<?php echo esc_attr( $booking_id ); ?>" class="booking_id"/>
                        <input type="hidden" name="rm" value="1"/> 
                        <input type="image" name="submit" id="donation_submit" class="has_donation" src="<?php echo esc_url( TE_BB_URL . '/assets/pay-paypal.png' );?>" alt="Pay"> <img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
                    </form>  
                </div>
            </div>
        </div>
        <div id="overlay"><p>Please wait..</p></div>
    <?php get_footer();
}