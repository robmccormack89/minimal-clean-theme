<?php
/**
 * Timber theme class & other functions for Twig.
 *
 * @package Rmcc_CV_Theme
 */

// Define paths to Twig templates
Timber::$dirname = array(
  'views/',
  'views/archive',
  'views/parts',
  'views/parts/comments',
  'views/single',
  'views/front',
);

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class RmccCvTheme extends Timber\Site
{
  /** Add timber support */
  public function __construct()
  {
    add_action('after_setup_theme', array( $this, 'theme_supports' ));
    add_action('wp_enqueue_scripts', array( $this, 'rmcc_cv_theme_enqueue_assets'));
    add_action('widgets_init', array( $this, 'rmcc_cv_custom_uikit_widgets_init'));
    add_filter('timber/context', array( $this, 'add_to_context' ));
    add_filter('timber/twig', array( $this, 'add_to_twig' ));
    add_action('init', array( $this, 'register_post_types' ));
    add_action('init', array( $this, 'register_taxonomies' ));
    add_action('init', array( $this, 'register_widget_areas' ));
    add_action('init', array( $this, 'register_navigation_menus' ));
    parent::__construct();
  }

  public function register_post_types()
  {
    
    // $labels_exp = array(
    //   'name'                  => _x( 'Experience', 'Post Type General Name', 'rmcc-cv-theme' ),
    //   'singular_name'         => _x( 'Experience', 'Post Type Singular Name', 'rmcc-cv-theme' ),
    //   'menu_name'             => __( 'Experience', 'rmcc-cv-theme' ),
    //   'name_admin_bar'        => __( 'Experience', 'rmcc-cv-theme' ),
    //   'archives'              => __( 'Experience Archives', 'rmcc-cv-theme' ),
    //   'attributes'            => __( 'Experience Item Attributes', 'rmcc-cv-theme' ),
    //   'parent_item_colon'     => __( 'Parent Experience Item:', 'rmcc-cv-theme' ),
    //   'all_items'             => __( 'All Experience Items', 'rmcc-cv-theme' ),
    //   'add_new_item'          => __( 'Add New Experience Item', 'rmcc-cv-theme' ),
    //   'add_new'               => __( 'Add New Experience Item', 'rmcc-cv-theme' ),
    //   'new_item'              => __( 'New Experience Item', 'rmcc-cv-theme' ),
    //   'edit_item'             => __( 'Edit Experience Item', 'rmcc-cv-theme' ),
    //   'update_item'           => __( 'Update Experience Item', 'rmcc-cv-theme' ),
    //   'view_item'             => __( 'View Experience Item', 'rmcc-cv-theme' ),
    //   'view_items'            => __( 'View Experience Items', 'rmcc-cv-theme' ),
    //   'search_items'          => __( 'Search Experience Item', 'rmcc-cv-theme' ),
    //   'not_found'             => __( 'Not found', 'rmcc-cv-theme' ),
    //   'not_found_in_trash'    => __( 'Not found in Trash', 'rmcc-cv-theme' ),
    //   'featured_image'        => __( 'Featured Image', 'rmcc-cv-theme' ),
    //   'set_featured_image'    => __( 'Set featured image', 'rmcc-cv-theme' ),
    //   'remove_featured_image' => __( 'Remove featured image', 'rmcc-cv-theme' ),
    //   'use_featured_image'    => __( 'Use as featured image', 'rmcc-cv-theme' ),
    //   'insert_into_item'      => __( 'Insert into item', 'rmcc-cv-theme' ),
    //   'uploaded_to_this_item' => __( 'Uploaded to this item', 'rmcc-cv-theme' ),
    //   'items_list'            => __( 'Experience Items list', 'rmcc-cv-theme' ),
    //   'items_list_navigation' => __( 'Experience Items list navigation', 'rmcc-cv-theme' ),
    //   'filter_items_list'     => __( 'Filter Experience items list', 'rmcc-cv-theme' ),
    // );
    // $args_exp = array(
    //   'label'                 => __( 'Experience', 'rmcc-cv-theme' ),
    //   'description'           => __( 'Work Experience', 'rmcc-cv-theme' ),
    //   'labels'                => $labels_exp,
    //   'supports'              => array( 'title', 'editor' ),
    //   'hierarchical'          => false,
    //   'public'                => true,
    //   'show_ui'               => true,
    //   'show_in_menu'          => true,
    //   'menu_position'         => 25,
    //   'show_in_admin_bar'     => true,
    //   'show_in_nav_menus'     => false,
    //   'can_export'            => true,
    //   'has_archive'           => false, // do we want an archive?
    //   'exclude_from_search'   => true,
    //   'publicly_queryable'    => false, // do we want singular endpoints? see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
    //   'capability_type'       => 'page',
    //   'show_in_rest'          => false,
    //   );
    // register_post_type( 'experience', $args_exp );
    // 
    // $labels_qua = array(
    //   'name'                  => _x( 'Qualification', 'Post Type General Name', 'rmcc-cv-theme' ),
    //   'singular_name'         => _x( 'Qualification', 'Post Type Singular Name', 'rmcc-cv-theme' ),
    //   'menu_name'             => __( 'Qualifications', 'rmcc-cv-theme' ),
    //   'name_admin_bar'        => __( 'Qualifications', 'rmcc-cv-theme' ),
    //   'archives'              => __( 'Qualificatios', 'rmcc-cv-theme' ),
    //   'attributes'            => __( 'Qualification Attributes', 'rmcc-cv-theme' ),
    //   'parent_item_colon'     => __( 'Parent Qualification:', 'rmcc-cv-theme' ),
    //   'all_items'             => __( 'All Qualifications', 'rmcc-cv-theme' ),
    //   'add_new_item'          => __( 'Add New Qualification', 'rmcc-cv-theme' ),
    //   'add_new'               => __( 'Add New Qualification', 'rmcc-cv-theme' ),
    //   'new_item'              => __( 'New Qualification', 'rmcc-cv-theme' ),
    //   'edit_item'             => __( 'Edit Qualification', 'rmcc-cv-theme' ),
    //   'update_item'           => __( 'Update Qualification', 'rmcc-cv-theme' ),
    //   'view_item'             => __( 'View Qualification', 'rmcc-cv-theme' ),
    //   'view_items'            => __( 'View Qualifications', 'rmcc-cv-theme' ),
    //   'search_items'          => __( 'Search Qualifications', 'rmcc-cv-theme' ),
    //   'not_found'             => __( 'Not found', 'rmcc-cv-theme' ),
    //   'not_found_in_trash'    => __( 'Not found in Trash', 'rmcc-cv-theme' ),
    //   'featured_image'        => __( 'Featured Image', 'rmcc-cv-theme' ),
    //   'set_featured_image'    => __( 'Set featured image', 'rmcc-cv-theme' ),
    //   'remove_featured_image' => __( 'Remove featured image', 'rmcc-cv-theme' ),
    //   'use_featured_image'    => __( 'Use as featured image', 'rmcc-cv-theme' ),
    //   'insert_into_item'      => __( 'Insert into item', 'rmcc-cv-theme' ),
    //   'uploaded_to_this_item' => __( 'Uploaded to this item', 'rmcc-cv-theme' ),
    //   'items_list'            => __( 'Qualifications list', 'rmcc-cv-theme' ),
    //   'items_list_navigation' => __( 'Qualifications list navigation', 'rmcc-cv-theme' ),
    //   'filter_items_list'     => __( 'Filter Qualifications list', 'rmcc-cv-theme' ),
    // );
    // $args_qua = array(
    //   'label'                 => __( 'Qualification', 'rmcc-cv-theme' ),
    //   'description'           => __( 'My Qualifications', 'rmcc-cv-theme' ),
    //   'labels'                => $labels_qua,
    //   'supports'              => array( 'title', 'editor' ),
    //   'hierarchical'          => false,
    //   'public'                => true,
    //   'show_ui'               => true,
    //   'show_in_menu'          => true,
    //   'menu_position'         => 25,
    //   'show_in_admin_bar'     => true,
    //   'show_in_nav_menus'     => false,
    //   'can_quaort'            => true,
    //   'has_archive'           => false, // do we want an archive?
    //   'exclude_from_search'   => true,
    //   'publicly_queryable'    => false, // do we want singular endpoints? see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
    //   'capability_type'       => 'page',
    //   'show_in_rest'          => false,
    // );
  	// register_post_type( 'qualification', $args_qua );
    // 
    // $labels_edu = array(
    //   'name'                  => _x( 'Education', 'Post Type General Name', 'rmcc-cv-theme' ),
    //   'singular_name'         => _x( 'Education item', 'Post Type Singular Name', 'rmcc-cv-theme' ),
    //   'menu_name'             => __( 'Education', 'rmcc-cv-theme' ),
    //   'name_admin_bar'        => __( 'Education', 'rmcc-cv-theme' ),
    //   'archives'              => __( 'Education Archives', 'rmcc-cv-theme' ),
    //   'attributes'            => __( 'Education Attributes', 'rmcc-cv-theme' ),
    //   'parent_item_colon'     => __( 'Parent Education item:', 'rmcc-cv-theme' ),
    //   'all_items'             => __( 'All Education items', 'rmcc-cv-theme' ),
    //   'add_new_item'          => __( 'Add New Education item', 'rmcc-cv-theme' ),
    //   'add_new'               => __( 'Add New Education item', 'rmcc-cv-theme' ),
    //   'new_item'              => __( 'New Education item', 'rmcc-cv-theme' ),
    //   'edit_item'             => __( 'Edit Education item', 'rmcc-cv-theme' ),
    //   'update_item'           => __( 'Update Education item', 'rmcc-cv-theme' ),
    //   'view_item'             => __( 'View Education item', 'rmcc-cv-theme' ),
    //   'view_items'            => __( 'View Education items', 'rmcc-cv-theme' ),
    //   'search_items'          => __( 'Search Education item items', 'rmcc-cv-theme' ),
    //   'not_found'             => __( 'Not found', 'rmcc-cv-theme' ),
    //   'not_found_in_trash'    => __( 'Not found in Trash', 'rmcc-cv-theme' ),
    //   'featured_image'        => __( 'Featured Image', 'rmcc-cv-theme' ),
    //   'set_featured_image'    => __( 'Set featured image', 'rmcc-cv-theme' ),
    //   'remove_featured_image' => __( 'Remove featured image', 'rmcc-cv-theme' ),
    //   'use_featured_image'    => __( 'Use as featured image', 'rmcc-cv-theme' ),
    //   'insert_into_item'      => __( 'Insert into item', 'rmcc-cv-theme' ),
    //   'uploaded_to_this_item' => __( 'Uploaded to this item', 'rmcc-cv-theme' ),
    //   'items_list'            => __( 'Education items list', 'rmcc-cv-theme' ),
    //   'items_list_navigation' => __( 'Education items list navigation', 'rmcc-cv-theme' ),
    //   'filter_items_list'     => __( 'Filter Education items list', 'rmcc-cv-theme' ),
    // );
    // $args_edu = array(
    //   'label'                 => __( 'Education', 'rmcc-cv-theme' ),
    //   'description'           => __( 'My Education', 'rmcc-cv-theme' ),
    //   'labels'                => $labels_edu,
    //   'supports'              => array( 'title', 'editor' ),
    //   'hierarchical'          => false,
    //   'public'                => true,
    //   'show_ui'               => true,
    //   'show_in_menu'          => true,
    //   'menu_position'         => 25,
    //   'show_in_admin_bar'     => true,
    //   'show_in_nav_menus'     => false,
    //   'can_quaort'            => true,
    //   'has_archive'           => false, // do we want an archive?
    //   'exclude_from_search'   => true,
    //   'publicly_queryable'    => false, // do we want singular endpoints? see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
    //   'capability_type'       => 'page',
    //   'show_in_rest'          => false,
    // );
  	// register_post_type( 'education', $args_edu );
    // 
    // $labels_lang = array(
    //   'name'                  => _x( 'Technology', 'Post Type General Name', 'rmcc-cv-theme' ),
    //   'singular_name'         => _x( 'Technology', 'Post Type Singular Name', 'rmcc-cv-theme' ),
    //   'menu_name'             => __( 'Technologies', 'rmcc-cv-theme' ),
    //   'name_admin_bar'        => __( 'Technologies', 'rmcc-cv-theme' ),
    //   'archives'              => __( 'Technologies', 'rmcc-cv-theme' ),
    //   'attributes'            => __( 'Technology Attributes', 'rmcc-cv-theme' ),
    //   'parent_item_colon'     => __( 'Parent Technology:', 'rmcc-cv-theme' ),
    //   'all_items'             => __( 'All Technologies', 'rmcc-cv-theme' ),
    //   'add_new_item'          => __( 'Add New Technology', 'rmcc-cv-theme' ),
    //   'add_new'               => __( 'Add New Technology', 'rmcc-cv-theme' ),
    //   'new_item'              => __( 'New Technology', 'rmcc-cv-theme' ),
    //   'edit_item'             => __( 'Edit Technology', 'rmcc-cv-theme' ),
    //   'update_item'           => __( 'Update Technology', 'rmcc-cv-theme' ),
    //   'view_item'             => __( 'View Technology', 'rmcc-cv-theme' ),
    //   'view_items'            => __( 'View Technologies', 'rmcc-cv-theme' ),
    //   'search_items'          => __( 'Search Technologies', 'rmcc-cv-theme' ),
    //   'not_found'             => __( 'Not found', 'rmcc-cv-theme' ),
    //   'not_found_in_trash'    => __( 'Not found in Trash', 'rmcc-cv-theme' ),
    //   'featured_image'        => __( 'Featured Image', 'rmcc-cv-theme' ),
    //   'set_featured_image'    => __( 'Set featured image', 'rmcc-cv-theme' ),
    //   'remove_featured_image' => __( 'Remove featured image', 'rmcc-cv-theme' ),
    //   'use_featured_image'    => __( 'Use as featured image', 'rmcc-cv-theme' ),
    //   'insert_into_item'      => __( 'Insert into item', 'rmcc-cv-theme' ),
    //   'uploaded_to_this_item' => __( 'Uploaded to this item', 'rmcc-cv-theme' ),
    //   'items_list'            => __( 'Technologies list', 'rmcc-cv-theme' ),
    //   'items_list_navigation' => __( 'Technologies list navigation', 'rmcc-cv-theme' ),
    //   'filter_items_list'     => __( 'Filter Technologies list', 'rmcc-cv-theme' ),
    // );
    // $args_lang = array(
    //   'label'                 => __( 'Technologies', 'rmcc-cv-theme' ),
    //   'description'           => __( 'Technology I like to use', 'rmcc-cv-theme' ),
    //   'labels'                => $labels_lang,
    //   'supports'              => array( 'title' ),
    //   'hierarchical'          => false,
    //   'public'                => true,
    //   'show_ui'               => true,
    //   'show_in_menu'          => true,
    //   'menu_position'         => 25,
    //   'show_in_admin_bar'     => true,
    //   'show_in_nav_menus'     => false,
    //   'can_quaort'            => true,
    //   'has_archive'           => false, // do we want an archive?
    //   'exclude_from_search'   => true,
    //   'publicly_queryable'    => false, // do we want singular endpoints? see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
    //   'capability_type'       => 'page',
    //   'show_in_rest'          => false,
    // );
    // register_post_type( 'language', $args_lang );
    // 
    // $labels_res = array(
    //   'name'                  => _x( 'Resource', 'Post Type General Name', 'rmcc-cv-theme' ),
    //   'singular_name'         => _x( 'Resource', 'Post Type Singular Name', 'rmcc-cv-theme' ),
    //   'menu_name'             => __( 'Resources', 'rmcc-cv-theme' ),
    //   'name_admin_bar'        => __( 'Resources', 'rmcc-cv-theme' ),
    //   'archives'              => __( 'Resources', 'rmcc-cv-theme' ),
    //   'attributes'            => __( 'Resource Attributes', 'rmcc-cv-theme' ),
    //   'parent_item_colon'     => __( 'Parent Resource:', 'rmcc-cv-theme' ),
    //   'all_items'             => __( 'All Resources', 'rmcc-cv-theme' ),
    //   'add_new_item'          => __( 'Add New Resource', 'rmcc-cv-theme' ),
    //   'add_new'               => __( 'Add New Resource', 'rmcc-cv-theme' ),
    //   'new_item'              => __( 'New Resource', 'rmcc-cv-theme' ),
    //   'edit_item'             => __( 'Edit Resource', 'rmcc-cv-theme' ),
    //   'update_item'           => __( 'Update Resource', 'rmcc-cv-theme' ),
    //   'view_item'             => __( 'View Resource', 'rmcc-cv-theme' ),
    //   'view_items'            => __( 'View Resources', 'rmcc-cv-theme' ),
    //   'search_items'          => __( 'Search Resources', 'rmcc-cv-theme' ),
    //   'not_found'             => __( 'Not found', 'rmcc-cv-theme' ),
    //   'not_found_in_trash'    => __( 'Not found in Trash', 'rmcc-cv-theme' ),
    //   'featured_image'        => __( 'Featured Image', 'rmcc-cv-theme' ),
    //   'set_featured_image'    => __( 'Set featured image', 'rmcc-cv-theme' ),
    //   'remove_featured_image' => __( 'Remove featured image', 'rmcc-cv-theme' ),
    //   'use_featured_image'    => __( 'Use as featured image', 'rmcc-cv-theme' ),
    //   'insert_into_item'      => __( 'Insert into item', 'rmcc-cv-theme' ),
    //   'uploaded_to_this_item' => __( 'Uploaded to this item', 'rmcc-cv-theme' ),
    //   'items_list'            => __( 'Resources list', 'rmcc-cv-theme' ),
    //   'items_list_navigation' => __( 'Resources list navigation', 'rmcc-cv-theme' ),
    //   'filter_items_list'     => __( 'Filter Resources list', 'rmcc-cv-theme' ),
    // );
    // $args_res = array(
    //   'label'                 => __( 'Resources', 'rmcc-cv-theme' ),
    //   'description'           => __( 'Resource I like to use', 'rmcc-cv-theme' ),
    //   'labels'                => $labels_res,
    //   'supports'              => array( 'title', 'editor' ),
    //   'hierarchical'          => false,
    //   'public'                => true,
    //   'show_ui'               => true,
    //   'show_in_menu'          => true,
    //   'menu_position'         => 25,
    //   'show_in_admin_bar'     => true,
    //   'show_in_nav_menus'     => false,
    //   'can_quaort'            => true,
    //   'has_archive'           => false, // do we want an archive?
    //   'exclude_from_search'   => true,
    //   'publicly_queryable'    => true, // do we want singular endpoints? see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
    //   'capability_type'       => 'page',
    //   'show_in_rest'          => false,
    // );
    // register_post_type( 'resource', $args_res );
    // 
    // $labels_por = array(
    //   'name'                  => _x( 'Portfolio', 'Post Type General Name', 'rmcc-cv-theme' ),
    //   'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'rmcc-cv-theme' ),
    //   'menu_name'             => __( 'Portfolio', 'rmcc-cv-theme' ),
    //   'name_admin_bar'        => __( 'Portfolio', 'rmcc-cv-theme' ),
    //   'archives'              => __( 'Portfolio', 'rmcc-cv-theme' ),
    //   'attributes'            => __( 'Project Attributes', 'rmcc-cv-theme' ),
    //   'parent_item_colon'     => __( 'Parent Project:', 'rmcc-cv-theme' ),
    //   'all_items'             => __( 'All Projects', 'rmcc-cv-theme' ),
    //   'add_new_item'          => __( 'Add New Project', 'rmcc-cv-theme' ),
    //   'add_new'               => __( 'Add New Project', 'rmcc-cv-theme' ),
    //   'new_item'              => __( 'New Project', 'rmcc-cv-theme' ),
    //   'edit_item'             => __( 'Edit Project', 'rmcc-cv-theme' ),
    //   'update_item'           => __( 'Update Project', 'rmcc-cv-theme' ),
    //   'view_item'             => __( 'View Project', 'rmcc-cv-theme' ),
    //   'view_items'            => __( 'View Portfolio', 'rmcc-cv-theme' ),
    //   'search_items'          => __( 'Search Portfolio', 'rmcc-cv-theme' ),
    //   'not_found'             => __( 'Not found', 'rmcc-cv-theme' ),
    //   'not_found_in_trash'    => __( 'Not found in Trash', 'rmcc-cv-theme' ),
    //   'featured_image'        => __( 'Featured Image', 'rmcc-cv-theme' ),
    //   'set_featured_image'    => __( 'Set featured image', 'rmcc-cv-theme' ),
    //   'remove_featured_image' => __( 'Remove featured image', 'rmcc-cv-theme' ),
    //   'use_featured_image'    => __( 'Use as featured image', 'rmcc-cv-theme' ),
    //   'insert_into_item'      => __( 'Insert into item', 'rmcc-cv-theme' ),
    //   'uploaded_to_this_item' => __( 'Uploaded to this item', 'rmcc-cv-theme' ),
    //   'items_list'            => __( 'Portfolio list', 'rmcc-cv-theme' ),
    //   'items_list_navigation' => __( 'Portfolio list navigation', 'rmcc-cv-theme' ),
    //   'filter_items_list'     => __( 'Filter Portfolio list', 'rmcc-cv-theme' ),
    // );
    // $args_por = array(
    //   'label'                 => __( 'Portfolio', 'rmcc-cv-theme' ),
    //   'description'           => __( 'My Portfolio of previous projects', 'rmcc-cv-theme' ),
    //   'labels'                => $labels_por,
    //   'supports'              => array( 'title', 'editor' ),
    //   'hierarchical'          => false,
    //   'public'                => true,
    //   'show_ui'               => true,
    //   'show_in_menu'          => true,
    //   'menu_position'         => 25,
    //   'show_in_admin_bar'     => true,
    //   'show_in_nav_menus'     => false,
    //   'can_quaort'            => true,
    //   'has_archive'           => false, // do we want an archive?
    //   'exclude_from_search'   => true,
    //   'publicly_queryable'    => false, // do we want singular endpoints? see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
    //   'capability_type'       => 'page',
    //   'show_in_rest'          => false,
    // );
    // register_post_type( 'portfolio', $args_por );
    
  }

  public function register_taxonomies()
  {
    // Register Taxonomies
  }

  public function register_widget_areas()
  {
    // Register widget areas
    if (function_exists('register_sidebar')) {
      register_sidebar(array(
        'name' => esc_html__('Sidebar Area', 'rmcc-cv-theme'),
        'id' => 'sidebar',
        'description' => esc_html__('Sidebar widget area; you can add multiple widgets here. Try the rmcc custom html widget with uikit markup.', 'rmcc-cv-theme'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3 class="uk-text-bold widget-title">',
        'after_title' => '</h3>'
      ));
      register_sidebar(array(
          'name' => esc_html__('Footer Area', 'rmcc-cv-theme'),
          'id' => 'sidebar-footer',
          'description' => esc_html__('Footer widget area; use only one widget here. Try the rmcc custom html widget with uikit markup.', 'rmcc-cv-theme'),
          'before_widget' => '',
          'after_widget' => '',
          'before_title' => '<h4 class="widget-title">',
          'after_title' => '</h4>'
      ));
      register_sidebar(array(
          'name' => esc_html__('Profile Section', 'rmcc-cv-theme'),
          'id' => 'sidebar-profile',
          'description' => esc_html__('Profile Section widget area; use only one widget here. Try the rmcc custom html widget with uikit markup.', 'rmcc-cv-theme'),
          'before_widget' => '',
          'after_widget' => '',
          'before_title' => '<h4 class="widget-title" hidden>',
          'after_title' => '</h4>'
      ));
    }
  }

  public function register_navigation_menus()
  {
    // This theme uses wp_nav_menu() in one locations.
    register_nav_menus(array(
      'main' => __('Main Menu', 'rmcc-cv-theme'),
      'mobile' => __('Mobile Menu', 'rmcc-cv-theme'),
    ));
  }

  public function add_to_context($context)
  {
    //add the site data to the context globally
    $context['site'] = $this;
    
    // optional args for Timber/Menu below. see options https://timber.github.io/docs/guides/menus/
    $main_menu_args = array(
      'depth' => 3,
    );
    // Initializing our menus
    $context['menu_main'] = new Timber\Menu('main');
    $context['menu_mobile'] = new Timber\Menu('mobile');
    // check for whether a menu exists
    $context['has_menu_main'] = has_nav_menu('main');
    $context['has_menu_mobile'] = has_nav_menu('mobile');

    // get the theme logo id
    $theme_logo_id = get_theme_mod('custom_logo');
    // get the theme logo url via the theme logo id
    $theme_logo_url = wp_get_attachment_image_url($theme_logo_id, 'full');
    // add theme logo url to the context
    $context['theme_logo_url'] = $theme_logo_url;

    // add sidebars to them context
    $context['sidebar_main']  = Timber::get_widgets('Sidebar Area');
    $context['sidebar_footer']   = Timber::get_widgets('Footer Area');
    $context['sidebar_profile']   = Timber::get_widgets('Profile Section');
    
    // $lang_posts_args = array(
    // 	'post_type' => 'language',
    // 	'posts_per_page'=>  -1,
    // );
    // $context['languages'] = new Timber\PostQuery( $lang_posts_args );

    return $context;
    
  }
  
  public function theme_supports()
  {
    // theme support for title tag
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('post-formats', array(
      'gallery',
      'quote',
      'video',
      'aside',
      'image',
      'link'
    ));
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('woocommerce');
    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    ));
    // Add support for core custom logo.
    add_theme_support('custom-logo', array(
      'height' => 30,
      'width' => 261,
      'flex-width' => true,
      'flex-height' => true
    ));
    
    // // remove emjoi styles & scripts
  	// remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
  	// remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); 
  	// remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
  	// remove_action( 'admin_print_styles', 'print_emoji_styles' );
    // // remove generator tag
    // remove_action('wp_head', 'wp_generator');
    // // remove manifest link
    // remove_action('wp_head', 'wlwmanifest_link');
    // remove_action('wp_head', 'rsd_link');
    // // Hide WP REST API links in page headers
    // remove_action( 'wp_head', 'rest_output_link_wp_head', 10);
    // remove_action( 'template_redirect', 'rest_output_link_header', 11);
    // // Remove dns-prefetch Link from WordPress Head (Frontend)
    // remove_action( 'wp_head', 'wp_resource_hints', 2 );

    load_theme_textdomain( 'rmcc-cv-theme', get_template_directory() . '/languages' );
  }
  
  public function rmcc_cv_theme_enqueue_assets()
  {
    wp_enqueue_style('rmcc-cv-theme-global-styles', get_template_directory_uri() . '/assets/css/base.css');
    wp_enqueue_script('rmcc-cv-theme-global-scripts', get_template_directory_uri() . '/assets/js/main/main.js', '', '', false);
    wp_enqueue_style('rmcc-cv-theme-styles', get_stylesheet_uri());
  }
  
  public function rmcc_cv_custom_uikit_widgets_init()
  {
    register_widget("Rmcc_CV_Theme_Custom_Widget_Class");
  }

  public function add_to_twig($twig)
  {
    /* this is where you can add your own functions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    return $twig;
  }
}

new RmccCvTheme();
