<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage movies
 * @since movies 1.0
 */
get_header(); ?>
<div class="row">
	<div class="col-sm-8 blog-main">
    <?php
      //if there are posts, while there are posts output the post
      if ( have_posts() ) : while ( have_posts() ) : the_post();
        get_template_part( 'content', get_post_format() );
      endwhile;
			?>
			<nav>
				<ul class="pager">
					<li><?php next_posts_link( 'Previous' ); ?></li>
					<li><?php previous_posts_link( 'Next' ); ?></li>
				</ul>
			</nav>
		<?php
		endif;
    ?>
	</div> <!-- /.blog-main -->
  <?php get_sidebar(); ?>
</div> 	<!-- /.row -->
<?php get_footer(); ?>
