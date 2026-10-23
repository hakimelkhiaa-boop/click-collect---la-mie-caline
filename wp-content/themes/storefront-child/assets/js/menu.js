document.addEventListener('DOMContentLoaded', function () {
  var burger = document.querySelector('.header__burger');
  var nav = document.querySelector('.header__nav');

  if (!burger || !nav) {
    return;
  }

  burger.addEventListener('click', function () {
    var isOpen = burger.getAttribute('aria-expanded') === 'true';
    burger.setAttribute('aria-expanded', String(!isOpen));
    nav.classList.toggle('header__nav--open');
  });
});