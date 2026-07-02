<?php
if (!isset($options) || !is_array($options)) {
    $options = bakhtech_cs_get_options();
}

$launch_js = isset($options['launch_js']) ? $options['launch_js'] : bakhtech_cs_format_js_datetime($options['launch_datetime']);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html($options['page_title']); ?></title>
    <?php wp_head(); ?>
    <style>
        :root {
            --cs-primary: <?php echo esc_attr($options['color_primary']); ?>;
            --cs-bg: <?php echo esc_attr($options['color_bg']); ?>;
            --cs-text-main: <?php echo esc_attr($options['color_text']); ?>;
            --cs-white: <?php echo esc_attr($options['color_card_bg']); ?>;
        }
    </style>
</head>
<body <?php body_class('bakhtech-cs-body'); ?>>
<?php wp_body_open(); ?>
    <div class="bakhtech-cs-shell">
        <header class="bakhtech-cs-header">
            <?php if ($options['header_label'] !== '') : ?>
                <span class="bakhtech-cs-header-label"><?php echo esc_html($options['header_label']); ?></span>
            <?php endif; ?>
        </header>
        <main class="bakhtech-cs-main">
            <!-- Badge -->
            <?php if ($options['badge_text'] !== '') : ?>
                <div class="bakhtech-cs-badge">
                    <span class="bakhtech-cs-badge-icon" aria-hidden="true">
                        <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                            <path d="M11 2l-6 8h4l-1 8 6-8h-4l1-8z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <span><?php echo esc_html($options['badge_text']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Logo Area -->
            <div class="bakhtech-cs-logo-area">
                <?php if (!empty($options['logo_url'])) : ?>
                    <img src="<?php echo esc_url($options['logo_url']); ?>" alt="<?php echo esc_attr($options['brand_title']); ?>" class="bakhtech-cs-logo-img">
                <?php else : ?>
                    <!-- Default Icon -->
                    <div class="bakhtech-cs-icon-default" aria-hidden="true">
                        <svg viewBox="0 0 64 64" aria-hidden="true" focusable="false">
                            <path d="M32 8L6 22l26 14 26-14L32 8z" fill="#1d77f2"></path>
                            <path d="M14 30v12l18 10 18-10V30l-18 10-18-10z" fill="#1d77f2"></path>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Main Title -->
            <?php if ($options['brand_title'] !== '') : ?>
                <h1 class="bakhtech-cs-title"><?php echo esc_html($options['brand_title']); ?></h1>
            <?php endif; ?>

            <!-- Tagline -->
            <?php if ($options['tagline_text'] !== '' || $options['tagline_highlight'] !== '') : ?>
                <p class="bakhtech-cs-tagline">
                    <?php echo esc_html($options['tagline_text']); ?>
                    <?php if ($options['tagline_highlight'] !== '') : ?>
                        <span class="bakhtech-cs-highlight"><?php echo esc_html($options['tagline_highlight']); ?></span>
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <!-- Description -->
            <?php if ($options['description_line_1'] !== '' || $options['description_line_2'] !== '') : ?>
                <p class="bakhtech-cs-description">
                    <?php echo esc_html($options['description_line_1']); ?>
                    <?php if ($options['description_line_2'] !== '') : ?>
                        <br><?php echo esc_html($options['description_line_2']); ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <!-- Countdown -->
            <div class="bakhtech-cs-countdown" data-countdown="<?php echo esc_attr($launch_js); ?>">
                <div class="bakhtech-cs-countdown-item">
                    <div class="bakhtech-cs-count" data-unit="days">00</div>
                    <div class="bakhtech-cs-count-label"><?php echo esc_html($options['label_days']); ?></div>
                </div>
                <!-- Colon separator handled by CSS -->
                <div class="bakhtech-cs-countdown-item">
                    <div class="bakhtech-cs-count" data-unit="hours">00</div>
                    <div class="bakhtech-cs-count-label"><?php echo esc_html($options['label_hours']); ?></div>
                </div>
                 <!-- Colon separator handled by CSS -->
                <div class="bakhtech-cs-countdown-item">
                    <div class="bakhtech-cs-count" data-unit="mins">00</div>
                    <div class="bakhtech-cs-count-label"><?php echo esc_html($options['label_mins']); ?></div>
                </div>
                 <!-- Colon separator handled by CSS -->
                <div class="bakhtech-cs-countdown-item">
                    <div class="bakhtech-cs-count" data-unit="secs">00</div>
                    <div class="bakhtech-cs-count-label"><?php echo esc_html($options['label_secs']); ?></div>
                </div>
            </div>

            <!-- Form -->
            <div class="bakhtech-cs-form">
                <?php if (!empty($options['fluent_form_shortcode'])) : ?>
                    <div class="bakhtech-cs-fluent-form">
                        <?php echo do_shortcode($options['fluent_form_shortcode']); ?>
                    </div>
                <?php else : ?>
                    <div class="bakhtech-cs-input-group">
                        <span class="bakhtech-cs-input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="email" placeholder="<?php echo esc_attr($options['input_placeholder']); ?>" aria-label="<?php echo esc_attr($options['input_placeholder']); ?>">
                        <button type="button"><?php echo esc_html($options['button_label']); ?></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($options['form_note'] !== '') : ?>
                    <p class="bakhtech-cs-form-note"><?php echo esc_html($options['form_note']); ?></p>
                <?php endif; ?>
            </div>
        </main>

        <footer class="bakhtech-cs-footer">
            <?php if ($options['footer_text'] !== '') : ?>
                <span class="bakhtech-cs-footer-text"><?php echo wp_kses_post($options['footer_text']); ?></span>
            <?php endif; ?>
            <div class="bakhtech-cs-socials">
                <?php if (!empty($options['social_twitter'])) : ?>
                    <a href="<?php echo esc_url($options['social_twitter']); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if (!empty($options['social_linkedin'])) : ?>
                    <a href="<?php echo esc_url($options['social_linkedin']); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if (!empty($options['social_instagram'])) : ?>
                    <a href="<?php echo esc_url($options['social_instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.585-.011-4.849-.069-3.259-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
