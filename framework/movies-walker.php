<?php
class Movies_Walker extends Walker_Nav_Menu {
    public $has_depth = false;

    function start_lvl(&$output, $depth = 0, $args = array()) {
      $output .= '<ul class="dropdown-menu">';
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
      $output .= '</ul>';
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id=0) {
      $class = "";
      $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
      $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
      $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
      $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
      if($depth == 0){
        $this->has_depth = false;
        $output .= '<li class="dropdown">';
        $output .= '<a {class} '. $attributes . '>' . esc_attr($item->title)  . '{caret}</a>';
      }else{
        $this->has_depth = true;
        $output .= '<li><a '. $attributes . '>' . esc_attr($item->title);
        $output .= "</a></li>\n";
      }
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id=0) {
      $output .= '</li>';
      if($this->has_depth){
        $output = str_replace('{class}', 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ', $output);
        $output = str_replace('{caret}', '<span class="caret"></span>', $output);
      }else{
        $output = str_replace('{class}', '', $output);
        $output = str_replace('{caret}', '', $output);

      }
    }
}
