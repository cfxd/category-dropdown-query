<?php 
get_header(); 
nectar_page_header($post->ID); 

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

?>
<div id="page-header-wrap" data-animate-in-effect="none" data-midnight="light" class="" style="height: 400px;">	    <div class="" data-animate-in-effect="none" id="page-header-bg" data-midnight="light" data-text-effect="rotate_in" data-bg-pos="center" data-alignment="left" data-alignment-v="middle" data-parallax="0" data-height="400" style="background-color: rgb(0, 0, 0); height: 400px; overflow: visible;">
  <div class="page-header-bg-image" style="background-image: url(/wp-content/uploads/2018/04/insights-banner.jpg);"></div> 
  <div class="container">
	  <div class="row" style="top: 0px; visibility: visible;">
			<div class="col span_6" style="top: 169.5px;">
				<div class="inner-wrap">
					<h1 class="top-heading"><span class="wraped"><span style="transform: rotateX(0deg) translate(0px, 0px); opacity: 1;">Scharf</span></span> <span class="wraped"><span style="transform: rotateX(0deg) translate(0px, 0px); opacity: 1;">Insights</span></span></h1>
					<span class="subheader" style="transform: rotateX(0deg) translate(0px, 0px); opacity: 1;"></span>
				</div>	 
			</div>
		</div>
	</div>
</div>
</div>
 
<div class="container-wrap">
  <div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
    <div class="entry-content">
      <h2 class="title-template">Blog</h2>  
      
      
      
      <?php
        $cat_terms = get_terms(array('taxonomy' => 'category'));
      ?>
        <form action="" method="post">
        	<select name="before_and_after" id="blog-cat-menu">
        	    <option value="all-cat" selected><?php _e('All Categories'); ?></option>
              <?php foreach($cat_terms as $t) : ?>
                <option value="<?php echo get_term_link($t); ?>"><?php echo $t->name; ?></option>
              <?php endforeach; ?>
        	</select>
        </form>
      <div class="blog_wrap">
    	<?php 
    	$args = array(
    		'post_type' => '',
    		'post_status' => 'publish',
    		'posts_per_page' => '3',
    		'paged' => 1,
    	);
    	$my_posts = new WP_Query( $args );
    	if ( $my_posts->have_posts() ) : 
    	?>
    	
    		<ul class="my-blogs">
    			<?php while ( have_posts() ) : the_post(); ?>	
          	<li class="blog-box">
          	  <a class="box_link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        			  <div class="blog-bullet-img">
                  <?php echo get_the_post_thumbnail(); ?>              
          	    </div>
                <div class="news-full-descrip">
          			  <p class="blog_title"><?php echo get_the_title(); ?></p>
                  <p class="blog_date"><?php echo get_the_date(); ?></p>
                  <p class="blog-textarea"><?php echo get_the_excerpt(); ?></p>
            	  </div>
          	  </a>
            </li>
    			<?php endwhile ?>
    		</ul>
    	<?php endif ?>
      </div>
      <div style="clear: both;"></div>
    	<div class="loadmore_two"><span>Load More</span></div>
    </div>
    <div class="bio-background"></div>
  </div><!--/container-->
</div><!--/container-wrap-->
<?php get_footer(); ?>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
var page = 2;
jQuery(function($) {
	$('body').on('click', '.loadmore_two', function() {
		var data = {
			'action': 'load_posts_by_ajax_two',
			'page': page,
			'security_two': '<?php echo wp_create_nonce("load_more_posts_two"); ?>'
		};
    $(function(){
      $('.loadmore_two').on('click',function() {
      $(this).css('visibility','hidden');
      });
    });
		$.post(ajaxurl, data, function(response) {
			$('.my-blogs').append(response);
			page++;
		});
	});
});
</script> 
