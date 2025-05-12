<?php
// Шапка сайта
custom_header();
// Хлебные крошки
rank_math_the_breadcrumbs();
?>

<main class="container">
    <h1 class="pages__title"><?= get_field('1st_level_heading', 48); ?></h1>
    <section class="catalog-block_slider">
        <?= get_template_part('/components/Sliders/Category'); ?>
    </section>

    <section class="catalog-banner">
        <?= apply_filters('the_content', get_post_field('post_content', 48)); ?>
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