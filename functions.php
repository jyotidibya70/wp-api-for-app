<?php
/**
 * Custom Theme functions and definitions.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;
function custom_setup() {
	load_theme_textdomain( 'custom', get_template_directory() . '/languages' );
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
	register_nav_menu( 'top-menu', __( 'Top Menu', 'custom' ) );
	register_nav_menu( 'primary', __( 'Primary Menu', 'custom' ) );
	register_nav_menu( 'mobile_menu', __( 'Mobile Menu', 'custom' ) );
	register_nav_menu( 'footer-1', __( 'Footer Menu 1', 'custom' ) );
	register_nav_menu( 'footer-2', __( 'Footer Menu 2', 'custom' ) );
	register_nav_menu( 'footer-3', __( 'Footer Menu 3', 'custom' ) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'custom_setup' );

function custom_scripts_styles() {
	global $wp_styles;
	wp_register_style( 'fonts-url', 'https://fonts.googleapis.com/css?family=Ubuntu:400,700', array(), '1.0');
       wp_enqueue_style( 'fonts-url' );  
	wp_enqueue_script( 'jquery-js', get_template_directory_uri() .'/js/jquery.min.js', array(), '3.3.1', false );
	wp_enqueue_script( 'jquery-js-migrate', get_template_directory_uri() .'/js/jquery-migrate-3.0.0.min.js', array(), '3.3.1', false );
	wp_enqueue_script( 'footer-js', get_template_directory_uri() . '/js/footer.js', array(), '3.3.1', true );
	wp_enqueue_script( 'scrollReveal', get_template_directory_uri() . '/js/scrollReveal.js', array(), '3.3.1', false );
	wp_register_style( 'bootsatrap4', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.1.0');
       wp_enqueue_style( 'bootsatrap4' );
    /*wp_register_style( 'all-fontawsome', get_template_directory_uri() . '/css/all.css', array(), '4.1.0');
       wp_enqueue_style( 'all-fontawsome' ); */ 
    /*wp_register_style( 'simplelightbox', get_template_directory_uri() . '/css/simplelightbox.min.css', array()); 
       wp_enqueue_style( 'simplelightbox' );*/
    wp_register_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array());
       wp_enqueue_style( 'owl-carousel' ); 
    wp_register_style( 'owl-theme-carousel', get_template_directory_uri() . '/css/owl.theme.default.min.css', array());
       wp_enqueue_style( 'owl-theme-carousel' ); 
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '1.3.3');
       wp_enqueue_style( 'font-awesome' ); 
    wp_register_style( 'animatee', get_template_directory_uri() . '/css/animate.css');
       wp_enqueue_style( 'animatee' ); 
    /*wp_register_style( 'bxslider-css', get_template_directory_uri() . '/css/jquery.bxslider.css', array(), '1.3.3');
       wp_enqueue_style( 'bxslider-css' );*/
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(),  false );
    wp_enqueue_script( 'jquery-nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array(),  false );     
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' ); 
	wp_enqueue_script( 'boostrap4-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '4.1.0', false );
	wp_enqueue_script( 'stellar-js', get_template_directory_uri() . '/js/stellar.js', array(), false );
	/*wp_enqueue_script( 'bxslider-js', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array(), false );*/
	/*wp_enqueue_script( 'simple-lightbox', get_template_directory_uri() . '/js/simple-lightbox.min.js', array(), false );*/
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/theme-custom.js', array(), '1.0.0', false );
	wp_localize_script( 'custom-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));
	wp_enqueue_script( 'wow-min', get_template_directory_uri() . '/js/wow.js', false );
	wp_enqueue_script( 'scrollspy-min', get_template_directory_uri() . '/js/scrollspy.js', false );	
	wp_enqueue_style( 'custom-style', get_stylesheet_uri() );
	wp_enqueue_style( 'custom-ie', get_template_directory_uri() . '/css/ie.css', array( 'custom-style' ), '20121010' );
	$wp_styles->add_data( 'custom-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'custom_scripts_styles' );
function custom_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'custom' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'custom_wp_title', 10, 2 );
function custom_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'custom_page_menu_args' );
function custom_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'custom' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Home Page Sidebar', 'custom' ),
		'id' => 'home-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer One', 'custom' ),
		'id' => 'footer-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Two', 'custom' ),
		'id' => 'footer-2',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Three', 'custom' ),
		'id' => 'footer-3',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Four', 'custom' ),
		'id' => 'footer-4',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'custom_widgets_init' );
