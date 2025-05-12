document.addEventListener("DOMContentLoaded", () => {
    // Инициализация Notyf
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'bottom',
        },
    });
    // Клик по кнопкам "Самовывоз" и "Доставка"
    const pickup = document.getElementById("pickup");
    const delivery = document.getElementById("delivery");

    const pickupTab = document.getElementById("pickupTab");
    const deliveryTab = document.getElementById("deliveryTab");

    const deliveryPrice = document.getElementById("deliveryPrice");
    const deliveryButtons = document.querySelectorAll(".delivery-wrapper__tab");
    const deliveryItem = document.getElementById("deliveryItem");
    
    // Если пользователь кликнул на Самовывоз...
    pickup.addEventListener("click", () => {
        pickupTab.classList.remove("hidden");
        deliveryTab.classList.add("hidden");
        deliveryItem.classList.add("hidden");
    });

    // Если пользователь кликнул на Доставку...
    delivery.addEventListener("click", () => {
        deliveryTab.classList.remove("hidden");
        pickupTab.classList.add("hidden");
        deliveryItem.classList.remove("hidden");

        // Первое зн-ие по умолчанию
        const deliveryActiveButton = document.querySelector(".delivery-wrapper__tab.active");
        const priceActive = deliveryActiveButton.dataset.price;
        deliveryPrice.textContent = `${priceActive}`;
    });

    // Переключение доставок внутри "Доставка", с выбором RU или СПб
    deliveryButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            // Установка выбранноый зн-ем RU или СПб
            deliveryButtons.forEach(i => i.classList.remove("active"));
            btn.classList.add("active");

            const price = btn.dataset.price;
            deliveryPrice.textContent = `${price}`;
        });
    })

    // Открытие выбора Способа Связи
    const contactCart = document.getElementById("contactCart");
    const contactList = document.querySelector(".contact-form__list");
    const contactItems = document.querySelectorAll(".contact-form__item");
    const contactCurrent = contactCart.querySelector(".cart-form__send-item-current");

    // Открытие / закрытие выпадашки
    contactCart.addEventListener("click", () => {
        contactCart.classList.toggle("open");
        contactList.classList.toggle("open");
    });

    // Выбор способа связи из выпадающего списка 
    contactItems.forEach((item) => {
        item.addEventListener("click", () => {
            contactCurrent.textContent = item.textContent;
            contactCart.classList.remove("open");
            contactList.classList.remove("open");
        });
    });

    // Клик вне области — закрытие списка
    document.addEventListener("click", (e) => {
        if (!e.target.closest("#contactCart") && !e.target.closest(".contact-form__list")) {
            contactCart.classList.remove("open");
            contactList.classList.remove("open");
        }
    });

    // Вывод товаров в корзину
    function renderCartItems(items) {
        // Переменная для вставки товаров
        const cartList = document.querySelector('.cart-info__list');
        // Очищаем перед вставкой
        cartList.innerHTML = ''; 
      
        items.forEach(item => {
          const li = document.createElement('li');
          li.dataset.id = item.id; // Уникальный иденфикатор для сравнения
          li.className = 'cart-info__item';
      
          li.innerHTML = `
            <div class="cart-info__item-preview">
              <img src="${item.image}" alt="" class="cart-info__item-preview-img">
            </div>

            <div class="cart-info__item-wrapper">
              <div class="cart-info__item-detail">
                <h2 class="cart-info__item-detail-title">${item.name}</h2>
                <span class="cart-info__item-detail-subtitle">${item.variation}</span>
              </div>
              
              <div class="cart-info__item-action">
                <div class="cart-info__item-action-count">
                  <button class="cart-action__minus-btn">
                  <img src="/wp-content/themes/apple_theme/assets/icons/minus_icon.svg" width="24" height="24" loading="lazy">
                  </button>
                  <input type="number" value="${item.quantity}" min="0" class="current-count__item" readonly>
                  <button class="cart-action__plus-btn">
                  <img src="/wp-content/themes/apple_theme/assets/icons/plus_icon.svg" width="24" height="24" loading="lazy">
                  </button>
                </div>

                <div class="cart-info__item-price-current">
                    ${item.price}
                </div>

                <button class="cart-info__item-delete-btn">
                  <img src="/wp-content/themes/apple_theme/assets/icons/close_icon.svg" width="24" height="24" loading="lazy">
                </button>
              </div>
            </div>`
          ;
      
          cartList.appendChild(li);
        });

        // Удаление товара по крестику
        const cartItem = document.querySelectorAll(".cart-info__item");

        cartItem.forEach((item) => {
          const itemId = item.dataset.id;
          const deleteBtn = item.querySelector(".cart-info__item-delete-btn");

          deleteBtn.addEventListener("click", () => {
             const cartItems = JSON.parse(localStorage.getItem("cart")) || [];

            // Удаляем товар из массива cartItems
            const updateFilter = cartItems.filter(item => item.id !== itemId);

            console.log(updateFilter);

            // Обновляем localStorage
            localStorage.setItem("cart", JSON.stringify(updateFilter));

            // Удаляем HTML-элемент
            item.remove();

            // Кол-во товаров отображаемое в шапке сайта
            updateTotalNavCount();

            notyf.success("Товар удалён из корзины");

            // Если товаров в корзине нет
            if (updateFilter.length === 0) {
              hideCart();
              cartTextEmpty.classList.remove("hidden");
            }
          });
        });

        // Изменение кол-ва продуктов
        cartItem.forEach((item) => {
          const itemId = item.dataset.id;
          const minus = item.querySelector(".cart-action__minus-btn");
          const plus = item.querySelector(".cart-action__plus-btn");
          const currentCount = item.querySelector(".current-count__item");

          minus.addEventListener("click", () => {
            let cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            let currentItem = cartItems.find(item => item.id === itemId);

            if (currentItem && currentItem.quantity > 1) {
              currentItem.quantity--;
              currentCount.value = currentItem.quantity;
              localStorage.setItem("cart", JSON.stringify(cartItems));
              // Кол-во товаров отображаемое в шапке сайта
              updateTotalNavCount();
            }
          });

          plus.addEventListener("click", () => {
            let cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            let currentItem = cartItems.find(item => item.id === itemId);

            if (currentItem) {
              currentItem.quantity++;
              currentCount.value = currentItem.quantity;
              localStorage.setItem("cart", JSON.stringify(cartItems));
              // Кол-во товаров отображаемое в шапке сайта
              updateTotalNavCount();
            }
          });

        });
    }

    // Функция для скрытии корзины
    function hideCart() {
        const cartInfo = document.querySelector(".cart-info");
        const cartForm = document.querySelector(".cart-form");

        cartInfo.classList.add("hide");
        cartForm.classList.add("hide");
    }

    // Функция для скрытии корзины
    function showCart() {
        const cartInfo = document.querySelector(".cart-info");
        const cartForm = document.querySelector(".cart-form");

        cartInfo.classList.remove("hide");
        cartForm.classList.remove("hide");
    }

    // Подсчет Итого:
    function updateCartTotal(items) {

    }

    // Получаем данные с корзины
    const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
    // Переменные
    const loaderCart = document.querySelector(".loader-cart");
    const cartTextEmpty = document.querySelector(".cart-blocks__empty");
    
    // Изначально скрываем всю корзину
    hideCart();

    // Если корзина не пустая, то...
    if (cartItems.length > 0) {
      // Отправляем запрос на сервер, чтобы получить актуальную информацию
      fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
          action: 'load_custom_cart_json',
          items: JSON.stringify(cartItems),
        }),
      })
      // Полученный ответ сохраняем в json формате
      .then(res => res.json())
      // Получаем информацию полученную сервера и передаем в функцию для вывода
      .then(data => {
        // Убрать loader
        loaderCart.classList.remove("active");
        // Показать корзину
        showCart();
        // Вывести товары
        renderCartItems(data);
      });
    // Если нет товаров то скрывать 2 блока
    } else {
        hideCart();
        // Убрать loader
        loaderCart.classList.remove("active");
        // Показать текст, что пусто
        cartTextEmpty.classList.remove("hidden");
    }
    
    // Кол-во товаров отображаемое в шапке сайта
    updateTotalNavCount();
});