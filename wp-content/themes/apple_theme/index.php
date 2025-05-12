<?php
// Шапка сайта
custom_header();
?>

<main class="wrapper container">
    <section class="banner">
        <!-- left block -->
        <div class="banner-left-block">
            <p class="banner__subtitle"><?= get_field('banner_subtitle'); ?></p>
            <h1 class="banner__title"><?= get_field('first_level_banner_header'); ?></h1>
            <div class="banner-btns">
                <a href="<?= get_permalink(wc_get_page_id('shop')); ?>" class="banner-btn banner-btn__catalog">Каталог</a>
                <button class="banner-btn banner-btn__question">Задать вопрос</button>
            </div>
        </div>
        <!-- left block -->

        <!-- right block -->
        <div class="banner-right-block">
            <?=
            wp_get_attachment_image(get_field("banner_image"), 'full', false, [
                'alt' => get_post_meta(get_field("banner_image"), '_wp_attachment_image_alt', true),
                'title' => get_the_title(get_field("banner_image")),
                'class' => 'banner__image'
            ]);
            ?>
            <!-- right block -->
        </div>

        <!-- popup -->
        <div class="question-popup" aria-hidden="true">
            <div class="question-popup__content">
                <button class="question-popup__close">
                    +
                </button>
                <div class="question-popup__header">
                    <p class="question-popup__header-title">Задайте вопрос</p>
                    <span class="question-popup__header-subtitle">И наш менеджер свяжется с вами в течение 10 минут!</span>
                </div>
                <form action="#" class="question-popup__form">
                    <input
                        id="questionPopupName"
                        type="text"
                        name="question-popup-name"
                        placeholder="Введите имя"
                        class="question-popup__form-input">
                    <input
                        id="questionPopupTel"
                        type="tel"
                        name="question-popup-tel"
                        placeholder="Введите телефон"
                        class="question-popup__form-input">
                    <textarea
                        id="questionPopupMessage"
                        name="question-popup-message"
                        placeholder="Ваш вопрос"
                        class="question-popup__form-textarea"></textarea>
                    <button
                        type="submit"
                        class="question-popup__form-btn">
                        Отправить вопрос
                    </button>
                </form>
            </div>
        </div>
        <!-- popup -->
    </section>

    <section class="category catalog-block_slider">
        <h2 class="category__title">Лучшие устройства в одном магазине</h2>
        <?= get_template_part('/components/Sliders/Category'); ?>
    </section>

    <?php if (have_rows("block_advantages")) {
        while (have_rows('block_advantages')): the_row();
    ?>
            <section class="advantages">
                <ul class="advantages__list">
                    <?php while (have_rows('list_of_benefits')): the_row(); ?>
                        <li class="advantages__item">
                            <div class="advantages__item-block">
                                <?=
                                wp_get_attachment_image(get_sub_field("icon_advantages"), 'full', false, [
                                    'alt' => get_post_meta(get_sub_field("icon_advantages"), '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(get_sub_field("icon_advantages")),
                                    'class' => 'advantages__item-icon'
                                ]);
                                ?>
                                <div class="advantages__item-text">
                                    <h2 class="advantages__item-text-title"><?= get_sub_field('advantages_title'); ?></h2>
                                    <p class="advantages__item-text-info"><?= get_sub_field('advantages_text'); ?></p>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </section>
        <?php endwhile; ?>
    <?php } ?>

    <?php if (have_rows('banner_bonuses')) {
        while (have_rows('banner_bonuses')): the_row(); ?>
            <section class="bonus">
                <div class="bonus-blocks">
                    <?=
                    wp_get_attachment_image(get_sub_field("banner_bonuses_img"), 'full', false, [
                        'alt' => get_post_meta(get_sub_field("banner_bonuses_img"), '_wp_attachment_image_alt', true),
                        'title' => get_the_title(get_sub_field("banner_bonuses_img")),
                        'class' => 'bonus__image'
                    ]);
                    ?>
                    <div class="bonus-block">
                        <div class="bonus-block-text">
                            <h2 class="bonus-block-text__title"><?= get_sub_field('banner_bonuses_title'); ?></h2>
                            <p class="bonus-block-text__info"><?= get_sub_field('banner_bonuses_text'); ?></p>
                        </div>
                        <button class="bonus-block__btn">Зарегистрироваться</button>
                    </div>
                </div>
            </section>
    <?php
        endwhile;
    }
    ?>

    <?php if (have_rows('block_social_networks')) {
        while (have_rows('block_social_networks')): the_row(); ?>
            <section class="subscribe">
                <ul class="subscribe-blocks">
                    <?php while (have_rows('list_of_social_networks')): the_row(); ?>
                        <li class="subscribe-block">
                            <?=
                            wp_get_attachment_image(get_sub_field("list_of_social_networks_icon"), 'full', false, [
                                'alt' => get_post_meta(get_sub_field("list_of_social_networks_icon"), '_wp_attachment_image_alt', true),
                                'title' => get_the_title(get_sub_field("list_of_social_networks_icon")),
                                'class' => 'subscribe-block__mask'
                            ]);
                            ?>
                            <div class="subscribe-block__header">
                                <p class="subscribe-block__header-title"><?= get_sub_field('list_of_social_networks_title'); ?></p>
                                <?php if (get_sub_field('additional_text_sub_heading')) { ?>
                                    <span class="subscribe-block__header-subtitle"><?= get_sub_field('additional_text_sub_heading'); ?></span>
                                <?php } ?>
                            </div>
                            <div class="subscribe-block__action">
                                <span class="subscribe-block__subinfo"><?= get_sub_field('list_of_social_networks_info'); ?></span>
                                <a href="<?= get_sub_field('list_of_social_networks_link'); ?>" target="_blank" rel="noopener noreferrer" class="subscribe-block__action-link">Подробнее</a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </section>
    <?php
        endwhile;
    }
    ?>

    <section class="form-question__block">
        <?= get_template_part('/components/Forms/Question'); ?>
    </section>
</main>

<?php
// Шапка сайта
custom_footer();
?>