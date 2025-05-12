<?php
// Темы для страниц разбитые под папки для страниц
add_filter('theme_page_templates', function ($templates) {
    $templates['templates/pages/warranty.php'] = 'Гарантии';
    $templates['templates/pages/contacts.php'] = 'Контакты';
    $templates['templates/pages/delivery-and-payment.php'] = 'Доставка и оплата';
    $templates['templates/category/catalog.php'] = 'Каталог';
    $templates['woocommerce/cart.php'] = 'Корзина';

    return $templates;
});
