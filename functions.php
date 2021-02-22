<?php
/*****************************************
* Weaver's Web Functions & Definitions *
*****************************************/

$functions_path = get_template_directory().'/functions/';
$post_type_path = get_template_directory().'/inc/post-types/';
$post_meta_path = get_template_directory().'/inc/post-metabox/';

/*--------------------------------------*/
/* Optional Panel Helper Functions
/*--------------------------------------*/

require_once($functions_path.'admin-functions.php');
require_once($functions_path.'admin-interface.php');
require_once($functions_path.'theme-options.php');
require_once($functions_path.'default-values.php');
require_once($functions_path.'feature_post.php');
require_once($functions_path.'notification.php');

function weaversweb_ftn_wp_enqueue_scripts(){
    if(!is_admin()){
        wp_enqueue_script('jquery');
        if(is_singular()and get_site_option('thread_comments')){
            wp_print_scripts('comment-reply');
			}
		}
	}
add_action('wp_enqueue_scripts','weaversweb_ftn_wp_enqueue_scripts');
function weaversweb_ftn_get_option($name){
    $options = get_option('weaversweb_ftn_options');
    if(isset($options[$name]))
        return $options[$name];
	}
function weaversweb_ftn_update_option($name, $value){
    $options = get_option('weaversweb_ftn_options');
    $options[$name] = $value;
    return update_option('weaversweb_ftn_options', $options);
	}
function weaversweb_ftn_delete_option($name){
    $options = get_option('weaversweb_ftn_options');
    unset($options[$name]);
    return update_option('weaversweb_ftn_options', $options);
	}
function get_theme_value($field){	
	$field1=weaversweb_ftn_get_option($field);
	$field_default=all_default_values($field);
	if(!empty($field1)){
		$field_val=$field1;
		}else{
		$field_val=$field_default;	
		}
	return	$field_val;
	}

/*--------------------------------------*/
/* Post Type Helper Functions
/*--------------------------------------*/
require_once($post_type_path.'squad.php');
require_once($post_type_path.'teams.php');
require_once($post_type_path.'articles.php');
require_once($post_type_path.'artical_videos.php');
require_once($post_type_path.'team_album.php');
require_once($post_type_path.'sponsor.php');
require_once($post_type_path.'trophy_album.php');
require_once($post_type_path.'live_match.php');
//require_once($post_type_path.'gameStats.php');

/*--------------------------------------*/
/* Post Meta Helper Functions
/*--------------------------------------*/


//require_once($post_meta_path.'team_players_meta_box.php');


/***************** Include Files Starts *********************/

//include('inc/post-types/faqs.php'); 
//require_once ($functions_path . 'multipost-thumbnail/multi-post-thumbnails.php');

/***************** Include Files Ends *********************/

/*--------------------------------------*/
/* Theme Helper Functions
/*--------------------------------------*/
if(!function_exists('weaversweb_theme_setup')):
	function weaversweb_theme_setup(){
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		register_nav_menus(array(
			'primary' => __('Primary Menu','weaversweb'),
			'secondary'  => __('Secondary Menu','weaversweb'),
			));
		add_theme_support('html5',array('search-form','comment-form','comment-list','gallery','caption'));
		}
	endif;
add_action('after_setup_theme','weaversweb_theme_setup');

