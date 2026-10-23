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
 * Retourne l'URL d'une page à partir de son slug.
 */
function storefrontchild_page_url($slug)
{
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/');
}

/**
 * Affiche le carrousel des catégories de produits.
 * $current_id : catégorie active (0 sur l'accueil).
 * $modifier   : variante, par exemple "large".
 */
function storefrontchild_category_carousel($current_id = 0, $modifier = '')
{
    $categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'orderby'    => 'menu_order',
        'exclude'    => array(get_option('default_product_cat')),
    ));

    if (is_wp_error($categories) || empty($categories)) {
        return;
    }

    $root_class = 'carousel' . ($modifier ? ' carousel--' . $modifier : '');
    $list_class = 'carousel__list' . ($modifier ? ' carousel__list--' . $modifier : '');
    $image_size = ('large' === $modifier) ? 'medium' : 'thumbnail';
?>
    <nav class="<?php echo esc_attr($root_class); ?>" aria-label="Catégories de produits">
        <button class="carousel__arrow carousel__arrow--prev" type="button">
            <span class="visually-hidden">Catégories précédentes</span>
        </button>

        <ul class="<?php echo esc_attr($list_class); ?>">
            <?php foreach ($categories as $category) : ?>
                <?php
                $is_active = ((int) $category->term_id === (int) $current_id);
                $image_id  = get_term_meta($category->term_id, 'thumbnail_id', true);
                ?>
                <li class="carousel__item">
                    <a class="carousel__link" href="<?php echo esc_url(get_term_link($category)); ?>" <?php echo $is_active ? ' aria-current="page"' : ''; ?>>
                        <span class="carousel__circle<?php echo $is_active ? ' carousel__circle--active' : ''; ?>">
                            <?php
                            echo wp_get_attachment_image(
                                $image_id,
                                $image_size,
                                false,
                                array('class' => 'carousel__image', 'alt' => '')
                            );
                            ?>
                        </span>
                        <span class="carousel__label<?php echo $is_active ? ' carousel__label--active' : ''; ?>">
                            Nos <?php echo esc_html(mb_strtolower($category->name)); ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <button class="carousel__arrow carousel__arrow--next" type="button">
            <span class="visually-hidden">Catégories suivantes</span>
        </button>
    </nav>
<?php
}

/**
 * Chargement des styles et scripts du thème enfant.
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'storefront-child-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Roboto+Condensed:wght@700&family=Yellowtail&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'storefront-child-style',
        get_stylesheet_uri(),
        array('storefront-style', 'storefront-child-fonts'),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'storefront-child-menu',
        get_stylesheet_directory_uri() . '/assets/js/menu.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    wp_enqueue_script(
        'storefront-child-carousel',
        get_stylesheet_directory_uri() . '/assets/js/carousel.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
});

/**
 * Retire les éléments par défaut de Storefront (header, footer, fil d'Ariane).
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

    // Fil d'Ariane
    remove_action('storefront_before_content', 'woocommerce_breadcrumb', 10);
    // Barre latérale et barre d'ajout au panier collante de Storefront
    remove_action('woocommerce_sidebar', 'storefront_get_sidebar', 10);
    remove_action('storefront_after_footer', 'storefront_sticky_single_add_to_cart', 999);
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
        <button class="header__burger" type="button" aria-expanded="false" aria-controls="header-nav">
            <span class="visually-hidden">Menu</span>
            <span class="header__burger-bar"></span>
            <span class="header__burger-bar"></span>
            <span class="header__burger-bar"></span>
        </button>

        <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>">
            <img
                class="header__logo"
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/logo.webp'); ?>"
                alt="La Mie Câline, retour à l'accueil"
                width="54"
                height="56">
        </a>

        <nav class="header__nav" id="header-nav" aria-label="Navigation principale">
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
        'instagram' => array('label' => 'Instagram', 'url' => 'https://www.instagram.com/lamiecaline/'),
        'facebook'  => array('label' => 'Facebook',  'url' => 'https://www.facebook.com/lamiecalinefrance'),
        'tiktok'    => array('label' => 'TikTok',    'url' => 'https://www.tiktok.com/@lamiecaline_officiel'),
        'linkedin'  => array('label' => 'LinkedIn',  'url' => 'https://www.linkedin.com/'),
        'youtube'   => array('label' => 'YouTube',   'url' => 'https://www.youtube.com/user/lamiecalinefrance'),
        'x'         => array('label' => 'X',         'url' => 'https://x.com/lamiecaline'),
    );

    $links_main = array(
        'cote-gourmandise' => 'Côté gourmandise',
        'cote-pratique'    => 'Côté pratique',
        'la-mie-caline'    => 'La Mie Câline',
        'nos-engagements'  => 'Nos engagements RSE',
    );

    $links_more = array(
        'nous-rejoindre' => 'Nous rejoindre',
        'nos-magasins'   => 'Nos magasins',
        'actualites'     => 'Actualités',
    );

    $links_legal = array(
        'mentions-legales' => 'Mentions légales',
        'donnees'          => 'Politique de protection des données personnelles',
        'cookies'          => 'Cookies',
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
                <?php foreach ($links_main as $slug => $label) : ?>
                    <li class="footer__item">
                        <a class="footer__link" href="<?php echo esc_url(storefrontchild_page_url($slug)); ?>"><?php echo esc_html($label); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <ul class="footer__list">
                <?php foreach ($links_more as $slug => $label) : ?>
                    <li class="footer__item">
                        <a class="footer__link" href="<?php echo esc_url(storefrontchild_page_url($slug)); ?>"><?php echo esc_html($label); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="footer__block">
                <p class="footer__title">Au cœur des réseaux</p>
                <ul class="footer__socials">
                    <?php foreach ($socials as $file => $social) : ?>
                        <li class="footer__social">
                            <a class="footer__social-link" href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer">
                                <?php storefrontchild_icon($file, 'light'); ?>
                                <span class="visually-hidden"><?php echo esc_html($social['label']); ?> (nouvel onglet)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer__block">
                <p class="footer__title">Service consommateur</p>
                <p class="footer__text">02 51 59 19 19</p>
                <p class="footer__note">Du lundi au vendredi de 9h à 18h</p>
                <a class="btn btn--primary btn--block" href="<?php echo esc_url(storefrontchild_page_url('contact')); ?>">
                    <?php storefrontchild_icon('mail'); ?>
                    Nous contacter
                </a>
            </div>
        </div>

        <ul class="footer__legal">
            <?php foreach ($links_legal as $slug => $label) : ?>
                <li class="footer__legal-item">
                    <a class="footer__link footer__link--small" href="<?php echo esc_url(storefrontchild_page_url($slug)); ?>"><?php echo esc_html($label); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <p class="footer__health">
            Pour votre santé, mangez au moins cinq fruits et légumes par jour.
            <a class="footer__link footer__link--small" href="https://www.mangerbouger.fr" target="_blank" rel="noopener noreferrer">www.mangerbouger.fr</a>
        </p>
    </div>
<?php
}
add_action('storefront_footer', 'storefrontchild_render_footer', 10);

/**
 * Ajoute une classe pour les pages en pleine largeur.
 */
add_filter('body_class', function ($classes) {
    $is_shop = function_exists('is_shop') && (is_shop() || is_product_category());
    $is_product = function_exists('is_product') && is_product();
    if (is_front_page() || $is_shop || $is_product) {
        $classes[] = 'layout-wide';
    }
    return $classes;
});
