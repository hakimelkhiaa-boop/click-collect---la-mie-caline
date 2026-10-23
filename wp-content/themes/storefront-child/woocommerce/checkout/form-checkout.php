<?php

/**
 * Page de validation de commande (BEM).
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo '<p class="checkout-page__notice">Vous devez être connecté pour passer commande.</p>';
    return;
}
?>
<div class="checkout-page">

    <h1 class="checkout-page__title">
        <span class="checkout-page__title-script">Ma</span>
        <span class="checkout-page__title-main">Commande</span>
    </h1>

    <form name="checkout" method="post" class="checkout woocommerce-checkout checkout-page__form" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" novalidate="novalidate">

        <div class="checkout-page__main">
            <?php if ($checkout->get_checkout_fields()) : ?>
                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                <div class="checkout-page__details" id="customer_details">
                    <?php do_action('woocommerce_checkout_billing'); ?>
                    <?php do_action('woocommerce_checkout_shipping'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>
            <?php endif; ?>
        </div>

        <aside class="checkout-page__aside">
            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
            <h2 class="checkout-page__subtitle" id="order_review_heading">Mon récapitulatif</h2>
            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="woocommerce-checkout-review-order checkout-page__review">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>
        </aside>

    </form>
</div>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>