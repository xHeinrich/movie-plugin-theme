//Global variables for page and movie info
var genre = jQuery()
jQuery(document).ready(function($) {
  //initialize select2 box
  $("#genres").select2();
  //change in the search box based on what you are looking for
  $('#select_search').on('change', function() {
    $("#search_box").attr("placeholder", "Search by " + $('#select_search').val());
  });
  //on button click search for your query with the selected parameters
  $( "#search_button" ).click(function() {
    getMovieInfo(1);
  });
  jQuery('#pagination').bootpag({
      total: 1
  }).on('page', function(event, num){
    getMovieInfo(num);
  });
  $( "select" ).change(function(){
    var value = $("#genres").select2("val");
  });
  //grab default movie info to start with
  getMovieInfo(1);
});

/**
 * Grab movie information from the wordpress ajax/JSON api
 * @param  integer The page we want to grab from wordpress
 * @return void
 */
function getMovieInfo(page)
{
  var data = {
    'action': 'grab_movies_list',
    'page' : page,
    'genre' : jQuery("#genres").select2("val"),
    'orderBy' : jQuery("#select_orderBy").val(),
    'order' : jQuery("#select_order").val(),
    'query': jQuery("#search_box").val(),
    'filterBy': jQuery("#filterBy").val()
  };

  jQuery.post('/wp-admin/admin-ajax.php', data, function(response) {
    jQuery('#movies').html(displayMovieInfo(response));
    jQuery('#pagination').bootpag({ total: parseInt( JSON.parse(response).max_pages) , maxVisible: 10});
  });
}

/**
 * [displayMovieInfo description]
 * @param  Movie movies Movies json objet
 * @return string       String of html to display movie info
 */
function displayMovieInfo(movies)
{
  var movieInfo = "";
  if(typeof JSON.parse(movies).movies == "undefined"){
    jQuery('#movies').html(movieListNone());
  }
  jQuery.each( JSON.parse(movies).movies, function( k, v ) {
    movieInfo = movieInfo + movieListTemplate(v);
  });
  return movieInfo;
}

/**
 * Disaply could not find any movies if no movies are found
 * @return void
 */
function movieListNone()
{
  return '<a href="#" class="list-group-item"><div class="col-md-12 text-center vcenter"> Could not find any movies</div></a>'
}

/**
 * Display the correct number of stars for a movie
 * @param  int rating Rating of the movie out of 10
 * @return string       Html containing the output of the stars
 */
function movieStars(rating)
{
  var stars = "";
  for(var i = 0; i < 10; i++){
    if(i == 5)
    {
      //empty text
      stars = stars + '<span>&nbsp;</span>';
    }
    if(i <= rating -1){
      stars = stars + '<span class="glyphicon glyphicon-star"></span>';
    }else{
      stars = stars + '<span class="glyphicon glyphicon-star-empty"></span>';
    }
  }
  return stars;
}

/**
 * Render the movie list tempalte
 * @param  array movie Json object containing a single movie
 * @return string       A single movie listing
 */
function movieListTemplate(movie)
{
  return '<a href="' + movie.link + '" class="list-group-item">' +
        '<div class="media col-md-2">' +
            '<figure class="pull-left">' +
              '<div class="movie-list-img">' +
                '<img class="media-object img-responsive"  src="' + movie.image + '" alt="' + movie.image + '" >' +
              '</div>' +
            '</figure>' +
        '</div>' +
        '<div class="col-md-6">' +
          '<h4 class="list-group-item-heading bold-thick italic">' + movie.name + '</h4>' +
          '<h6 class="list-group-item-heading bold-thick italic">' + movie.release_date.month + ', ' + movie.release_date.year + '</h4>' +
            '<p class="list-group-item-text">' + movie.description + '</p>' +
        '</div>' +
        '<div class="col-md-4 text-center">' +
            '<h2 class="rating"> Rating </h2>' +
            '<div class="stars">' +
              movieStars(movie.rating) +
            '</div>'+
            '<p>'+ movie.rating + '<small> / </small> 10 </p>'+
            '<button type="button" class="btn btn-default btn-md btn-block">View Details</button>' +
        '</div>'+
  '</a>';
}

/**
 * render the pagination for a specific page
 * @param  int max_pages Max pages for the query
 * @param  int page      Current page for the query
 * @return void
 */
function movieListPagination(max_pages, page)
{
  // init bootpag
    $('#pagination').bootpag({
        total: max_pages
    }).on("page", function(event, page){
         $("#content").html("Insert content"); // some ajax content loading...
    });
}