if ( ! function_exists( 'custom_content_nav' ) ) :
function custom_content_nav( $html_id ) {
	global $wp_query;
	$html_id = esc_attr( $html_id );
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'custom' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'custom' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'custom' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;
if ( ! function_exists( 'custom_comment' ) ) :
function custom_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'custom' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'custom' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'custom' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%1$s at %2$s', 'custom' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'custom' ); ?></p>
			<?php endif; ?>
			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'custom' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'custom' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
if ( ! function_exists( 'custom_entry_meta' ) ) :
function custom_entry_meta() {
	$categories_list = get_the_category_list( __( ', ', 'custom' ) );
	$tag_list = get_the_tag_list( '', __( ', ', 'custom' ) );
	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'custom' ), get_the_author() ) ),
		get_the_author()
	);
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'custom' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'custom' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'custom' );
	}
	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;
function custom_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();
	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';
	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}
	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';
	}
	if ( wp_style_is( 'custom-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';
	if ( ! is_multi_author() )
		$classes[] = 'single-author';
	return $classes;
}
add_filter( 'body_class', 'custom_body_class' );
function custom_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'custom_content_width' );
function new_excerpt_length($length) {
    return 90;
}
add_filter('excerpt_length', 'new_excerpt_length');
function custom_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'custom_customize_register' );
function custom_customize_preview_js() {
	wp_enqueue_script( 'custom-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}
include_once('inc/boostrap/boostrap.php' );
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter('style_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'codeless_remove_type_attr', 10, 2);
function codeless_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}
add_filter('comment_form_default_fields', 'website_remove');
function website_remove($fields)
{
if(isset($fields['url']))
unset($fields['url']);
return $fields;
}
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
// Register Custom Post Type
function radio_program() {

	$labels = array(
		'name'                  => _x( 'Radio Programs', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Radio Program', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Radio Program', 'text_domain' ),
		'name_admin_bar'        => __( 'Radio Program', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Radio Program', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'comments' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		"query_var" => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'radio_program', $args );

}
add_action( 'init', 'radio_program', 0 );
// Register Custom Taxonomy
function Language() {

	$labels = array(
		'name'                       => _x( 'Languages', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Language', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Language', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_in_rest' 				 => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'language', array( 'radio_program' ), $args );

}
add_action( 'init', 'Language', 0 );
// Register Custom Taxonomy
function program_category() {

	$labels = array(
		'name'                       => _x( 'Program Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Program Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Program Category', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_in_rest' 				 => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'program_category', array( 'radio_program' ), $args );

}
add_action( 'init', 'program_category', 0 );
add_action('wp_ajax_prog_filter_funtion', 'prog_filter_funtion'); 
add_action('wp_ajax_nopriv_prog_filter_funtion', 'prog_filter_funtion');
function prog_filter_funtion(){
?>
<script type="text/javascript">
	( function( $ ) {
$(document).ready(function(){
$('.single-radio-prog').click(function(){
$('.rdp_player').removeClass('showplayer');
//$('.audio-lenght').show('1000');
 $(this).find('.rdp_player').addClass('showplayer');
 //$(this).find('.audio-lenght').hide('1000');
});
});
} )( jQuery );
</script>
<?php
					$query = new WP_Query( array( 'post_type' => 'radio_program', 'posts_per_page' => -1, 'orderby' => 'date', 'order'   => 'ASC', ) );
					if ( $query->have_posts() ) : ?>
					<?php $count=1; while ( $query->have_posts() ) : $query->the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="single-radio-prog">
							<div class="RP-content">
								<?php 
								require_once( ABSPATH . 'wp-admin/includes/media.php' );
							 	$audio_file = get_field('audio_url');
								$audio_file_id = $audio_file['id'];
								$audio_file_path = get_attached_file( $audio_file_id);
								$lengths = wp_read_audio_metadata($audio_file_path);
								$lenght  = $lengths['length_formatted'];
								?>

								<h2><?php the_title(); ?><p class="audio-lenght"><?php echo $lenght; ?></p></h2>
								<div class="Rp-Sing">
									<?php echo substr(get_the_excerpt(),0,400); ?>
								</div>								
							</div>
							<div class="rdp_player">
								<?php  echo do_shortcode('[audio mp3="'.$audio_file['url'].'"][/audio]'); ?>						
							</div>						
						</div>
					</article>
					<?php $count++; endwhile; wp_reset_postdata(); ?>
					<?php else : ?>
					<?php endif;  exit(); ?>
<?php
}
add_filter( 'comment_post_redirect', 'redirect_after_comment', 10, 2 );
function redirect_after_comment($location, $comment )
{
	$post_id = $comment->comment_post_ID;
	if('radio_program' == get_post_type($post_id)){
    $location = '/radio-program/#popup-'.$post_id;
  }else{
	$location = wp_get_referer()."#comment-".$commentdata->comment_ID;
  }

	return $location;
}
function ea_comment_textarea_placeholder( $args ) {
	$args['comment_field']        = str_replace( 'textarea', 'textarea placeholder="Your Message"', $args['comment_field'] );
	return $args;
}
add_filter( 'comment_form_defaults', 'ea_comment_textarea_placeholder' );
function be_comment_form_fields( $fields ) {
	foreach( $fields as &$field ) {
		$fields['author'] = '<p class="comment-form-author">'.'<label for="author">' . __( 'FULL NAME' ) . '</label> ' . '<input id="author" placeholder="Your Name should be here*" name="author" required type="text" value="' .
                esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />'.
                ( $req ? '<span class="required">*</span>' : '' )  .
                '</p>';
        $fields['email'] = '<p class="comment-form-email">' .
                '<label for="email">' . __( 'EMAIL ID' ) . '</label> '. '<input id="email" placeholder="Your Email should be here*" name="email" type="text" required value="' . esc_attr(  $commenter['comment_author_email'] ) .
                '" size="30"' . $aria_req . ' />'   .
                ( $req ? '<span class="required">*</span>' : '' ) 
                 .
                '</p>';
	}
	return $fields;
}
add_filter( 'comment_form_default_fields', 'be_comment_form_fields' );
add_filter( 'comment_form_fields', 'move_comment_field' );
function move_comment_field( $fields ) {
	$comment_field = $fields['comment']; $email = $fields['email']; $author = $fields['author'];
    unset( $fields['comment'] );
    unset( $fields['author'] );
    unset( $fields['email'] );
    $fields['author'] =  $author;
    $fields['email'] = $email;
    $fields['comment'] = $comment_field;
    return $fields;
}
add_action( 'template_redirect', 'wpse_45164_redirect_press' );

function wpse_45164_redirect_press()
{
    if ( ! is_singular( 'radio_program' ) )
        return;

    wp_redirect( site_url('/radio-program/#primary'), 301 );
    exit;
}
add_action( 'rest_api_init', 'custom_api_get_all_posts' );   

function custom_api_get_all_posts() {
    register_rest_route( 'api/v1', '/radio-program', array(
        'methods' => 'GET',
        'callback' => 'custom_api_get_all_posts_callback'
    ));
    register_rest_route( 'wp/v2', '/radio-program', array(
        'methods' => 'GET',
        'callback' => 'custom_api_get_all_posts_callback'
    ));
    register_rest_route( 'wp/v2', '/program_tags', array(
        'methods' => 'GET',
        'callback' => 'get_tag_rest_api'
    ));
    register_rest_route( 'wp/v2', '/program_category', array(
        'methods' => 'GET',
        'callback' => 'get_pc_rest_api'
    ));
}
function get_pc_rest_api( $request ) {
    $terms = get_terms( 'program_category', 'orderby=count&hide_empty=0'  );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        
        $posts_data[] = (object) array(
        	'id' => $term->term_id,
        	'taxonomy' => $term->taxonomy,
        	'parent' => $term->parent,
        	'filter' => $term->filter,
            'term_name' => $term->name, 
            'slug' => $term->slug, 
        );
    }
}                 
    return $posts_data;                   
}
function get_tag_rest_api( $request ) {
    $terms = get_terms( 'program_tags', 'orderby=count&hide_empty=0'  );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        
        $posts_data[] = (object) array(
        	'id' => $term->term_id,
        	'taxonomy' => $term->taxonomy,
        	'parent' => $term->parent,
        	'filter' => $term->filter,
            'term_name' => $term->name, 
            'slug' => $term->slug, 
        );
    }
}                 
    return $posts_data;                   
}
function custom_api_get_all_posts_callback( $request ) {
	$language = $_GET['language']; $cat = $_GET['cat']; $protag = $_GET['protag'];
	if($language == ''){
		$taxqery1 = array('taxonomy' => 'language','field' => 'slug','terms' => $language,'operator'  => 'NOT IN');
	}else{
		$taxqery1 = array('taxonomy' => 'language','field' => 'slug','terms' => $language);
	}
	if($cat == ''){
		$taxqery2 = array('taxonomy' => 'program_category','field' => 'slug','terms' => $cat,'operator'  => 'NOT IN');
	}else{
		$taxqery2 = array('taxonomy' => 'program_category','field' => 'slug','terms' => $cat);
	}
	if($protag == ''){
		$taxqery3 = array('taxonomy' => 'program_tags','field' => 'slug','terms' => $protag,'operator'  => 'NOT IN');
	}else{
		$taxqery3 = array('taxonomy' => 'program_tags','field' => 'slug','terms' => $protag);
	}
    // Initialize the array that will receive the posts' data. 
    $posts_data = array();
    // Receive and set the page parameter from the $request for pagination purposes
    $paged = $request->get_param( 'page' );
    $paged = ( isset( $paged ) || ! ( empty( $paged ) ) ) ? $paged : 1; 
    // Get the posts using the 'post' and 'news' post types
    $posts = get_posts( array(
            'paged' => $paged,
            'post__not_in' => get_option( 'sticky_posts' ),
            'posts_per_page' => -1,            
            'post_type' => array( 'radio_program' ),
            'tax_query' => array(
		    'relation' => 'AND',$taxqery1,
		        'relation' => 'AND',$taxqery2,
		        'relation' => 'AND', $taxqery3,
		    	) 
        )
    ); 
    foreach( $posts as $post ) {
        $id = $post->ID;
        $date = get_the_date( 'F j, Y', $id );
        $file = get_field('audio_url', $post->ID);
        $comments = get_comments( array( 'post_id' => $id ) );
        $term_obj_list = get_the_terms( $id, 'language' );
		$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
		$terms_string_slug = join(', ', wp_list_pluck($term_obj_list, 'slug'));
		$term_obj_list1 = get_the_terms( $id, 'program_category' );
		$terms_string1 = join(', ', wp_list_pluck($term_obj_list1, 'name'));
		$term_obj_list2 = get_the_terms( $id, 'program_tags' );
		$terms_string2 = join(', ', wp_list_pluck($term_obj_list2, 'name'));

        $posts_data[] = (object) array( 
            'id' => $id, 
            'post_date' => $date,
            'slug' => $post->post_name, 
            'type' => $post->post_type,
            'title' => $post->post_title,
            'content' => $post->post_content,
            'audio_file' => $file['url'],
            'language' => $terms_string,
            'program_category' => $terms_string1,
            'program_tags' => $terms_string2,
            //'comment_data' => $comments,
        );
    }                  
    return $posts_data;                   
}
add_action( 'rest_api_init', 'rest_api_filter_add_filters' );
 /**
  * Add the necessary filter to each post type
  **/
function rest_api_filter_add_filters() {
	foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
		add_filter( 'rest_' . $post_type->name . '_query', 'rest_api_filter_add_filter_param', 10, 2 );
	}
}
function rest_api_filter_add_filter_param( $args, $request ) {
	// Bail out if no filter parameter is set.
	if ( empty( $request['filter'] ) || ! is_array( $request['filter'] ) ) {
		return $args;
	}
	$filter = $request['filter'];
	if ( isset( $filter['posts_per_page'] ) && ( (int) $filter['posts_per_page'] >= 1 && (int) $filter['posts_per_page'] <= 100 ) ) {
		$args['posts_per_page'] = $filter['posts_per_page'];
	}
	global $wp;
	$vars = apply_filters( 'rest_query_vars', $wp->public_query_vars );
	// Allow valid meta query vars.
	$vars = array_unique( array_merge( $vars, array( 'meta_query', 'meta_key', 'meta_value', 'meta_compare' ) ) );
	foreach ( $vars as $var ) {
		if ( isset( $filter[ $var ] ) ) {
			$args[ $var ] = $filter[ $var ];
		}
	}
	return $args;
}
// Register Custom Taxonomy
function program_tag() {

	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Tags', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Tags', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_in_rest' 				 => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'program_tags', array( 'radio_program' ), $args );

}
add_action( 'init', 'program_tag', 0 );
function podcast() {
$ob=  simplexml_load_file('https://radiobrahmaputra.podbean.com/feed.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
$html = '<div class="podcast-conatiner">';
foreach ($ob->channel->item as $entry) {
	$title = $entry->title;
	$permalink = $entry->link;
	$description = $entry->description;
	$excerpt = substr(strip_tags($description),0,150);
	$img_url = $entry->children( 'media', True )->content->attributes()['url'];
	$att = $entry->enclosure->attributes();
	$url = $att['url'];
$html .= '<div class="podcast-single"><div class="row"><div class="col-lg-3 pdright0"><div class="podcast_featured_img">';
$html .= '<img src="'.$img_url.'" alt="Listen to '.$title.'"  class="cstm-pdc-img"/>';
$html .= '</div></div><div class="col-lg-9 pdleft0"><div class="podcast_content"><p class="podcast_title">';
$html .= '<a href="'.$permalink.'" target="_blank">'.$title.'</a></p>';
$html .= '<div class="podcast_desc">'.$excerpt.'...</div>';
$html .= ' <p class="podcast_player">';
$html .= do_shortcode('[audio= mp3="'.$url.'" ogg="source.ogg" wav="source.wav"]');
$html .= '</p></div> </div></div></div>';
}
$html .= '</div>';
return $html;
}
add_shortcode('podcast', 'podcast');
function filter_rest_allow_anonymous_comments() {
    return true;
}
add_filter('rest_allow_anonymous_comments','filter_rest_allow_anonymous_comments');
