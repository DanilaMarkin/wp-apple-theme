<?php
// Подключени файлов из inc/
// - Файл для вывода навигации из меню
require_once get_template_directory() . '/inc/Walkers/Walker_Nav_Menu.php';
// - Файл для вывода навигации из моб меню
require_once get_template_directory() . '/inc/Walkers/Walker_Nav_Mob_Menu.php';
// - Файл для вывода навигации из подвала сайта
require_once get_template_directory() . '/inc/Walkers/Walker_Footer_Menu.php';
// - Файл для вывода навигации из шапки сайта - категории
require_once get_template_directory() . '/inc/Walkers/Walker_Nav_Category.php';
// - Файл для вывода навигации из подвала сайта - категории
require_once get_template_directory() . '/inc/Walkers/Walker_Footer_Category.php';
// - Файд для регистрации шаблонов
require_once get_template_directory() . '/inc/template-register.php';
// - Файл для регистарции новых вкладок в Настройки
require_once get_template_directory() . '/inc/customizer.php';
// - Файл для отправки писем с формы "Остались Вопросы?"
require_once get_template_directory() . '/inc/Mail/send-question-form.php';
// - Файл для отправки писем с формы "Задайте вопрос"
require_once get_template_directory() . '/inc/Mail/send-question-popup-form.php';

// Кастомные CSS стили
function apple_styles()
{
    // Стандартные стили style
    wp_enqueue_style('apple-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));

    // Глобальные стили для всего сайта
    wp_enqueue_style("apple-global", get_template_directory_uri() . '/assets/css/global.css', array(), filemtime(get_template_directory() . '/assets/css/global.css'));

    // Подключаем CSS файл Swiper
    wp_enqueue_style('swiper-css', '/node_modules/swiper/swiper-bundle.min.css', array(), null);

    // Подключаем CSS файл Notyf
    wp_enqueue_style('notyf-css', '/node_modules/notyf/notyf.min.css', array(), null);
}
add_action('wp_enqueue_scripts', 'apple_styles');

// Кастомные JS стили
function apple_scripts()
{
    // Фунционал который есть на любой странице
    wp_enqueue_script('apple-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/main.js'), true);

    wp_localize_script('apple-main', 'my_ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);

    // Функционал для страницы Корзина(id=150)
    if (is_page(150)) {
        wp_enqueue_script('apple-cart', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/cart.js'), true);
    }
    // Подключение библеотеки Swiper
    wp_enqueue_script('swiper-js', '/node_modules/swiper/swiper-bundle.min.js', array(), null, true);

    // Подключение библеотеки Notyf
    wp_enqueue_script('notyf-js', '/node_modules/notyf/notyf.min.js', array(), null, true);

    // Подключение библеотеки SweetAlert2
    wp_enqueue_script('sweetalert2', '/node_modules/sweetalert2/dist/sweetalert2.all.min.js', array(), null, true);
}
add_action("wp_enqueue_scripts", "apple_scripts");

// Поддержка WooCommerce в теме
function europe_woocommerce_setup()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'europe_woocommerce_setup');

// Кастомная шапка сайта
function custom_header()
{
    get_template_part('/templates/partials/header');
}

// Кастомный подвал сайта
function custom_footer()
{
    get_template_part('/templates/partials/footer');
}

// Регистрация меню в админ-панеле
function register_custom_menus()
{
    register_nav_menus([
        'header_general_pages_menu' => 'Общие страницы',
        'header_category_pages_menu' => 'Категории продуктов',
    ]);
}
add_action('after_setup_theme', 'register_custom_menus');


function ajax_get_variation_price()
{
    $product_id = intval($_POST['product_id']);
    $product = wc_get_product($product_id);

    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error(['message' => 'Invalid product']);
    }

    $product_variable = new WC_Product_Variable($product_id);
    $variations = $product_variable->get_available_variations();

    foreach ($variations as $variation) {
        $is_match = true;
        foreach ($_POST as $key => $value) {
            if (in_array($key, ['action', 'product_id'])) continue;

            $attr_key = 'attribute_pa_' . $key;
            if (!isset($variation['attributes'][$attr_key]) || $variation['attributes'][$attr_key] !== $value) {
                $is_match = false;
                break;
            }
        }

        if ($is_match) {
            $variation_obj = wc_get_product($variation['variation_id']);
            wp_send_json([
                'price_html' => $variation_obj->get_price_html(),
                'variation_id' => $variation_obj->get_id(),
            ]);
        }
    }

    wp_send_json_error(['message' => 'No matching variation found']);
}

