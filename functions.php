<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'DIYCraftPhotography Theme' ); /*Genesis Sample Theme*/
define( 'CHILD_THEME_URL', 'https://www.diycraftphotography.com' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'sample_viewport_meta_tag' );
function sample_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Adding custom Favicon */
add_filter( 'genesis_pre_load_favicon', 'custom_favicon' );
function custom_favicon( $favicon_url ) {
    return 'favicon.ico';
}
// Add support for custom background and header
add_theme_support( 'custom-background' );
add_theme_support( 'genesis-custom-header', array(
    'width' => 1152,
    'height' => 138
) );

add_image_size( 'feature', 620, 230, TRUE );

/*Added 4/14 icons on home page */
add_filter( 'pre_get_posts', 'be_archive_query' );
/**
 * Archive Query
 *
 * Sets all archives to 27 per page
 * @since 1.0.0
 * @link https://www.billerickson.net/customize-the-wordpress-query/
 *
 * @param object $query
 */
function be_archive_query( $query ) {
	if( $query->is_main_query() && $query->is_archive() ) {
		$query->set( 'posts_per_page', 16 );
	}
}

/*Clickable Header */
function clickable_header() {
    ?>
    <div id="pixel"><a href="https://diycraftphotography.com"><img src="https://diycraftphotography.com/siteart/pixel.png"/></div></a>
   <?php
}
add_action('genesis_header','clickable_header');
remove_action('genesis_site_title', 'genesis_seo_site_title' );
remove_action('genesis_site_description', 'genesis_seo_site_description' );

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );



/* remove link text from yarpp */
/* Disabled YARPP 12/16/14 performance problems */
/*
add_action('yarpp-thumbnail','remove_yarpp_link');
function remove_yarpp_link() {
    remove_action('yarpp-thumbnail', 'the_permalink');
    remove_action('yarpp-thumbnail', 'the_title');
}
*/


add_filter('genesis_post_meta', 'sp_post_meta_filter');
function sp_post_meta_filter($post_meta) {
    if (is_singular() ) {
        $post_meta = '[post_categories before="Category: "] [post_tags before="This post is about: "]';
        return $post_meta;
    } else {
       $post_meta = '';
       return $post_meta;
    }
}

/*Customizing excerpts*/
add_filter('excerpt_length', create_function('$a', 'return 50;'));
add_filter( 'excerpt_more', 'child_read_more_link' );
add_filter( 'get_the_content_more_link', 'child_read_more_link' );
add_filter( 'the_content_more_link', 'child_read_more_link' );


/* Altering the byline added 4/14 */
add_filter('genesis_post_info', 'custom_post_info');
function custom_post_info($post_info) {
     $post_info =  __('By', 'genesis') . ' [post_author_posts_link] ' . __('on', 'genesis') . ' [post_date] [post_edit]';
     return $post_info;
}


/* *Customize the read more link */
function child_read_more_link() {
    return '... <br/><br/><a class="more-link" href="' . get_permalink() . '" rel="nofollow">{Read More}</a>';
}

/* Adding AdSense to the bottom of every post */
add_filter( 'the_content', 'my_content_filter' );

function my_content_filter( $content ) {
   if ( is_single() || is_page() ) {
      $content .= '
      		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- DIYCraft_PostEnd -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-1407541373557710"
			     data-ad-slot="2950187989"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script><br>';
   }
   return $content;
}

/* Add author box to end of every post */
add_filter ('get_the_author_genesis_author_box_single', 'childtheme_authorbox');
function childtheme_authorbox() {?>
        	<div id="authorarea">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ); ?>
				<div class="authorinfo">
				<strong>Hello there!</strong>
				<?php the_author_meta( 'description' ); ?>
				</br>
				</br>
				For more craft business advice, follow DIYCraftPhotography on <a href="https://twitter.com/diycraftphoto">Twitter</a>, <a href="https://plus.google.com/u/0/b/115023838006445745773/+Diycraftphotography/posts">Google+</a>, <a href="https://www.facebook.com/pages/DIY-Craft-Photography/460907297342171">Facebook</a>, and <a href="https://www.pinterest.com/diycraftphoto/">Pinterest</a>.
				</div> <!-- end authorarea div -->
	</div> <!-- end authorinfo div --><?php
}

add_filter( 'genesis_author_box_gravatar_size', 'author_box_gravatar_size' );
function author_box_gravatar_size( $size ) {
return '120';
}

/* Modify the speak your mind title in comments */
add_filter( 'comment_form_defaults', 'sp_comment_form_defaults' );
function sp_comment_form_defaults( $defaults ) {

	$defaults['title_reply'] = __( 'Leave a Comment' );
	return $defaults;
	}

/*Adjusting YARPP image size added 3/2014 */
/* Disabled YARPP 12/16/14 performance problems */
/*
add_image_size('yarpp-thumbnail', 150, 150, true);
*/

//* Enqueue Dashicons
add_action( 'wp_enqueue_scripts', 'enqueue_dashicons' );
function enqueue_dashicons() {
	wp_enqueue_style( 'dashicons' );
}
//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'sk_search_button_text' );
function sk_search_button_text( $text ) {
	return esc_attr( '&#xf179;' );
}
/** Customize search form input box text */
add_filter( 'genesis_search_text', 'custom_search_text' );
function custom_search_text($text) {
    return esc_attr( 'Search DIYCraftPhotography...' );
}
