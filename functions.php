<?php
function ajax_filter_posts_scripts() {
    // Enqueue script
    wp_register_script('afp_script', get_template_directory_uri() . '/scripts/scripts.js', false, null, false);
    wp_enqueue_script('afp_script');
    
    wp_localize_script( 'afp_script', 'afp_vars', array(
      'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
      'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
    ));
  }
  
  add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);
  
  function ajax_filter_get_posts( $category ) {
  
    // Verify nonce
    if( !isset( $_POST['afp_nonce'] ) || !wp_verify_nonce( $_POST['afp_nonce'], 'afp_nonce' ) )
    die('Permission denied');
  
  
  $category = $_POST['blog-cat-menu'];
  
  
   // WP Query
  $args = array(
      'post_type' => '',
      'post_status' => 'publish',
      'posts_per_page' => '3',
      'nopaging' => false, // show all posts in one go
    );
    // If taxonomy is not set, remove key from array and get all posts
    if( $_REQUEST['blog-cat-menu'] == 'all-cats' ) {
      echo 'All Cat Loop';
            
      unset( $args['blog-cat-menu'] );      
      
    }else{
     // This is the code which you are missing. You need to add taxonomy query if taxonomy is set.
    
       echo 'Diff Cat Loop';
             
       $arg['tax_query']= array(
        array(
          'posty_type' => '',
          'posts_per_page' => '3',
          'order' => 'ASC',
          'orderby' => 'date',
          'tax_query' => array(
              array(
                'taxonomy' => $_POST['blog-cat-menu'],
                'field'    => '', // term_id, slug  
              ),
            ),
          'include_children' => true, // set true if you want post of its child category also
          'operator' => 'IN'
        ),
      );


    }
  

   
  
  $query = new WP_Query( $args );
  
  if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
  
  $output  = '<li class="blog-box"><a class="box_link" href="'. the_permalink().'">
        			  <div class="blog-bullet-img">
                  '. the_post_thumbnail().'              
          	    </div>
                <div class="news-full-descrip">
          			  <p class="blog_title">'. the_title().'</p>
                  <p class="blog_date">'. the_date().'</p>
                  <p class="blog-textarea">'. the_excerpt().'</p>
            	  </div>
          	  </a>
            </li>';
  
  $result = 'success';
  
  endwhile; else:
  $output = '<h2>No posts found</h2>';
  $result = 'fail';
  endif;
  
  $response = html_entity_decode($output, 'UTF-8');
  echo $response;
  die();
}

add_action( 'wp_ajax_filter_posts', 'ajax_filter_get_posts' );

?>
