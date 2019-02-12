<?php
function product_filter_function(){
    $args = array(
      'post_type' => 'product',
      'orderby' => 'date'
    );
    // for taxonomies / categories
    if( isset( $_POST['categoryFilter'] ) ){
      $filter = $_POST['categoryFilter'];
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'category',
          'field' => 'id',
          'terms' => $filter
        )
      );
    }
    // product filter
    if( isset( $_POST['productFilter'] ) && !empty($_POST['productFilter'])){
      $filter = $_POST['productFilter'];
      $args['post__in'] = array($filter);
    }

    $query = new WP_Query( $args );
    if( $query->have_posts() ) :
      //wp_send_json($query);
      while( $query->have_posts() ): $query->the_post();
        //get_post();
        get_template_part( 'content-product', get_post_format() );
      endwhile;
      wp_reset_postdata();
    else :
      echo 'No posts found';
    endif;

    die();
}


add_action('wp_ajax_productfilter', 'product_filter_function');
add_action('wp_ajax_nopriv_productfilter', 'product_filter_function');
?>
