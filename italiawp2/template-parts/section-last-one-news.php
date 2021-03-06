<?php
/*
 * ### SEZIONE ULTIMA NOTIZIA ###
 * Mostra l'ultimo articolo in evidenza (sticky).
 * Pensata come alternativa o preliminare "a section-last-news".
 *
 */
?>

<?php
$args = array(
    'posts_per_page' => 1,
    'post__in'  => get_option( 'sticky_posts' ),
    'ignore_sticky_posts' => 1
);

$the_query = new WP_Query($args);
if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();

        $img_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        if ($img_url != "") {
            $img_url = $img_url[0];
        }else if(get_theme_mod('active_immagine_evidenza_default')) {	
            $img_url = esc_url(get_theme_mod('immagine_evidenza_default'));
            if($img_url=="") {
                $img_url = get_bloginfo('template_url') . "/images/400x220.png";
            }
        }

        $category = get_the_category(); $first_category = $category[0];
        $datapost = get_the_date('j F Y', '', ''); ?>

<section id="novita_evidenza">
    <article>
        <div class="novita-foto">
            <?php if($img_url!="") { ?>
            <img src="<?php print $img_url; ?>" alt="<?php the_title(); ?>" />
            <?php } ?>
        </div>
        <div class="novita-testo">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            <a href="<?php the_permalink(); ?>"
                               title="<?php the_title(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <p><?php echo get_the_excerpt(); ?></p>
                        <p class="Grid-cell u-textSecondary"><?php echo $datapost; ?></p>
                        <div class="argomenti">
                            <?php
                            if (!empty($category)) {
                                foreach ($category as $cat) {
                                    echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" title="' . esc_html($cat->name) . '" class="badge badge-pill badge-argomenti">' . esc_html($cat->name) . '</a>';
                                }
                            }
                            ?>
                        </div>
                        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"
                           title="Vai alla pagina: Tutte le novità" class="tutte">
                            Tutte le novità
                            <svg class="icon">
                                <use xlink:href="<?php bloginfo('template_url'); ?>/static/img/ponmetroca.svg#ca-arrow_forward"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
            
<?php
    
    endwhile;  endif;
    wp_reset_postdata();
