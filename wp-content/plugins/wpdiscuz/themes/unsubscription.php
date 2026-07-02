<?php
if (!defined("ABSPATH")) {
    exit();
}
if (wp_is_block_theme()) {
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wp-site-blocks">
    <header class="wp-block-template-part site-header">
        <?php block_header_area(); ?>
    </header>
    <?php
    } else {
        get_header();
    }
    do_action("wpdiscuz_subscription_template_before");
    ?>
    <div style="margin: 0 auto; padding: 50px 0; max-width:800px" class="wpdc-unsubscription-main">
        <?php
        global $wpDiscuzSubscriptionMessage, $wpDiscuzSubscriptionKey, $wpDiscuzSubscriptionAction;
        $wpdiscuz = wpDiscuz();
        add_filter("is_load_wpdiscuz", '__return_true');
        if ($wpDiscuzSubscriptionKey) {
            echo '<h2 class="wpdc-unsubscription-message">' . esc_html__('Do you want to delete', 'wpdiscuz') . ' ' . esc_html($wpDiscuzSubscriptionMessage) . '?</h2>';
            ?>
            <div class="wpdc-unsubscription-actions" style="text-align: center; padding: 20px;">
                <button type="button" id="wpdc-unsubscription-delete-button" class="wpdc-unsubscription-delete" data-action="<?php esc_attr_e($wpDiscuzSubscriptionAction, 'wpdiscuz'); ?>"
                        data-key="<?php esc_attr_e($wpDiscuzSubscriptionKey, 'wpdiscuz'); ?>">
                    <?php esc_html_e('Delete', 'wpdiscuz'); ?>
                </button>
            </div>
            <?php
        } else {
            echo '<h2 class="wpdc-unsubscription-message">' . esc_html($wpDiscuzSubscriptionMessage) . '</h2>';
        }
        ?>
        <br>
        <?php
        $currentUser = WpdiscuzHelper::getCurrentUser();
        $userEmail   = isset($_COOKIE["comment_author_email_" . COOKIEHASH]) ? sanitize_email(wp_unslash($_COOKIE["comment_author_email_" . COOKIEHASH])) : "";
        if ($currentUser->exists()) {
            $userEmail = $currentUser->user_email;
        }

        if ($userEmail) {
            ?>
            <div class="wpdc-unsubscription-bulk">
                <?php $bulkManageLink = home_url("/wpdiscuzsubscription/bulkmanagement/"); ?>
                <a href="<?php echo wp_nonce_url($bulkManageLink, $wpdiscuz->helper->generateNonceKey()); ?>"
                   class="wpdc-unsubscription-manage-link">
                    <?php esc_html_e($wpdiscuz->options->getPhrase("wc_user_settings_email_me_delete_links")) ?>
                </a>( <?php esc_html_e($userEmail); ?> )
                <div class="wpdc-unsubscription-manage-link-desc">
                    <?php esc_html_e($wpdiscuz->options->getPhrase("wc_user_settings_email_me_delete_links_desc")) ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>
        let wpdcUnsubscriptionDeleteButton = document.getElementById("wpdc-unsubscription-delete-button");
        if (wpdcUnsubscriptionDeleteButton) {
            wpdcUnsubscriptionDeleteButton.addEventListener("click", async function () {
                try {
                    const wpdcUnsubscriptionAction = this.getAttribute("data-action");
                    const wpdcUnsubscriptionKey = this.getAttribute("data-key");
                    const wpdcUnsubscriptionDeleteUrl = '<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>';
                    const wpdiscuzNonce = '<?php echo esc_js($wpdiscuz->helper->generateNonce()); ?>';

                    const wpdcUnsubscriptionData = new FormData();
                    wpdcUnsubscriptionData.append('action', 'wpdiscuzDeleteDataWithEmail');
                    wpdcUnsubscriptionData.append('wpdiscuz_nonce', wpdiscuzNonce);
                    wpdcUnsubscriptionData.append('unsubscription_action', wpdcUnsubscriptionAction);
                    wpdcUnsubscriptionData.append('unsubscription_key', wpdcUnsubscriptionKey);

                    const wpdcUnsubscriptionDeleteResponse = await fetch(wpdcUnsubscriptionDeleteUrl, {
                        method: 'POST',
                        body: wpdcUnsubscriptionData,
                    });
                    const wpdcUnsubscriptionResponseData = await wpdcUnsubscriptionDeleteResponse.json();
                    console.log(wpdcUnsubscriptionResponseData);
                    if (wpdcUnsubscriptionResponseData.success) {
                        this.style.display = 'none';
                    }
                    document.querySelector('.wpdc-unsubscription-message').innerHTML = wpdcUnsubscriptionResponseData.data.message;
                } catch (e) {
                    console.error(e);
                }
            });
        }
    </script>
    <?php
    do_action("wpdiscuz_subscription_template_after");
    if (wp_is_block_theme()) {
    ?>
    <footer class="wp-block-template-part site-footer">
        <?php block_footer_area(); ?>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
<?php
} else {
    get_footer();
}
?>
