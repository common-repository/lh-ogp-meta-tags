<?php
/**
 * Plugin Name: LH OGP Meta Tags
 * Plugin URI: https://lhero.org/portfolio/lh-ogp-meta-tags/
 * Description: Customise your OGP meta tags the LocalHero way.
 * Version: 1.73
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com/
 * Tags: OGP, Open Graph, facebook, Meta, html, head, sharing, social media, tag
*/

if (!class_exists('LH_ogp_meta_tags_plugin')) {


class LH_ogp_meta_tags_plugin {

var $opt_name = "lh_ogp_meta-options";
var $site_icon_name = 'site_icon';
var $hidden_field_name = 'lh_ogp_meta-submit_hidden';
var $ogp_thumbnail_name = 'lh_ogp_meta-thumbnail_name';
var $fb_publisher_name = 'lh_ogp_meta-fb_publisher_name';
var $fb_article_author_name = 'lh_ogp_meta-fb_article_author_name';
var $fb_userids_field_name = 'lh_ogp_meta-fb_userids_field_name';
var $fb_page_app_field_name = 'lh_ogp_meta-fb_page_app_field_name';
var $namespace = "lh_ogp_meta_tags";
var $options;
var $filename;


private function isValidURL($url) {

return (bool)parse_url($url);

}

private function ogp_is_amp_endpoint(){

if (!function_exists('is_amp_endpoint')){

// this function doesn't even exist

return false;

} else {

//the function exists

if (is_amp_endpoint()){

return true;

} else {

return false;

}


}


}

private function get_supported_post_types() {

return array('post', 'page');


}

private function truncate_string($string,$min) {
$string = do_shortcode($string);
$string = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $string);
    $text = trim(strip_tags($string));
    if(strlen($text)>$min) {
        $blank = strpos($text,' ');
        if($blank) {
            # limit plus last word
            $extra = strpos(substr($text,$min),' ');
            $max = $min+$extra;
            $r = substr($text,0,$max);
            if(strlen($text)>=$max) $r=trim($r,'.').'...';
        } else {
            # if there are no spaces
            $r = substr($text,0,$min).'...';
        }
    } else {
        # if original length is lower than limit
        $r = $text;
    }

$r = htmlspecialchars(trim(preg_replace('/\s\s+/', ' ', $r)));
$r = preg_replace( "/\r|\n/", " ", $r );
    return $r;
}

private function return_meta_description($postid){
  
  
$first = get_post_meta( $postid, "_".$this->namespace."-post_object-desc", true);
  
  
if (!empty($first)){
  
return $first;
  
  
} else {
  
  
$second = get_post_meta( $postid, $this->namespace."-post_object-desc", true);
  
if (!empty($second)){
 
return $second;
  
} else {
  
  
 return false; 
  
}
  
  
}
  
  
}

  
  
  
  
private function return_post_description($post){

if (isset($post->ID) and $this->return_meta_description($post->ID) ){  

return esc_attr($this->truncate_string($this->return_meta_description($post->ID),300));

} elseif (isset($post->post_excerpt)){

return $this->truncate_string($post->post_excerpt,300);

} elseif (isset($post->post_content)){

return esc_attr($this->truncate_string(apply_filters('the_content',$post->post_content),300));

}

}

private function render_og_image($url){
    
?>
<meta property="og:image" content="<?php echo $url; ?>"/>
<?php 
    
    
    

}

private function render_og_locale($locale){
    
?>
<meta property="og:locale" content="<?php echo $locale; ?>"/>
<?php 
    
    
}


private function render_og_title($title){
    
  ?>
<meta property="og:title" content="<?php echo $title; ?>"/>
<?php   
    
    
}

private function render_og_url($url){
    
  ?>
<meta property="og:url" content="<?php echo $url; ?>"/>
<?php   
    
    
}

private function render_og_type($type){
    
  ?>
<meta property="og:type" content="<?php echo $type; ?>"/>
<?php   
    
    
}

private function render_og_site_name($site_name){
    
  ?>
<meta property="og:site_name" content="<?php echo $site_name; ?>"/>
<?php   
    
    
}

private function render_og_description($description){
    
  ?>
<meta property="og:description" content="<?php echo $description; ?>"/>
<?php   
    
    
}


public function add_ogp_meta() {


echo "\n<!-- begin LH OGP meta output -->\n";

if (is_singular() and !is_front_page()){


global $post;

if (isset($post)){

$this->render_og_title(esc_attr($post->post_title));
$this->render_og_url(get_permalink($post->ID));
$this->render_og_locale(get_locale());
$this->render_og_type("article");
$this->render_og_description($this->return_post_description($post));
$this->render_og_site_name(get_bloginfo('name'));

if (isset($post->post_author)){


if (get_the_author_meta($this->fb_article_author_name, $post->post_author )){
?>
<meta property="article:author" content="<?php echo get_the_author_meta($this->fb_article_author_name, $post->post_author ); ?>"/>
<meta name="author" content="<?php echo esc_attr(get_the_author_meta('display_name', $post->post_author )); ?>"/>
<?php 

}

}

if (isset($this->options[$this->fb_publisher_name])){


?>
<meta property="article:publisher" content="<?php echo $this->options[$this->fb_publisher_name]; ?>"/>
<?php 

}

if (isset($post->post_type) and get_post_meta($post->ID, $post->post_type."_".$this->ogp_thumbnail_name."_thumbnail_id", true)){


$featured_image_id = get_post_meta($post->ID, $post->post_type."_".$this->ogp_thumbnail_name."_thumbnail_id", true);

$image = wp_get_attachment_image_src($featured_image_id, 'lh-ogp-meta-thumbnail');

$this->render_og_image($image[0]);


} elseif (isset($post->ID) and get_the_post_thumbnail_url($post->ID, 'lh-ogp-meta-thumbnail')){

$featured_image_id = get_post_thumbnail_id($post->ID);

$this->render_og_image(get_the_post_thumbnail_url($post->ID, 'lh-ogp-meta-thumbnail'));

}

} else {


$image = wp_get_attachment_image_src($this->site_icon, 'lh-ogp-meta-thumbnail');

$this->render_og_image($image[0]);


} 

$images = get_attached_media('image', $post->ID);
foreach($images as $image) { 

if (isset($image->ID) and (!isset($featured_image_id) or ($image->ID != $featured_image_id))){

$image_details = wp_get_attachment_image_src($image->ID,'lh-ogp-meta-thumbnail');

$this->render_og_image($image_details[0]);


}

} 

} else {

$image = wp_get_attachment_image_src(get_option('site_icon'), 'lh-ogp-meta-thumbnail');

$this->render_og_title(esc_attr(get_bloginfo('name')));
$this->render_og_type("website");
$this->render_og_locale(get_locale());
$this->render_og_url(get_bloginfo('url'));
$this->render_og_image($image[0]);
$this->render_og_site_name(esc_attr(get_bloginfo('name')));
$this->render_og_description(esc_attr(get_bloginfo('description')));



}

if (isset($this->options[$this->fb_userids_field_name])){
echo "<meta property=\"fb:admins\" content=\"".$this->options[$this->fb_userids_field_name]."\" />\n";
}

if (isset($this->options[$this->fb_page_app_field_name])){
echo "<meta property=\"fb:app_id\" content=\"".$this->options[$this->fb_page_app_field_name]."\" />\n";
}



echo "<!-- end LH OGP meta output -->\n\n";



}


public function plugin_menu(){

add_options_page('LH OGP Meta Tag settings', 'OGP Meta Tags', 'manage_options', $this->filename, array($this,"plugin_options"));

}


public function plugin_options(){

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}


    if( isset($_POST[$this->hidden_field_name]) && $_POST[ $this->hidden_field_name ] == 'Y' ) {
        // Read their posted value

if ($_POST[ $this->ogp_image_name."-url" ] != ""){
$options[$this->ogp_image_name] = sanitize_text_field($_POST[ $this->ogp_image_name ]);
}

if (($_POST[ $this->fb_publisher_name ]) and ($_POST[ $this->fb_publisher_name ] != "")){
$options[$this->fb_publisher_name] = sanitize_text_field($_POST[ $this->fb_publisher_name ]);
}

if (($_POST[$this->fb_page_app_field_name]) and ($_POST[ $this->fb_page_app_field_name ] != "")){
$options[$this->fb_page_app_field_name] = sanitize_text_field($_POST[ $this->fb_page_app_field_name ]);
}

if (($_POST[$this->fb_userids_field_name]) and ($_POST[ $this->fb_userids_field_name ] != "")){
$options[$this->fb_userids_field_name] = sanitize_text_field($_POST[ $this->fb_userids_field_name ]);
}



if (update_option( $this->opt_name, $options )){

$this->options = get_option($this->opt_name);

        // Put an settings updated message on the screen


?>
<div class="updated"><p><strong><?php _e('Settings Updated', $this->namespace ); ?></strong></p></div>
<?php

} 

}


// Now display the settings editing screen

include ('partials/option-settings.php');
    

} 




