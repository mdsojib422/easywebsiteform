<?php
/*
 * Easy Website Form Shortcode Functions
 */
if ( !defined( 'ABSPATH' ) ) {die( "Don't try this" );};
if ( !class_exists( "EWform_Shortcode" ) ) {
    class EWform_Shortcode {
        function __construct() {
            add_action( "wp_head", [$this, "ewform_style_push"] );
            if ( !shortcode_exists( "ewform" ) ) {
                add_shortcode( "ewform", [$this, "ewform_callback_fun"] );
            }
        }
        /**
         * @param $attr
         * @param $content
         * @return false|string
         */
        function ewform_callback_fun( $attr, $content ) {
            $api_key = get_option( 'ewform_key' ) ? get_option( 'ewform_key' ) : '';

            // content to array
            $content = explode( "/", $content );
            extract( shortcode_atts( [
                'title' => esc_html__( "Easy Website Form", "easywebsiteform" ),
                'id'    => end( $content ),
            ], $attr ) );

            if ( empty( $id ) ) {
                return sprintf( "<h4>%s</h4>", esc_html__( "Form Not Found/Broken Url Provided", "easywebsiteform" ) );
            }

            if ( empty( $api_key ) ) {
                return sprintf( "<p class='ewform-notice' >%s <a href='%s'><b>%s</b></a>%s</p>", esc_html__( "Please enter your API Key in the Easy Website Form plugin ", "easywebsiteform" ),esc_url(admin_url("admin.php?page=ewfoption")), esc_html__( "API Setup", "easywebsiteform" ),  esc_html__(" to use shortcodes"));
            }

           
            ob_start();
            ?>
            <div class="ew_form_wrapper">
                <div id="iframe-overlay-<?php echo esc_attr( $id ); ?>"></div>
                <div id="iframe-loader-<?php echo esc_attr( $id ); ?>"
                    style="background-image: url('<?php echo esc_url( EWFORM_URL ); ?>/assets/img/Iframe-loader.gif');">
                </div>
                <div id="iframe-<?php echo esc_attr( $id ); ?>" class="ewf-iframe" data-form="<?php echo esc_attr( $id ); ?>" data-title="<?php echo esc_attr( $title ); ?>"></div>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * @return void
         */
        function ewform_style_push() {
            ?>
            <style id="ewform">
                .ew_form_wrapper {
                    position: relative;
                }
                .ewform-notice{
                    color:#ff3b58;
                }
                .ewform-notice a{
                    text-decoration: none;
                }
                .iframe_overlay {
                    background-color: rgba(0, 0, 0, 0.2);
                    background-size: cover;
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    width: 100%;
                    height: 100%;
                }
                .iframe_loader {
                    height: 100px;
                    display: block;
                    width: 100px;
                    position: absolute;
                    background-size: cover;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }
            </style>
            <?php
}

    }
}
new EWform_Shortcode();