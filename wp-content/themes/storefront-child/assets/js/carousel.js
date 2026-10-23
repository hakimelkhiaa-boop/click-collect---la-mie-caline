document.addEventListener('DOMContentLoaded', function () {
  var carousel = document.querySelector('.carousel');

  if (!carousel) {
    return;
  }

  var list = carousel.querySelector('.carousel__list');
  var prev = carousel.querySelector('.carousel__arrow--prev');
  var next = carousel.querySelector('.carousel__arrow--next');
  var active = carousel.querySelector('.carousel__circle--active');

  function scrollStep(direction) {
    list.scrollBy({ left: direction * list.clientWidth * 0.8, behavior: 'smooth' });
  }

  prev.addEventListener('click', function () {
    scrollStep(-1);
  });

  next.addEventListener('click', function () {
    scrollStep(1);
  });

  if (active) {
    active.scrollIntoView({ block: 'nearest', inline: 'center' });
  }
});