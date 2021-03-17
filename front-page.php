<?php
/**
 * The front page template (when backend settings for front page display are set to static or latest posts)
 *
 * @package Rmcc_CV_Theme
 */

$context = Timber::context();
$templates = array('front-page.twig');

// $ex_posts_args = array(
// 	'post_type' => 'experience',
// 	'posts_per_page'=>  -1,
// );
// $context['experiences'] = new Timber\PostQuery( $ex_posts_args );
// 
// $edu_posts_args = array(
// 	'post_type' => 'education',
// 	'posts_per_page'=>  -1,
// );
// $context['educations'] = new Timber\PostQuery( $edu_posts_args );
// 
// $tech_posts_args = array(
// 	'post_type' => 'resource',
// 	'posts_per_page'=>  -1,
// );
// $context['resources'] = new Timber\PostQuery( $tech_posts_args );
// 
// $qual_posts_args = array(
// 	'post_type' => 'qualification',
// 	'posts_per_page'=>  -1,
// );
// $context['qualifications'] = new Timber\PostQuery( $qual_posts_args );

$context['posts'] = new Timber\PostQuery();

Timber::render( $templates, $context );