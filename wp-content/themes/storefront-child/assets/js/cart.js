(function () {
  var timer;

  function scheduleUpdate() {
    clearTimeout(timer);
    timer = setTimeout(function () {
      var update = document.querySelector('.cart__form [name="update_cart"]');

      if (!update) {
        return;
      }

      update.disabled = false;
      update.removeAttribute('aria-disabled');
      update.click();
    }, 600);
  }

  document.addEventListener('click', function (event) {
    var button = event.target.closest('.qty-picker__button');

    if (!button) {
      return;
    }

    var input = button.closest('.qty-picker').querySelector('.qty-picker__input');
    var step = parseInt(button.getAttribute('data-step'), 10);
    var max = input.max ? parseInt(input.max, 10) : Infinity;
    var value = parseInt(input.value, 10) || 1;
    var next = Math.min(max, Math.max(1, value + step));

    if (next === value) {
      return;
    }

    input.value = next;
    scheduleUpdate();
  });

  document.addEventListener('change', function (event) {
    if (event.target.classList && event.target.classList.contains('qty-picker__input')) {
      scheduleUpdate();
    }
  });
})();