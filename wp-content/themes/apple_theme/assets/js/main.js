document.addEventListener("DOMContentLoaded", () => {
    // Инициализация Notyf
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'bottom',
        },
    });

    // Глобальные переменные
    const overlay = document.getElementById("overlay");
    const body = document.body;

    // Форма "Остались вопросы?"
    const formQuestion = document.querySelector(".form-question");

    if (formQuestion) {
        formQuestion.addEventListener("submit", (e) => {
            // Останавливаем стандартное поведение браузера
            e.preventDefault();

            // Поля формы
            const nameQuestion = document.querySelector(".form-question-name");
            const phoneQuestion = document.querySelector(".form-question-tel");

            // Флажок для валидации
            let isValid = true;

            // Валидация имени (только кириллица)
            const nameRegex = /^[А-Яа-яЁё\s\-]+$/;
            if (!nameRegex.test(nameQuestion.value.trim())) {
                nameQuestion.classList.add("error");
                isValid = false;
            } else {
                nameQuestion.classList.remove("error");
            }

            // Валидация телефона (только цифры)
            const phoneRegex = /^\d+$/;
            if (!phoneRegex.test(phoneQuestion.value.trim())) {
                phoneQuestion.classList.add("error");
                isValid = false;
            } else {
                phoneQuestion.classList.remove("error");
            }

            // Если валидация прошла успешна
            if (isValid) {
                fetch("/wp-admin/admin-ajax.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        action: "send_question_form",
                        name: nameQuestion.value.trim(),
                        phone: phoneQuestion.value.trim() 
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Форма об успешной отправки сообщения
                        Swal.fire({
                            title: "Успешно!",
                            text: "Мы скоро свяжемся с вами!",
                            icon: "success",
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: true,
                            confirmButtonText: "ОК",
                            customClass: {
                                confirmButton: "swal-confirm-button"
                            }
                        });
                        formQuestion.reset();
                    } else {
                        notyf.error(data.data || "Ошибка отправки");
                    }
                })
                .catch(() => {
                    notyf.error("Ошибка сети");
                });
            } else {
                // Всплывающие увед-ие Ошибка
                notyf.error('Проверьте поля');
            }
        });
    }

    // Открытие модального окна на Гл.Стр Зд "Задать вопрос"
    const questionPopup = document.querySelector(".question-popup");
    const questionBtnPopup = document.querySelector(".banner-btn__question");
    const questionBtnPopupClose = document.querySelector(".question-popup__close");

    // Клик по кнопке "Задать Вопрос"
    if (questionBtnPopup) {
        questionBtnPopup.addEventListener("click", () => {
            questionPopup.classList.add("open");
            overlay.classList.add("active");
            body.classList.add("no-scroll");
        });
    }

    // Клик по крестику для закрытия модального окна
    if (questionBtnPopupClose) {
        questionBtnPopupClose.addEventListener("click", () => {
            questionPopup.classList.remove("open");
            overlay.classList.remove("active");
            body.classList.remove("no-scroll");
        });
    }

    // Клик по пустой области
    overlay.addEventListener("click", (e) => {
        if (e.target === overlay) {
            questionPopup.classList.remove("open");
            overlay.classList.remove("active");
            body.classList.remove("no-scroll");
        }
    });

    // Отправка с формы поп-ап "Задайте вопрос"
    const formQuestionPopup = document.querySelector(".question-popup__form");
    
    if (formQuestionPopup) {
        formQuestionPopup.addEventListener("submit", (e) => {
            // Останавливаем стандартное поведение браузера
            e.preventDefault();

            // Поля формы
            const questionPopupName = document.getElementById("questionPopupName");
            const questionPopupTel = document.getElementById("questionPopupTel");
            const questionPopupMessage = document.getElementById("questionPopupMessage");

             // Флажок для валидации
            let isValid = true;

            // Валидация имени (только кириллица)
            const nameRegex = /^[А-Яа-яЁё\s\-]+$/;
            if (!nameRegex.test(questionPopupName.value.trim())) {
                questionPopupName.classList.add("error");
                isValid = false;
            } else {
                questionPopupName.classList.remove("error");
            }

            // Валидация телефона (только цифры)
            const phoneRegex = /^\d+$/;
            if (!phoneRegex.test(questionPopupTel.value.trim())) {
                questionPopupTel.classList.add("error");
                isValid = false;
            } else {
                questionPopupTel.classList.remove("error");
            }

            if (isValid) {
                fetch("/wp-admin/admin-ajax.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        action: "send_question_popup_form",
                        name: questionPopupName.value.trim(),
                        phone: questionPopupTel.value.trim(),
                        message: questionPopupMessage.value.trim() 
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Закрытие формы для вывода сообщений
                        questionPopup.classList.remove("open");
                        overlay.classList.remove("active");
                        body.classList.remove("no-scroll");
                        // Очистка формы
                        formQuestionPopup.reset();
                        // Форма об успешной отправки сообщения
                        Swal.fire({
                            title: "Успешно!",
                            text: "Мы скоро свяжемся с вами!",
                            icon: "success",
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: true,
                            confirmButtonText: "ОК",
                            customClass: {
                                confirmButton: "swal-confirm-button"
                            }
                        });
                    } else {
                        notyf.error(data.data || "Ошибка отправки");
                    }
                })
                .catch(() => {
                    notyf.error("Ошибка сети");
                });
            } else {
                // Всплывающие увед-ие Ошибка
                notyf.error('Проверьте поля');
            }
        });
    }

     // Шапка следующая за пользователем
    const header = document.querySelector(".header-fixed");
    // Хранить скролл последний
    let lastScroll = window.scrollY;
    let timeout;

    // Скрыть шапку
    const hideHeader = () => {
        header.classList.add("header__hidden");
    };

    // Показать шапку
    const showHeader = () => {
        header.classList.remove("header__hidden");
    };

    // Отслеживать постоянно координату Y
    window.addEventListener("scroll", () => {
        // Хранить текущую Y
        const currentScroll = window.scrollY;

        // Если пользователь скроллит (в любом направлении)
        if (currentScroll !== lastScroll) {
            hideHeader();

            // Если уже есть таймер — сбросим его
            clearTimeout(timeout);

            // Если пользователь остановился на 400мс — покажем хедер
            timeout = setTimeout(() => {
                showHeader();
            }, 300);
        }

        lastScroll = currentScroll;
    });

    // Получение цены после выбора атрибутов у товара
    // Находим все товары на странице
    const productItems = document.querySelectorAll('.subcatalog-cart__item[data-id]');

    productItems.forEach(productItem => {
        const productId = productItem.getAttribute('data-id');
        // Находим элементы внутри конкретного товара
        const priceContainer = productItem.querySelector('.product-price');
        const variotionId = productItem.querySelector('.variotion_id');
        // pre-load
        const loaderPrice = productItem.querySelector('.loader-cart');
        
        // Получаем все input'ы типа radio внутри блока товара
        const inputRadios = productItem.querySelectorAll('input[type="radio"][name$="_' + productId + '"]');

        if (!inputRadios.length || !priceContainer) return;
        
        // Функция для получения выбранных значений
        function getSelectedValues() {
            const values = {};
            inputRadios.forEach(input => {
                if (input.checked) {
                    const nameParts = input.name.split('_'); // например, ['color', '123']
                    const attr = nameParts[0]; // color, ssd, display и т.д.
                    values[attr] = input.value;
                }
            });
            return values;
        }
        
        // Функция обновления цены
        function updatePrice() {
            const values = getSelectedValues();

             // Проверка, что все атрибуты выбраны (по количеству уникальных атрибутов)
            const requiredAttrs = new Set(Array.from(inputRadios).map(input => input.name.split('_')[0]));
            const selectedAttrs = Object.keys(values);
            if (requiredAttrs.size !== selectedAttrs.length) return;

            // Показываем loader и скрываем цену
            loaderPrice.classList.add("active");
            priceContainer.classList.add("active");

            fetch(my_ajax_object.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    action: 'get_variation_price',
                    product_id: productId,
                    ...values
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.price_html) {
                    priceContainer.innerHTML = data.price_html;
                    variotionId.value = data.variation_id;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                // Скрываем лоадер и показываем цену
                loaderPrice.classList.remove("active");
                priceContainer.classList.remove("active");
            });
        }
        
        // Добавляем обработчики событий
        inputRadios.forEach(input => {
            input.addEventListener('change', updatePrice);
        });
        
        // Вызываем обновление цены при загрузке
        updatePrice();
    });

    // Добавление товара в корзину
    productItems.forEach(productItem => {
        // Переменные
        const addBtntoCart = productItem.querySelector(".subcatalog-cart__item-right-btn-buy");
        const priceContainer = productItem.querySelector('.product-price');
        const productId = productItem.getAttribute('data-id');
        const variationIdInput = productItem.querySelector('.variotion_id');

        // Проверка на налчие кнопки
        if (addBtntoCart) {
            // Клик на кнопку "Добавить в корзину"
            addBtntoCart.addEventListener("click", () => {
                // Проверка если у товара нет цены, то не добавлять товар и выводить сообщение
                if (priceContainer.querySelector(".empty-price")) {
                    notyf.error("Товар недоступен для заказа");
                    return;
                }
                // Если есть цена, то...
                let color = null;
                let memory = null;
                
                // Проверяем наличие выбранного цвета
                const colorRadio = productItem.querySelector('input[name^="color_"]:checked');
                if (colorRadio) {
                    color = colorRadio.value;
                }
                
                 // Проверяем, есть ли variation_id
                 const variation_id = variationIdInput ? variationIdInput.value : null;

                // Проверяем наличие выбранного объема памяти
                const memoryRadio = productItem.querySelector('input[name^="ssd_"]:checked');
                if (memoryRadio) {
                    memory = memoryRadio.value;
                }
                
                // Проверяем, что для вариативного товара выбраны все атрибуты
                const isVariableProduct = productItem.querySelector('.radio__list') !== null;
                if (isVariableProduct && (!color || !memory)) {
                    notyf.error("Пожалуйста, выберите цвет и объем памяти");
                    return;
                }

                // Создаем уникальный ID для корзины (комбинация productId + variation_id)
                const cartItemId = variation_id ? `${productId}_${variation_id}` : productId;
                console.log(cartItemId);

                // Получаем текущую корзину из LocalStorage
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Ищем существующий товар
                const existingItemIndex = cart.findIndex(item => item.id === cartItemId);
                
                if (existingItemIndex !== -1) {
                    // Увеличиваем количество существующего товара
                    cart[existingItemIndex].quantity += 1;
                } else {
                    // Добавляем новый товар
                    cart.push({
                        id: cartItemId,
                        productId: productId,
                        variation_id: variation_id,
                        quantity: 1
                    });
                }
                
                // Сохраняем обновленную корзину в LocalStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                
                notyf.success("Добавлено в корзину");

                // Кол-во товаров отображаемое в шапке сайта
                updateTotalNavCount();

            });
        }

    });

    // Кол-во в шапку сайта
    window.updateTotalNavCount = function() {
        // Получаем корзину, если нет то присваиваем 0
        const cartItems = JSON.parse(localStorage.getItem("cart")) || [];

        const currentCountNav = document.querySelector(".current-count");

        if (!currentCountNav) return;

        let total = 0;

        cartItems.forEach((item) => {
            total += parseInt(item.quantity) || 0;
        });

        currentCountNav.textContent = total;
    }

    // Кол-во товаров отображаемое в шапке сайта
    updateTotalNavCount();
});