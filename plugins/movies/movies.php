<?php
/**
 * Plugin Name: Movie Plugin
 * Plugin URI:
 * Description: Create and view a movie database
 * Version: 1.0.0
 * Author: Nathan Heinrich
 * Author URI: http://www.halfinity.com
 * License: GPL2
 * Text Domain: movie-plugin
*/

define( 'MOVIE_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define( 'MOVIE_PLUGIN_URL', plugin_basename( __FILE__ ));

/* Install sample data */
function movie_plugin_install_data() {
  $movie = array(
      'id' => NULL,
      'order' => serialize($_POST['data']['Order']),
      'created' => current_time('mysql', 1),
      'user_id' => $current_user->ID
  );
  $wpdb->insert(ORDERS_TABLE, $data);
}

/**
 * register the movie post type
 * @return void
 */
function create_movie() {
    register_post_type( 'movie',
        array(
            'labels' => array(
                'name' => 'Movies',
                'singular_name' => 'Movie',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Movie',
                'edit' => 'Edit',
                'edit_item' => 'Edit Movie',
                'new_item' => 'New Movie',
                'view' => 'View',
                'view_item' => 'View Movie',
                'search_items' => 'Search Movie',
                'not_found' => 'No Movies found',
                'not_found_in_trash' => 'No Movies found in Trash',
                'parent' => 'Parent Movie'
            ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array('thumbnail', 'title'),
            'taxonomies' => array( 'genre' ),
            'menu_icon' => 'dashicons-format-video',//plugins_url(  ),
            'has_archive' => true
        )
    );
}

/**
 * Register the actor post type
 * @return void
 */
function create_actor() {
    register_post_type( 'actor',
        array(
            'labels' => array(
                'name' => 'Actors',
                'singular_name' => 'Actor',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Actor',
                'edit' => 'Edit',
                'edit_item' => 'Edit Actor',
                'new_item' => 'New Actor',
                'view' => 'View',
                'view_item' => 'View Actor',
                'search_items' => 'Search Actor',
                'not_found' => 'No Actors found',
                'not_found_in_trash' => 'No Actors found in Trash',
                'parent' => 'Parent Actor'
            ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array('thumbnail', 'title'),
            'taxonomies' => array( '' ),
            'menu_icon' => 'dashicons-groups',//plugins_url(  ),
            'has_archive' => true
        )
    );
}

/**
 * Register the character post type
 * @return Void
 */
function create_character() {
    register_post_type( 'character',
        array(
            'labels' => array(
                'name' => 'Characters',
                'singular_name' => 'Character',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Character',
                'edit' => 'Edit',
                'edit_item' => 'Edit Character',
                'new_item' => 'New Character',
                'view' => 'View',
                'view_item' => 'View Character',
                'search_items' => 'Search Character',
                'not_found' => 'No Characters found',
                'not_found_in_trash' => 'No Characters found in Trash',
                'parent' => 'Parent Character'
            ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array('thumbnail', 'title'),
            'taxonomies' => array( '' ),
            'menu_icon' => 'dashicons-smiley',//plugins_url(  ),
            'has_archive' => true
        )
    );
}

add_action( 'init', 'create_movie' );
add_action( 'init', 'create_actor' );
add_action( 'init', 'create_character' );

add_action( 'cmb2_admin_init', 'display_movie_meta_box' );
add_action( 'cmb2_admin_init', 'display_character_meta_box' );
add_action( 'cmb2_admin_init', 'display_actor_meta_box' );

/**
 * Display the actors metabox in the actors post
 * creation section in the admin panel
 * @return void
 */
function display_actor_meta_box() {
  $prefix = '_actors_';
  //initialize a new instance of cmb2
  $cmb = new_cmb2_box( array(
    'id'            => 'actor-meta-box',
    'title'         => __( 'Actor Information', 'cmb2' ),
    'object_types'  => array( 'actor' ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
  ) );

  //the actors name
  $cmb->add_field( array(
    'name'       => __( 'Name', 'cmb2' ),
    'desc'       => __( 'The name of the actor', 'cmb2' ),
    'id'         => $prefix . 'name',
    'type'       => 'text',
    'show_on_cb' => 'cmb2_hide_if_no_cats',
  ) );

  //Birth Date
  $cmb->add_field( array(
    'name' => esc_html__( 'Birth Date', 'cmb2' ),
    'desc' => esc_html__( 'Birth date of the actor', 'cmb2' ),
    'id'   => $prefix . 'birth_date',
    'type' => 'text_date',
  ) );

  //actor biography
  $cmb->add_field( array(
		'name' => esc_html__( 'Biography', 'cmb2' ),
		'desc' => esc_html__( 'Actors biography', 'cmb2' ),
		'id'   => $prefix . 'description',
		'type' => 'wysiwyg',
	) );

  //add a field for a picture of the actor
  $cmb->add_field( array(
		'name' => esc_html__( 'Actor picture', 'cmb2' ),
		'desc' => esc_html__( 'A picture of the actor', 'cmb2' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );

}

/**
 * display a metabox for character information in the character admin section
 * @return void
 */
function display_character_meta_box() {

  $prefix = '_characters_';
  //initialize a new instance of the cmb2 class
  $cmb = new_cmb2_box( array(
    'id'            => 'character-meta-box',
    'title'         => __( 'Character Information', 'cmb2' ),
    'object_types'  => array( 'character' ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
  ) );

  //create a text field for the characters name
  $cmb->add_field( array(
    'name'       => __( 'Name', 'cmb2' ),
    'desc'       => __( 'The name of the character', 'cmb2' ),
    'id'         => $prefix . 'name',
    'type'       => 'text',
    'show_on_cb' => 'cmb2_hide_if_no_cats',
  ) );

  //add a field for a picture of the character
  $cmb->add_field( array(
		'name' => esc_html__( 'Character poster', 'cmb2' ),
		'desc' => esc_html__( 'An image of the character', 'cmb2' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );

  // Add new field for related actors
  $cmb->add_field( array(
  	'name'        => __( 'Related Actors' ),
  	'id'          => $prefix . 'actors',
  	'type'        => 'post_search_text', // This field type
  	'post_type'   => 'actor',
  	'select_type' => 'checkbox',
  	'select_behavior' => 'replace',
  ) );

}

/**
 * Display the movies metabox in the admin panel
 * @return void
 */
function display_movie_meta_box() {
  /*
    :Name
    :Genre
    :Release Date
    :Associated ACTORS (and the name of the character they play)
    :Rating
    :Description
    :Image
  */
  $prefix = '_movies_';
  //initialize a new instance of cmb2
  $cmb = new_cmb2_box( array(
		'id'            => 'movie-meta-box',
		'title'         => __( 'Movie Information', 'cmb2' ),
		'object_types'  => array( 'movie', ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	) );

  // Name of the movie
  $cmb->add_field( array(
    'name'       => __( 'Name', 'cmb2' ),
    'desc'       => __( 'The name of the movie', 'cmb2' ),
    'id'         => $prefix . 'name',
    'type'       => 'text',
    'show_on_cb' => 'cmb2_hide_if_no_cats',
  ) );

  //Release Date
  $cmb->add_field( array(
    'name' => esc_html__( 'Release Date', 'cmb2' ),
    'desc' => esc_html__( 'The date the movie was released', 'cmb2' ),
    'id'   => $prefix . 'release_date',
    'type' => 'text_date',
  ) );


  //array with values of 0-10 for the rating
  $options = array();
  for($i = 0; $i < 11; $i++){
    $options[$i] = esc_html__( $i , 'cmb2');
  }

  //the rating of the movie
  $cmb->add_field( array(
    'name'             => esc_html__( 'Rating', 'cmb2' ),
    'desc'             => esc_html__( 'The movie rating', 'cmb2' ),
    'id'               => $prefix . 'rating',
    'type'             => 'select',
    'show_option_none' => true,
    'options'          => $options,
  ) );

  //a list of characters involved in the movie
  $cmb->add_field( array(
  	'name'        => __( 'Characters' ),
  	'id'          => $prefix . 'characters',
  	'type'        => 'post_search_text',
  	'post_type'   => 'character',
  	'select_type' => 'checkbox',
  	'select_behavior' => 'replace',
  ) );

  //movie description
  $cmb->add_field( array(
		'name' => esc_html__( 'Description', 'cmb2' ),
		'desc' => esc_html__( 'Movie Description', 'cmb2' ),
		'id'   => $prefix . 'description',
		'type' => 'wysiwyg',
	) );

  //the movie poster to display
  $cmb->add_field( array(
		'name' => esc_html__( 'Movie poster', 'cmb2' ),
		'desc' => esc_html__( 'The official movie poster', 'cmb2' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );
}

add_action( 'init', 'create_genres_taxonomy' );

/**
 * Register a taxonomy to the movie section called genre
 * @return void
 */
function create_genres_taxonomy() {
    $labels = array(
      'name'                           => 'Genres',
      'singular_name'                  => 'Genre',
      'search_items'                   => 'Search Genres',
      'all_items'                      => 'All Genres',
      'edit_item'                      => 'Edit Genre',
      'update_item'                    => 'Update Genre',
      'add_new_item'                   => 'Add New Genre',
      'new_item_name'                  => 'New Genre Name',
      'menu_name'                      => 'Genre',
      'view_item'                      => 'View Genre',
      'popular_items'                  => 'Popular Genre',
      'separate_items_with_commas'     => 'Separate genres with commas',
      'add_or_remove_items'            => 'Add or remove genres',
      'choose_from_most_used'          => 'Choose from the most used genres',
      'not_found'                      => 'No genres found'
  );
	register_taxonomy(
		'genre',
		'movie',
		array(
			'hierarchical' => true,
      'labels' => $labels,
		)
	);
}

/**
 * Get a character name from an actor post id
 * @param  integer $movie_id The id of the movie you want to get the character
 * information for for a specific actor
 * @param  integer $actor_id The actor which is playing the character
 * @return string           The characters name that the actor is playing
 */
function get_character_from_actor($movie_id, $actor_id)
{
  $posts = get_post_meta($movie_id, '_movies_characters', true);
  $characters = get_characters($posts);
  foreach($characters->posts as $character){
    $actors = get_post_meta($character->ID, '_characters_actors', true);
    $actors = explode(',', $actors);
    if(in_array($actor_id, $actors)){
      return get_post_meta($character->ID, '_characters_name', true);
    }
  }
}

/**
 * Get movies within a search criterion
 * @param  string  $genre    A genre of movie e.g action
 * @param  string  $order_by A field to order the search by
 * @param  string  $order    Asc or Desc order
 * @param  integer $page     The current page being viewed
 * @param  string  $query    A query string to search the post by
 * @return WP_Query          A WP_Query object containing the resulting output
 */
function get_movies($genre, $order_by, $order, $page = 1, $query = '')
{
  $args = array(
      'post_type' => 'movie',
      's' => $query,
      'order'   => $order,
      'orderby' => $order_by,
      'posts_per_page' => 1,
      'paged' => $page,
      'tax_query' => array(
          array(
              'taxonomy' => 'genre',
              'field'    => 'slug',
              'terms'    => $genre,
          ),
      ),
  );
  if($order_by != ""){
    //$args['orderby'] = 'meta_value';
    //$args['meta_key'] = $order_by;
  }
  $query = new WP_Query( $args);
  return $query;
}

/**
 * Find actors given a certain post id
 * @param  String/WP_Query $posts A characters WP_Query object or string of
 * post ids
 * @return WP_Query        The resulting WP_Query object
 */
function get_actors($posts)
{
  //if the post info is a string of post ids
  if(is_string($posts)){
    $posts = explode(',', $posts);
    $args = array(
      'post_type' => 'actor',
      'post__in' => $posts
    );
    $query = new WP_Query( $args);
    return $query;
  //otherwise its a wp_query object
  }else{
    $posts = explode(',', get_post_meta($posts->post->ID, '_characters_actors', true));// {_characters_actors});
    $args = array(
      'post_type' => 'actor',
      'post__in' => $posts
    );
    $query = new WP_Query( $args);
    return $query;
  }
}

/**
 * Find characters given a string of post ids
 * @param  String $posts A string of post ids joined by a comma
 * @return WP_Query        The resulting WP_Query object
 */
function get_characters($posts)
{
  if(is_string($posts) || is_int($posts)){
    $posts = explode(',', $posts);
    $args = array(
      'post_type' => 'character',
      'post__in' => $posts
    );
    $query = new WP_Query( $args);
    return $query;
  }else{
    return "Error getting characters";
  }
}

/* AJAX REQUEST FOR BOTH LOGGED IN AND NON LOGGED IN USERS */
add_action( 'wp_ajax_grab_movies_list', 'grab_movies_list' );
add_action( 'wp_ajax_nopriv_grab_movies_list', 'grab_movies_list' );

/**
 * Process and return a JSON object containing a list of movies given post data
 * to filter through results
 * @return String Json encoded string containing a movie list
 */
function grab_movies_list() {
  global $wpdb;

  //post data from the client
  $filter_by = $_POST['filterBy'];
  $genre = implode(',', $_POST['genre']);
  $order_by = $_POST['orderBy'];
  $order = $_POST['order'];
  $page = $_POST['page'];
  $query = $_POST['query'];
  $return_data = array();

  switch($order_by){
    case "name";
      $order_by = "_movies_name";
      break;
    case "release_date";
      $order_by = "_movies_release_date";
      break;
    case "rating";
      $order_by = "_movies_rating";
      break;
    default:
      $order_by = "";
      break;
  }

  if(empty($genre) || empty($order_by) || empty($order) || empty($page)){
    return "Missing post information";
  }
  // setup inital query and execute it
  $query = "";

  if($filter_by == "title"){
    $query = get_movies($genre, $order_by, $order, $page, $query);
  }elseif( $filter_by == "actor"){
    //TODO: filter by actor name
    return "0";
    wp_die();
  }
  $return_data['max_pages'] = $query->max_num_pages;
  $return_data['movies'] = array();
  foreach($query->posts as $post){
    //create the array to encode into json
    $data = array(
      'id' => $post->ID,
      'name' => $post->{_movies_name},
      'link' => get_permalink($post->ID),
      'release_date' => array(
        'year' => date('Y', strtotime($post->{_movies_release_date})),
        'month' => date('M', strtotime($post->{_movies_release_date})),
        'day' => date('d', strtotime($post->{_movies_release_date})),
        'raw' => strtotime($post->{_movies_release_date})
      ),
      'characters' => $post->{_movies_characters},
      'actors' => json_encode(get_actors(get_characters($post->{_movies_characters}))->posts),
      'rating' => $post->{_movies_rating},
      'description' => substr(strip_tags($post->{_movies_description}), 0, 400) . '...',
      'image' => $post->{_movies_image},
    );
    array_push($return_data['movies'], $data);
  }
  echo json_encode($return_data);
  wp_die(); // this is required to terminate immediately and return a proper response
}
