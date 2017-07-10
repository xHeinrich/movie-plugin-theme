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
  <div class="row content">
       <div class="col-md-5">
            <img class="media-object img-responsive img-sm-center movie-poster" src="<?php echo get_post_meta( get_the_ID(), '_movies_image', true); ?>" />
            <div class="form-group">
                &nbsp;
            </div>
        </div>
        <div class="col-md-7 text-sm-center">
            <?php
            /**
             * output the base movie info including title, releasee date and genres
             */
            ?>
            <h3><?php the_title(); ?></h3>
            <h4><?php echo date('Y',get_post_meta( get_the_ID(), '_movies_release_date', true)) . '</br>'; ?></h4>
            <h4><?php
                      $terms = get_terms( array(
                            'taxonomy' => 'genre',
                            'hide_empty' => false,
                        ) );
                        $terms_list = array();
                        foreach($terms as $term){
                          array_push($terms_list,$term->name);
                        }
                        echo implode('/', $terms_list);
                        ?></small></h5>
              <row>
                <div class="col-md-6" style="padding-left: 0px;">
                  <h4>
                    Rating
                  </h4>
                </div>
                <div class="col-md-6">
                  <h4>
                  <?php echo get_post_meta( get_the_ID(), '_movies_rating', true) . '/10</br>'; ?>
                  </h4>
                </div>
              </row>
        </div>
          <div class="form-group">
              &nbsp;
          </div>
          <?php
          /** get actor and chracter information for the movie **/
          $characters = get_characters( implode(',', get_post_meta(get_the_ID(), '_movies_characters')));
          $actors = get_actors($characters);
          ?>
          <div class="col-md-6 text-sm-center">
              <h3 class="">Cast</h3>
                <?php foreach($actors->posts as $actor){
                  //actors portrait
                  $portrait = get_post_meta( $actor->ID, '_actors_image', true);
                  echo '<div class="col-md-12"><div class="col-md-3 ">';
                  echo '<img class="media-object img-responsive img-sm-center actor-img" src="' . $portrait . '"/>';
                  echo '</div>';
                  echo '<div class="col-md-6 col-md-push-3">';
                  echo '<p>' . get_post_meta($actor->ID, '_actors_name', true) . '</p>';
                  echo '<p>' . get_character_from_actor(get_the_id(), $actor->ID) . '</p>';
                  echo '</div></div>';
                }
                ?>

              </div>
          </div>
        <div class="form-group">
            &nbsp;
        </div>
        <div class="row content">
        <div class="col-md-12">
          <!-- related movies and cast -->
          <div class="row">
            <div class="col-md-12 text-sm-center">
              <h3>Synopsis</h3>
              <?php echo get_post_meta( get_the_ID(), '_movies_description', true) . '</br>'; ?>
            </div>
            <div class="form-group">
                &nbsp;
            </div>
            <div class="col-md-12 text-sm-center">
              <h3>Related Movies</h3>
              <?php
                  /**
                   * output 3 related movies
                   */
                  global $post;
                  //grab all taxonomies related to the post
                  $taxonomy_names = get_object_taxonomies( $post );
                  $category = $taxonomy_names[0];
                  $custom_terms = get_terms($category);
                  $current_post_id = get_the_ID();
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
                          if(get_the_id() == $current_post_id){
                            continue;
                          }
                          echo '
                          <a href="'.get_permalink().'" class="col-lg-3">
                            <div class="panel div-sm-center">
                               <div class="panel-heading text-sm-center"><strong>'. get_post_meta( get_the_ID(), '_movies_name', true) . '</strong></div>
                               <div class="panel-body">

                               <div class="boximg">
                                <img src="' . get_post_meta( get_the_ID(), '_movies_image', true) . '" class="img-responsive img-sm-center movie-list-img">
                             </div>
                            </div>
                         </a>';
                          endwhile;
                       }
                       return;
                  }
                  ?>
            </div>
          </div>
      </div>
    </div>
  </div>
 <?php the_content(); ?>
