//Global variables for page and movie info
var genre = jQuery()
jQuery(document).ready(function($) {
  $("#genres").select2();
  console.log("ready");
  $('#select_search').on('change', function() {
    $("#search_box").attr("placeholder", "Search by " + $('#select_search').val());
  });
  $( "#search_button" ).click(function() {
    console.log('search');
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
    console.log(value);
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
    console.log('postMovieInfo');
    console.dir(response);
    jQuery('#movies').html(displayMovieInfo(response));
    jQuery('#pagination').bootpag({ total: parseInt( JSON.parse(response).max_pages) , maxVisible: 10});
    console.log('________________________');
    console.dir(JSON.parse(response).max_pages);
  });
  console.log('getMovieInfo final');
}

function changePage(page)
{
}

function displayMovieInfo(movies)
{
  console.log('displayMovieInfo');
  var movieInfo = "";
  if(typeof JSON.parse(movies).movies == "undefined"){
    movieListNone();
  }
  jQuery.each( JSON.parse(movies).movies, function( k, v ) {
    console.log('testestsetset');
    console.dir(v);
    movieInfo = movieInfo + movieListTemplate(v);
  });
  console.log('displayMovieInfo final');
  console.log(movieInfo);
  return movieInfo;
}

function movieListNone()
{
  return '<a href="#" class="list-group-item"><div class="col-md-12 text-center vcenter"> Search for a movie</div></a>'
}

function movieStars(rating)
{
  var stars = "";
  for(var i = 0; i < 11; i++){
    if(i <= rating){
      stars = stars + '<span class="glyphicon glyphicon-star"></span>';
    }else{
      stars = stars + '<span class="glyphicon glyphicon-star-empty"></span>';
    }
  }
  return stars;
}

function movieListTemplate(movie)
{
  console.log('________________________________Movie_________________');
  console.dir(movie);
  console.log('___________________________END  Movie_________________');
  var date =  new Date(+movie.release_date + 1000*3600);
  console.dir(date.getMonth());
  console.dir(movie.release_date);
  return '<a href="' + movie.link + '" class="list-group-item">' +
        '<div class="media col-md-3">' +
            '<figure class="pull-left">' +
              '<div class="movie-list-img">' +
                '<img class="media-object img-responsive"  src="' + movie.image + '" alt="' + movie.image + '" >' +
              '</div>' +
            '</figure>' +
        '</div>' +
        '<div class="col-md-6">' +
          '<h4 class="list-group-item-heading">' + movie.name + '</h4>' +
          '<h6 class="list-group-item-heading">' + movie.release_date.month + ', ' + movie.release_date.year + '</h4>' +
            '<p class="list-group-item-text">' + movie.description + '</p>' +
        '</div>' +
        '<div class="col-md-3 text-center">' +
          '<button type="button" class="btn btn-default btn-md btn-block">View Details</button>' +
            '<h2 class="rating"> Rating </h2>' +
            '<div class="stars">' +
              movieStars(movie.rating) +
            '</div>'+
            '<p> Rated '+ movie.rating + ' <small> / </small> 10 </p>'+
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
