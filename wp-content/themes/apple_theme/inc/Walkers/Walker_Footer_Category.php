<?php
class Custom_Walker_Footer_Category  extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if ($depth === 0) {
            $output .= '<li class="footer-categorys__item">';
            $output .= '<a href="' . esc_url($item->url) . '" class="footer-categorys__item-link"  title="Перейти к категории ' . esc_attr($item->title) . '">';
            $output .= esc_html($item->title);
            $output .= '</a>';
            $output .= '</li>';
        }
    }
}
