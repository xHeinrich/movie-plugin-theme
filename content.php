<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage movies
 * @since movies 1.0
 */
?>
<div class="movie-post">
	<h2 class="movie-post-title"><?php the_title(); ?></h2>
	<p class="movie-post-meta"><?php the_date(); ?> by <a href="#"><?php the_author(); ?></a></p>

 <?php the_content(); ?>

</div><!-- /.blog-post -->
