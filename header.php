<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package groundwork
 */
?><!DOCTYPE html>

<?php

/*	So here's what we need to do.
	
	Groundwork Parent should have NOTHING site-specific about it. Currently, it contains
	_SETUP. That's a problem. My goal here is to move _SETUP into the child theme. But
	the parent theme needs to know where _SETUP is.

	So: Grab the path to the currently active child theme. I've just proven that I can have
	different WP sites share Groundwork Parent, but have different child themes active. This
	is fucking marvelous.

*/
	
$child_path = get_stylesheet_directory();
include($child_path."/_SETUP.php");


	/*	Build the class for whatever page we're on */
	
	function theSlug() {
		if(SITE__CUSTOM_CLASS_FOR_EACH_PAGE) {
			if ( is_home() ) {
				$theSlug = false;
			}
			else {
				global $post;
				$theSlug = get_post( $post )->post_name;
				if ( is_page() ) {
					$theSlug = "page--".$theSlug;
				} else {
					$theSlug = "post--".$theSlug;
				}
				return $theSlug;
			}
		}
	}

	global $wp_query;
	$postid = $wp_query->post->ID;
	$customFieldClasses = get_post_meta($postid, "htmlClasses", true);
	wp_reset_query();
	
	
	/*	Do the following:
		 - Find out what Wordpress function generates a path
		 	to the main Groundwork theme
		 - Set this up as the groundwork_path variable
		 - Get the custom class toggle working.
	
	*/
	
	// include($groundwork_path."/add-ons/customPostClass.php");
	

?>

<html <?php language_attributes(); ?> <?php body_class("no-js ".$customFieldClasses." ".theSlug()); ?> <body>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">				
				
		<!-- webtype goes here -->
		<?php echo get_post_meta($post->ID, "webtype", true); ?>


		<!--[if (gte IE 8)&(lt IE 9)]><link href="<?php echo get_template_directory_uri(); ?>/assets/css/ie8.css" rel="stylesheet"/><![endif]-->
		<!--[if (gte IE 9)|(lt IE 8)]><!-->
			<link href="<?php echo get_template_directory_uri(); ?>/assets/css/site.css" rel="stylesheet" />

		<!--<![endif]-->

		<?php wp_head(); ?>
		
		<?php
			if ( (is_single()) || (is_page()) ) {
				if(get_post_meta($post->ID, 'hasCustomStyling', true)==true) {
					echo '<link href="'.content_url().'/post_themes/'.get_the_date("Ymd", $post->ID ).'_'.theSlug().'/style.css" rel="stylesheet" />';
				}
			}
		?>
		
		<!-- custom post CSS file goes here -->
		
	</head>
	
	<body>
		<?php
			include(INCLUDE_PATH."googleanalytics.php");
		?>
		<div class="u-lPageContent hfeed site">

		<?php if(SITE__HAS_NAVIGATION) { ?>
				<a class="ac-hiddenVisually ac-skipLink" href="#targetnavigation">skip to navigation (press enter key)</a>
				<a class="ac-NavAnchor ac-NavAnchor--menu icomoon" href="#navigation">Menu</a>
		<?php } ?>

			<div class="u-lHeader" role="banner">
				<header>
					<div class="u-Masthead">
						<h1 class="u-Masthead__siteTitle">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

							<?php if(HEADER__USE_LOGO) { ?>
								<img src="<?php echo HEADER__USE_LOGO; ?>" />
							<?php } ?>

							<?php if(HEADER__USE_INCLUDE != "") { 
								include(HEADER__USE_INCLUDE);
							} ?>

							<b class="u-Masthead__siteTitle__text"><?php bloginfo( 'name' ); ?></b></a>
						</h1>
						
						<?php if(SITE__SHOW_SITEDESC) { ?>
						<h2 class="u-Masthead__siteDesc"><?php bloginfo( 'description' ); ?></h2>
						<?php } ?>
					</div>
				</header>
			</div><!-- #masthead -->
	
		
			<div class="u-lMain" role="main">