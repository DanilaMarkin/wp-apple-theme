<?php
class Custom_Walker_Footer_Menu  extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if ($depth === 0) {
            $output .= '<li class="footer-pages__item">';
            $output .= '<a href="' . esc_url($item->url) . '" class="footer-pages__item-link"  title="Перейти на страницу ' . esc_attr($item->title) . '">';
            $output .= esc_html($item->title);
            $output .= '</a>';
            $output .= '</li>';
        }
    }
}
