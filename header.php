<?php
/**
 * Header
 */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$currentUrl = ($parsedUrl['query'] !== 'id' ? $protocol . $host . $requestUri : $protocol . $host . $parsedUrl['path']);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">
    <!-- Color mobile browser tab -->
    <!--	<meta name="theme-color" content="#4285f4" />-->

    <!-- Add external fonts below (Typekit Only!) -->
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-5L7NTDC');</script>
    <!-- End Google Tag Manager -->

    <!-- Newsletter HubSpot Form -->
    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>

    <script>

        <!-- Home Page Newsletter Hub Spot Form -->

        hbspt.forms.create({
            portalId: "4990772",
            formId: "333229e1-23c5-455a-b9ec-6f120551dfbe",
            target: '#hs-home-newsletter-form',
            cssRequired: true,
            css: `
            .newsletter-form .hs-form .hs-input,
            .newsletter-form .hs-form .hs_hs_persona select,
            .newsletter-form .hs-form .input .select2-selection--single {
                border: 0.0625rem solid #576949;
                border-radius: 3.125rem;
                border-bottom-left-radius: 3.125rem;
                font-size: 0.75rem;
                -webkit-appearance: none;
                appearance: none;
                height: 2.5rem;
                &:hover {
                    cursor: pointer;
                }
                &:focus {
                    background-color: #fff;
                }
            }
            .newsletter-form .hs-form .hs-button {
                height: 2.5rem;
            }
            .newsletter-form .hs-form .input .select2-selection--single {
                padding-top: 0.75rem;
            }
            .newsletter-form .hs-form input {
              &::placeholder {
                font-style: italic;
              }
            }

            .hs-form .no-list {
                list-style-position: none;
                list-style: none;
            }
            .hs-form .no-list li {
                text-decoration: none;
            }
            .hs-form .no-list ul {
                margin-left: 0;
            }

            .newsletter-form .hs-form .no-list .hs-main-font-element {
                margin-top: 1rem;
                color: #a32a39;
                font-style: italic;
                font-size: .75rem;
                padding-top: 0;
                margin-top: .75rem;
                padding-left: 1.25rem;
            }
            .newsletter-form .hs-form .hs-fieldtype-text label,
            .newsletter-form .hs-form .hs-fieldtype-select label {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .hs-form .hs-fieldtype-text span,
            .hs-form .hs-fieldtype-select span {
                font-size: 0.875rem;
                line-height: 1.375rem;
            }
            .newsletter-form .hs-form .hs-button {
                background-color: #576949;
                padding: .75rem 2.875rem .75rem 1.25rem;
                margin-top: 2rem;
                border-radius: 3.125rem;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");
                background-repeat: no-repeat;
                background-position: 5.7rem center;
                &:hover {
                    background-color: #2c3a25;

                }
            }
        `
        });


        <!-- Newsletter-form-sign-up-page -->

        hbspt.forms.create({
            portalId: "4990772",
            formId: "ccd4457a-d189-4412-9c17-dbbeed810235",
            target: '#hs-newsletter-form-sign-up',
            cssRequired: true,
            css: `
            .newsletter-form .hs-form .hs-input,
            .newsletter-form .hs-form .hs_hs_persona select,
            .newsletter-form .hs-form .input .select2-selection--single {
                border: 0.0625rem solid #576949;
                border-radius: 3.125rem;
                border-bottom-left-radius: 3.125rem;
                font-size: 0.75rem;
                -webkit-appearance: none;
                appearance: none;
                height: 2.5rem;
                &:hover {
                    cursor: pointer;
                }
                &:focus {
                    background-color: #fff;
                }
            }
            .newsletter-form .hs-form .hs-button {
                height: 2.5rem;
            }
            .newsletter-form .hs-form .input .select2-selection--single {
                padding-top: 0.75rem;
            }
            .newsletter-form .hs-form input {
              &::placeholder {
                font-style: italic;
              }
            }

            .hs-form .no-list {
                list-style-position: none;
                list-style: none;
            }
            .hs-form .no-list li {
                text-decoration: none;
            }
            .hs-form .no-list ul {
                margin-left: 0;
            }

            .newsletter-form .hs-form .no-list .hs-main-font-element {
                margin-top: 1rem;
                color: #a32a39;
                font-style: italic;
                font-size: .75rem;
                padding-top: 0;
                margin-top: .75rem;
                padding-left: 1.25rem;
            }
            .newsletter-form .hs-form .hs-fieldtype-text label,
            .newsletter-form .hs-form .hs-fieldtype-select label {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .hs-form .hs-fieldtype-text span,
            .hs-form .hs-fieldtype-select span {
                font-size: 0.875rem;
                line-height: 1.375rem;
            }
            .newsletter-form .hs-form .hs-button {
                background-color: #576949;
                padding: .75rem 2.875rem .75rem 1.25rem;
                margin-top: 2rem;
                border-radius: 3.125rem;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");
                background-repeat: no-repeat;
                background-position: 5.7rem center;
                &:hover {
                    background-color: #2c3a25;

                }
            }
        `
        });




        <!-- Contact Us Page Newsletter Hub Spot Form -->

        hbspt.forms.create({
            portalId: "4990772",
            formId: "a32fcb7f-5d45-4f63-b100-06a135dc75fa",
            target: '#hs-contact-newsletter-form',
            cssRequired: true,
            css: `
            .newsletter-form .hs-form .hs-input,
            .newsletter-form .hs-form .hs_hs_persona select,
            .newsletter-form .hs-form .input .select2-selection--single {
                border: 0.0625rem solid #576949;
                border-radius: 3.125rem;
                border-bottom-left-radius: 3.125rem;
                font-size: 0.75rem;
                -webkit-appearance: none;
                appearance: none;
                height: 2.5rem;
                &:hover {
                    cursor: pointer;
                }
                &:focus {
                    background-color: #fff;
                }
            }
            .newsletter-form .hs-form .hs-button {
                height: 2.5rem;
            }
            .newsletter-form .hs-form .input .select2-selection--single {
                padding-top: 0.75rem;
            }
            .newsletter-form .hs-form input {
              &::placeholder {
                font-style: italic;
              }
            }

            .hs-form .no-list {
                list-style-position: none;
                list-style: none;
            }
            .hs-form .no-list li {
                text-decoration: none;
            }
            .hs-form .no-list ul {
                margin-left: 0;
            }

            .newsletter-form .hs-form .no-list .hs-main-font-element {
                margin-top: 1rem;
                color: #a32a39;
                font-style: italic;
                font-size: .75rem;
                padding-top: 0;
                margin-top: .75rem;
                padding-left: 1.25rem;
            }
            .newsletter-form .hs-form .hs-fieldtype-text label,
            .newsletter-form .hs-form .hs-fieldtype-select label {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .hs-form .hs-fieldtype-text span,
            .hs-form .hs-fieldtype-select span {
                font-size: 0.875rem;
                line-height: 1.375rem;
            }
            .newsletter-form .hs-form .hs-button {
                background-color: #576949;
                padding: .75rem 2.875rem .75rem 1.25rem;
                margin-top: 2rem;
                border-radius: 3.125rem;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");
                background-repeat: no-repeat;
                background-position: 5.7rem center;
                &:hover {
                    background-color: #2c3a25;

                }
            }
        `
        });

        <!-- About Us Page Newsletter Hub Spot Form -->

        hbspt.forms.create({
            portalId: "4990772",
            formId: "c8e4b8a7-ce0b-491c-8551-b069705f38bb",
            target: '#hs-about-newsletter-form',
            cssRequired: true,
            css: `
            .newsletter-form .hs-form .hs-input,
            .newsletter-form .hs-form .hs_hs_persona select,
            .newsletter-form .hs-form .input .select2-selection--single {
                border: 0.0625rem solid #576949;
                border-radius: 3.125rem;
                border-bottom-left-radius: 3.125rem;
                font-size: 0.75rem;
                -webkit-appearance: none;
                appearance: none;
                height: 2.5rem;
                &:hover {
                    cursor: pointer;
                }
                &:focus {
                    background-color: #fff;
                }
            }
            .newsletter-form .hs-form .hs-button {
                height: 2.5rem;
            }
            .newsletter-form .hs-form .input .select2-selection--single {
                padding-top: 0.75rem;
            }
            .newsletter-form .hs-form input {
              &::placeholder {
                font-style: italic;
              }
            }

            .hs-form .no-list {
                list-style-position: none;
                list-style: none;
            }
            .hs-form .no-list li {
                text-decoration: none;
            }
            .hs-form .no-list ul {
                margin-left: 0;
            }

            .newsletter-form .hs-form .no-list .hs-main-font-element {
                margin-top: 1rem;
                color: #a32a39;
                font-style: italic;
                font-size: .75rem;
                padding-top: 0;
                margin-top: .75rem;
                padding-left: 1.25rem;
            }
            .newsletter-form .hs-form .hs-fieldtype-text label,
            .newsletter-form .hs-form .hs-fieldtype-select label {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .hs-form .hs-fieldtype-text span,
            .hs-form .hs-fieldtype-select span {
                font-size: 0.875rem;
                line-height: 1.375rem;
            }
            .newsletter-form .hs-form .hs-button {
                background-color: #576949;
                padding: .75rem 2.875rem .75rem 1.25rem;
                margin-top: 2rem;
                border-radius: 3.125rem;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");
                background-repeat: no-repeat;
                background-position: 5.7rem center;
                &:hover {
                    background-color: #2c3a25;

                }
            }
        `
        });

        <!-- Footer Newsletter Hub Spot Form -->

        hbspt.forms.create({
            portalId: "4990772",
            formId: "343a5f74-ddc8-4354-a9f0-f4c05840b038",
            target: '#hs-footer-newsletter-form',
            cssRequired: true,
            css: `
            #hs-footer-newsletter-form .hs-form .hs-input,
            #hs-footer-newsletter-form .hs-form .hs_hs_persona select,
            #hs-footer-newsletter-form .hs-form .input .select2-selection--single {
                border: 0.0625rem solid #576949;
                border-radius: 3.125rem;
                border-bottom-left-radius: 3.125rem;
                font-size: 0.75rem;
                -webkit-appearance: none;
                appearance: none;
                height: 2.5rem;

                &:hover {
                    cursor: pointer;
                }
                &:focus {
                    background-color: #fff;
                }
            }
            #hs-footer-newsletter-form .hs-form .hs-button {
                height: 2.5rem;
            }
            #hs-footer-newsletter-form .hs-form .input .select2-selection--single {
                padding-right: 2rem;
            }
            #hs-footer-newsletter-form .hs-form input {
              &::placeholder {
                font-style: italic;
              }
            }

            .hs-form .select2-container--default.select2-container--open.select2-container--below .select2-selection--single {
                border-bottom-left-radius: 3.125rem;
                border-bottom-right-radius: 3.125rem;
            }

            .hs-form .no-list {
                list-style-position: none;
                list-style: none;
            }
            .hs-form .no-list li {
                text-decoration: none;
            }
            .hs-form .no-list ul {
                margin-left: 0;
            }

            #hs-footer-newsletter-form .hs-form .no-list .hs-main-font-element {
                margin-top: 1rem;
                color: #a32a39;
                font-style: italic;
                font-size: .75rem;
                padding-top: 0;
                margin-top: .75rem;
                padding-left: 1.25rem;
            }
            #hs-footer-newsletter-form .hs-fieldtype-text,
            #hs-footer-newsletter-form .hs-fieldtype-select {
                display: grid;
                grid-template-columns: 51% 49%;
                margin-bottom: 0.5rem;
            }
            #hs-footer-newsletter-form .hs-form .hs-fieldtype-text label,
            #hs-footer-newsletter-form .hs-form .hs-fieldtype-select label {
                grid-column: 1;
                margin-right: 0.8rem;
                display: flex;
                align-items: center;
            }

            #hs-footer-newsletter-form .hs-form .hs-fieldtype-text .input,
            #hs-footer-newsletter-form .hs-form .hs-fieldtype-select .input {
                grid-column: 2;
            }

            #hs-footer-newsletter-form .hs-form .hs-fieldtype-text .no-list.hs-error-msgs,
            #hs-footer-newsletter-form .hs-form .hs-fieldtype-select .no-list.hs-error-msgs {
                margin-top: 0,2rem;
                grid-column: 1 / -1;
            }
            .hs-form .hs-fieldtype-text span,
            .hs-form .hs-fieldtype-select span {
                font-size: 0.875rem;
                line-height: 1.375rem;
            }

            .hs-form .hs-fieldtype-select .selection {
                width: 100%;
            }
            #hs-footer-newsletter-form .hs-form .hs-button {
                background-color: #576949;
                padding: .75rem 2.875rem .75rem 1.25rem;
                border-radius: 3.125rem;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");
                background-repeat: no-repeat;
                background-position: 5.7rem center;
                &:hover {
                    background-color: #2c3a25;

                }
            }
        `
        });

