<?php

/**
 * Panier vide (BEM).
 */
defined('ABSPATH') || exit;

do_action('woocommerce_cart_is_empty');
?>
<div class="cart-page cart-page--empty">
    <h1 class="cart-page__title">
        <span class="cart-page__title-script">Mon</span>
        <span class="cart-page__title-main">Panier</span>
    </h1>
    <p class="cart-page__count">Votre panier est vide pour le moment.</p>
    <a class="btn btn--primary" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Découvrir nos produits</a>
</div>