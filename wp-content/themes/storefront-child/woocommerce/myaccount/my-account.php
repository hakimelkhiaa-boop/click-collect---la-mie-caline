<?php

/**
 * Espace client connecté (BEM).
 */
defined('ABSPATH') || exit;
?>
<div class="account-page">

    <h1 class="account-page__title">Mon compte</h1>

    <div class="account">
        <div class="account__nav">
            <?php do_action('woocommerce_account_navigation'); ?>
        </div>

        <div class="account__content woocommerce-MyAccount-content">
            <?php do_action('woocommerce_account_content'); ?>
        </div>
    </div>

</div>