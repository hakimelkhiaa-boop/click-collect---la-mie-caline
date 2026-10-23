<?php

/**
 * Fiche produit simple (BEM).
 */
defined('ABSPATH') || exit;

global $product;

if (post_password_required()) {
    echo get_the_password_form(); // phpcs:ignore
    return;
}

$terms    = get_the_terms($product->get_id(), 'product_cat');
$category = ($terms && ! is_wp_error($terms)) ? reset($terms) : null;

woocommerce_output_all_notices();
?>
<article class="product-page">

    <div class="product-page__media">
        <?php
        echo wp_kses_post(
            $product->get_image('large', array('class' => 'product-page__image'))
        );
        ?>
    </div>

    <div class="product-page__info">
        <?php if ($category) : ?>
            <p class="product-page__category">
                <a class="product-page__category-link" href="<?php echo esc_url(get_term_link($category)); ?>">
                    Nos <?php echo esc_html($category->name); ?>
                </a>
            </p>
        <?php endif; ?>

        <h1 class="product-page__title"><?php echo esc_html(get_the_title()); ?></h1>

        <div class="product-page__buy">
            <p class="product-page__price"><?php echo wp_kses_post($product->get_price_html()); ?></p>
            <div class="product-page__cart">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>
        </div>
    </div>

</article>