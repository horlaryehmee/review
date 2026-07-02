<?php

if (!defined("ABSPATH")) {
    exit();
}

$editableRoles = get_editable_roles();

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-groups"></span>
            <?php esc_html_e("Online Users Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Displays real-time online/offline status indicators next to comment author names. Periodically checks user activity, shows a pop-up notification when a new user comes online, and lets you customize indicator colors, status labels, and notification appearance.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: enableOnlineChecking -->
        <div class="wpd-opt-row" data-wpd-opt="enableOnlineChecking">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable online status checking", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wou-pro-enableOnlineChecking" checked/>
                    <label for="wou-pro-enableOnlineChecking"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: checkFrequency -->
        <div class="wpd-opt-row" data-wpd-opt="checkFrequency">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Online status checking rate", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="60" class="wpd-num-input"/>
                <select>
                    <option selected><?php esc_html_e("second(s)", "wpdiscuz"); ?></option>
                    <option><?php esc_html_e("minute(s)", "wpdiscuz"); ?></option>
                </select>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: disableStatusForRoles -->
        <div class="wpd-opt-row" data-wpd-opt="disableStatusForRoles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Disable status for roles", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach ($editableRoles as $key => $role) { ?>
                    <div class="wpd-mublock">
                        <input type="checkbox" disabled
                               value="<?php echo esc_attr($key); ?>"
                               id="wou-pro-role-<?php echo esc_attr($key); ?>"/>
                        <label for="wou-pro-role-<?php echo esc_attr($key); ?>"><?php echo esc_html($role["name"]); ?></label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: isShowNotificationPopup -->
        <div class="wpd-opt-row" data-wpd-opt="isShowNotificationPopup">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable pop-up notification of new online users", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wou-pro-isShowNotificationPopup" checked/>
                    <label for="wou-pro-isShowNotificationPopup"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: notificationPopupTimeout -->
        <div class="wpd-opt-row" data-wpd-opt="notificationPopupTimeout">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Hide pop-up notification in", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" class="wpd-num-input"/>&nbsp; <?php esc_html_e("seconds", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: notificationPopupPosition -->
        <div class="wpd-opt-row" data-wpd-opt="notificationPopupPosition">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pop-up notification location", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <select>
                    <option><?php esc_html_e("Top left", "wpdiscuz"); ?></option>
                    <option><?php esc_html_e("Top right", "wpdiscuz"); ?></option>
                    <option selected><?php esc_html_e("Bottom right", "wpdiscuz"); ?></option>
                    <option><?php esc_html_e("Bottom left", "wpdiscuz"); ?></option>
                </select>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: notificationItemBG -->
        <div class="wpd-opt-row" data-wpd-opt="notificationItemBG">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pop-up notification background color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#eeeeee;"></span>
                    <input type="text" disabled value="#eeeeee"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: notificationItemTextColor -->
        <div class="wpd-opt-row" data-wpd-opt="notificationItemTextColor">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pop-up notification text color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#333333; border-color:#666;"></span>
                    <input type="text" disabled value="#333333"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: onlineStatusColor -->
        <div class="wpd-opt-row" data-wpd-opt="onlineStatusColor">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Online status color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#00b38f;"></span>
                    <input type="text" disabled value="#00b38f"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: offlineStatusColor -->
        <div class="wpd-opt-row" data-wpd-opt="offlineStatusColor">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Offline status color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#ca3c3c;"></span>
                    <input type="text" disabled value="#ca3c3c"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: showStatusLabel -->
        <div class="wpd-opt-row" data-wpd-opt="showStatusLabel">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show Status Label", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wou-pro-showStatusLabel"/>
                    <label for="wou-pro-showStatusLabel"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: deleteUserStatusesOlderThan -->
        <div class="wpd-opt-row" data-wpd-opt="deleteUserStatusesOlderThan">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Delete users' statuses older than", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Users' statuses will be automatically deleted from the DB after X days", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="30" class="wpd-num-input"/>&nbsp; <?php esc_html_e("days", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseUserIsOnline -->
        <div class="wpd-opt-row" data-wpd-opt="phraseUserIsOnline">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('"X" user is online', "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("is online", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseUserLastComment -->
        <div class="wpd-opt-row" data-wpd-opt="phraseUserLastComment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('"X" user last comment', "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Last Comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseReadMore -->
        <div class="wpd-opt-row" data-wpd-opt="phraseReadMore">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('"read this comment" link text', "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("read this comment »", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseOnline -->
        <div class="wpd-opt-row" data-wpd-opt="phraseOnline">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Online status label", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Online", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseOffline -->
        <div class="wpd-opt-row" data-wpd-opt="phraseOffline">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Offline status label", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Offline", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: deleteAllStatuses -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="deleteAllStatuses">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Delete all statuses", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This button deletes all users' statuses from the database", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <button type="button" disabled class="button button-secondary">
                    <?php esc_html_e("Delete All Statuses", "wpdiscuz"); ?> (0)
                </button>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-online-users/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Online Users Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
