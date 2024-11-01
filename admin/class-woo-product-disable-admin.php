<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://purvik.me
 * @since      1.0.0
 *
 * @package    Woo_Product_Disable
 * @subpackage Woo_Product_Disable/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Disable
 * @subpackage Woo_Product_Disable/admin
 * @author     Purvik <contact@purvik.me>
 */
class Woo_Product_Disable_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Product_Disable_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Product_Disable_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-product-disable-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Product_Disable_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Product_Disable_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-product-disable-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        /**
         * Manage product post column
         * 
         * @param array $existing_columns
         * @return type
         * @since    1.0.0
         */
        public function pd_manage_product_posts_columns( $existing_columns ) {
                if ( empty( $existing_columns ) && ! is_array( $existing_columns ) ) {
                    $existing_columns = array();
                }
                $columns['disable']         = __( 'Disable', 'woocommerce' );
                return array_merge( $columns, $existing_columns );
        }
        
        /**
         * Render product column
         * 
         * @global type $post
         * @global type $the_product
         * @param type $column
         * @since    1.0.0
         */
        public function pd_render_product_columns( $column ){
    
                global $post, $the_product;    

                switch ( $column ) {
                    case 'disable' :
                            $url = wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_disable_product&product_id=' . $post->ID ), 'woocommerce-disable-product' );
                            echo '<a href="' . esc_url( $url ) . '" title="'. __( 'Toggle disabled', 'woocommerce' ) . '">';
                            if ( is_disabled( $post->ID ) ) {
                                    echo '<span class="dashicons dashicons-marker" style="color:red;" data-tip="' . esc_attr__( 'Yes', 'woocommerce' ) . '"></span>';
                            } else {
                                    echo '<span class="dashicons dashicons-marker" style="color:green;" data-tip="' . esc_attr__( 'No', 'woocommerce' ) . '"></span>';
                            }
                            echo '</a>';
                            break;
                        default :
                            break;
                }
        }
        
        /**
         * Disable product
         * 
         * @since    1.0.0
         */
        public function pd_disable_product() {
                if ( current_user_can( 'edit_products' ) && check_admin_referer( 'woocommerce-disable-product' ) ) {
                        $product_id = absint( $_GET['product_id'] );

                        if ( 'product' === get_post_type( $product_id ) ) {
                                update_post_meta( $product_id, '_woo_disabled', get_post_meta( $product_id, '_woo_disabled', true ) === 'yes' ? 'no' : 'yes' );

            //                    delete_transient( 'wc_featured_products' );
                        }
                }

                wp_safe_redirect( wp_get_referer() ? remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'ids' ), wp_get_referer() ) : admin_url( 'edit.php?post_type=product' ) );
                die();
        }
        
        /**
         * Check is woocommerce active or not
         * 
         * @since    1.0.0
         */
        public function pd_admin_notice__error(){
            if ( !class_exists( 'WooCommerce' ) ) {
                pd_e_notice();
            }
        }

}
