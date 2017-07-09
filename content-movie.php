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
  <div class="row">
       <div class="col-md-5 push-md-1">
            <img style="media-object img-responsive" src="<?php echo get_post_meta( get_the_ID(), '_movies_image', true); ?>" />
            <div class="form-group">
                &nbsp;
            </div>
        </div>
        <div class="col-md-6">
            <h3><?php the_title(); ?></h3>
            <h4><?php
                      echo get_post_meta( get_the_ID(), '_movies_release_date', true) . '</br>';
                      $terms = get_terms( array(
                            'taxonomy' => 'genre',
                            'hide_empty' => false,
                        ) );
                        $terms_list = array();
                        foreach($terms as $term){
                          array_push($terms_list,$term->name);// $term->slug . '" selected="selected">' . $term->name . '(' . $term->count . ')</option>';
                        }
                        echo implode('/', $terms_list);
                        ?></small></h5>
              <row>
                <div class="col-md-6" style="padding-left: 0px;">
                  Rating
                </div>
                <div class="col-md-6">
                  <?php echo get_post_meta( get_the_ID(), '_movies_rating', true) . '/10</br>'; ?>
                </div>
              </row>
        </div>
        <div class="form-group">
            &nbsp;
        </div>
        <div class="col-md-12">
          <!-- related movies and cast -->
          <row>
            <?php
            //echo json_encode(get_post_meta(get_the_ID(), '_movies_characters'));
            $characters = get_characters( implode(',', get_post_meta(get_the_ID(), '_movies_characters')));
            $actors = get_actors($characters);
            //die(json_encode($actors->post));
            ?>
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
              <row>
                <h3>Cast</h3>
                <div class="col-md-3 col-push-md3">
                  <?php foreach($actors->posts as $actor){
                    //actors portrait
                    $portrait = get_post_meta( $actor->ID, '_actors_image', true);
                    echo '<img class="media-object img-responsive img-circle" src="' . $portrait . '"/>';
                  }
                  ?>
                </div>
                <div class="col-md-6">
                  <?php
                  /**
                    * Output all actors names and related role
                  */
                  foreach($actors->posts as $actor){
                    $name = get_post_meta( $actor->ID, '_actors_name', true);
                    echo '<p>' . $name . '</p>';
                    echo '<p>' . get_character_from_actor(get_the_id(), $actor->ID) . '</p>';

                  }
                  ?>
                </div>
              </row>
            </div>
          </row>
          <row>
            <div class="col-md-12">
              <?php
              /** output 3 related movies **/
                  //for use in the loop, list 5 post titles related to first tag on current post
                  global $post;

                  $taxonomy_names = get_object_taxonomies( $post );
                  $category = $taxonomy_names[0];
                  $custom_terms = get_terms($category);
                  foreach($custom_terms as $custom_term) {
                      wp_reset_query();
                      $args = array(
                          'post_type' => 'movie',
                          'posts_per_page' => 4,
                          'post__not_in' => array(
                            explode(',', $post->ID)
                          ),
                          'tax_query' => array(
                              array(
                                  'taxonomy' => 'genre',
                                  'field' => 'slug',
                                  'terms' => $custom_term->slug,
                              ),
                          ),
                       );

                       $loop = new WP_Query($args);

                       if($loop->have_posts()) {

                          while($loop->have_posts()) : $loop->the_post();
                          echo '
                          <a href="'.get_permalink().'" class="col-lg-3">
                            <div class="panel">
                               <div class="panel-heading"><strong>'. get_post_meta( get_the_ID(), '_movies_name', true) . '</strong></div>
                               <div class="panel-body">

                               <div class="boximg">
                                <img src="' . get_post_meta( get_the_ID(), '_movies_image', true) . '" class="img-responsive">
                                <span class="label label-danger date">'. get_post_meta( get_the_ID(), '_movies_name', true) .'</span>
                             </div>
                            </div>
                         </a>';
                          endwhile;
                       }
                  }
                  ?>
            </div>
          </row>
          <row>
            <div class="col-md-12">
              <h3>Synopsis</h3>
              <?php echo get_post_meta( get_the_ID(), '_movies_description', true) . '</br>'; ?>
            </div>
          </row>
        </div>
    </div>

 <?php the_content(); ?>

</div><!-- /.blog-post -->
