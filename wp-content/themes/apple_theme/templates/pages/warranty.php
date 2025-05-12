<?php
// Шапка сайта
custom_header();
// Хлебные крошки
rank_math_the_breadcrumbs();
?>

<main class="container">
    <h1 class="pages__title"><?= the_title(); ?></h1>
    <section class="warranty-block">
        <?= the_content(); ?>
    </section>
</main>

<?php
// Шапка сайта
custom_footer();
?>