add_action('wp_ajax_get_variation_price', 'ajax_get_variation_price');
add_action('wp_ajax_nopriv_get_variation_price', 'ajax_get_variation_price');

function load_custom_cart_json_callback()
{
    $items = json_decode(stripslashes($_POST['items']), true);
    $response = [];

    foreach ($items as $item) {
        $product_id = (int) $item['productId'];
        $variation_id = !empty($item['variation_id']) ? (int) $item['variation_id'] : null;
        $quantity = (int) $item['quantity'];

        // Получаем объект товара
        $product = $variation_id ? wc_get_product($variation_id) : wc_get_product($product_id);
        $parent = wc_get_product($product_id);

        if ($product && $parent) {
            // Получаем название родителя (например: "iPhone 15 Pro Max")
            $name = $parent->get_name();

            // Извлекаем только значения атрибутов вариации
            $variation_name = '';
            if ($variation_id) {
                $variation = new WC_Product_Variation($variation_id);
                $attributes = $variation->get_attributes();

                $values = [];

                foreach ($attributes as $taxonomy => $term_slug) {
                    if (taxonomy_exists($taxonomy)) {
                        $term = get_term_by('slug', $term_slug, $taxonomy);
                        if ($term && !is_wp_error($term)) {
                            $values[] = $term->name;
                        }
                    } else {
                        // Просто текстовое значение
                        $values[] = $term_slug;
                    }
                }

                $variation_name = implode(', ', $values);
            }

            $image = wp_get_attachment_image_url($product->get_image_id(), 'medium');

            $response[] = [
                'id' => $item['id'],
                'name'      => $name,
                'variation' => $variation_name,
                'price'     => wc_price($product->get_price()),
                'image'     => $image ?: get_template_directory_uri() . '/assets/images/image.png',
                'quantity'  => $quantity,
            ];
        }
    }

    wp_send_json($response);
}

add_action('wp_ajax_load_custom_cart_json', 'load_custom_cart_json_callback');
add_action('wp_ajax_nopriv_load_custom_cart_json', 'load_custom_cart_json_callback');

// Фунция для вывода атрибутов
function render_attribute_selector($product, $attribute_slug, $title, $input_prefix = 'option')
{
    $attributes = $product->get_variation_attributes();

    if (!empty($attributes[$attribute_slug])) {
        $slugs = $attributes[$attribute_slug]; // порядок как на странице товара
?>
        <div class="selected-radio">
            <p class="selected-radio__title"><?= esc_html($title); ?>:</p>
            <div class="selected-option__list">
                <?php foreach ($slugs as $slug):
                    $term = get_term_by('slug', $slug, $attribute_slug);
                    if (!$term) continue;
                    $name = $term->name;
                ?>
                    <input type="radio"
                        name="<?= $input_prefix; ?>_<?= $product->get_id(); ?>"
                        id="<?= $input_prefix; ?>_<?= $product->get_id(); ?>_<?= esc_attr($slug); ?>"
                        class="radio-hidden"
                        value="<?= esc_attr($slug); ?>">

                    <label for="<?= $input_prefix; ?>_<?= $product->get_id(); ?>_<?= esc_attr($slug); ?>"
                        class="option-label"><?= esc_html($name); ?></label>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
