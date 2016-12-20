<?php
remove_all_actions('wp_footer', 1234);
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <![endif]-->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'oasis/action/before_render_main' ); ?>
<div id="page" class="site">
    <div class="site-inner">
        <header id="masthead" class="site-header">
            <div class="site-header-inner">
                <div class="container">
                    <div class="site-branding">
                        <a href="<?php echo esc_url( home_url( '/'  ) ); ?>" rel="home">
                            <figure class="logo--normal"><?php Oasis()->getLayout()->renderLogo();?></figure>
                            <figure class="logo--transparency"><?php Oasis()->getLayout()->renderTransparencyLogo();?></figure>
                        </a>
                    </div>
                    <nav class="site-main-nav pull-right margin-top-25">
                        <a href="https://themeforest.net/item/oasis-modern-woocommerce-theme/18401438" class="btn">Purchase</a>
                    </nav>
                </div>
            </div>
        </header>
        <!-- #masthead -->
        <div id="main" class="site-main">
            <div class="container">
                <div class="row">
                    <main id="site-content" class="col-md-12 col-xs-12 site-content">
                        <div class="site-content-inner">
                            <?php
                            if( have_posts() ):  the_post();
                                the_content();
                            endif;
                            ?>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
wp_footer();
?>
</body>
</html>