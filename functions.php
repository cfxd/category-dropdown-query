<?php 

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles');
function salient_child_enqueue_styles() {
	
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('font-awesome'));
    wp_enqueue_script('scrollmagic', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', ['jquery'], null, true);
    wp_enqueue_script('scrollmagictwo', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', ['jquery'], null, true);
    wp_enqueue_script( 'javascript', get_stylesheet_directory_uri() . '/scripts/scripts.js', array( 'jquery' ), '', true );
    
    if ( is_rtl() ) 
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
}


// The Quarterly Newsletter post type load more function
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');

function load_posts_by_ajax_callback() {
	check_ajax_referer('load_more_posts', 'security');
	
	
	$paged = $_POST['page'];
	$args = array(
		'post_type' => 'quarterly-newsletter',
		'post_status' => 'publish',
		'posts_per_page' => '4',
		'paged' => $paged,
	);
	$my_posts = new WP_Query( $args );
	if ( $my_posts->have_posts() ) :
		?>
		<?php while ( $my_posts->have_posts() ) : $my_posts->the_post() ?>
		
		
			<?php if ( is_user_logged_in() ) { // your code for logged in user ?>
				<?php $newsletter_pdf = get_field( 'newsletter_pdf' ); ?>
          <?php if ( $newsletter_pdf ) { ?>
          	<a class="box-news-link" href="<?php echo $newsletter_pdf['url']; ?>" target="_blank">
            	<div class="newsletter-box">
          			<div class="news-bullet-img">
                  <img src="/wp-content/themes/salient-child/img/news-bullet.png" alt="News Bullet">
            	  </div>
            	  <div class="news-full-descrip">
          			  <p class="newsletter_title"><?php the_title(); ?></p>
                  <p class="newsletter_date"><?php echo get_the_date(); ?></p>
                  <p class="newletter-textarea"><?php the_content(); ?></p>
            	  </div>
        	    </div>
          	</a>
          <?php } ?>
          <?php  } else { // your code for logged out user ?>
            <a href="/request-access-newsletter/" class="box-news-link-logged-out-lm">
            	<div class="newsletter-box">
          			<div class="news-bullet-img">
                  <img src="/wp-content/themes/salient-child/img/news-bullet.png" alt="News Bullet">
            	  </div>
            	  <div class="news-full-descrip">
          			  <p class="newsletter_title"><?php the_title(); ?></p>
                  <p class="newsletter_date"><?php echo get_the_date(); ?></p>
                  <p class="newletter-textarea"><?php the_content(); ?></p>
            	  </div>
              </div>
            </a>
          <?php  } ?>
      
      
      
		<?php endwhile; ?>
		<?php endif; wp_die(); } 
  		

// The Blog post type load more function
add_action('wp_ajax_load_posts_by_ajax_two', 'load_posts_by_ajax_callback_two');
add_action('wp_ajax_nopriv_load_posts_by_ajax_two', 'load_posts_by_ajax_callback_two');

function load_posts_by_ajax_callback_two() {
	check_ajax_referer('load_more_posts_two', 'security_two');		
  	
  		$paged = $_POST['page'];
	$args = array(
		'post_type' => '',
		'post_status' => 'publish',
		'posts_per_page' => '3',
		'paged' => $paged,
	);
	$my_posts = new WP_Query( $args );
	if ( $my_posts->have_posts() ) :
		?>
		
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
			
		<?php endwhile;  endif; wp_die(); } 
  		
  		
  		
// The Tagged Archive's post type load more function
add_action('wp_ajax_load_posts_by_ajax_three', 'load_posts_by_ajax_callback_three');
add_action('wp_ajax_nopriv_load_posts_by_ajax_three', 'load_posts_by_ajax_callback_three');


function load_posts_by_ajax_callback_three() {
    check_ajax_referer('load_more_posts_three', 'security_three');


    $term_slug= $_POST['slugTerm'];
    $paged = $_POST['page'];
    $loop = new WP_Query( array( 'post_type' => '', 'tag' => $term_slug,
        'posts_per_page' => 3, 'paged' => $paged, ) ); ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

        <li class="blog-box">
            <a class="box_link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
      			<div class="blog-bullet-img">
                <?php the_post_thumbnail(); ?>              
        	  </div>
        	  <div class="news-full-descrip">
      			  <p class="blog_title"><?php echo get_the_title(); ?></p>
              <p class="blog_date"><?php echo get_the_date(); ?></p>
              <p class="blog-textarea"><?php echo get_the_excerpt(); ?></p>
        	  </div>
          </a>
        </li>


    <?php endwhile;  wp_die(); } 
   

  		
//custom excerpt ending
if(!function_exists('excerpt_more')){
	function excerpt_more( $more ) {
		return '<span class="excerpt_read">...read more</span>';
	}
}
add_filter('excerpt_more', 'excerpt_more');

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 32;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );  		
  		

	
add_action('do_meta_boxes', 'be_rotator_image_metabox' );
/**
 * Move Featured Image Metabox on 'rotator' post type
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/move-featured-image-metabox
 */
