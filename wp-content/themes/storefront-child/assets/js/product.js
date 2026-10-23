jQuery(function ($) {
  var $form = $('.variations_form');
  var $image = $('.product-page__image');
  var $price = $('.product-page__price');

  if (!$form.length || !$image.length) {
    return;
  }

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
});