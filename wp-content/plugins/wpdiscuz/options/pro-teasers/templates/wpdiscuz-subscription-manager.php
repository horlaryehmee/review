<?php

if (!defined("ABSPATH")) {
    exit();
}

// Compute unique month/year labels for the Subscriptions "All Dates" dropdown.
// Offsets mirror the dummy dates used in the table rows below.
$sub_offsets = ["-3 days", "-11 days", "-27 days"];
$sub_months  = [];
foreach ($sub_offsets as $offset) {
    $key = date("Y-m", strtotime($offset));
    if (!isset($sub_months[$key])) {
        $sub_months[$key] = date_i18n("F Y", strtotime($offset));
    }
}
// Sort newest first (keys are "YYYY-MM" so krsort works correctly).
krsort($sub_months);

// Compute unique month/year labels for the Follows "All Dates" dropdown.
$fol_offsets = ["-5 days", "-19 days"];
$fol_months  = [];
foreach ($fol_offsets as $offset) {
    $key = date("Y-m", strtotime($offset));
    if (!isset($fol_months[$key])) {
        $fol_months[$key] = date_i18n("F Y", strtotime($offset));
    }
}
krsort($fol_months);

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-email-alt"></span>
            <?php esc_html_e("Subscription Manager Addon", "wpdiscuz"); ?>
            <span class="wpd-pro-badge"><?php esc_html_e("PRO", "wpdiscuz"); ?></span>
        </span>
        <span class="wpd-pro-teaser-header-right">
            <span class="wpd-pro-toggle-icon">&#9650;</span>
        </span>
    </div>

    <div class="wpd-pro-teaser-body">

        <!-- Intro -->
        <div class="wpd-opt-row">
            <div class="wpd-opt-intro">
                <?php esc_html_e("Adds two dedicated admin pages under the wpDiscuz menu:", "wpdiscuz"); ?>
                <ul class="wsbm-pro-intro-list">
                    <li><strong><?php esc_html_e("Subscriptions", "wpdiscuz"); ?></strong> &mdash; <?php esc_html_e("full list of all comment subscriptions with search, filter by status / type / date / user type, and per-row actions to confirm, cancel, send email, view profile, or unsubscribe.", "wpdiscuz"); ?></li>
                    <li><strong><?php esc_html_e("Follows", "wpdiscuz"); ?></strong> &mdash; <?php esc_html_e("full list of all user follows with search, filter by status / date, and the same per-row management actions.", "wpdiscuz"); ?></li>
                </ul>
                <p class="wsbm-pro-intro-p"><?php esc_html_e("Both pages display real-time statistics (total, confirmed, awaiting confirmation, unique subscribers / followers).", "wpdiscuz"); ?></p>
            </div>
        </div>

        <!-- ── Subscriptions page preview ────────────────────────── -->
        <div class="wpd-subtitle wpd-subtitle-mt">
            <?php esc_html_e("Subscriptions", "wpdiscuz"); ?>
        </div>

        <div class="wpd-wsbm-page-preview">

            <!-- Filter dropdowns -->
            <div class="tablenav top wpd-wsbm-tablenav">
                <div class="alignleft actions">
                    <select>
                        <option><?php esc_html_e("All Status", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Confirmed", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Awaiting confirmation", "wpdiscuz"); ?></option>
                    </select>
                    <select>
                        <option><?php esc_html_e("All Type", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Post", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("All Comments", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Comment", "wpdiscuz"); ?></option>
                    </select>
                    <select>
                        <option><?php esc_html_e("All Dates", "wpdiscuz"); ?></option>
                        <?php foreach ($sub_months as $label) : ?>
                            <option><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select>
                        <option><?php esc_html_e("All Users", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Registered", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Guests", "wpdiscuz"); ?></option>
                    </select>
                </div>
                <br class="clear"/>
            </div>

            <!-- Subscriptions table -->
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <td class="manage-column column-cb check-column wpd-wsbm-cb-col">
                            <input type="checkbox" disabled/>
                        </td>
                        <th class="manage-column column-email sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Email", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                        <th class="manage-column column-actions"><?php esc_html_e("Actions", "wpdiscuz"); ?></th>
                        <th class="manage-column column-post_title"><?php esc_html_e("Post Title", "wpdiscuz"); ?></th>
                        <th class="manage-column column-subscribtion_type sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Type", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                        <th class="manage-column column-subscription_date sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Date", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="check-column"><input type="checkbox" disabled/></th>
                        <td class="column-email column-primary">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell wpds-confirmed"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Confirmed", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpds-subscriber-email">user@example.com</span>
                        </td>
                        <td class="column-actions">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell-slash wpds-awaiting-confirmation"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Cancel confirmation", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-envelope wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Send Email", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-eye wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("View Profile", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-trash-alt wpds-delete"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Unsubscribe", "wpdiscuz"); ?></span>
                            </span>
                        </td>
                        <td class="column-post_title"><?php esc_html_e("Hello World", "wpdiscuz"); ?></td>
                        <td class="column-subscribtion_type"><strong><?php esc_html_e("Post", "wpdiscuz"); ?></strong></td>
                        <td class="column-subscription_date"><?php echo esc_html(date_i18n(get_option("date_format"), strtotime("-3 days"))); ?></td>
                    </tr>
                    <tr>
                        <th class="check-column"><input type="checkbox" disabled/></th>
                        <td class="column-email column-primary">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell-slash wpds-awaiting-confirmation"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Awaiting", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpds-subscriber-email">guest@example.com</span>
                        </td>
                        <td class="column-actions">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell wpds-confirmed"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Set as confirmed", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-envelope wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Send Email", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-trash-alt wpds-delete"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Unsubscribe", "wpdiscuz"); ?></span>
                            </span>
                        </td>
                        <td class="column-post_title"><?php esc_html_e("Sample Post Title", "wpdiscuz"); ?></td>
                        <td class="column-subscribtion_type"><strong><?php esc_html_e("Comment", "wpdiscuz"); ?></strong></td>
                        <td class="column-subscription_date"><?php echo esc_html(date_i18n(get_option("date_format"), strtotime("-11 days"))); ?></td>
                    </tr>
                    <tr>
                        <th class="check-column"><input type="checkbox" disabled/></th>
                        <td class="column-email column-primary">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell wpds-confirmed"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Confirmed", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpds-subscriber-email">member@example.com</span>
                        </td>
                        <td class="column-actions">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell-slash wpds-awaiting-confirmation"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Cancel confirmation", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-envelope wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Send Email", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-trash-alt wpds-delete"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Unsubscribe", "wpdiscuz"); ?></span>
                            </span>
                        </td>
                        <td class="column-post_title"><?php esc_html_e("Getting Started Guide", "wpdiscuz"); ?></td>
                        <td class="column-subscribtion_type"><strong><?php esc_html_e("All Comments", "wpdiscuz"); ?></strong></td>
                        <td class="column-subscription_date"><?php echo esc_html(date_i18n(get_option("date_format"), strtotime("-27 days"))); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Subscription statistics -->
            <div class="wpd_stats_cont wpd-wsbm-stats">
                <div class="wpds-stat-all">
                    <span class="wpds-stat-rowname"><?php esc_html_e("All Subscriptions", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">248</span>
                </div>
                <div class="wpds-stat-confirmed">
                    <span class="wpds-stat-rowname"><?php esc_html_e("Confirmed", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">194</span>
                </div>
                <div class="wpds-stat-awaiting">
                    <span class="wpds-stat-rowname"><?php esc_html_e("Awaiting confirmation", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">54</span>
                </div>
                <div class="wpds-stat-subscribers">
                    <span class="wpds-stat-rowname"><?php esc_html_e("Subscribers", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">137</span>
                </div>
            </div>
        </div><!-- /.wpd-wsbm-page-preview -->

        <!-- ── Follows page preview ───────────────────────────────── -->
        <div class="wpd-subtitle wpd-subtitle-mt-lg">
            <?php esc_html_e("Follows", "wpdiscuz"); ?>
        </div>

        <div class="wpd-wsbm-page-preview">

            <!-- Filter dropdowns -->
            <div class="tablenav top wpd-wsbm-tablenav">
                <div class="alignleft actions">
                    <select>
                        <option><?php esc_html_e("All Status", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Confirmed", "wpdiscuz"); ?></option>
                        <option><?php esc_html_e("Awaiting confirmation", "wpdiscuz"); ?></option>
                    </select>
                    <select>
                        <option><?php esc_html_e("All Dates", "wpdiscuz"); ?></option>
                        <?php foreach ($fol_months as $label) : ?>
                            <option><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br class="clear"/>
            </div>

            <!-- Follows table -->
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <td class="manage-column column-cb check-column wpd-wsbm-cb-col">
                            <input type="checkbox" disabled/>
                        </td>
                        <th class="manage-column column-follower_id sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Follower ID", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                        <th class="manage-column column-follower_email sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Follower Email", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                        <th class="manage-column column-actions"><?php esc_html_e("Actions", "wpdiscuz"); ?></th>
                        <th class="manage-column column-user_email sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Followed User Email", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                        <th class="manage-column column-follow_date sortable desc">
                            <span class="wpd-wsbm-sort-label"><span><?php esc_html_e("Date", "wpdiscuz"); ?></span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="check-column"><input type="checkbox" disabled/></th>
                        <td class="column-follower_id column-primary">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell wpds-confirmed"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Confirmed", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpds-follower-email">42</span>
                        </td>
                        <td class="column-follower_email">
                            <span class="wpds-follower-email">follower@example.com</span>
                        </td>
                        <td class="column-actions">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell-slash wpds-awaiting-confirmation"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Cancel confirmation", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-envelope wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Send Email", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-eye wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("View Profile", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-trash-alt wpds-delete"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Unfollow", "wpdiscuz"); ?></span>
                            </span>
                        </td>
                        <td class="column-user_email">
                            <span class="wpds-follower-email">admin@example.com</span>
                        </td>
                        <td class="column-follow_date"><?php echo esc_html(date_i18n(get_option("date_format"), strtotime("-5 days"))); ?></td>
                    </tr>
                    <tr>
                        <th class="check-column"><input type="checkbox" disabled/></th>
                        <td class="column-follower_id column-primary">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell-slash wpds-awaiting-confirmation"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Awaiting", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpds-follower-email">17</span>
                        </td>
                        <td class="column-follower_email">
                            <span class="wpds-follower-email">jane@example.com</span>
                        </td>
                        <td class="column-actions">
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-bell wpds-confirmed"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Set as confirmed", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-envelope wpds-action-icon"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Send Email", "wpdiscuz"); ?></span>
                            </span>
                            <span class="wpd-wsbm-action">
                                <i class="fas fa-trash-alt wpds-delete"></i>
                                <span class="wpd-wsbm-icon-label"><?php esc_html_e("Unfollow", "wpdiscuz"); ?></span>
                            </span>
                        </td>
                        <td class="column-user_email">
                            <span class="wpds-follower-email">author@example.com</span>
                        </td>
                        <td class="column-follow_date"><?php echo esc_html(date_i18n(get_option("date_format"), strtotime("-19 days"))); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Follows statistics -->
            <div class="wpd_stats_cont wpd-wsbm-stats">
                <div class="wpds-stat-all">
                    <span class="wpds-stat-rowname"><?php esc_html_e("All Follows", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">86</span>
                </div>
                <div class="wpds-stat-confirmed">
                    <span class="wpds-stat-rowname"><?php esc_html_e("Confirmed", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">71</span>
                </div>
                <div class="wpds-stat-awaiting">
                    <span class="wpds-stat-rowname"><?php esc_html_e("Awaiting confirmation", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">15</span>
                </div>
                <div class="wpds-stat-subscribers">
                    <span class="wpds-stat-rowname"><?php esc_html_e("Followers", "wpdiscuz"); ?></span>
                    <span class="wpds-stat-count">58</span>
                </div>
            </div>
        </div><!-- /.wpd-wsbm-page-preview -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-subscribe-manager/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Subscription Manager Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
