<?php

/**
 * The template for displaying the header.
 */

?><!DOCTYPE html>
<!--[if IE 9]>
<html class="<?php html_class( 'is-ie is-ie-9' ); ?>" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 9) ]><!-->
<html class="<?php html_class(); ?>" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <title><?php trim(wp_title('')); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta charset="<?php bloginfo( 'charset' ); ?>" />

  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
  
  <?php get_template_part( 'template-parts/wrapper/start' ); ?>    
