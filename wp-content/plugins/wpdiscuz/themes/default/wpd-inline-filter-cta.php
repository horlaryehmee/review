<?php

if (!defined('ABSPATH')) {
    exit();
}

/**
 * @var $wpdiscuz WpdiscuzCore
 */
if (!isset($wpdiscuz)) {
    $wpdiscuz = wpDiscuz();
}
//wpd-inline-filter-cta
?>
<div class="wpd-inline-filter-cta">
    <div class="wpd-current-view">
        <i class="fas fa-quote-left"></i> <?php esc_html_e($wpdiscuz->options->getPhrase("wc_inline_feedbacks")); ?>
    </div>
    <div class="wpd-filter-view-all"><?php esc_html_e($wpdiscuz->options->getPhrase("wc_inline_comments_view_all")); ?></div>
</div>
