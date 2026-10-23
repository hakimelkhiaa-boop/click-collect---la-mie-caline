<?php

/**
 * Boutique et pages de catégorie (BEM).
 */
defined('ABSPATH') || exit;

get_header();

$current_id = is_product_category() ? get_queried_object_id() : 0;
$script     = $current_id ? 'Nos' : 'Notre';
$main       = $current_id ? single_term_title('', false) : 'Carte';

?>

<main class="shop">

    <?php storefrontchild_category_carousel($current_id); ?>

    <h1 class="shop__title">
        <span class="shop__title-script"><?php echo esc_html($script); ?></span>
        <span class="shop__title-main"><?php echo esc_html($main); ?></span>
    </h1>
    <div class="shop__tools">
        <button class="shop__filter" type="button">
            Filtrer
            <svg class="shop__filter-icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
                <path d="M3 6h18M6 12h12M10 18h4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </div>
    <?php if (woocommerce_product_loop()) : ?>
        <ul class="shop__list">
            <?php
            while (have_posts()) :
                the_post();
                wc_get_template_part('content', 'product');
            endwhile;
            ?>
        </ul>
    <?php else : ?>
        <p class="shop__empty">Aucun produit dans cette catégorie pour le moment.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>