<?php
/**
 * Plugin Name:     Extension Generate_express
 * Plugin URI:      https://github.com/Lightweb-Media/
 * Description:     Remove first Paragraph from the_content and show it on specific position
 * Author:          Sebastian Weiss & René Kutter
 * Author URI:      https://lightweb-media.de
 * Text Domain:     generate_express
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Generate_express
 */

// Your code starts here.
// 
// 
function get_first_para($content){
	  $output = preg_match_all('%(<p[^>]*>.*?</p>)%i', $content, $matches);
  $first_para = $matches [1] [0];
  return $first_para;
}

function remove_first_para($content, $first_para){
	return str_replace($first_para, "",$content);
}

add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 10,1);
add_action( 'generate_after_header','add_content_to_action');
function filter_the_content_in_the_main_loop( $content ) {
 
    // Check if we're inside the main loop in a single Post.
    if ( is_singular() && in_the_loop() && is_main_query() ) {
      
		$first_para = get_first_para($content);
		$content = remove_first_para($content, $first_para);

	
			
		return $content;	
    }
 
    return $content;
}

function add_content_to_action($first_para){
	    // Check if we're inside the main loop in a single Post.
 if (is_page_template('page-wide-table.php')) { 
	global $post;
	$first_para = get_first_para(get_the_content());
	echo '<p>'.$first_para.'</p>';
 }

}
