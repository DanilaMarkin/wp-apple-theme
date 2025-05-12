<div class="category-header">
    <p class="category-header__text">Выберите категорию</p>
    <div class="category-header__arrow">
        <button id="categoryCartLeft" class="category-header__arrow-btn left">
            <img
                src="<?= get_template_directory_uri(); ?>/assets/icons/arrow_icon.svg"
                class="category-header__arrow-btn-icon"
                width="32"
                height="32"
                title=""
                alt=""
                loading="lazy">
        </button>
        <button id="categoryCartRight" class="category-header__arrow-btn right">
            <img
                src="<?= get_template_directory_uri(); ?>/assets/icons/arrow_icon.svg"
                class="category-header__arrow-btn-icon"
                width="32"
                height="32"
                title=""
                alt=""
                loading="lazy">
        </button>
    </div>
</div>

<?php
// Получаем текущую категорию
$current_term = get_queried_object();

// Получаем все категории товаров (в том числе пустые)
$terms = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
]);

// Фильтруем только те, у которых display_type = 'subcategories'
$subcategories = array_filter($terms, function ($term) {
    return get_term_meta($term->term_id, 'display_type', true) === 'subcategories';
});
?>

<div id="categoryCart" class="swiper category-cart">
    <ul class="swiper-wrapper category-cart__list">
        <?php foreach ($subcategories as $term):
            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            // Проверяем, активна ли категория
            $is_active = (isset($current_term->term_id) && $term->term_id == $current_term->term_id);
        ?>
            <li class="swiper-slide category-cart__item <?= $is_active ? 'active' : ''; ?>">
                <?=
                wp_get_attachment_image($thumbnail_id, 'full', false, [
                    'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true),
                    'title' => get_the_title($thumbnail_id),
                    'class' => 'category-cart__item-image'
                ]);
                ?>
                <a href="<?= esc_url(get_term_link($term)); ?>" class="category-cart__item-link">
                    <h3 class="category-cart__item-link-title"><?= esc_html($term->name); ?></h3>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>