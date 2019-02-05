<?php get_header(); ?>

<link rel='stylesheet' id='font-css' href='https://omronhealthcare.com/wp-content/themes/Omron07/css/font.css?ver=5.0.2' type='text/css' media='all' />
<div class="wrap product">
  <header class="page-header">
		<h2 class="page-title">Product Support and Solutions</h2>
	</header>
  <div id="primary" class="content-area">
    <div id="main" class="site-main">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
      <article id="product-<?php the_ID() ?>" >
        <h3 class="entry-title"><?php the_title()?></h3>
        <?php the_content() ?>
      </article>
      <?php endwhile; endif;?>
    </div>
  </div>
  <div id="secondary" class="widget-area">
    <form method="POST" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" id="filter">
      <input type="hidden" name="action" value="productfilter">
      <section id="categoryFilterSection" class="widget">
        <h2 class="widget-title">Filter by Category</h2>
          <select id="categoryFilter" name="categoryFilter" class="form-control">
            <option class="">All Categories</option>
            <?php
              $taxonomy_name = "category";
              $terms = get_terms($taxonomy_name);
              if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                foreach( get_terms( $taxonomy_name, array( 'hide_empty' => false, 'parent' => 0 ) ) as $term ) {
                  echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                  $term_children = get_term_children( $term->term_id, $taxonomy_name );
                  foreach ( $term_children as $child ) {
                    $term_child = get_term_by( 'id', $child, $taxonomy_name );
                    echo '<option value="'.$term_child->term_id.'">--'.$term_child->name.'</option>';
                  }
                }
              }
            ?>
          </select>
      </section>
      <section id="productFilterSection" class="widget">
          <h2 class="widget-title">Search by Product</h2>
          <select id="productFilter" name="productFilter" class="form-control">
            <option value="">All Products</option>
            <?php
            if ( have_posts() ) : while ( have_posts() ) : the_post();

              echo '<option value="'.get_the_ID().'">';
              echo the_title();
              echo '</option>';

            endwhile; endif;
            ?>
          </select>
        </section>
    </form>
    <script>
    jQuery(function($) {
      $('#filter select').change(function(){
        var filter = $('#filter');
        if ($(this).attr("id") !== "productFilter") {
          $("#productFilter").html("<option value=''>All Products</option>");
        }
        $.ajax({
          url:filter.attr('action'),
          data:filter.serialize(), // form data
          type:filter.attr('method'), // POST
          beforeSend:function(xhr){
            $('#main').html('Processing...'); // changing the button label
          },
          success:function(data){
            $('#main').html("");
            $("#productFilter").html("<option value=''>All Products</option>");
            $.each( jQuery.parseJSON( data ), function( key, post ) {
              $("#productFilter").append("<option value='"+post.ID+"'>"+post.post_title+"</option>");
              $('#main').append(
                '<article id="post-'+post.post_id+'">\
                  <h3 class="entry-title">'+post.post_title+'</h3>\
                  '+post.post_content+'\
                </article>');
            });

          }
        });
        return false;
      });
    });
    </script>
  </div>
</div>

<?php get_footer(); ?>