function be_rotator_image_metabox() {
	remove_meta_box( 'postimagediv', '', 'side' );
	add_meta_box('postimagediv', __('Custom Image'), 'post_thumbnail_meta_box', '', 'normal', 'high');
}

// Remove <p> tags around images
function filter_ptags_on_images($content)
{
    // do a regular expression replace...
    // find all p tags that have just
    // <p>maybe some white space<img all stuff up to /> then maybe whitespace </p>
    // replace it with just the image tag...
    return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
}

// we want it to be run after the autop stuff... 10 is default.
add_filter('the_content', 'filter_ptags_on_images');
  		
global $post;
foreach(get_the_tags($post->ID) as $tag)
{
    echo '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
}
// Remove first part of title from archive page.
add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});

// Add a custom user role
$result = add_role( 'insights_subscriber', __( 'Insights Subscriber' ),
  array( 
    'read' => true, // true allows this capability
    'read_private_posts' => true, // true allows this capability
    'read_private_pages' => true, // true allows this capability
  )
);



function wpse23007_redirect(){
  if( is_admin() && !defined('DOING_AJAX') && ( current_user_can('insights_subscriber') ) ){
    wp_redirect(home_url());
    exit;
  }
}
add_action('init','wpse23007_redirect');


add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}


function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
          background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/Scharf_Logo_RGB.gif);
      		height:137px;
      		width:227px;
      		background-size: 227px 137px;
      		background-repeat: no-repeat;
          padding-bottom: 15px;
        }
        .login.login-action-rp.wp-core-ui.locale-en-us,
        .login.login-action-login.wp-core-ui.locale-en-us, 
        .login.login-action-lostpassword.wp-core-ui.locale-en-us,
        .login.login-action-resetpass.wp-core-ui.locale-en-us {
          background: #fff;
        }
        #wp-submit {
          background-color: #cc9500 !important;
          font-family: 'Roboto', sans-serif !important;
          font-weight: 500 !important;
          font-size: 16px !important;
        }
        .wp-core-ui .button-primary {
          background: #cc9500;
          background-color: rgba(0, 0, 0, 0) !important;
          border-color: #cc9500 !important;
          box-shadow: 0 1px 0 rgba(0, 0, 0, 0) !important;
          text-decoration: none !important;
          text-shadow: none !important;
        }
        .login form {
          box-shadow: none !important;
        }
        #pass-strength-result.strong {
          background-color: #fff !important;
          border-color: #fff !important;
          opacity: 1;
          color: #83c373;
        }
        #pass-strength-result.good {
          background-color: #fff !important;
          border-color: #fff !important;
          opacity: 1;
          color: #ffc733 !important;
          
        }
        #pass-strength-result.bad {
          background-color: #fff !important;
          border-color: #fff !important;
          opacity: 1;
          color: #f78b53 !important;
        }
        #pass-strength-result.short {
          background-color: #fff !important;
          border-color: #fff !important;
          opacity: 1;
          color: #e35b5b !important;
        }
        .login.login-action-rp.wp-core-ui .button-primary-disabled, .login.login-action-rp.wp-core-ui .button-primary.disabled,.login.login-action-rp.wp-core-ui .button-primary:disabled, .login.login-action-rp.wp-core-ui .button-primary[disabled], .button.button-primary.button-large {
          color: #fff !important;
          background: #008ec2 !important;
          background-color:  #cc9500 !important;
          border-color: #fff !important;
          box-shadow: none !important;
          padding: 15px 22px !important;
          line-height: 0 !important;
          display: block;
          margin: 0 auto;
          float: none !important;
        }
        .message.reset-pass,
        .login #login_error,
        .login .message {
          border-left: 0px !important;
          box-shadow: none !important;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Function to change email address
 
function wpb_sender_email( $original_email_address ) {
    return 'noreply@ScharfInvestments.com';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'Scharf Investments';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

remove_role( 'subscriber' );

// prevent admin notification email for new registered users or user password changes
function conditional_mail_stop() {
    global $phpmailer;
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $subject = array(
        sprintf(__('[%s] New User Registration'), $blogname),
        sprintf(__('[%s] Password Lost/Changed'), $blogname),
        sprintf(__('[%s] Password Changed'), $blogname)        
    );
    if ( in_array( $phpmailer->Subject, $subject ) )
        // empty $phpmailer class -> email cannot be send
        $phpmailer = new PHPMailer( true );
}
add_action( 'phpmailer_init', 'conditional_mail_stop' );

//team post type

if ( ! function_exists('team_post_type') ) {

// Register Custom Post Type
function team_post_type() {

	$labels = array(
		'name'                  => _x( 'Team Members', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Team Members', 'text_domain' ),
		'name_admin_bar'        => __( 'Team Members', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Team Member:', 'text_domain' ),
		'all_items'             => __( 'All Team Members', 'text_domain' ),
		'add_new_item'          => __( 'Add New Team Member', 'text_domain' ),
		'add_new'               => __( 'Add New Team Member', 'text_domain' ),
		'new_item'              => __( 'New Team Member', 'text_domain' ),
		'edit_item'             => __( 'Edit Team Member', 'text_domain' ),
		'update_item'           => __( 'Update Team Member', 'text_domain' ),
		'view_item'             => __( 'View Team Member', 'text_domain' ),
		'view_items'            => __( 'View Team Members', 'text_domain' ),
		'search_items'          => __( 'Search Team Member', 'text_domain' ),
		'not_found'             => __( 'Team Member Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Team Member Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Team Member', 'text_domain' ),
		'items_list'            => __( 'Team Members list', 'text_domain' ),
		'items_list_navigation' => __( 'Team Members list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Team Members list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'team-members',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Team Member', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'post_type_team', $args );

}
add_action( 'init', 'team_post_type', 0 );

}



add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');
 
/*
 * Enqueue a script with the correct path.
 */
function wpdocs_scripts_method() {
    wp_enqueue_script(
        'custom_script',
        get_template_directory_uri() . '/js/main.js',
        array('jquery')
    );
}

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


// stops editor from removing tags
function override_mce_options($initArray) {
	$opts = '*[*]';
	$initArray['valid_elements'] = $opts;
	$initArray['extended_valid_elements'] = $opts;
	return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');



//Dropdown Menu for blog Posts by scott@sv-port.com
function ajax_filter_posts_scripts() {
    // Enqueue script
    wp_register_script('afp_script', get_stylesheet_directory_uri() . '/scripts/scripts.js', false, null, false);
    
    wp_localize_script( 'afp_script', 'afp_vars', array(
      'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
      'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
    ));
    wp_enqueue_script('afp_script');
  }
  
  add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);
  
function ajax_filter_categories() {
  echo json_encode(array('url' => $_POST['before_and_after']));
  die();
}

add_action('wp_ajax_filter_posts', 'ajax_filter_categories');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_categories');

?>
  		
