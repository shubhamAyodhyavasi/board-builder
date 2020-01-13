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
get_header();
global $wpdb, $current_user;
$user_details = wp_get_current_user();
$emailid      = $current_user->user_email;
$username = $current_user->user_login;
?>
<div class="main clearfix">
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
                        <li class="has-submenu l1">
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
                                        <li class="l3">
                                            <a href="javascript:void(0)"  data-target="emb-multi">Multi</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="l1" id="preview-li">
                            <a href="javascript:void(0)" id="preview" data-target="preview">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/canvasBg.jpg' ); ?>" style="display: none" alt="">
                             <i class="	fa fa-eye"></i> Preview</a>
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
                        <li class="active">
                            <a href="javascript:void(0)" data-target="tab-info">Info</a>
                            
                        </li>
                        <li class="">
                            <a href="javascript:void(0)"  data-target="tab-settings">Settings</a>
                        </li>
                        <div class="content">
                            <div id="tab-info" class="open">
                                <p>Current plan subscription</p>
                                <p class="text-uppercase"><strong>Standard</strong></p>
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
                    <input type="radio" name="size" id="2">
                    <label for="2">24"x18"</label>
                    <input type="radio" name="size" id="1.5">
                    <label for="1.5">18"x14"</label>
                    <input type="radio" name="size" id="1">
                    <label for="1">15"x12"</label>
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
                <div class="">
                    <br><br><br>
                    <input type="radio" id="texture-01" name="select-texture" >
                    <label for="texture-01" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure01.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-02" name="select-texture" >
                    <label for="texture-02" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure02.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-03" name="select-texture" >
                    <label for="texture-03" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure03.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-04" name="select-texture" >
                    <label for="texture-04" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure04.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-05" name="select-texture" >
                    <label for="texture-05" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure05.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-06" name="select-texture" >
                    <label for="texture-06" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure06.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-07" name="select-texture" >
                    <label for="texture-07" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure07.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-08" name="select-texture" >
                    <label for="texture-08" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure08.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-09" name="select-texture" >
                    <label for="texture-09" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure09.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-10" name="select-texture" >
                    <label for="texture-10" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure10.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-11" name="select-texture" >
                    <label for="texture-11" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure11.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
                    </label>
                    <input type="radio" id="texture-12" name="select-texture" >
                    <label for="texture-12" class="tile with-img-text">
                        <img src="<?php echo esc_url( TE_BB_URL . '/assets/texture/texure12.png' ); ?>" alt="">
                        <br>
                        <p>TextureName</p>
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
                                <input type="text" name="board_first_word" id="text-one" style="width: 100%">
                                <br><br>
                                <div class="font-size-selector">
                                    <label>Select Size</label>
                                    <input type="number" name="" id="text-one-font-size" min="15" max="80" value="18" >
                                </div>

                                <br><br>
                                    <p>Select Font</p>
                                    <div class="select-type-radio">
                                        <input type="radio" id="font-01" name="select-font" >
                                        <label for="font-01" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font01.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="font-02" name="select-font" >
                                        <label for="font-02" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font02.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="font-03" name="select-font" >
                                        <label for="font-03" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font03.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-04" name="select-font" >
                                        <label for="font-04" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font04.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-05" name="select-font" >
                                        <label for="font-05" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font05.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-06" name="select-font" >
                                        <label for="font-06" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font06.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-07" name="select-font" >
                                        <label for="font-07" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font07.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-08" name="select-font" >
                                        <label for="font-08" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font08.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-09" name="select-font" >
                                        <label for="font-09" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font09.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="font-10" name="select-font" >
                                        <label for="font-10" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font10.png' ); ?>" alt="">
                                        </label>
                                    </div>
                                    <div class="color-type-radio">
                                            <input type="color" id="color-01" name="select-color" value="#f6f3ee"  >
                                            <input type="radio" id="color-01" name="select-color" value="#f6f3ee"  >
                                            <label for="color-01" style="background-color: #f6f3ee">
                                            </label>
                                            <input type="radio" id="color-02" name="select-color" value="#ede5da"  >
                                            <label for="color-02" style="background-color: #ede5da">
                                            </label>
                                            <input type="radio" id="color-03" name="select-color" value="#cfcfcf"  >
                                            <label for="color-03" style="background-color: #cfcfcf">
                                            </label>
                                            <input type="radio" id="color-04" name="select-color" value="#a2a2a2"  >
                                            <label for="color-04" style="background-color: #a2a2a2">
                                            </label>
                                            <input type="radio" id="color-05" name="select-color" value="#8e9295"  >
                                            <label for="color-05" style="background-color: #8e9295">
                                            </label>
                                            <input type="radio" id="color-06" name="select-color" value="#6e7276"  >
                                            <label for="color-06" style="background-color: #6e7276">
                                            </label>
                                            <input type="radio" id="color-07" name="select-color" value="#59595b"  >
                                            <label for="color-07" style="background-color: #59595b">
                                            </label>
                                            <input type="radio" id="color-08" name="select-color" value="#6e7276"  >
                                            <label for="color-08" style="background-color: #6e7276">
                                            </label>
                                            <input type="radio" id="color-09" name="select-color" value="#59595b"  >
                                            <label for="color-09" style="background-color: #59595b">
                                            </label>
                                            <input type="radio" id="color-10" name="select-color" value="#d3bda6"  >
                                            <label for="color-10" style="background-color: #d3bda6">
                                            </label>
                                            <input type="radio" id="color-11" name="select-color" value="#aa998f"  >
                                            <label for="color-11" style="background-color: #aa998f">
                                            </label>
                                            <input type="radio" id="color-12" name="select-color" value="#8a786b"  >
                                            <label for="color-12" style="background-color: #8a786b">
                                            </label>
                                            <input type="radio" id="color-13" name="select-color" value="#6f5e55"  >
                                            <label for="color-13" style="background-color: #6f5e55">
                                            </label>
                                            <input type="radio" id="color-14" name="select-color" value="#574a45"  >
                                            <label for="color-14" style="background-color: #574a45">
                                            </label>
                                            <input type="radio" id="color-15" name="select-color" value="#2a2a2c"  >
                                            <label for="color-15" style="background-color: #2a2a2c">
                                            </label>
                                            <input type="radio" id="color-16" name="select-color" value="#df945c"  >
                                            <label for="color-16" style="background-color: #df945c">
                                            </label>
                                            <input type="radio" id="color-17" name="select-color" value="#de6945"  >
                                            <label for="color-17" style="background-color: #de6945">
                                            </label>
                                            <input type="radio" id="color-18" name="select-color" value="#df945c"  >
                                            <label for="color-18" style="background-color: #df945c">
                                            </label>
                                            <input type="radio" id="color-19" name="select-color" value="#de6945"  >
                                            <label for="color-19" style="background-color: #de6945">
                                            </label>
                                            <input type="radio" id="color-20" name="select-color" value="#be7146"  >
                                            <label for="color-20" style="background-color: #be7146">
                                            </label>
                                            <input type="radio" id="color-21" name="select-color" value="#af664c"  >
                                            <label for="color-21" style="background-color: #af664c">
                                            </label>
                                            <input type="radio" id="color-22" name="select-color" value="#ffd88d"  >
                                            <label for="color-22" style="background-color: #ffd88d">
                                            </label>
                                            <input type="radio" id="color-23" name="select-color" value="#f1bb4a"  >
                                            <label for="color-23" style="background-color: #f1bb4a">
                                            </label>
                                            <input type="radio" id="color-24" name="select-color" value="#eaae38"  >
                                            <label for="color-24" style="background-color: #eaae38">
                                            </label>
                                            <input type="radio" id="color-25" name="select-color" value="#f8aa24"  >
                                            <label for="color-25" style="background-color: #f8aa24">
                                            </label>
                                            <input type="radio" id="color-26" name="select-color" value="#ffb050"  >
                                            <label for="color-26" style="background-color: #ffb050">
                                            </label>
                                            <input type="radio" id="color-27" name="select-color" value="#ff9f39"  >
                                            <label for="color-27" style="background-color: #ff9f39">
                                            </label>
                                            <input type="radio" id="color-28" name="select-color" value="#ffb050"  >
                                            <label for="color-28" style="background-color: #ffb050">
                                            </label>
                                            <input type="radio" id="color-29" name="select-color" value="#ff9f39"  >
                                            <label for="color-29" style="background-color: #ff9f39">
                                            </label>
                                            <input type="radio" id="color-30" name="select-color" value="#bf8d38"  >
                                            <label for="color-30" style="background-color: #bf8d38">
                                            </label>
                                            <input type="radio" id="color-31" name="select-color" value="#edd5d5"  >
                                            <label for="color-31" style="background-color: #edd5d5">
                                            </label>
                                            <input type="radio" id="color-32" name="select-color" value="#f0c5cf"  >
                                            <label for="color-32" style="background-color: #f0c5cf">
                                            </label>
                                            <input type="radio" id="color-33" name="select-color" value="#e3a3b1"  >
                                            <label for="color-33" style="background-color: #e3a3b1">
                                            </label>
                                            <input type="radio" id="color-34" name="select-color" value="#d88bb7"  >
                                            <label for="color-34" style="background-color: #d88bb7">
                                            </label>
                                            <input type="radio" id="color-35" name="select-color" value="#cb75a4"  >
                                            <label for="color-35" style="background-color: #cb75a4">
                                            </label>
                                            <input type="radio" id="color-36" name="select-color" value="#c56a76"  >
                                            <label for="color-36" style="background-color: #c56a76">
                                            </label>
                                            <input type="radio" id="color-37" name="select-color" value="#d8a391"  >
                                            <label for="color-37" style="background-color: #d8a391">
                                            </label>
                                            <input type="radio" id="color-38" name="select-color" value="#c56a76"  >
                                            <label for="color-38" style="background-color: #c56a76">
                                            </label>
                                            <input type="radio" id="color-39" name="select-color" value="#d8a391"  >
                                            <label for="color-39" style="background-color: #d8a391">
                                            </label>
                                            <input type="radio" id="color-40" name="select-color" value="#d9c0de"  >
                                            <label for="color-40" style="background-color: #d9c0de">
                                            </label>
                                            <input type="radio" id="color-41" name="select-color" value="#c39fcb"  >
                                            <label for="color-41" style="background-color: #c39fcb">
                                            </label>
                                            <input type="radio" id="color-42" name="select-color" value="#b6a2bb"  >
                                            <label for="color-42" style="background-color: #b6a2bb">
                                            </label>
                                            <input type="radio" id="color-43" name="select-color" value="#9f6582"  >
                                            <label for="color-43" style="background-color: #9f6582">
                                            </label>
                                            <input type="radio" id="color-44" name="select-color" value="#8b5e8e"  >
                                            <label for="color-44" style="background-color: #8b5e8e">
                                            </label>
                                            <input type="radio" id="color-45" name="select-color" value="#684869"  >
                                            <label for="color-45" style="background-color: #684869">
                                            </label>
                                            <input type="radio" id="color-46" name="select-color" value="#5d5f75"  >
                                            <label for="color-46" style="background-color: #5d5f75">
                                            </label>
                                            <input type="radio" id="color-47" name="select-color" value="#cfcc95"  >
                                            <label for="color-47" style="background-color: #cfcc95">
                                            </label>
                                            <input type="radio" id="color-48" name="select-color" value="#5d5f75"  >
                                            <label for="color-48" style="background-color: #5d5f75">
                                            </label>
                                            <input type="radio" id="color-49" name="select-color" value="#cfcc95"  >
                                            <label for="color-49" style="background-color: #cfcc95">
                                            </label>
                                            <input type="radio" id="color-50" name="select-color" value="#d7cf6d"  >
                                            <label for="color-50" style="background-color: #d7cf6d">
                                            </label>
                                            <input type="radio" id="color-51" name="select-color" value="#a8a330"  >
                                            <label for="color-51" style="background-color: #a8a330">
                                            </label>
                                            <input type="radio" id="color-52" name="select-color" value="#568c51"  >
                                            <label for="color-52" style="background-color: #568c51">
                                            </label>
                                            <input type="radio" id="color-53" name="select-color" value="#6e7c44"  >
                                            <label for="color-53" style="background-color: #6e7c44">
                                            </label>
                                            <input type="radio" id="color-54" name="select-color" value="#6e6f45"  >
                                            <label for="color-54" style="background-color: #6e6f45">
                                            </label>
                                            <input type="radio" id="color-55" name="select-color" value="#c6eee3">
                                            <label for="color-55" style="background-color: #c6eee3">
                                            </label>
                                            <input type="radio" id="color-56" name="select-color" value="#99baaf">
                                            <label for="color-56" style="background-color: #99baaf">
                                            </label>
                                            <input type="radio" id="color-57" name="select-color" value="#6ecfc8">
                                            <label for="color-57" style="background-color: #6ecfc8">
                                            </label>
                                            <input type="radio" id="color-58" name="select-color" value="#99baaf">
                                            <label for="color-58" style="background-color: #99baaf">
                                            </label>
                                            <input type="radio" id="color-59" name="select-color" value="#6ecfc8">
                                            <label for="color-59" style="background-color: #6ecfc8">
                                            </label>
                                            <input type="radio" id="color-60" name="select-color" value="#d2b1b5"  >
                                            <label for="color-60" style="background-color: #d2b1b5">
                                            </label>
                                    </div>
                                </div>
                            </div>
                            <div id="secound-word" class="">
                                <div class="">
                                    <input type="text" name="board_second_word" id="text-two" style="width: 100%">
                                    <br><br>
                                    <div class="font-size-selector">
                                        <label>Select Size</label>
                                        <input type="number" name="" id="text-two-font-size" min="15" max="80" value="18" >
                                    </div>
                                    <br><br>
                                    <p>Select Font</p>
                                    <div class="select-type-radio">
                                        <input type="radio" id="word-2nd-font-01" name="select-font" >
                                        <label for="word-2nd-font-01" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font01.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-02" name="select-font" >
                                        <label for="word-2nd-font-02" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font02.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-03" name="select-font" >
                                        <label for="word-2nd-font-03" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font03.png' ); ?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-04" name="select-font" >
                                        <label for="word-2nd-font-04" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font04.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-05" name="select-font" >
                                        <label for="word-2nd-font-05" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font05.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-06" name="select-font" >
                                        <label for="word-2nd-font-06" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font06.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-07" name="select-font" >
                                        <label for="word-2nd-font-07" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font07.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-08" name="select-font" >
                                        <label for="word-2nd-font-08" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font08.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-09" name="select-font" >
                                        <label for="word-2nd-font-09" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font09.png' );?>" alt="">
                                        </label>
                                        <input type="radio" id="word-2nd-font-10" name="select-font" >
                                        <label for="word-2nd-font-10" class="">
                                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/font/font10.png' );?>" alt="">
                                        </label>
                                    </div>
                                    <div class="color-type-radio">
                                            <input type="color" id="color-01" name="select-color" value="#f6f3ee"  >
                                            <input type="radio" id="word-2nd-color-01" name="select-color" value="#f6f3ee"  >
                                            <label for="word-2nd-color-01" style="background-color: #f6f3ee">
                                            </label>
                                            <input type="radio" id="word-2nd-color-02" name="select-color" value="#ede5da"  >
                                            <label for="word-2nd-color-02" style="background-color: #ede5da">
                                            </label>
                                            <input type="radio" id="word-2nd-color-03" name="select-color" value="#cfcfcf"  >
                                            <label for="word-2nd-color-03" style="background-color: #cfcfcf">
                                            </label>
                                            <input type="radio" id="word-2nd-color-04" name="select-color" value="#a2a2a2"  >
                                            <label for="word-2nd-color-04" style="background-color: #a2a2a2">
                                            </label>
                                            <input type="radio" id="word-2nd-color-05" name="select-color" value="#8e9295"  >
                                            <label for="word-2nd-color-05" style="background-color: #8e9295">
                                            </label>
                                            <input type="radio" id="word-2nd-color-06" name="select-color" value="#6e7276"  >
                                            <label for="word-2nd-color-06" style="background-color: #6e7276">
                                            </label>
                                            <input type="radio" id="word-2nd-color-07" name="select-color" value="#59595b"  >
                                            <label for="word-2nd-color-07" style="background-color: #59595b">
                                            </label>
                                            <input type="radio" id="word-2nd-color-08" name="select-color" value="#6e7276"  >
                                            <label for="word-2nd-color-08" style="background-color: #6e7276">
                                            </label>
                                            <input type="radio" id="word-2nd-color-09" name="select-color" value="#59595b"  >
                                            <label for="word-2nd-color-09" style="background-color: #59595b">
                                            </label>
                                            <input type="radio" id="word-2nd-color-10" name="select-color" value="#d3bda6"  >
                                            <label for="word-2nd-color-10" style="background-color: #d3bda6">
                                            </label>
                                            <input type="radio" id="word-2nd-color-11" name="select-color" value="#aa998f"  >
                                            <label for="word-2nd-color-11" style="background-color: #aa998f">
                                            </label>
                                            <input type="radio" id="word-2nd-color-12" name="select-color" value="#8a786b"  >
                                            <label for="word-2nd-color-12" style="background-color: #8a786b">
                                            </label>
                                            <input type="radio" id="word-2nd-color-13" name="select-color" value="#6f5e55"  >
                                            <label for="word-2nd-color-13" style="background-color: #6f5e55">
                                            </label>
                                            <input type="radio" id="word-2nd-color-14" name="select-color" value="#574a45"  >
                                            <label for="word-2nd-color-14" style="background-color: #574a45">
                                            </label>
                                            <input type="radio" id="word-2nd-color-15" name="select-color" value="#2a2a2c"  >
                                            <label for="word-2nd-color-15" style="background-color: #2a2a2c">
                                            </label>
                                            <input type="radio" id="word-2nd-color-16" name="select-color" value="#df945c"  >
                                            <label for="word-2nd-color-16" style="background-color: #df945c">
                                            </label>
                                            <input type="radio" id="word-2nd-color-17" name="select-color" value="#de6945"  >
                                            <label for="word-2nd-color-17" style="background-color: #de6945">
                                            </label>
                                            <input type="radio" id="word-2nd-color-18" name="select-color" value="#df945c"  >
                                            <label for="word-2nd-color-18" style="background-color: #df945c">
                                            </label>
                                            <input type="radio" id="word-2nd-color-19" name="select-color" value="#de6945"  >
                                            <label for="word-2nd-color-19" style="background-color: #de6945">
                                            </label>
                                            <input type="radio" id="word-2nd-color-20" name="select-color" value="#be7146"  >
                                            <label for="word-2nd-color-20" style="background-color: #be7146">
                                            </label>
                                            <input type="radio" id="word-2nd-color-21" name="select-color" value="#af664c"  >
                                            <label for="word-2nd-color-21" style="background-color: #af664c">
                                            </label>
                                            <input type="radio" id="word-2nd-color-22" name="select-color" value="#ffd88d"  >
                                            <label for="word-2nd-color-22" style="background-color: #ffd88d">
                                            </label>
                                            <input type="radio" id="word-2nd-color-23" name="select-color" value="#f1bb4a"  >
                                            <label for="word-2nd-color-23" style="background-color: #f1bb4a">
                                            </label>
                                            <input type="radio" id="word-2nd-color-24" name="select-color" value="#eaae38"  >
                                            <label for="word-2nd-color-24" style="background-color: #eaae38">
                                            </label>
                                            <input type="radio" id="word-2nd-color-25" name="select-color" value="#f8aa24"  >
                                            <label for="word-2nd-color-25" style="background-color: #f8aa24">
                                            </label>
                                            <input type="radio" id="word-2nd-color-26" name="select-color" value="#ffb050"  >
                                            <label for="word-2nd-color-26" style="background-color: #ffb050">
                                            </label>
                                            <input type="radio" id="word-2nd-color-27" name="select-color" value="#ff9f39"  >
                                            <label for="word-2nd-color-27" style="background-color: #ff9f39">
                                            </label>
                                            <input type="radio" id="word-2nd-color-28" name="select-color" value="#ffb050"  >
                                            <label for="word-2nd-color-28" style="background-color: #ffb050">
                                            </label>
                                            <input type="radio" id="word-2nd-color-29" name="select-color" value="#ff9f39"  >
                                            <label for="word-2nd-color-29" style="background-color: #ff9f39">
                                            </label>
                                            <input type="radio" id="word-2nd-color-30" name="select-color" value="#bf8d38"  >
                                            <label for="word-2nd-color-30" style="background-color: #bf8d38">
                                            </label>
                                            <input type="radio" id="word-2nd-color-31" name="select-color" value="#edd5d5"  >
                                            <label for="word-2nd-color-31" style="background-color: #edd5d5">
                                            </label>
                                            <input type="radio" id="word-2nd-color-32" name="select-color" value="#f0c5cf"  >
                                            <label for="word-2nd-color-32" style="background-color: #f0c5cf">
                                            </label>
                                            <input type="radio" id="word-2nd-color-33" name="select-color" value="#e3a3b1"  >
                                            <label for="word-2nd-color-33" style="background-color: #e3a3b1">
                                            </label>
                                            <input type="radio" id="word-2nd-color-34" name="select-color" value="#d88bb7"  >
                                            <label for="word-2nd-color-34" style="background-color: #d88bb7">
                                            </label>
                                            <input type="radio" id="word-2nd-color-35" name="select-color" value="#cb75a4"  >
                                            <label for="word-2nd-color-35" style="background-color: #cb75a4">
                                            </label>
                                            <input type="radio" id="word-2nd-color-36" name="select-color" value="#c56a76"  >
                                            <label for="word-2nd-color-36" style="background-color: #c56a76">
                                            </label>
                                            <input type="radio" id="word-2nd-color-37" name="select-color" value="#d8a391"  >
                                            <label for="word-2nd-color-37" style="background-color: #d8a391">
                                            </label>
                                            <input type="radio" id="word-2nd-color-38" name="select-color" value="#c56a76"  >
                                            <label for="word-2nd-color-38" style="background-color: #c56a76">
                                            </label>
                                            <input type="radio" id="word-2nd-color-39" name="select-color" value="#d8a391"  >
                                            <label for="word-2nd-color-39" style="background-color: #d8a391">
                                            </label>
                                            <input type="radio" id="word-2nd-color-40" name="select-color" value="#d9c0de"  >
                                            <label for="word-2nd-color-40" style="background-color: #d9c0de">
                                            </label>
                                            <input type="radio" id="word-2nd-color-41" name="select-color" value="#c39fcb"  >
                                            <label for="word-2nd-color-41" style="background-color: #c39fcb">
                                            </label>
                                            <input type="radio" id="word-2nd-color-42" name="select-color" value="#b6a2bb"  >
                                            <label for="word-2nd-color-42" style="background-color: #b6a2bb">
                                            </label>
                                            <input type="radio" id="word-2nd-color-43" name="select-color" value="#9f6582"  >
                                            <label for="word-2nd-color-43" style="background-color: #9f6582">
                                            </label>
                                            <input type="radio" id="word-2nd-color-44" name="select-color" value="#8b5e8e"  >
                                            <label for="word-2nd-color-44" style="background-color: #8b5e8e">
                                            </label>
                                            <input type="radio" id="word-2nd-color-45" name="select-color" value="#684869"  >
                                            <label for="word-2nd-color-45" style="background-color: #684869">
                                            </label>
                                            <input type="radio" id="word-2nd-color-46" name="select-color" value="#5d5f75"  >
                                            <label for="word-2nd-color-46" style="background-color: #5d5f75">
                                            </label>
                                            <input type="radio" id="word-2nd-color-47" name="select-color" value="#cfcc95"  >
                                            <label for="word-2nd-color-47" style="background-color: #cfcc95">
                                            </label>
                                            <input type="radio" id="word-2nd-color-48" name="select-color" value="#5d5f75"  >
                                            <label for="word-2nd-color-48" style="background-color: #5d5f75">
                                            </label>
                                            <input type="radio" id="word-2nd-color-49" name="select-color" value="#cfcc95"  >
                                            <label for="word-2nd-color-49" style="background-color: #cfcc95">
                                            </label>
                                            <input type="radio" id="word-2nd-color-50" name="select-color" value="#d7cf6d"  >
                                            <label for="word-2nd-color-50" style="background-color: #d7cf6d">
                                            </label>
                                            <input type="radio" id="word-2nd-color-51" name="select-color" value="#a8a330"  >
                                            <label for="word-2nd-color-51" style="background-color: #a8a330">
                                            </label>
                                            <input type="radio" id="word-2nd-color-52" name="select-color" value="#568c51"  >
                                            <label for="word-2nd-color-52" style="background-color: #568c51">
                                            </label>
                                            <input type="radio" id="word-2nd-color-53" name="select-color" value="#6e7c44"  >
                                            <label for="word-2nd-color-53" style="background-color: #6e7c44">
                                            </label>
                                            <input type="radio" id="word-2nd-color-54" name="select-color" value="#6e6f45"  >
                                            <label for="word-2nd-color-54" style="background-color: #6e6f45">
                                            </label>
                                            <input type="radio" id="word-2nd-color-55" name="select-color" value="#c6eee3"  >
                                            <label for="word-2nd-color-55" style="background-color: #c6eee3">
                                            </label>
                                            <input type="radio" id="word-2nd-color-56" name="select-color" value="#99baaf"  >
                                            <label for="word-2nd-color-56" style="background-color: #99baaf">
                                            </label>
                                            <input type="radio" id="word-2nd-color-57" name="select-color" value="#6ecfc8"  >
                                            <label for="word-2nd-color-57" style="background-color: #6ecfc8">
                                            </label>
                                            <input type="radio" id="word-2nd-color-58" name="select-color" value="#99baaf"  >
                                            <label for="word-2nd-color-58" style="background-color: #99baaf">
                                            </label>
                                            <input type="radio" id="word-2nd-color-59" name="select-color" value="#6ecfc8"  >
                                            <label for="word-2nd-color-59" style="background-color: #6ecfc8">
                                            </label>
                                            <input type="radio" id="word-2nd-color-60" name="select-color" value="#d2b1b5"  >
                                            <label for="word-2nd-color-60" style="background-color: #d2b1b5">
                                            </label>
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
                    <label>color :</label>
                    <input type="color" name="emb-color" id="" value="#CCCCCC">
                </div>
                <br>
                <div>
                    <a href="javascript:void(0)" class="remove-emb" class="btn ">Remove Embellishment</a>
                </div>
                <br>
                <div class="">
                    <div class="round-tile-radio">
                        <input type="radio" name="select-emb-flower" id="flower-01">
                        <label for="flower-01">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower01.png' );?>" alt="">
                            <p>Emblem A</p>
                        </label>
                        <input type="radio" name="select-emb-flower" id="flower-02">
                        <label for="flower-02">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower02.png' );?>" alt="">
                            <p>Emblem B</p>
                        </label>
                        <input type="radio" name="select-emb-flower" id="flower-03">
                        <label for="flower-03">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower03.png' );?>" alt="">
                            <p>Emblem C</p>
                        </label>
                        <input type="radio" name="select-emb-flower" id="flower-04">
                        <label for="flower-04">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower04.png' );?>" alt="">
                            <p>Emblem D</p>
                        </label>
                        <input type="radio" name="select-emb-flower" id="flower-05">
                        <label for="flower-05">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/flower05.png' );?>" alt="">
                            <p>Emblem E</p>
                        </label>
                        <input type="radio" name="select-emb-flower" id="flower-06">
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
                    <label>color :</label>
                    <input type="color" name="emb-color" id="" value="#CCCCCC">
                </div>
                <br>
                <div>
                    <a href="javascript:void(0)" class="remove-emb" class="btn ">Remove Embellishment</a>
                </div>
                <br>
                <div class="">
                    <div class="round-tile-radio">
                        <input type="radio" name="select-emb-cactus" id="cactus-01">
                        <label for="cactus-01">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus01.png' );?>" alt="">
                            <p>Emblem A</p>
                        </label>
                        <input type="radio" name="select-emb-cactus" id="cactus-02">
                        <label for="cactus-02">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus02.png' );?>" alt="">
                            <p>Emblem B</p>
                        </label>
                        <input type="radio" name="select-emb-cactus" id="cactus-03">
                        <label for="cactus-03">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus03.png' );?>" alt="">
                            <p>Emblem C</p>
                        </label>
                        <input type="radio" name="select-emb-cactus" id="cactus-04">
                        <label for="cactus-04">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus04.png' );?>" alt="">
                            <p>Emblem D</p>
                        </label>
                        <input type="radio" name="select-emb-cactus" id="cactus-05">
                        <label for="cactus-05">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/cactus05.png' );?>" alt="">
                            <p>Emblem E</p>
                        </label>
                        <input type="radio" name="select-emb-cactus" id="cactus-06">
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
                    <label>color :</label>
                    <input type="color" name="emb-color" id="" value="#CCCCCC">
                </div>
                <br>
                <div>
                    <a href="javascript:void(0)" class="remove-emb" class="btn ">Remove Embellishment</a>
                </div>
                <br>
                <div class="">
                    <div class="round-tile-radio">
                        <input type="radio" name="select-emb-wreaths" id="wreaths-01">
                        <label for="wreaths-01">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths01.png' );?>" alt="">
                            <p>Emblem A</p>
                        </label>
                        <input type="radio" name="select-emb-wreaths" id="wreaths-02">
                        <label for="wreaths-02">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths02.png' );?>" alt="">
                            <p>Emblem B</p>
                        </label>
                        <input type="radio" name="select-emb-wreaths" id="wreaths-03">
                        <label for="wreaths-03">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths03.png' );?>" alt="">
                            <p>Emblem C</p>
                        </label>
                        <input type="radio" name="select-emb-wreaths" id="wreaths-04">
                        <label for="wreaths-04">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths04.png' );?>" alt="">
                            <p>Emblem D</p>
                        </label>
                        <input type="radio" name="select-emb-wreaths" id="wreaths-05">
                        <label for="wreaths-05">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths05.png' );?>" alt="">
                            <p>Emblem E</p>
                        </label>
                        <input type="radio" name="select-emb-wreaths" id="wreaths-06">
                        <label for="wreaths-06">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/wreaths06.png' );?>" alt="">
                            <p>Emblem F</p>
                        </label>
                    </div>
                </div>
            </div>
            <div id="emb-multi">
                <h3>Select Emblem</h3>
                <h4>wreaths</h4>
                <br>
                <div class="color-selector">
                    <label>color :</label>
                    <input type="color" name="emb-color" id="" value="#CCCCCC">
                </div>
                <br>
                <div>
                    <a href="javascript:void(0)" class="remove-emb" class="btn ">Remove Embellishment</a>
                </div>
                <br>
                <div class="">
                    <div class="round-tile-radio">
                        <input type="radio" name="select-emb-multi" id="multi-01">
                        <label for="multi-01">
                            <img src="<?php echo esc_url( TE_BB_URL . '/assets/emb/multi-01.png' );?>" alt="">
                            <p>multi 01</p>
                        </label>
                    </div>
                </div>
            </div>
            <div id="preview">
                <h3>Preview
                    <span>Letter Count: 12 (33 Left)</span>
                </h3>
                <h3>Quantity</h3>
                <input type="text" name="item_quantity" id="item-quantity" value="1" class="text-center" style="width: 100px;">
                <br>
                <h3>Description</h3>
                <p class="text-left" >Diameter: Approx. 24 inches</p>
                <p class="text-left" >Base: 1/2 inch thick</p>
                <p class="text-left" >Weight: Approx. 4 lbs.</p>
                <p class="text-left" >Letters are cut out of 1/2 inch birch wood, hand sanded, painted, and mounted onto a handcut finished brich round that is stained (the back of the base is unfinished). our unique signs are customizable with a choice of stain, paint color, font and symbols. your one of a kind sign will come with a sawtooth hanger anger.</p>
                <p>Total</p>
                <p class="text-left" >we will send you a proof to ensure you are happy with your choices </p>
                <p>TOTAL Price: 48$</p>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
            <div id="export">
                <h3>Export</h3>
                <br>
                <a href="javascript:void(0)" class="btn full" id="export-btn"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp; Export to PDF</a>
            </div>
            
        </aside>
        <div class="app">
        
            <input type="hidden" id="letter_price" value="<?php echo( get_option( 'letter_price' ) ); ?>">
            <input type="hidden" id="embellishment_price" value="<?php echo( get_option( 'embellishment_price' ) ); ?>">
            <div class="canvas-header">
                <p id="text-on-board">Text on board: <span></span></p>
                <p id="letter-count-on-board">Letter Count: <span class="count"></span> <span class="remain"></span></p>
                <p id="Price-of-board">Price: <span></span></p>
            </div>
            <div class="" id="canvas">
                
            </div>
        </div>
    </div>
<?php get_footer(); ?>