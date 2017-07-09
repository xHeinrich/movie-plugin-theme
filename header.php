<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage movies
 * @since movies 1.0
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Nathan Heinrich">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo get_bloginfo('template_directory'); ?>/favicon.ico">

    <title><?php echo get_bloginfo( 'name' ); ?></title>

    <?php wp_head();?>
  </head>

  <body>

    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top navbar-movies">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site-navigation" aria-expanded="true" aria-controls="navbar" >
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="col-xs-3">

          <a class="navbar-brand" href="<?php echo get_bloginfo( 'wpurl' );?>"><img src="<?php echo get_bloginfo('template_directory') . '/assets/images/logo.png'; ?>"/></a>
        </div>
      </div>
        <?php if ( has_nav_menu( 'primary' ) ) : ?>
          <nav id="site-navigation" class="navbar-collapse collapse" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'movies' ); ?>" style="height: 0px;">
            <?php
              wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'nav navbar-nav',
                'walker' => new Movies_Walker(),
               ) );
            ?>
          </nav><!-- .main-navigation -->
        <?php endif; ?>

      </div>
    </nav>

    <div class="container">
