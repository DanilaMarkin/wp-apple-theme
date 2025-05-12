<?php
function apple_customize_register($wp_customize)
{
    $wp_customize->add_section('apple_contacts', [
        'title'    => 'Контакты сайта',
        'priority' => 30,
    ]);

    // Телефон
    $wp_customize->add_setting('apple_phone', [
        'default' => '',
    ]);

    $wp_customize->add_control('apple_phone', [
        'label'   => 'Телефон',
        'section' => 'apple_contacts',
        'type'    => 'text',
    ]);
    // Телефон

    // Почта
    $wp_customize->add_setting('apple_email', [
        'default' => '',
    ]);

    $wp_customize->add_control('apple_email', [
        'label'   => 'Email',
        'section' => 'apple_contacts',
        'type'    => 'text',
    ]);
    // Почта

    // Адрес
    $wp_customize->add_setting('apple_adress', [
        'default' => '',
    ]);

    $wp_customize->add_control('apple_adress', [
        'label'   => 'Адрес',
        'section' => 'apple_contacts',
        'type'    => 'text',
    ]);
    // Адрес

    // Ссылка на WhatsApp
    $wp_customize->add_setting('apple_link_wa', [
        'default' => '',
    ]);

    $wp_customize->add_control('apple_link_wa', [
        'label'   => 'WhatsApp',
        'section' => 'apple_contacts',
        'type'    => 'text',
    ]);
    // Ссылка на WhatsApp

    // Ссылка на Telegram
    $wp_customize->add_setting('apple_link_tg', [
        'default' => '',
    ]);

    $wp_customize->add_control('apple_link_tg', [
        'label'   => 'Telegram',
        'section' => 'apple_contacts',
        'type'    => 'text',
    ]);
    // Ссылка на Telegram
}
add_action('customize_register', 'apple_customize_register');