function weaversweb_widgets_init(){
	register_sidebar(array(
		'name'          => __('Widget Area','weaversweb'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar.','weaversweb'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		));


	register_sidebar(array(
		'name'          => __('Twitter Feed Area','weaversweb'),
		'id'            => 'twitter-sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar.','weaversweb'),
		'before_widget' => '<div class="twitter_div">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
		));

}
add_action('widgets_init','weaversweb_widgets_init');

function weaversweb_scripts(){

	wp_enqueue_style('weaversweb-bootstrap-min-css',get_template_directory_uri().'/css/bootstrap.min.css',array());

	wp_enqueue_style('weaversweb-akslider',get_template_directory_uri().'/css/akslider.css',array());

	//wp_enqueue_style('weaversweb-akslider',get_template_directory_uri().'/style.css',array());

	wp_enqueue_style('weaversweb-donate.css',get_template_directory_uri().'/css/donate.css',array());

	wp_enqueue_style('weaversweb-theme.css',get_template_directory_uri().'/css/theme.css',array());

	wp_enqueue_style('weaversweb-font-awesome-css',get_template_directory_uri().'/css/font-awesome.min.css',array());
	
	// Load the Internet Explorer specific script.
	//wp_enqueue_script('weaversweb-bootstrap-script',get_template_directory_uri().'/js/bootstrap.min.js',array('jquery'),'20151811',true);
	
	global $wp_scripts;
	wp_enqueue_script('weaversweb-popper-script',get_template_directory_uri().'/js/popper.min.js',array('jquery'),'20151811',true);
	
	//wp_enqueue_script('weaversweb-jquery',get_template_directory_uri().'/js/jquery.js',array('jquery'),'20151811',true);

	wp_enqueue_script('weaversweb-uikit',get_template_directory_uri().'/js/uikit.js',array('jquery'),'20151811',true);
	wp_enqueue_script('weaversweb-SimpleCounter',get_template_directory_uri().'/js/SimpleCounter.js',array('jquery'),'20151811',true);
	wp_enqueue_script('weaversweb-grid',get_template_directory_uri().'/js/components/grid.js',array('jquery'),'20151811',true);
	wp_enqueue_script('weaversweb-slider',get_template_directory_uri().'/js/components/slider.js',array('jquery'),'20151811',true);
	wp_enqueue_script('weaversweb-slideshow',get_template_directory_uri().'/js/components/slideshow.js',array('jquery'),'20151811',true);
	wp_enqueue_script('weaversweb-slideset',get_template_directory_uri().'/js/components/slideset.js',array('jquery'),'20151811',true);
    wp_enqueue_script('weaversweb-sticky',get_template_directory_uri().'/js/components/sticky.js',array('jquery'),'20151811',true);
    wp_enqueue_script('weaversweb-lightbox',get_template_directory_uri().'/js/components/lightbox.js',array('jquery'),'20151811',true);
     wp_enqueue_script('weaversweb-isotope',get_template_directory_uri().'/js/isotope.pkgd.min.js',array('jquery'),'20151811',true);
     wp_enqueue_script('weaversweb-theme',get_template_directory_uri().'/js/theme.js',array('jquery'),'20151811',true);
     
     wp_enqueue_script('weaversweb-popper-script',get_template_directory_uri().'/js/custom.js',array('jquery'),'20151811',true);
	
 }
add_action('wp_enqueue_scripts','weaversweb_scripts');
//add_image_size( 'post-thumb', 360, 271, array( 'center', 'top' ));
//Ajax url define
add_action('wp_head','ajaxurl');
function ajaxurl() { ?>
<script type="text/javascript"> var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>'; </script>
<?php }

//Parents Role For My Baby Day
$content_editor_role = add_role('content_editor_role', 'Content editor', array(
	'read' => true,
	'edit_posts' => true,
	'delete_posts' => true,
	'edit_pages' => false,
	'edit_others_posts' => false,
	'create_posts' => true,
	'manage_categories' => false,
	'publish_posts' => true,
	'edit_themes' => false,
	'install_plugins' => false, 
	'update_plugin' => false,
	'update_core' => false
 ));

$application_user_role = add_role('application_user_role', 'Application User', array(
	'read' => true,
	'edit_posts' => true,
	'delete_posts' => true,
	'edit_pages' => false,
	'edit_others_posts' => false,
	'create_posts' => true,
	'manage_categories' => false,
	'publish_posts' => true,
	'edit_themes' => false,
	'install_plugins' => false, 
	'update_plugin' => false,
	'update_core' => false
 ));


//Custom Role For Company
/*$company_role = add_role('company', 'Company', array(
	'read' => true,
	'edit_posts' => true,
	'delete_posts' => true,
	'edit_pages' => false,
	'edit_others_posts' => false,
	'create_posts' => true,
	'manage_categories' => false,
	'publish_posts' => true,
	'edit_themes' => false,
	'install_plugins' => false, 
	'update_plugin' => false,
	'update_core' => false
));*/

//add_image_size( 'offersimage', 422, 417, array( 'center', 'center' ) );

/*add_action( 'admin_menu', 'pk_menu_page_removing',999 );
function pk_menu_page_removing() {
   remove_menu_page( 'edit.php' );
   remove_menu_page( 'tools.php' );  
   remove_menu_page( 'plugins.php' ); 
   remove_menu_page( 'edit-comments.php' ); 
   remove_menu_page('edit.php?post_type=to_do');  
   remove_menu_page('edit.php?post_type=customer_goals');  
   remove_menu_page('edit.php?post_type=customer_my_goals');
   remove_menu_page('edit.php?post_type=page');
   remove_menu_page('options-general.php');
   remove_menu_page('themes.php');
   remove_menu_page('edit.php?post_type=acf');	
}*/

/*
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );*/
function featured_post_chk() {
?>	
<script type="text/javascript">
function myfun(a,b){
     jQuery.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {action:'cart_addition_ajax',pid : a, chbx : b},
            type: "POST",
            cache: false,
          }); 
      location.reload(true);
  }
</script>  
<?php       
}
add_action( 'admin_enqueue_scripts', 'featured_post_chk' );

