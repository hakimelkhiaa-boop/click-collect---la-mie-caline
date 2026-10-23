<?php get_header(); ?>

<main class="home">

    <section class="hero">
        <div class="hero__content">
            <p class="hero__eyebrow">2 BONNES RAISONS DE</p>
            <h1 class="hero__title">CRAQUER</h1>
            <p class="hero__text">Le 3e OFFERT ! 🍪</p>
            <a class="btn btn--primary" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Je commande</a>
        </div>
        <img
            class="hero__image"
            src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/cookies.png'); ?>"
            alt="Assortiment de cookies"
            width="402"
            height="181">
    </section>

    <section class="selection">
        <h2 class="selection__title">Notre sélection</h2>
        <?php storefrontchild_category_carousel(0, 'large'); ?>
    </section>

</main>

<?php get_footer(); ?>