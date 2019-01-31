<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
  $parent_style = 'parent-style'; // This is 'twentyseventeen-style' for the Twenty Fifteen theme.

  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style',
      get_stylesheet_directory_uri() . '/style.css',
      array( $parent_style ),
      wp_get_theme()->get('Version')
  );
}


add_action( 'init', 'product_custom_post_type' );
function product_custom_post_type() {
  $posttypename = "product";
  $prefix = "product_";
  $labels = array(
    'name' => _x( 'Products', $posttypename ),
    'singular_name' => _x( $posttypename, $posttypename ),
    'add_new' => _x( 'Add New', $posttypename ),
    'add_new_item' => _x( 'Add New products', $posttypename ),
    'edit_item' => _x( 'Edit products', $posttypename ),
    'new_item' => _x( 'New product', $posttypename ),
    'view_item' => _x( 'View product', $posttypename ),
    'search_items' => _x( 'Search products', $posttypename ),
    'not_found' => _x( 'No products found', $posttypename ),
    'not_found_in_trash' => _x( 'No products found in Trash', $posttypename ),
    'parent_item_colon' => _x( 'Parent products:', $posttypename ),
    'menu_name' => _x( 'Products', $posttypename ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Product custom post type for all types of product.',
    'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
    'taxonomies' => array($prefix."category", $prefix.'tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-laptop'
  );
  register_post_type( $posttypename, $args );
  flush_rewrite_rules( false );
}

add_action( 'init', 'product_category_taxonomy', 10);
function product_category_taxonomy() {
  $prefix = "";
	$labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Categories', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'not_found' => __('No categories found'),
    'edit_item' => __( 'Edit category' ),
    'update_item' => __( 'Update category' ),
    'add_new_item' => __( 'Add New category' ),
		'separate_items_with_commas'    => __('Seperate attribute values with commas'),
    'new_item_name' => __( 'New category Name' ),
    'menu_name' => __( 'Categories' ),
  );

  register_taxonomy($prefix."category",array('product'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
		'show_in_menu'        => true,
    'show_admin_column' => true,
    'query_var' => true,
		'hierarchical' => true,
		'capabilities' => array(
			'manage_terms'  => 'activate_plugins',
		  'edit_terms'    => 'activate_plugins',
		  'delete_terms'  => 'activate_plugins',
		  'assign_terms'  => 'edit_posts'
    ),
    'rewrite' => array( 'slug' => $prefix."category" ),
  ));

}
?>