public function add_new_image_sizes_to_wp() {

if ( function_exists( 'add_image_size' ) ) { 

add_image_size( 'lh-ogp-meta-thumbnail', 1500, 1500 ); 

}

}


public function add_schema($attr) {

if ( !is_feed() and !$this->ogp_is_amp_endpoint()) {

$attr .= "\n xmlns:og=\"http://ogp.me/ns#\"";

}

return $attr;

}


public function extra_user_profile_field( $user ) {



?>

<table class="form-table">
<tr>
<th><label for="<?php echo $this->fb_article_author_name; ?>">Facebook user url</label></th>
<td><input type="text" name="<?php echo $this->fb_article_author_name; ?>" id="<?php echo $this->fb_article_author_name; ?>" value="<?php echo esc_attr( get_the_author_meta($this->fb_article_author_name, $user->ID ) ); ?>" class="regular-text" /></td>
</tr>
</table>

<?php

}


public function save_extra_user_profile_field( $user_id ) {
  $saved = false;
  if ( isset($_POST[$this->fb_article_author_name]) and current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, $this->fb_article_author_name, sanitize_text_field($_POST[$this->fb_article_author_name]));

    $saved = true;
  }
  return true;
}

// add a settings link next to deactive / edit
public function add_settings_link( $links, $file ) {

	if( $file == $this->filename ){
		$links[] = '<a href="'. admin_url( 'options-general.php?page=' ).$this->filename.'">Settings</a>';
	}
	return $links;
}

