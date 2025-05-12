<?php
// Шапка сайта
custom_header();
// Хлебные крошки
rank_math_the_breadcrumbs();
?>

<main class="container">
    <h1 class="pages__title"><?= the_title(); ?></h1>
    <section class="cart-blocks">
        <p class="cart-blocks__empty hidden">Корзина пуста</p>
        <!-- loader -->
        <div class="loader-cart active">
            <div class="loader"></div>
        </div>
        <!-- loader -->
        <div class="cart-info">
            <ul class="cart-info__list">
                <!-- load data -->
            </ul>
        </div>

        <div class="cart-form">
            <h2 class="cart-form__title">Оформить</h2>

            <div class="cart-form__radio">
                <input type="radio" name="del" id="pickup" class="radio-hidden" checked>
                <label for="pickup" class="delivery-radio__label">Самовывоз</label>

                <input type="radio" name="del" id="delivery" class="radio-hidden">
                <label for="delivery" class="delivery-radio__label">Доставка</label>
            </div>

            <div id="pickupTab" class="delivery-wrapper">
                <span class="cart-form__text">Вы можете забрать свой заказ в нашем магазине с 10:00 до 21:00 ежедневно. Услуга действует при оформлении заказа с 10:00 до 20:00. </span>
                <form action="#" class="cart-form__send">
                    <div class="cart-form__send-item">
                        <label for="nameCart" class="cart-form__send-label">Имя</label>
                        <input type="text" id="nameCart" placeholder="Ваше имя" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="phoneCart" class="cart-form__send-label">Телефон</label>
                        <input type="tel" id="phoneCart" placeholder="Ваш телефон" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="messageCart" class="cart-form__send-label">Комментарий</label>
                        <input type="text" id="messageCart" placeholder="Ваш комментарий" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="bonusCart" class="cart-form__send-label">Номер бонусной карты (При наличии)</label>
                        <input type="text" id="bonusCart" placeholder="Номер" class="cart-form__send-input">
                    </div>
                </form>
            </div>

            <div id="deliveryTab" class="delivery-wrapper hidden">
                <div class="delivery-wrapper__tabs">
                    <button id="deliverySpb" class="delivery-wrapper__tab active" data-price="Бесплатная">По СПб</button>
                    <button id="deliveryRu" class="delivery-wrapper__tab" data-price="500₽">По России</button>
                </div>
                <form action="#" class="cart-form__send">
                    <div class="cart-form__send-item">
                        <label for="nameCart" class="cart-form__send-label">Имя</label>
                        <input type="text" id="nameCart" placeholder="Ваше имя" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="phoneCart" class="cart-form__send-label">Телефон</label>
                        <input type="tel" id="phoneCart" placeholder="Ваш телефон" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="emailCart" class="cart-form__send-label">E-mail</label>
                        <input type="email" id="emailCart" placeholder="Ваш телефон" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="adressCart" class="cart-form__send-label">Адрес</label>
                        <input type="email" id="adressCart" placeholder="Город, улица, дом" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="contactCart" class="cart-form__send-label">Способ связи</label>
                        <div class="custom-select-wrapper">
                            <div id="contactCart" class="cart-form__send-item-selected">
                                <span class="cart-form__send-item-current">Telegram</span>
                                <img
                                    src="<?= get_template_directory_uri(); ?>/assets/icons/arrow_select_icon.svg"
                                    width="24"
                                    height="24"
                                    title=""
                                    alt=""
                                    class="cart-form__send-item-selected-icon"
                                    loading="lazy">
                            </div>
                            <!-- list -->
                            <ul class="contact-form__list">
                                <li class="contact-form__item">
                                    Telegram
                                </li>
                                <li class="contact-form__item">
                                    WhatsApp
                                </li>
                                <li class="contact-form__item">
                                    Электронная почта
                                </li>
                                <li class="contact-form__item">
                                    По телефону
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="cart-form__send-item">
                        <label for="messageCart" class="cart-form__send-label">Комментарий</label>
                        <input type="text" id="messageCart" placeholder="Ваш комментарий" class="cart-form__send-input">
                    </div>
                    <div class="cart-form__send-item">
                        <label for="bonusCart" class="cart-form__send-label">Номер бонусной карты (При наличии)</label>
                        <input type="text" id="bonusCart" placeholder="Номер" class="cart-form__send-input">
                    </div>
                </form>
            </div>

            <div class="cart-form__detail">
                <ul class="cart-form__detail-list">
                    <li class="cart-form__detail-item">
                        <p class="cart-form__detail-item-info">Итого</p>
                        <span id="cart-total-price" class="cart-form__detail-item-current">233.347₽</span>
                    </li>
                    <li id="deliveryItem" class="cart-form__detail-item hidden">
                        <p class="cart-form__detail-item-info">Доставка</p>
                        <span class="cart-form__detail-item-current" id="deliveryPrice">1200₽</span>
                    </li>
                    <li class="cart-form__detail-item">
                        <p class="cart-form__detail-item-info">К оплате</p>
                        <span class="cart-form__detail-item-current">235.000₽</span>
                    </li>
                </ul>
            </div>

            <button class="cart-form__btn-send">Заказать</button>
        </div>
    </section>
</main>

<?php
// Шапка сайта
custom_footer();
?>