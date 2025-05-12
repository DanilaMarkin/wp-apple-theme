<!DOCTYPE html>
<html <?= language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= wp_title(); ?></title>
    <?= wp_head(); ?>
</head>

<body <?= body_class(); ?>>
    <div id="overlay"></div>
    <header class="header-fixed">
        <nav class="menu container">
            <div class="menu-top">
                <ul class="menu-top__list">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header_general_pages_menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s', // Убираем <ul>, так как он уже есть в разметке
                        'depth'          => 1,
                        'fallback_cb'    => false,
                        'walker'         => new Custom_Walker_Nav_Menu(), // Используем кастомный Walker
                    ));
                    ?>
                </ul>
                <ul class="menu-top__social-list">
                    <li class="menu-top__social-item">
                        <img
                            src="<?= get_template_directory_uri(); ?>/assets/icons/whatsapp_icon.svg"
                            width="12"
                            height="12"
                            title=""
                            alt=""
                            loading="lazy">
                        <a href="<?= get_theme_mod('apple_link_wa'); ?>" target="_blank" rel="noopener noreferrer" class="menu-top__social-item-link">
                            WhatsApp
                        </a>
                    </li>
                    <li class="menu-top__social-item">
                        <img
                            src="<?= get_template_directory_uri(); ?>/assets/icons/telegram_icon.svg"
                            width="14"
                            height="14"
                            title=""
                            alt=""
                            loading="lazy">
                        <a href="<?= get_theme_mod('apple_link_tg'); ?>" target="_blank" rel="noopener noreferrer" class="menu-top__social-item-link">
                            Telegram
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-bottom">
                <div class="menu-bottom__block">
                    <a href="/" class="logo">
                        <p class="logo__text">LOGO</p>
                    </a>

                    <ul class="menu-bottom__catetory-list">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header_category_pages_menu',
                            'container'      => false,
                            'items_wrap'     => '%3$s', // Убираем <ul>, так как он уже есть в разметке
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'walker'         => new Custom_Walker_Nav_Category(), // Используем кастомный Walker
                        ));
                        ?>
                    </ul>
                </div>

                <div class="menu-bottom__last">
                    <a href="tel:<?= preg_replace('/\D+/', '', get_theme_mod('apple_phone')); ?>" class="menu-bottom__last-phone">
                        <?= get_theme_mod('apple_phone'); ?>
                    </a>
                    <a href="<?= get_permalink(150); ?>" class="menu-bottom__last-cart">
                        <img
                            src="<?= get_template_directory_uri(); ?>/assets/icons/cart_icon.svg"
                            width="32"
                            height="32"
                            title=""
                            alt=""
                            loading="lazy">
                        <!-- current count -->
                        <span class="current-count">0</span>
                    </a>
                    <!-- burger menu -->
                    <button class="burger-menu" id="burger">
                        <span class="burger-menu__line first"></span>
                        <span class="burger-menu__line second"></span>
                        <span class="burger-menu__line last"></span>
                    </button>
                    <!-- burger menu -->
                </div>
            </div>
        </nav>

        <!-- mob menu -->
        <nav class="mob-menu" aria-hidden="true">
            <div class="mob-menu__wrapper">

                <div class="mob-menu__pages">
                    <ul class="mob-menu__list">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header_general_pages_menu',
                            'container'      => false,
                            'items_wrap'     => '%3$s', // Убираем <ul>, так как он уже есть в разметке
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'walker'         => new Custom_Walker_Nav_Menu(), // Используем кастомный Walker
                        ));
                        ?>
                    </ul>
                </div>

                <div class="mob-menu__social">

                    <div class="mob-menu__social-top">
                        <p class="mob-menu__social-title">Мессенджеры</p>
                        <ul class="mob-menu__social-list">
                            <li class="mob-menu__social-item">
                                <img
                                    src="<?= get_template_directory_uri(); ?>/assets/icons/whatsapp_icon.svg"
                                    width="12"
                                    height="12"
                                    title=""
                                    alt=""
                                    loading="lazy">
                                <a href="<?= get_theme_mod('apple_link_wa'); ?>" target="_blank" rel="noopener noreferrer" class="mob-menu__social-item-link">
                                    WhatsApp
                                </a>
                            </li>
                            <li class="mob-menu__social-item">
                                <img
                                    src="<?= get_template_directory_uri(); ?>/assets/icons/telegram_icon.svg"
                                    width="14"
                                    height="14"
                                    title=""
                                    alt=""
                                    loading="lazy">
                                <a href="<?= get_theme_mod('apple_link_tg'); ?>" target="_blank" rel="noopener noreferrer" class="mob-menu__social-item-link">
                                    Telegram
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mob-menu__social-bottom">
                        <p class="mob-menu__social-title">Телефон</p>
                        <a href="tel:<?= preg_replace('/\D+/', '', get_theme_mod('apple_phone')); ?>" class="mob-menu__social-phone">
                            <?= get_theme_mod('apple_phone'); ?>
                        </a>
                    </div>
                </div>

            </div>
        </nav>
    </header>
    <div class="header-placeholder"></div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btnMenu = document.querySelector(".burger-menu");
            const menuMob = document.querySelector(".mob-menu");
            const body = document.body;

            btnMenu.addEventListener("click", () => {
                menuMob.classList.toggle("open");
                btnMenu.classList.toggle("active");
                body.classList.toggle("no-scroll");
            });
        });
    </script>