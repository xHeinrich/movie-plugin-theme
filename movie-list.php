<?php /* Template Name: movie-list */ ?>
<?php
get_header(); ?>
<div class="row">
  <div class="row" id="search_bar">
  <div class="col-md-12">
          <div class="input-group" id="adv-search">
              <input type="text" class="form-control" id="search_box" name="query" placeholder="Search for Movie" />
              <div class="input-group-btn">
                  <div class="btn-group" role="group">
                      <div class="dropdown dropdown-lg">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                          <div class="dropdown-menu dropdown-menu-right" role="menu">
                              <form class="form-horizontal" role="form">
                                <div class="form-group">
                                  <label for="filter">Filter by</label>
                                  <select class="form-control" name="filterBy" id="filterBy">
                                      <option value="title">Movie Name</option>
                                      <option value="actor">Actor</option>
                                  </select>
                                </div>
                              </form>
                              <form class="form-horizontal" role="form">
                                <div class="form-group">
                                  <label for="genres">Genre Filter</label>
                                </br>
                                  <select class="form-control" name="genres[]" multiple="multiple" id="genres">
                                    <?php
                                      $terms = get_terms( array(
                                          'taxonomy' => 'genre',
                                          'hide_empty' => false,
                                      ) );
                                      foreach($terms as $term){
                                        echo '<option value="' . $term->slug . '" selected="selected">' . $term->name . '(' . $term->count . ')</option>';
                                      }
                                    ?>
                                  </select>
                                </div>
                              </form>
                              <form class="form-horizontal" role="form">
                                <div class="form-group">
                                  <label for="filter">Order by</label>
                                  <select class="form-control" name="orderBy" id="select_orderBy">
                                      <option value="name">Name</option>
                                      <option value="release_date">Release Date</option>
                                      <option value="rating">Rating</option>
                                  </select>
                                </div>
                              </form>
                              <form class="form-horizontal" role="form">
                                <div class="form-group">
                                  <label for="filter">Order</label>
                                  <select class="form-control" name="order" id="select_order">
                                      <option value="ASC">Ascending</option>
                                      <option value="DESC">Descending</option>
                                  </select>
                                </div>
                              </form>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary" id="search_button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>
<div class="row">
  <div class="well movies">
    <div class="list-group" id="movies">

     </div>
     <div class="" id="pagination">

     </div>
   </div>
</div>

<?php get_footer(); ?>