public function ogp_description_metabox_content(){

$value = $this->return_meta_description(get_the_ID());

wp_nonce_field( $this->namespace."-post_edit-nonce", $this->namespace."-post_edit-nonce" );

?>



<label class="screen-reader-text" id="<?php  echo $this->namespace."-post_object-desc-prompt-text";  ?>" for="<?php  echo $this->namespace."-post_object-desc";  ?>">Enter OGP Description</label>
<textarea name="<?php  echo $this->namespace."-post_object-desc";  ?>" id="<?php  echo $this->namespace."-post_object-desc";  ?>" placeholder="Enter OGP Description" style="width: 100%;" maxlength="300" ><?php echo $value;  ?>
</textarea>

<?php



}




public function add_meta_boxes($post_type, $post) {

$supported_types = $this->get_supported_post_types();

if (in_array($post_type, $supported_types)) {

add_meta_box($this->namespace."-ogp_description-div", "OGP Description", array($this,"ogp_description_metabox_content"), $post_type, "side", "low");


}



}


public function update_post_meta( $post_id, $post, $update ) {

if (isset($_POST[$this->namespace."-post_edit-nonce"]) and wp_verify_nonce($_POST[$this->namespace."-post_edit-nonce"], $this->namespace."-post_edit-nonce") and isset($_POST[$this->namespace."-post_object-desc"])){

$content = sanitize_text_field($_POST[$this->namespace."-post_object-desc"]);

update_post_meta($post_id, "_".$this->namespace."-post_object-desc", $content);
  
  
delete_post_meta($post_id, $this->namespace."-post_object-desc");


}

}

public function lh_instant_articles_address_tag_filter($text, $post_id){

$object = get_post( $post_id);



if ($this->isValidURL(get_the_author_meta($this->fb_article_author_name, $object->post_author ))){

return '<a rel="facebook" href="'.get_the_author_meta($this->fb_article_author_name, $object->post_author ).'">'.$text.'</a>';

} else {

return $text;

}




}

public function lh_instant_articles_figure_tag_filter($figure, $post_id){

$object = get_post($post_id);

if (isset($object->post_type) and get_post_meta($object->ID, $object->post_type."_".$this->ogp_thumbnail_name."_thumbnail_id", true)){


$image = wp_get_attachment_image_src(get_post_meta($object->ID, $object->post_type."_".$this->ogp_thumbnail_name."_thumbnail_id", true), 'full')[0];


}

if (isset($image)){

return '<img src="'.$image.'"/>';



} else {

return $figure;

}
 



}




public function __construct() {


$this->options = get_option($this->opt_name);
$this->filename = plugin_basename( __FILE__ );
$this->site_icon = get_option($this->site_icon_name);

add_action('admin_menu', array($this,"plugin_menu"));
add_action( 'init', array($this,"add_new_image_sizes_to_wp"));
add_filter('language_attributes', array($this,"add_schema"));
add_action('wp_head', array($this,"add_ogp_meta"));
add_action( 'show_user_profile', array($this,"extra_user_profile_field"),10,1);
add_action( 'edit_user_profile', array($this,"extra_user_profile_field"),10,1);
add_action( 'personal_options_update', array($this,"save_extra_user_profile_field"));
add_action( 'edit_user_profile_update', array($this,"save_extra_user_profile_field"));
add_action( 'user_register', array($this,"save_extra_user_profile_field"));
add_filter('plugin_action_links', array($this,"add_settings_link"), 10, 2);
add_action( 'save_post', array($this,"update_post_meta"),10,3);

add_filter('lh_instant_articles_address_tag_filter', array($this,"lh_instant_articles_address_tag_filter"), 10, 2);
add_filter('lh_instant_articles_figure_tag_filter', array( $this, 'lh_instant_articles_figure_tag_filter' ),15,2);


if (!class_exists('MultiPostThumbnails')) {

include_once('includes/multi-post-thumbnails.php');

}

  if (class_exists('MultiPostThumbnails')) {
            $types = $this->get_supported_post_types();
            foreach($types as $type) {
                new MultiPostThumbnails(array(
                    'label' => 'OGP Image',
                    'id' => $this->ogp_thumbnail_name,
                    'post_type' => $type
                    )
                );
            }
        }


add_action('add_meta_boxes', array($this,"add_meta_boxes"),10,2);

add_filter( 'jetpack_enable_open_graph', '__return_false' );

}


}

$lh_ogp_meta_tags_instance = new LH_ogp_meta_tags_plugin();



}


?>