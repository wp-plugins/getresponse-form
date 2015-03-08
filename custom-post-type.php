<?php

/*
*Instruction - if you are using this as a template for a plugin, change the class name, the call to create an object from this class *at the bottom, and modify the private variables to meet your needs.
*/

class GetResponseFormCreatorCustomPostType{

private $post_type = 'getresponseform';
private $post_label = 'GetResponse Form';
private $prefix = '_getresponse_form_creator_';
function __construct() {
	
	add_filter( 'cmb_meta_boxes', array(&$this,'metaboxes' ));
	add_action( 'init', array(&$this,'initialize_meta_boxes'), 9999 );
	add_action("init", array(&$this,"create_post_type"));
	add_action( 'init', array(&$this, 'getresponse_form_creator_register_shortcodes'));
	add_action( 'wp_footer', array(&$this, 'enqueue_styles'));
	add_action( 'wp_footer', array(&$this, 'enqueue_scripts'));
	register_activation_hook( __FILE__, array(&$this,'activate' ));
}

function create_post_type(){
	register_post_type($this->post_type, array(
	         'label' => _x($this->post_label, $this->post_type.' label'), 
	         'singular_label' => _x('All '.$this->post_label, $this->post_type.' singular label'), 
	         'public' => true, // These will be public
	         'show_ui' => true, // Show the UI in admin panel
	         '_builtin' => false, // This is a custom post type, not a built in post type
	         '_edit_link' => 'post.php?post=%d',
	         'capability_type' => 'page',
	         'hierarchical' => false,
	         'rewrite' => array("slug" => $this->post_type), // This is for the permalinks
	         'query_var' => $this->post_type, // This goes to the WP_Query schema
	         //'supports' =>array('title', 'editor', 'custom-fields', 'revisions', 'excerpt'),
	         'supports' =>array('title', 'author'),
	         'add_new' => _x('Add New', 'Event')
	         ));
}


/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function metaboxes( array $meta_boxes ) {
	
	// Start with an underscore to hide fields from custom fields list
	//$prefix = '_getresponse_form_creator_';
	

	$meta_boxes[] = array(
		'id'         => 'getresponse_form_metabox',
		'title'      => 'GetResponse Form Creator',
		'pages'      => array( $this->post_type ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Headline',
				'desc' => 'Enter your headline here.',
				'id'   => $this->prefix . 'headline',
				'type' => 'text',
				//'std'  => 'This is the headline, man!',
			),
			array(
			            'name' => 'Background Color',
			            'desc' => 'Use this to set the backgroud of the form.',
			            'id'   => $this->prefix . 'background_color',
			            'type' => 'colorpicker',
					'std'  => '#ffffff'
		        ),
		        /*
		        array(
				'name' => 'Image',
				'desc' => 'Upload an image or enter an URL where you image is located.',
				'id'   => $this->prefix . 'image',
				'type' => 'file',
			),
			*/
			array(
				'name'    => 'Message',
				//'desc'    => 'field description (optional)',
				'id'      => $this->prefix . 'message',
				'type'    => 'wysiwyg',
				'options' => array(	'textarea_rows' => 20, 'wpautop' => true ),
				
			),
			array(
			            'name' => 'Button Color',
			            'desc' => 'Use this to set the form button color.',
			            'id'   => $this->prefix . 'button_color',
			            'type' => 'colorpicker',
					'std'  => '#8a8a8a'
		        ),
		        array(
				'name' => 'Button Text',
				'desc' => 'Enter the form button text here.',
				'id'   => $this->prefix . 'button_text',
				'type' => 'text',
				'std'  => 'Get It',
			),
			array(
				'name' => 'GetResponse Campaign Token',
				'desc' => 'Enter the GetResponse Campaign Token here.',
				'id'   => $this->prefix . 'getresponse_campaign_token',
				'type' => 'text',
				'std'  => '',
			),

		),
	);

	

	// Add other metaboxes as needed

	return $meta_boxes;
}


function getresponse_form_creator_shortcode($atts){
		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );
		//$meta_data = get_post_meta( $id, $this->prefix . 'adsense_code', true );
		//$meta_data = get_post_meta($id);
		$dir = plugin_dir_path( __FILE__ );

		$headline = get_post_meta($id, $this->prefix . 'headline', true);
		$background_color = get_post_meta($id, $this->prefix . 'background_color', true);
		$image = get_post_meta($id, $this->prefix . 'image', true);
		$message = get_post_meta($id, $this->prefix . 'message', true);
		$button_color = get_post_meta($id, $this->prefix . 'button_color', true);
		$button_text = get_post_meta($id, $this->prefix . 'button_text', true);
		$getresponse_campaign_token = get_post_meta($id, $this->prefix . 'getresponse_campaign_token', true);
		
		ob_start();
		include $dir.'template/getresponseFormCreatorTemplate.php';
		return ob_get_clean();
}



function getresponse_form_creator_register_shortcodes(){
		add_shortcode( 'getresponse_form', array(&$this,'getresponse_form_creator_shortcode' ));
	}


function activate() {
	// register taxonomies/post types here
	$this->create_post_type();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function enqueue_styles(){
	wp_register_style( 'getresponse-form-creator-css', plugin_dir_url(__FILE__).'css/getresponseFormCreator.css' );
	wp_enqueue_style('getresponse-form-creator-css');
}

function enqueue_scripts(){
	wp_enqueue_script('getresponse-form-creator-js', plugin_dir_url(__FILE__).'js/getresponseFormCreator.js');
}


/*
 * Initialize the metabox class.
 */
 
function initialize_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'lib/metabox/init.php';

}


}

new GetResponseFormCreatorCustomPostType();


?>