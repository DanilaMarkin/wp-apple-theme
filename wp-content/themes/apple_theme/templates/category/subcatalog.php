<?php
// Шапка сайта
custom_header();
// Хлебные крошки
rank_math_the_breadcrumbs();

$current_category = get_queried_object();
?>

<main class="subcatalog container">
    <h1 class="pages__title"><?= single_term_title(); ?></h1>
    <section class="catalog-block_slider">
        <?= get_template_part('/components/Sliders/Category'); ?>
    </section>

    <?php
    // Получаем подкатегории родительской категории
    $parent_category_id = $current_category->parent ? $current_category->parent : $current_category->term_id;

    $child_terms = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false, // показываем даже пустые категории
        'parent' => $parent_category_id, // подкатегории родительской категории
    ]);
    ?>
    <section class="subcatalog-wrapper">
        <div class="subcatalog-pages">
            <ul class="subcatalog-pages__list">
                <?php foreach ($child_terms as $term) {
                    // Получаем ссылку на текущую подкатегорию
                    $term_link = esc_url(get_term_link($term));
                    // Проверяем, совпадает ли ссылка подкатегории с текущей страницей
                    $is_active = (get_queried_object_id() == $term->term_id);
                ?>
                    <li class="subcatalog-pages__item <?php echo $is_active ? 'active' : ''; ?>">
                        <a href="<?= $term_link; ?>" title="Перейти к категории <?= esc_html($term->name); ?>"><?= esc_html($term->name); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <?php
        // Аргументы для WP_Query
        $args = [
            'post_type' => 'product', // Товары в WooCommerce
            'posts_per_page' => -1, // Количество товаров, можно указать конкретное число
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $current_category->term_id, // Текущая категория
                    'operator' => 'IN',
                ],
            ],
        ];

        // Создаем новый запрос
        $query = new WP_Query($args);

        // Проверяем, есть ли товары
        if ($query->have_posts()) {
        ?>
            <div class="subcatalog-cart">
                <ul class="subcatalog-cart__list">
                    <?php
                    while ($query->have_posts()) : $query->the_post();
                        // Получаем объект товара
                        $product = wc_get_product(get_the_ID());

                        if ($product) {
                            global $product;
                    ?>
                            <li class="subcatalog-cart__item" data-id="<?= $product->get_id(); ?>">
                                <!-- slider image -->
                                <div class="subcatalog-cart__item-sliders">
                                    <div id="subcatalogImgesCart-<?= $product->get_id(); ?>" class="swiper" role="list" aria-label="Галерея товара">
                                        <div class="swiper-wrapper subcatalog-cart__item-sliders-wrapper">
                                            <!-- gallery images -->
                                            <?php
                                            // Массив ID изображений галереи
                                            $attachment_ids = $product->get_gallery_attachment_ids();
                                            foreach ($attachment_ids as $attachment_id) {
                                            ?>
                                                <figure class="swiper-slide subcatalog-cart__item-slider" role="listitem">
                                                    <?=
                                                    wp_get_attachment_image($attachment_id, 'medium', false, [
                                                        'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
                                                        'title' => get_the_title($attachment_id),
                                                        'class' => "swiper-slide subcatalog-cart__item-slider-image",
                                                        'data-image-id' => $attachment_id,
                                                    ]);
                                                    ?>
                                                </figure>
                                            <?php } ?>
                                            <!-- gallery images -->
                                        </div>
                                    </div>

                                    <!-- arrow btns for slider -->
                                    <button id="subcatalogBtnLeft-<?= $product->get_id(); ?>" class="subcatalog-cart__item-sliders-btn-left">
                                        <img
                                            src="<?= get_template_directory_uri(); ?>/assets/icons/arrow_icon.svg"
                                            class="subcatalog-cart__item-sliders-btn-icon"
                                            width="32"
                                            height="32"
                                            title=""
                                            alt=""
                                            loading="lazy">
                                    </button>
                                    <button id="subcatalogBtnRight-<?= $product->get_id(); ?>" class="subcatalog-cart__item-sliders-btn-right">
                                        <img
                                            src="<?= get_template_directory_uri(); ?>/assets/icons/arrow_icon.svg"
                                            class="subcatalog-cart__item-sliders-btn-icon"
                                            width="32"
                                            height="32"
                                            title=""
                                            alt=""
                                            loading="lazy">
                                    </button>
                                </div>

                                <!-- middle block -->
                                <div class="subcatalog-cart__item-content">
                                    <!-- left block -->
                                    <div class="subcatalog-cart__item-info">
                                        <div class="subcatalog-cart__item-info-header">
                                            <h2 class="subcatalog-cart__item-info-title"><?= the_title(); ?></h2>
                                            <p class="subcatalog-cart__item-info-text"><?= wp_trim_words($product->get_description()); ?></p>
                                        </div>
                                        <!-- color radio -->
                                        <?php
                                        if ($product->is_type('variable')) {
                                            // Получаем атрибуты вариаций
                                            $attributes = $product->get_variation_attributes();

                                            $variations = $product->get_available_variations();
                                        ?>
                                            <input type="hidden" class="variotion_id" value="">
                                            <div class="radio__list">
                                                <?php
                                                if (!empty($attributes['pa_color'])) {
                                                    $color_terms = wc_get_product_terms($product->get_id(), 'pa_color', [
                                                        'orderby' => 'menu_order',
                                                        'order'   => 'ASC',
                                                        'fields'  => 'all',
                                                    ]);
                                                ?>
                                                    <div class="selected-radio">
                                                        <p class="selected-radio__title">Цвет:</p>
                                                        <div class="selected-color__list">
                                                            <?php
                                                            foreach ($color_terms as $term):
                                                                $color_slug = $term->slug;
                                                                $color_name = $term->name;

                                                                // Находим ID вариации, которая соответствует данному цвету
                                                                foreach ($variations as $variation) {
                                                                    if (in_array($color_slug, $variation['attributes'])) {
                                                                        // Получаем ID изображения вариации
                                                                        $image_id = get_post_thumbnail_id($variation['variation_id']);
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                                <input type="radio" name="color_<?= $product->get_id(); ?>" id="color_<?= $product->get_id(); ?>_<?php echo esc_attr($color_slug); ?>" class="radio-hidden" value="<?php echo esc_attr($color_slug); ?>">
                                                                <label
                                                                    for="color_<?= $product->get_id(); ?>_<?php echo esc_attr($color_slug); ?>"
                                                                    class="color-label"
                                                                    style="background: #<?php echo esc_attr($color_slug); ?>"
                                                                    data-image-id="<?php echo esc_attr($image_id); ?>">
                                                                </label>
                                                            <?php
                                                            endforeach;
                                                            ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <!-- color radio -->

                                                <!-- option radio -->
                                                <?php
                                                render_attribute_selector($product, 'pa_memory', 'Объем памяти', 'memory');
                                                render_attribute_selector($product, 'pa_display', 'Экран', 'display');
                                                ?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <!-- left block -->

                                    <!-- right block -->
                                    <div class="subcatalog-cart__item-right">
                                        <div class="subcatalog-cart__item-right-header">
                                            <div class="subcatalog-cart__item-right-header-cost-block">
                                                <!-- loader -->
                                                <div class="loader-cart">
                                                    <div class="loader"></div>
                                                </div>
                                                <!-- loader -->
                                                <div class="subcatalog-cart__item-right-price product-price">
                                                    <?php if ($product->get_price_html()) : ?>
                                                        <?= $product->get_price_html(); ?>
                                                    <?php else : ?>
                                                        <p class="empty-price">«Цена»</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <button class="subcatalog-cart__item-right-btn-buy" data-btn-cart="<?= $product->get_id(); ?>">В корзину</button>
                                        </div>
                                        <ul class="subcatalog-cart__item-right-char">
                                            <li class="subcatalog-cart__item-right-char-item">
                                                <img
                                                    src="<?= get_template_directory_uri(); ?>/assets/icons/sim_icon.svg"
                                                    class="subcatalog-cart__item-right-char-icon"
                                                    width="15"
                                                    height="15"
                                                    title=""
                                                    alt=""
                                                    loading="lazy">
                                                <dl class="subcatalog-cart__item-right-char-item-block">
                                                    <dt>SIM:</dt>
                                                    <dd>SIM+eSIM</dd>
                                                </dl>
                                            </li>
                                            <li class="subcatalog-cart__item-right-char-item">
                                                <img
                                                    src="<?= get_template_directory_uri(); ?>/assets/icons/delivery_truck_icon.svg"
                                                    class="subcatalog-cart__item-right-char-icon"
                                                    width="15"
                                                    height="15"
                                                    title=""
                                                    alt=""
                                                    loading="lazy">
                                                <dl class="subcatalog-cart__item-right-char-item-block">
                                                    <dt>Доставка:</dt>
                                                    <dd>В день заказа</dd>
                                                </dl>
                                            </li>
                                            <li class="subcatalog-cart__item-right-char-item">
                                                <img
                                                    src="<?= get_template_directory_uri(); ?>/assets/icons/verify_icon.svg"
                                                    class="subcatalog-cart__item-right-char-icon"
                                                    width="15"
                                                    height="15"
                                                    title=""
                                                    alt=""
                                                    loading="lazy">
                                                <dl class="subcatalog-cart__item-right-char-item-block">
                                                    <dt>Гарантии:</dt>
                                                    <dd>1 год</dd>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- right block -->

                                </div>
                                <!-- middle block -->
                            </li>
                    <?php
                        }
                    endwhile;
                    ?>
                </ul>
            </div>
        <?php } else { ?>
            <p class="subcatalog-cart__empty-text">Раздел в разработке.</p>
        <?php } ?>
    </section>

    <section class="accessory">
        <h2 class="pages__title">Аксессуары</h2>
        <?= get_template_part('/components/Sliders/Accessory'); ?>
    </section>

    <section class="form-question__block">
        <?= get_template_part('/components/Forms/Question'); ?>
    </section>
</main>

<?php
// Шапка сайта
custom_footer();
?>