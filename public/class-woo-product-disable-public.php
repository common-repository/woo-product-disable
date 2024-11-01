<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://purvik.me
 * @since      1.0.0
 *
 * @package    Woo_Product_Disable
 * @subpackage Woo_Product_Disable/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Disable
 * @subpackage Woo_Product_Disable/public
 * @author     Purvik <contact@purvik.me>
 */
class Woo_Product_Disable_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-product-disable-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-product-disable-public.js', array( 'jquery' ), $this->version, false );

	}
        
        /**
         * pre_get_posts hook
         * 
         * @since    1.0.0
         * @param type $query
         */
        public function pd_pre_product_query_override( $query = false ) {
            if(!is_admin() && is_search() ){
                $this->pd_disable_product_query($query);
            }
        }
        
        /**
         * woocommerce_product_query hook
         * 
         * @since    1.0.0
         * @param type $query
         */
        public function pd_woo_product_query_override( $query = false ) {
            if(!is_admin() && is_woocommerce() ){
                $this->pd_disable_product_query($query);
            }
        }
        
        /**
         * Disable product query function
         * 
         * @since    1.0.0
         * @param type $query
         * @return type
         */
        public function pd_disable_product_query($query){
            $query->set( 'meta_query', array(
                'relation' => 'OR',
                array(
                    'key' => '_woo_disabled',
                    'value' => 'yes',
                    'compare' => 'NOT EXISTS',
                ),
                array(
                    'key' => '_woo_disabled',
                    'value' => 'yes',
                    'compare' => '!=',
                ),
            ));
            
            return $query;
        }
        
        /**
         * Related product query function
         * 
         * @since    1.0.0
         * @param array $query
         * @param type $this_id
         * @return type
         */
        public function pd_woocommerce_product_related_posts_query( $query, $this_id ) {
    
            $exclude_ids = get_product_by_is_disable('yes');

            if(empty($exclude_ids))
                return $query;

            $exclude_ids = implode( ',', array_map( 'absint', $exclude_ids ) );
            $query['where'] .= " AND p.ID NOT IN ( {$exclude_ids} )";

            return $query;
        }

}