<!-- Сontent Newsletter Hub Spot Form -->

        hbspt.forms.create({
            portalId: "4990772",
            formId: "333229e1-23c5-455a-b9ec-6f120551dfbe",
            target: '#hs-content-newsletter-form',
            cssRequired: true,
            css: `
            #hs-content-newsletter-form .hs-form .hs-input,
            #hs-content-newsletter-form .hs-form .hs_hs_persona select,
            #hs-content-newsletter-form .hs-form .input .select2-selection--single {
                border: 0.0625rem solid #576949;
                border-radius: 3.125rem;
                border-bottom-left-radius: 3.125rem;
                font-size: 0.75rem;
                -webkit-appearance: none;
                appearance: none;
                height: 2.5rem;

                &:hover {
                    cursor: pointer;
                }
                &:focus {
                    background-color: #fff;
                }
            }
            #hs-footer-newsletter-form .hs-form .hs-button {
                height: 2.5rem;
            }
            #hs-footer-newsletter-form .hs-form .input .select2-selection--single {
                padding-right: 2rem;
            }
            #hs-footer-newsletter-form .hs-form input {
              &::placeholder {
                font-style: italic;
              }
            }

            .hs-form .select2-container--default.select2-container--open.select2-container--below .select2-selection--single {
                border-bottom-left-radius: 3.125rem;
                border-bottom-right-radius: 3.125rem;
            }

            .hs-form .no-list {
                list-style-position: none;
                list-style: none;
            }
            .hs-form .no-list li {
                text-decoration: none;
            }
            .hs-form .no-list ul {
                margin-left: 0;
            }

            #hs-content-newsletter-form .hs-form .no-list .hs-main-font-element {
                margin-top: 1rem;
                color: #a32a39;
                font-style: italic;
                font-size: .75rem;
                padding-top: 0;
                margin-top: .75rem;
                padding-left: 1.25rem;
            }
            #hs-content-newsletter-form .hs-fieldtype-text,
            #hs-content-newsletter-form .hs-fieldtype-select {
                display: grid;
                grid-template-columns: 51% 49%;
                margin-bottom: 0.5rem;
            }
            #hs-content-newsletter-form .hs-form .hs-fieldtype-text label,
            #hs-content-newsletter-form .hs-form .hs-fieldtype-select label {
                grid-column: 1;
                margin-right: 0.8rem;
                display: flex;
                align-items: center;
            }

            #hs-content-newsletter-form .hs-form .hs-fieldtype-text .input,
            #hs-content-newsletter-form .hs-form .hs-fieldtype-select .input {
                grid-column: 2;
            }

            #hs-content-newsletter-form .hs-form .hs-fieldtype-text .no-list.hs-error-msgs,
            #hs-content-newsletter-form .hs-form .hs-fieldtype-select .no-list.hs-error-msgs {
                margin-top: 0,2rem;
                grid-column: 1 / -1;
            }
            .hs-form .hs-fieldtype-text span,
            .hs-form .hs-fieldtype-select span {
                font-size: 0.875rem;
                line-height: 1.375rem;
            }

            .hs-form .hs-fieldtype-select .selection {
                width: 100%;
            }
            #hs-content-newsletter-form .hs-form .hs-button {
                background-color: #576949;
                padding: .75rem 2.875rem .75rem 1.25rem;
                border-radius: 3.125rem;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");
                background-repeat: no-repeat;
                background-position: 5.7rem center;
                &:hover {
                    background-color: #2c3a25;

                }
            }
        `
        });

        <!-- Contact Us HubSpot Form -->
        <!--        hbspt.forms.create({-->
        <!--            portalId: "4990772",-->
        <!--            formId: "8064f479-4286-45a3-acc5-59413b21bd14",-->
        <!--            target: '#contact-us-form',-->
        <!--            cssRequired: true,-->
        <!--            css: `-->
        <!--            .hs-form input,-->
        <!--            .hs-form textarea {-->
        <!--                border: 0.0625rem solid #576949;-->
        <!--                border-radius: 3.125rem;-->
        <!--                font-size: 1rem;-->
        <!--            }-->
        <!--            .hs-form textarea {-->
        <!--                border-radius: 0.625rem;-->
        <!--            }-->
        <!---->
        <!--            .hs-form .no-list {-->
        <!--                list-style-position: none;-->
        <!--                list-style: none;-->
        <!--            }-->
        <!--            .hs-form .no-list li {-->
        <!--                text-decoration: none;-->
        <!--            }-->
        <!--            .hs-form .no-list ul {-->
        <!--                margin-left: 0;-->
        <!--            }-->
        <!--            .hs-form .no-list .hs-error-msg{-->
        <!--                margin-top: 1rem;-->
        <!--                color: #a32a39;-->
        <!--                font-style: italic;-->
        <!--                font-size: .75rem;-->
        <!--                padding-top: 0;-->
        <!--                margin-top: .75rem;-->
        <!--                padding-left: 1.25rem;-->
        <!--                margin-bottom: 1.25rem;-->
        <!--            }-->
        <!--            .hs-form .hs-fieldtype-text label,-->
        <!--            .hs-form .hs-fieldtype-textarea label {-->
        <!--                margin-bottom: 0.5rem;-->
        <!--                margin-top: 1.25rem;-->
        <!--            }-->
        <!--            .hs-form .hs-fieldtype-textarea .input textarea  {-->
        <!--                height: 9.375rem-->
        <!--            }-->
        <!--            .hs-form .hs-fieldtype-text span,-->
        <!--            .hs-form .hs-fieldtype-textarea span {-->
        <!--                font-size: 0.875rem;-->
        <!--                line-height: 1.375rem;-->
        <!--            }-->
        <!--            .hs-form .hs-button {-->
        <!--                background-color: #576949;-->
        <!--                padding: .75rem 2.875rem .75rem 1.25rem;-->
        <!--                margin-top: 2.25rem;-->
        <!--                border-radius: 3.125rem;-->
        <!--                color: #fff;-->
        <!--                font-weight: 700;-->
        <!--                font-size: 1rem;-->
        <!--                line-height: 1;-->
        <!--                color: #fff;-->
        <!--                background-image: url("/wp-content/themes/wholistic-matters-main/assets/images/Line%201.svg");-->
        <!--                background-repeat: no-repeat;-->
        <!--                background-position: 5.7rem center;-->
        <!--                &:hover {-->
        <!--                    background-color: #2c3a25;-->
        <!---->
        <!--                }-->
        <!--            }-->
        <!--        `-->
        <!--        });-->
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- <div class="preloader hide-for-medium">
	<div class="preloader__icon"></div>
