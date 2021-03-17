<?php
/**
 * Theme functions & bits
 *
 * @package Rmcc_CV_Theme
 */
 
// add_filter( 'rest_authentication_errors', function( $result ) {
//  if ( ! empty( $result ) ) {
//    return $result;
//  }
//  if ( ! is_user_logged_in() ) {
//    return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
//  }
//  if ( ! current_user_can( 'administrator' ) ) {
//    return new WP_Error( 'rest_not_admin', 'You are not an administrator.', array( 'status' => 401 ) );
//  }
//  return $result;
// });
// 
// function crunchify_stop_loading_wp_embed_and_jquery() {
// 	if (!is_admin()) {
// 		wp_deregister_script('wp-embed');
// 	}
// }
// add_action('init', 'crunchify_stop_loading_wp_embed_and_jquery');

// removes sticky posts from main loop, this function fixes issue of duplicate posts on archive. see https://wordpress.stackexchange.com/questions/225015/sticky-post-from-page-2-and-on
add_action('pre_get_posts', function ($q)
{

  if ($q->is_home() && $q->is_main_query()) {

    // Remove sticky posts
    $q->set('ignore_sticky_posts', 1);
    // Get the sticky posts array
    $stickies = get_option('sticky_posts');
    // Make sure we have stickies before continuing, else, bail
    if (!$stickies) {
      return;
    }
    // Great, we have stickies, lets continue
    // Lets remove the stickies from the main query
    $q->set('post__not_in', $stickies);
    // Lets add the stickies to page one via the_posts filter
    if ($q->is_paged()) {
      return;
    }

    add_filter('the_posts', function ($posts, $q) use ($stickies) {

      // Make sure we only target the main query
      if (!$q->is_main_query()) {
        return $posts;
      }
      // Get the sticky posts
      $args = [
        'posts_per_page' => count($stickies),
        'post__in'       => $stickies
      ];
      $sticky_posts = get_posts($args);
      // Lets add the sticky posts in front of our normal posts
      $posts = array_merge($sticky_posts, $posts);

      return $posts;

    }, 10, 2);

  }

});

// stuff to say we need timber activated!! see TGM Plugin activation library
function cv_theme_register_required_plugins()
{
  $plugins = array(
    array(
      'name' => 'Timber',
      'slug' => 'timber-library',
      'required' => true
    )
  );
  $config  = array(
    'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
    'default_path' => '', // Default absolute path to bundled plugins.
    'menu' => 'tgmpa-install-plugins', // Menu slug.
    'parent_slug' => 'themes.php', // Parent menu slug.
    'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    'has_notices' => true, // Show admin notices or not.
    'dismissable' => true, // If false, a user cannot dismiss the nag message.
    'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false, // Automatically activate plugins after installation or not.
    'message' => '' // Message to output right before the plugins table.
  );
  tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'cv_theme_register_required_plugins');
