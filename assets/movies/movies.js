//Global variables for page and movie info
var genre = jQuery()
jQuery(document).ready(function($) {
  $("#genres").select2();
  $('#select_search').on('change', function() {
    $("#search_box").attr("placeholder", "Search by " + $('#select_search').val());
  });
  $( "#search_button" ).click(function() {
    getMovieInfo(1);
  });
  jQuery('#pagination').bootpag({
      total: 1
  }).on('page', function(event, num){
    getMovieInfo(num);
  });
  $('#movies').html(movieListNone);
  $( "select" ).change(function(){
    var value = $("#genres").select2("val");
  });
  getMovieInfo(1);
});

function getMovieInfo(page)
{
  console.log('getMovieInfo');
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

function displayMovieInfo(movies)
{
  var movieInfo = "";
  if(typeof JSON.parse(movies).movies == "undefined"){
    movieListNone();
  }
  jQuery.each( JSON.parse(movies).movies, function( k, v ) {
    movieInfo = movieInfo + movieListTemplate(v);
  });
  return movieInfo;
}

function movieListNone()
{
  return '<a href="#" class="list-group-item"><div class="col-md-12 text-center vcenter"> Search for a movie</div></a>'
}

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

function movieListPagination(max_pages, page)
{
  // init bootpag
    $('#pagination').bootpag({
        total: max_pages
    }).on("page", function(event, page){
         $("#content").html("Insert content"); // some ajax content loading...
    });
}
