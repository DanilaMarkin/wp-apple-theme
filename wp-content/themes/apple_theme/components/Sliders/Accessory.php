<?php
$categorys_cart = [
    [
        'title' => 'Чехлы и защита',
        'image' => 'accessory-1.svg'
    ],
    [
        'title' => 'Дом',
        'image' => 'accessory-2.svg'
    ],
    [
        'title' => 'Питание',
        'image' => 'accessory-3.svg'
    ],
    [
        'title' => 'Клавиатуры',
        'image' => 'accessory-4.svg'
    ],
    [
        'title' => 'Pencil',
        'image' => 'accessory-5.svg'
    ],
    [
        'title' => 'AirTag',
        'image' => 'accessory-6.svg'
    ],
    [
        'title' => 'Чехлы и защита',
        'image' => 'accessory-1.svg'
    ],
    [
        'title' => 'Дом',
        'image' => 'accessory-2.svg'
    ],
    [
        'title' => 'Питание',
        'image' => 'accessory-3.svg'
    ],
    [
        'title' => 'Клавиатуры',
        'image' => 'accessory-4.svg'
    ],
    [
        'title' => 'Pencil',
        'image' => 'accessory-5.svg'
    ],
    [
        'title' => 'AirTag',
        'image' => 'accessory-6.svg'
    ],
];
?>

<div class="category-header">
    <p class="category-header__text">Выберите категорию</p>
    <div class="category-header__arrow">
        <button id="accessoryCartLeft" class="category-header__arrow-btn left">
            <img
                src="<?= get_template_directory_uri(); ?>/assets/icons/arrow_icon.svg"
                class="category-header__arrow-btn-icon"
                width="32"
                height="32"
                title=""
                alt=""
                loading="lazy">
        </button>
        <button id="accessoryCartRight" class="category-header__arrow-btn right">
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
<div id="accessoryCart" class="swiper category-cart">
    <ul class="swiper-wrapper category-cart__list">
        <?php foreach ($categorys_cart as $category_cart) { ?>
            <li class="swiper-slide category-cart__item">
                <img
                    src="<?= get_template_directory_uri(); ?>/assets/images/accessory/<?= $category_cart['image']; ?>"
                    class="category-cart__item-image"
                    title=""
                    alt=""
                    loading="lazy">
                <a href="#" class="category-cart__item-link">
                    <h3 class="category-cart__item-link-title">
                        <?= $category_cart['title']; ?>
                    </h3>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>