<?php // Silence is golden

/**
 * Get error notice if woocommerce plugin is not active
 * 
 * @since    1.0.0
 */
if ( ! function_exists( 'pd_e_notice' ) ) {
    function pd_e_notice(){
        echo '<div class="error notice">';
            echo '<p><strong>Woocommerce Product Disable requires WooCommerce to be activated</strong></p>';
        echo '</div>';
    }
}

/**
 * Check is product is disable or not
 * 
 * @since    1.0.0
 */
if ( ! function_exists( 'is_disabled' ) ) {
    function is_disabled($post_id){
        $disable = get_post_meta( $post_id, '_woo_disabled', true );

        return $disable === 'yes' ? true : false;
    }
}

/**
 * Get product id by is disable or not
 * 
 * @since    1.0.0
 */
if ( ! function_exists( 'get_product_by_is_disable' ) ) {    
    function get_product_by_is_disable( $value ) {
      global $wpdb;

      $product_id = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_woo_disabled' AND meta_value='%s'", $value ) );

      if ( $product_id )
          return $product_id;

      return null;

    }
}