//feature post
add_action( 'wp_ajax_cart_addition_ajax', 'add_feturepostid', 10 );
function add_feturepostid(){
   $postId =   $_REQUEST['pid'];
   $chebx  =   $_REQUEST['chbx'];
   update_post_meta($postId, 'featured',$chebx);
   wp_die();
}
//feture post

addfeturepost('video');
addfeturepost('articles');

function image_upload($image){

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php'); 


	$uploadedfile = $image;
	$upload_overrides = array( 'test_form' => false );
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );


	$filename = $movefile['file'];
	$attachment = array(
		'post_mime_type' => $movefile['type'],
		'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
		'post_content' => '',
		'post_status' => 'inherit',
		'guid' => $movefile['url']
	);
	$attachment_id = wp_insert_attachment( $attachment, $movefile['url'] );
	$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
	wp_update_attachment_metadata( $attachment_id, $attachment_data );
    return $attachment_id;
} 
//body class
add_filter( 'body_class', 'my_neat_body_class');
function my_neat_body_class( $classes ) {
     if ( is_page(155) )
          $classes[] = 'tm-isblog';
      if ( is_page(150) || is_page(153) || is_page(191) || is_page(193) || is_page(182) || is_singular('squad') || is_singular('articles')  )
          $classes[] = 'tm-isblog';
      if(is_page(191))
      	$classes[] = 'tt-players-page';
       if(is_page(193) || is_singular('squad') || is_page(182))
      	$classes[] = 'tt-gallery-page';
 
     return $classes; 
}
function arabicDate($cdate, $cday,$csdate, $cYear){
$months = array(
    "Jan" => "يناير",
    "Feb" => "فبراير",
    "Mar" => "مارس",
    "Apr" => "ابريل",
    "May" => "ماي",
    "Jun" => "يونيو",
    "Jul" => "يوليوز",
    "Aug" => "غشث",
    "Sep" => "شتنبر",
    "Oct" => "أكتوبر",
    "Nov" => "نونبر",
    "Dec" => "دجنبر"
);
 
//$your_date = date('y-m-d'); // The Current Date
$your_date = $cdate; // The Current Date
 
$en_month = date("M", strtotime($your_date));
 
foreach ($months as $en => $ar) {
    if ($en == $en_month) {
        $ar_month = $ar;
    }
}
 
$find = array (
 
    "Sat",
    "Sun",
    "Mon",
    "Tue",
    "Wed" ,
    "Thu",
    "Fri"
 
);
 
$replace = array (
 
    "السبت",
    "الأحد",
    "الإثنين",
    "الثلاثاء",
    "الأربعاء",
    "الخميس",
    "الجمعة"
 
);
 
//$ar_day_format = date('D'); // The Current Day
$ar_day_format = $cday;
$ar_day = str_replace($find, $replace, $ar_day_format);
 
 
header('Content-Type: text/html; charset=utf-8');
$standard = array("0","1","2","3","4","5","6","7","8","9");
//$eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
$eastern_arabic_symbols = array("0","1","2","3","4","5","6","7","8","9");
//$current_date = $ar_day.' '.date('d').' / '.$ar_month.' / '.date('Y');
$current_date = $ar_day.' '.$csdate.'  '.$ar_month;
$arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);
 
// Echo Out the Date
return $arabic_date;
 }