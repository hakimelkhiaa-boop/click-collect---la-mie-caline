<?php

/**
 * Récapitulatif du panier (BEM).
 */
defined('ABSPATH') || exit;

$cart = WC()->cart;
?>
<div class="cart_totals recap<?php echo WC()->customer->has_calculated_shipping() ? ' calculated_shipping' : ''; ?>">

    <?php do_action('woocommerce_before_cart_totals'); ?>

    <h2 class="recap__title">Mon récapitulatif</h2>

    <ul class="recap__items">
        <?php
        foreach ($cart->get_cart() as $cart_item) :
            $_product = $cart_item['data'];

            if (! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0) {
                continue;
            }

            $name = $_product->is_type('variation') ? get_the_title($cart_item['product_id']) : $_product->get_name();
            $qty  = $cart_item['quantity'];
        ?>
            <li class="recap__item">
                <span class="recap__item-name"><?php echo esc_html($name . ' · ' . $qty . ($qty > 1 ? ' articles' : ' article')); ?></span>
                <span class="recap__item-price"><?php echo wp_kses_post($cart->get_product_subtotal($_product, $qty)); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

    <table class="recap__table">
        <tbody>
            <?php if ($cart->needs_shipping() && $cart->show_shipping()) : ?>
                <?php do_action('woocommerce_cart_totals_before_shipping'); ?>
                <?php wc_cart_totals_shipping_html(); ?>
                <?php do_action('woocommerce_cart_totals_after_shipping'); ?>
            <?php endif; ?>

            <tr class="order-total">
                <th>Total TTC</th>
                <td data-title="Total"><?php wc_cart_totals_order_total_html(); ?></td>
            </tr>
        </tbody>
    </table>

    <a class="btn btn--primary btn--block recap__checkout" href="<?php echo esc_url(wc_get_checkout_url()); ?>">
        Poursuivre ma commande
    </a>
    <p class="recap__note">Encore un instant avant de vous régaler !</p>

    <?php do_action('woocommerce_after_cart_totals'); ?>
</div>