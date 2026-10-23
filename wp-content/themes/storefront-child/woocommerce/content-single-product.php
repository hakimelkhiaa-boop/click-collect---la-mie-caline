<?php

/**
 * Fiche produit (BEM).
 */
defined('ABSPATH') || exit;

global $product;

if (post_password_required()) {
    echo get_the_password_form(); // phpcs:ignore
    return;
}

$terms    = get_the_terms($product->get_id(), 'product_cat');
$category = ($terms && ! is_wp_error($terms)) ? reset($terms) : null;

$composition = function_exists('get_field') ? get_field('composition', $product->get_id()) : '';
$allergens   = function_exists('get_field') ? get_field('allergenes', $product->get_id()) : array();
$allergens   = is_array($allergens) ? $allergens : array();

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

        <?php if ($composition || $allergens) : ?>
            <div class="accordion">

                <?php if ($composition) : ?>
                    <details class="accordion__item">
                        <summary class="accordion__summary">Composition</summary>
                        <div class="accordion__content">
                            <p class="accordion__text"><?php echo wp_kses_post(nl2br(esc_html($composition))); ?></p>
                        </div>
                    </details>
                <?php endif; ?>

                <?php if ($allergens) : ?>
                    <details class="accordion__item">
                        <summary class="accordion__summary">Allergènes</summary>
                        <div class="accordion__content">
                            <ul class="accordion__list">
                                <?php foreach ($allergens as $allergen) : ?>
                                    <li class="accordion__entry"><?php echo esc_html($allergen['label']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </details>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <div class="product-page__cart">
            <?php woocommerce_template_single_add_to_cart(); ?>
        </div>
    </div>

</article>