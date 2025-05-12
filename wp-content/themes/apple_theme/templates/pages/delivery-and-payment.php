<?php
// Шапка сайта
custom_header();
// Хлебные крошки
rank_math_the_breadcrumbs();
?>

<main class="container">
    <h1 class="pages__title"><?= the_title(); ?></h1>
    <section class="delivery-and-payment-block">
        <?= the_content(); ?>
    </section>
    <section class="form-question__block">
        <?= get_template_part('/components/Forms/Question'); ?>
    </section>
</main>

<?php
// Шапка сайта
custom_footer();
?>