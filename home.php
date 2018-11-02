 <?php
   $cat_terms = get_terms(array('taxonomy' => 'category'));
 ?>
<form action="" method="post">
        	<select name="before_and_after" id="blog-cat-menu">
        	    <option value="all-cat" selected><?php _e('All Categories'); ?></option>
              <?php foreach($cat_terms as $t) : ?>
                <option value="<?php echo $t->slug; ?>"><?php echo $t->name; ?></option>
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
    			<?php while ( $my_posts->have_posts() ) : $my_posts->the_post() ?>	
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
