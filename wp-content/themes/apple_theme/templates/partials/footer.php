<footer>
    <div class="container">
        <a href="/" class="footer__logo">
            Logo
        </a>

        <div class="footer-middle">
            <div class="footer__pages">
                <ul class="footer-categorys__list">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header_category_pages_menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s', // Убираем <ul>, так как он уже есть в разметке
                        'depth'          => 1,
                        'fallback_cb'    => false,
                        'walker'         => new Custom_Walker_Footer_Category(), // Используем кастомный Walker
                    ));
                    ?>
                </ul>
                <ul class="footer-pages__list">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header_general_pages_menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s', // Убираем <ul>, так как он уже есть в разметке
                        'depth'          => 1,
                        'fallback_cb'    => false,
                        'walker'         => new Custom_Walker_Footer_Menu(), // Используем кастомный Walker
                    ));
                    ?>
                </ul>
            </div>

            <div class="footer-contacts">
                <div class="footer-contacts__phone">
                    <img
                        src="<?= get_template_directory_uri(); ?>/assets/icons/phone_white_icon.svg"
                        width="12"
                        height="12"
                        loading="lazy"
                        alt="">
                    <a href="tel:<?= preg_replace('/\D+/', '', get_theme_mod('apple_phone')); ?>" class="footer-contacts__phone-link">
                        <?= get_theme_mod('apple_phone'); ?>
                    </a>
                </div>

                <div class="footer-contact__bottom">
                    <div class="footer-contact__block">
                        <img
                            src="<?= get_template_directory_uri(); ?>/assets/icons/whatsapp_icon.svg"
                            class="footer-contact__block-wa-icon"
                            width="12"
                            height="12"
                            loading="lazy"
                            alt="">
                        <a href="<?= get_theme_mod('apple_link_wa'); ?>" target="_blank" rel="noopener noreferrer" class="footer-contact__block-link">WhatsApp</a>
                    </div>
                    <div class="footer-contact__block">
                        <img
                            src="<?= get_template_directory_uri(); ?>/assets/icons/telegram_blue_icon.svg"
                            width="14"
                            height="14"
                            loading="lazy"
                            alt="">
                        <a href="<?= get_theme_mod('apple_link_tg'); ?>" target="_blank" rel="noopener noreferrer" class="footer-contact__block-link">Telegram</a>
                    </div>
                </div>
            </div>
        </div>

        <span class="footer-privacy">
            Сайт носит сугубо информационный характер и не является публичной офертой, определяемой Статьей 437 (2) ГК РФ. Apple, логотип Apple и изображения Apple являются зарегистрированными товарными знаками компании Apple Inc. в США и других странах. App Store является знаком обслуживания компании Apple Inc. Instagram принадлежит компании Meta, признанной экстремистской организацией и запрещенной в РФ.
        </span>
    </div>
</footer>

<?= wp_footer(); ?>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth < 768) {
            const image = document.querySelector('.banner-right-block img');
            const h1 = document.querySelector('.banner-left-block h1');

            if (image && h1) {
                // Перемещаем изображение после h1
                h1.insertAdjacentElement('afterend', image);

                // Скрываем правый блок, чтобы не было пустоты
                const rightBlock = document.querySelector('.banner-right-block');
                if (rightBlock) {
                    rightBlock.style.display = 'none';
                }
            }
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categorySwiper = new Swiper('#categoryCart', {
            slidesPerView: 2,
            spaceBetween: 10,
            grabCursor: true,
            keyboard: {
                enabled: true,
            },
            navigation: {
                nextEl: '#categoryCartRight',
                prevEl: '#categoryCartLeft',
            },
            breakpoints: {
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 32,
                },
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const accessorySwiper = new Swiper('#accessoryCart', {
            slidesPerView: 2,
            spaceBetween: 10,
            grabCursor: true,
            keyboard: {
                enabled: true,
            },
            navigation: {
                nextEl: '#accessoryCartRight',
                prevEl: '#accessoryCartLeft',
            },
            breakpoints: {
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 32,
                },
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.subcatalog-cart__item').forEach(item => {
            const swiperContainer = item.querySelector('.swiper');
            const btnLeft = item.querySelector('.subcatalog-cart__item-sliders-btn-left');
            const btnRight = item.querySelector('.subcatalog-cart__item-sliders-btn-right');

            if (!swiperContainer) return;

            const swiper = new Swiper(swiperContainer, {
                slidesPerView: 1,
                spaceBetween: 10,
                grabCursor: true,
                loop: true,
                keyboard: {
                    enabled: true,
                },
                navigation: {
                    nextEl: btnRight,
                    prevEl: btnLeft,
                },
            });

            const labels = item.querySelectorAll('.color-label');
            const slides = item.querySelectorAll('.subcatalog-cart__item-slider-image');

            labels.forEach(label => {
                label.addEventListener('click', function() {
                    const targetImageId = this.getAttribute('data-image-id');

                    if (!targetImageId) return;

                    slides.forEach((img, index) => {
                        if (img.dataset.imageId === targetImageId) {
                            swiper.slideToLoop(index);
                        }
                    });
                });
            });
        });
    });
</script>