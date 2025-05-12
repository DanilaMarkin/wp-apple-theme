<?php
// Шапка сайта
custom_header();
// Хлебные крошки
rank_math_the_breadcrumbs();
?>

<main class="container">
    <section class="contacts">
        <div class="contacts-info__blocks">
            <div class="contacts-info__header">
                <h1 class="pages__title"><?= the_title(); ?></h1>
                <div class="contacts-info"><?= the_content(); ?></div>
            </div>

            <ul class="contacts-info__list">
                <li class="contacts-info__item">
                    <span>Адрес: <p><?= get_theme_mod('apple_adress'); ?></p></span>
                </li>
                <li class="contacts-info__item">
                    <span>Телефон: <a href="tel:<?= preg_replace('/\D+/', '', get_theme_mod('apple_phone')); ?>"><?= get_theme_mod('apple_phone'); ?></a></span>
                </li>
                <li class="contacts-info__item">
                    <span>E-mail: <a href="mailto:<?= get_theme_mod('apple_email'); ?>"><?= get_theme_mod('apple_email'); ?></a></span>
                </li>
            </ul>
        </div>

        <div class="contacts-map">
            <div style="position:relative;overflow:hidden;">
                <iframe src="<?= get_field('map_src'); ?>" width="100%" height="402" frameborder="1" allowfullscreen="true" style="position:relative;">
                </iframe>
            </div>
        </div>
    </section>
</main>

<?php
// Шапка сайта
custom_footer();
?>