<?php
if (is_shop()) {
    // Кастомная верстка для страницы магазина
    get_template_part('/templates/category/catalog');
} else {
    // Кастомная верстка для подкатегорий
    get_template_part('/templates/category/subcatalog');
}
?>