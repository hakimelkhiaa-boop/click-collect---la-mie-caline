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
            width="820"
            height="370">
    </section>

    <section class="selection">
        <h2 class="selection__title">Notre sélection</h2>
        <ul class="selection__list">
            <?php
            $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'exclude'    => array(get_option('default_product_cat')),
            ));

            foreach ($categories as $category) :
                $image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            ?>
                <li class="selection__item">
                    <a class="selection__link" href="<?php echo esc_url(get_term_link($category)); ?>">
                        <span class="selection__circle">
                            <?php
                            echo wp_get_attachment_image(
                                $image_id,
                                'medium',
                                false,
                                array('class' => 'selection__image', 'alt' => '')
                            );
                            ?>
                        </span>
                        <?php echo esc_html($category->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

</main>

<?php get_footer(); ?>