<?php

/**
 * Page Panier (BEM).
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');

$count = WC()->cart->get_cart_contents_count();
?>
<div class="cart-page">

    <a class="cart-page__back" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
        <svg class="cart-page__back-icon" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
            <path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Continuer mes achats
    </a>

    <h1 class="cart-page__title">
        <span class="cart-page__title-script">Mon</span>
        <span class="cart-page__title-main">Panier</span>
    </h1>
    <p class="cart-page__count">
        <?php echo esc_html($count . ($count > 1 ? ' articles' : ' article')); ?> pour une pause gourmande
    </p>

    <div class="cart">

        <form class="cart__form woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <ul class="cart__list">
                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                    $_product = $cart_item['data'];

                    if (! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0) {
                        continue;
                    }

                    $permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
                    $name      = $_product->is_type('variation') ? get_the_title($cart_item['product_id']) : $_product->get_name();
                    $max       = $_product->get_max_purchase_quantity();
                    $details   = wc_get_formatted_cart_item_data($cart_item);
                ?>
                    <li class="cart-item">
                        <div class="cart-item__media">
                            <?php
                            $image = $_product->get_image('woocommerce_thumbnail', array('class' => 'cart-item__image', 'alt' => ''));
                            echo wp_kses_post($permalink ? '<a href="' . esc_url($permalink) . '">' . $image . '</a>' : $image);
                            ?>
                        </div>

                        <div class="cart-item__info">
                            <h2 class="cart-item__name">
                                <?php if ($permalink) : ?>
                                    <a class="cart-item__link" href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($name); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($name); ?>
                                <?php endif; ?>
                            </h2>
                            <?php if ($details) : ?>
                                <div class="cart-item__details"><?php echo wp_kses_post($details); ?></div>
                            <?php endif; ?>
                            <p class="cart-item__unit">
                                <?php echo wp_kses_post(WC()->cart->get_product_price($_product)); ?> / unité
                            </p>
                        </div>

                        <div class="cart-item__actions">
                            <?php if ($_product->is_sold_individually()) : ?>
                                <input type="hidden" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" value="1">
                            <?php else : ?>
                                <div class="qty-picker">
                                    <button class="qty-picker__button" type="button" data-step="-1">
                                        <span class="visually-hidden">Retirer un article</span>
                                        <span aria-hidden="true">&minus;</span>
                                    </button>
                                    <input
                                        class="qty-picker__input qty"
                                        type="number"
                                        name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                                        value="<?php echo esc_attr($cart_item['quantity']); ?>"
                                        min="1"
                                        <?php echo ($max > 0) ? 'max="' . esc_attr($max) . '"' : ''; ?>
                                        step="1"
                                        inputmode="numeric"
                                        aria-label="Quantité">
                                    <button class="qty-picker__button qty-picker__button--plus" type="button" data-step="1">
                                        <span class="visually-hidden">Ajouter un article</span>
                                        <span aria-hidden="true">+</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <p class="cart-item__total">
                                <?php echo wp_kses_post(WC()->cart->get_product_subtotal($_product, $cart_item['quantity'])); ?>
                            </p>
                        </div>

                        <a class="cart-item__remove" href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>">
                            Supprimer<span class="visually-hidden"> <?php echo esc_html($name); ?> du panier</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <button class="visually-hidden" type="submit" name="update_cart" value="Mettre à jour le panier" disabled aria-disabled="true">Mettre à jour le panier</button>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>

        <div class="cart__aside">
            <?php
            do_action('woocommerce_before_cart_collaterals');
            woocommerce_cart_totals();
            ?>
        </div>

    </div>
</div>
<?php do_action('woocommerce_after_cart'); ?>