<?php

/**
 * Produit dans la liste de la boutique (BEM).
 */
defined('ABSPATH') || exit;

global $product;

if (empty($product) || ! $product->is_visible()) {
    return;
}

$excerpt = wp_trim_words(wp_strip_all_tags($product->get_short_description()), 22, '…');
?>
<li class="product-card">
    <a class="product-card__link" href="<?php echo esc_url(get_permalink()); ?>">
        <span class="product-card__media">
            <?php
            echo wp_kses_post(
                $product->get_image('woocommerce_thumbnail', array('class' => 'product-card__image', 'alt' => ''))
            );
            ?>
        </span>
        <div class="product-card__body">
            <h2 class="product-card__title"><?php echo esc_html(get_the_title()); ?></h2>
            <p class="product-card__text"><?php echo esc_html($excerpt); ?></p>
        </div>
    </a>
</li>