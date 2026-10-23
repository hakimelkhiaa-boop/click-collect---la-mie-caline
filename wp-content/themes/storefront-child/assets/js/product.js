jQuery(function ($) {
  var $form = $('.variations_form');
  var $image = $('.product-page__image');
  var $price = $('.product-page__price');

  if (!$form.length || !$image.length) {
    return;
  }

  /* ----- Image et prix de la variation ----- */
  var original = {
    src: $image.attr('src'),
    srcset: $image.attr('srcset') || '',
    sizes: $image.attr('sizes') || '',
    alt: $image.attr('alt') || '',
    price: $price.html()
  };

  $form.on('found_variation', function (event, variation) {
    if (variation.image && variation.image.src) {
      $image.attr({
        src: variation.image.src,
        srcset: variation.image.srcset || '',
        sizes: variation.image.sizes || '',
        alt: variation.image.alt || ''
      });
    }

    if (variation.price_html) {
      $price.html(variation.price_html);
    }
  });

  $form.on('hide_variation reset_image', function () {
    $image.attr({
      src: original.src,
      srcset: original.srcset,
      sizes: original.sizes,
      alt: original.alt
    });
    $price.html(original.price);
  });

  /* ----- Options affichées en boutons ----- */
  var buttonAttributes = ['choix-de-la-variete'];

  $form.find('select').each(function () {
    var select = this;
    var $select = $(select);

    if (buttonAttributes.indexOf(select.id) === -1) {
      return;
    }

    var $group = $('<div class="options" role="group"></div>');
    var label = $form.find('label[for="' + select.id + '"]').text();

    $group.attr('aria-label', label);
    $select.closest('tr').addClass('product-page__option-row');
    $select.addClass('visually-hidden');
    $select.after($group);

    function render() {
      $group.empty();

      $select.find('option').each(function () {
        if (!this.value) {
          return;
        }

        var pressed = this.value === select.value;
        var $button = $('<button type="button" class="options__button"></button>');

        $button
          .text($(this).text())
          .attr('data-value', this.value)
          .attr('aria-pressed', pressed ? 'true' : 'false');

        $group.append($button);
      });
    }

    $group.on('click', '.options__button', function () {
      $select.val($(this).attr('data-value')).trigger('change');
      render();
    });

    $form.on('woocommerce_update_variation_values reset_data', render);
    render();
  });
});