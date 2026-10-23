<?php

/**
 * Connexion et création de compte (BEM).
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form');

$registration  = ('yes' === get_option('woocommerce_enable_myaccount_registration'));
$ask_password  = ('no' === get_option('woocommerce_registration_generate_password'));
$ask_username  = ('no' === get_option('woocommerce_registration_generate_username'));
$login_value   = (! empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification
$register_open = isset($_POST['register']); // phpcs:ignore WordPress.Security.NonceVerification
?>
<div class="account-page">

    <h1 class="account-page__title">Mon compte</h1>

    <div class="auth<?php echo $registration ? '' : ' auth--single'; ?>">

        <section class="auth__col">
            <h2 class="auth__heading">Déjà un compte ?</h2>

            <form class="auth__form woocommerce-form woocommerce-form-login login" method="post" novalidate>
                <?php do_action('woocommerce_login_form_start'); ?>

                <div class="auth__field">
                    <label class="auth__label" for="username">Adresse e-mail</label>
                    <input class="auth__input" type="text" name="username" id="username" autocomplete="username" value="<?php echo $login_value; // phpcs:ignore 
                                                                                                                        ?>" required aria-required="true">
                </div>

                <div class="auth__field">
                    <label class="auth__label" for="password">Mot de passe</label>
                    <input class="auth__input" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true">
                </div>

                <p class="auth__forgot">
                    <a class="auth__forgot-link" href="<?php echo esc_url(wp_lostpassword_url()); ?>">Mot de passe oublié ?</a>
                </p>

                <?php do_action('woocommerce_login_form'); ?>

                <label class="auth__remember">
                    <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                    <span>Se souvenir de moi</span>
                </label>

                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button class="btn btn--primary btn--block" type="submit" name="login" value="Se connecter">Se connecter</button>

                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
        </section>

        <?php if ($registration) : ?>
            <section class="auth__col auth__col--register">
                <h2 class="auth__heading">Pas encore de compte ?</h2>
                <p class="auth__text">Créez votre compte La Mie Câline.</p>

                <details class="auth__details" <?php echo $register_open ? ' open' : ''; ?>>
                    <summary class="auth__toggle btn btn--primary btn--block">Créer mon compte</summary>

                    <form class="auth__form auth__form--register woocommerce-form woocommerce-form-register register" method="post" novalidate <?php do_action('woocommerce_register_form_tag'); ?>>
                        <?php do_action('woocommerce_register_form_start'); ?>

                        <?php if ($ask_username) : ?>
                            <div class="auth__field">
                                <label class="auth__label" for="reg_username">Identifiant</label>
                                <input class="auth__input" type="text" name="username" id="reg_username" autocomplete="username" required aria-required="true">
                            </div>
                        <?php endif; ?>

                        <div class="auth__field">
                            <label class="auth__label" for="reg_email">Adresse e-mail</label>
                            <input class="auth__input" type="email" name="email" id="reg_email" autocomplete="email" value="<?php echo (! empty($_POST['email']) && is_string($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; // phpcs:ignore 
                                                                                                                            ?>" required aria-required="true">
                        </div>

                        <?php if ($ask_password) : ?>
                            <div class="auth__field">
                                <label class="auth__label" for="reg_password">Mot de passe</label>
                                <input class="auth__input" type="password" name="password" id="reg_password" autocomplete="new-password" required aria-required="true">
                            </div>
                        <?php else : ?>
                            <p class="auth__text">Un lien pour définir votre mot de passe vous sera envoyé par e-mail.</p>
                        <?php endif; ?>

                        <?php do_action('woocommerce_register_form'); ?>

                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button class="btn btn--primary btn--block" type="submit" name="register" value="Créer mon compte">Valider mon inscription</button>

                        <?php do_action('woocommerce_register_form_end'); ?>
                    </form>
                </details>
            </section>
        <?php endif; ?>

    </div>
</div>
<?php do_action('woocommerce_after_customer_login_form'); ?>