</div> -->

<?php
    $has_header_banner = get_field('toggle_header_banner', 'option');
    $header_classes = ( $has_header_banner ) ? 'header banner-margin' : 'header';
?>

<!-- BEGIN of header -->
<header class="<?php echo $header_classes; ?>">
    <?php if( have_rows('header_slider', 'option') ): ?>
        <ul  class="header-slider hs-cta-trigger-button hs-cta-trigger-button-181938718511-deactivated">
            <?php while( have_rows('header_slider', 'option') ): the_row();
                $text = get_sub_field('text', 'option');
                ?>
                <li class="header-slider-item">
                    <span><?php echo $text; ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
    <?php if( $has_header_banner ): ?>
        <div class="header-banner ">
            <?php echo get_field('header_banner', 'option'); ?>
        </div>
    <?php endif; ?>
    <div class="header-content">
        <div class="logo text-center medium-text-left">
            <h1><?php show_custom_logo(); ?><span class="css-clip"><?php echo get_bloginfo( 'name' ); ?></span></h1>
        </div>
        <?php if ( has_nav_menu( 'header-menu' ) || has_nav_menu( 'mobile-menu' ))  : ?>
            <nav class="top-bar" id="main-menu">
                <?php wp_nav_menu( array(
                    'theme_location' => 'header-menu',
                    'menu_class'     => 'menu header-menu',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                    'walker'         => new Walker_Navigation()
                ) ); ?>
                <?php wp_nav_menu( array(
                    'theme_location' => 'mobile-menu',
                    'menu_class'     => 'menu header-menu',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                    'walker'         => new Mob_Walker_Navigation()
                ) ); ?>
            </nav>
        <?php endif; ?>

        <div class="header-search">
            <a id="header-search-icon" href="/?s=" aria-label="Search"><?php echo return_svg(get_template_directory_uri().'/assets/images/search-icon.svg', 'search-icon') ?></a>
            <button id="header-search-icon-mobile" type="button" class="header-search-icon-mobile" aria-label="Toggle search">

                <?php echo return_svg(get_template_directory_uri().'/assets/images/search-icon.svg', 'search-icon') ?>
                <?php echo return_svg(get_template_directory_uri().'/assets/images/cross-black.svg', 'cross-icon') ?>
            </button>
            <input id="header-search" placeholder="Search">
            <div class="header__menu-toggle">
                <div class="title-bar hide-for-large" data-responsive-toggle="main-menu" data-hide-for="large">
                    <button class="menu-icon" type="button" data-toggle aria-label="Menu" aria-controls="main-menu"><span></span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="search-modal">
        <div class="header-search">
            <?php echo return_svg(get_template_directory_uri().'/assets/images/search-icon.svg', 'search-icon') ?>
            <input id="search-modal-input" placeholder="Enter search here...">
            <a href="" class="search-modal-arrow" aria-label="Submit search"><?php echo return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></a>
        </div>
        <span id="search-option-title">Advance Search Options<?php display_svg(get_template_directory_uri().'/assets/images/arrow-down.svg', 'arrow-down-icon') ?></span>
        <?php if( have_rows('search_options_list', 'option') ): ?>
            <ul class="search-options-list">
                <?php while( have_rows('search_options_list', 'option') ): the_row();
                    $search_audience = get_sub_field('search_audience','option');
                    $args = array(
                        'post_type' => 'page',
                        'tax_query' => array(
                            array(
                                'taxonomy' => $search_audience->taxonomy,
                                'field'    => 'slug',
                                'terms'    => $search_audience->slug,
                            ),
                        ),
                    );

                    $query = new WP_Query($args);
                    $title = $query->posts[0]->post_title;
                    ?>
                    <li>
                        <span><?php echo $title; ?></span>
                        <?php
                        $search_params = get_sub_field('search_params', 'option');
                        if( $search_params ): ?>
                            <ul>
                                <?php foreach( $search_params as $search_param ): ?>
                                    <li class="search-option" data-audience-tax="<?php echo $search_audience->taxonomy?>" data-taxonomy="<?php echo $search_param->taxonomy?>" data-audience-term="<?php echo $search_audience->slug?>">
                                        <input type="radio" id="<?php echo $search_audience->slug ."-" . $search_param->slug?>"  value="<?php echo $search_param->slug?>">
                                        <label class="radio-label" for="<?php echo $search_audience->slug ."-" . $search_param->slug?>"><?php echo $search_param->name?></label><br>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                            // Reset the global post object so that the rest of the page works correctly.
                            wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</header>
<!-- END of header -->