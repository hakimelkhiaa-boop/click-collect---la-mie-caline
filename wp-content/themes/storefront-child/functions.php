<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/**
 * Affiche une icône SVG décorative du thème.
 */
function storefrontchild_icon($name, $modifier = '')
{
    $url   = get_stylesheet_directory_uri() . '/assets/img/icons/' . $name . '.svg';
    $class = 'icon' . ($modifier ? ' icon--' . $modifier : '');
    echo '<img class="' . esc_attr($class) . '" src="' . esc_url($url) . '" alt="" width="24" height="24">';
}

/**
 * Chargement des styles du thème enfant et de la police.
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'storefront-child-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'storefront-child-style',
        get_stylesheet_uri(),
        array('storefront-style', 'storefront-child-fonts'),
        wp_get_theme()->get('Version')
    );
});

/**
 * Retire le header et le footer par défaut de Storefront.
 */
function storefrontchild_remove_storefront_parts()
{
    // Header
    remove_action('storefront_header', 'storefront_header_container', 0);
    remove_action('storefront_header', 'storefront_skip_links', 5);
    remove_action('storefront_header', 'storefront_site_branding', 20);
    remove_action('storefront_header', 'storefront_secondary_navigation', 30);
    remove_action('storefront_header', 'storefront_product_search', 40);
    remove_action('storefront_header', 'storefront_header_container_close', 41);
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
    remove_action('storefront_header', 'storefront_primary_navigation', 50);
    remove_action('storefront_header', 'storefront_header_cart', 60);
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper_close', 68);

    // Footer
    remove_action('storefront_footer', 'storefront_footer_widgets', 10);
    remove_action('storefront_footer', 'storefront_credit', 20);
    remove_action('storefront_footer', 'storefront_handheld_footer_bar', 999);
}
add_action('init', 'storefrontchild_remove_storefront_parts');

/**
 * Header personnalisé (BEM).
 */
function storefrontchild_render_header()
{
    $cart_count = 0;
    if (function_exists('WC') && WC()->cart) {
        $cart_count = WC()->cart->get_cart_contents_count();
    }
?>
    <div class="header">
        <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>">
            <img
                class="header__logo"
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/logo.webp'); ?>"
                alt="La Mie Câline, retour à l'accueil"
                width="54"
                height="56">
        </a>

        <nav class="header__nav" aria-label="Navigation principale">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'header__list',
                'fallback_cb'    => false,
            ));
            ?>
        </nav>

        <ul class="header__actions">
            <li class="header__action">
                <a class="header__action-link" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                    <?php storefrontchild_icon('account'); ?>
                    <span class="visually-hidden">Mon compte</span>
                </a>
            </li>
            <li class="header__action">
                <a class="header__action-link" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    <?php storefrontchild_icon('cart'); ?>
                    <span class="visually-hidden">Panier</span>
                    <span class="header__count"><?php echo esc_html($cart_count); ?></span>
                </a>
            </li>
        </ul>
    </div>
<?php
}
add_action('storefront_header', 'storefrontchild_render_header', 10);

/**
 * Classes BEM sur le menu principal.
 */
function storefrontchild_menu_item_class($classes, $item, $args)
{
    if ('primary' === $args->theme_location) {
        return array('header__item');
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'storefrontchild_menu_item_class', 10, 3);

function storefrontchild_menu_link_class($atts, $item, $args)
{
    if ('primary' === $args->theme_location) {
        $atts['class'] = 'header__link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'storefrontchild_menu_link_class', 10, 3);

/**
 * Footer personnalisé (BEM).
 */
function storefrontchild_render_footer()
{
    $socials = array(
        'instagram' => 'Instagram',
        'facebook'  => 'Facebook',
        'tiktok'    => 'TikTok',
        'youtube'   => 'YouTube',
        'x'         => 'X',
    );
?>
    <div class="footer">
        <div class="footer__main">
            <a class="footer__logo-link" href="<?php echo esc_url(home_url('/')); ?>">
                <img
                    class="footer__logo"
                    src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/logo.webp'); ?>"
                    alt="La Mie Câline, retour à l'accueil"
                    width="54"
                    height="56">
            </a>

            <ul class="footer__list">
                <li class="footer__item"><a class="footer__link" href="#">Côté gourmandise</a></li>
                <li class="footer__item"><a class="footer__link" href="#">Nos magasins</a></li>
                <li class="footer__item"><a class="footer__link" href="#">La Mie Câline</a></li>
                <li class="footer__item"><a class="footer__link" href="#">Nos engagements</a></li>
            </ul>

            <div class="footer__block">
                <p class="footer__title">Les réseaux sociaux</p>
                <ul class="footer__socials">
                    <?php foreach ($socials as $file => $label) : ?>
                        <li class="footer__social">
                            <a class="footer__social-link" href="#">
                                <?php storefrontchild_icon($file, 'light'); ?>
                                <span class="visually-hidden"><?php echo esc_html($label); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer__block">
                <p class="footer__title">Service consommateur</p>
                <p class="footer__text">02 51 59 19 19</p>
                <a class="btn btn--primary" href="#">Contactez-nous</a>
            </div>
        </div>

        <ul class="footer__legal">
            <li class="footer__item"><a class="footer__link" href="#">Mentions légales</a></li>
            <li class="footer__item"><a class="footer__link" href="#">CGV</a></li>
        </ul>
    </div>
<?php
}
add_action('storefront_footer', 'storefrontchild_render_footer', 10);
