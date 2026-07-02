<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-admin-users"></span>
            <?php esc_html_e("User &amp; Comment Mentioning Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Allows to mention certain comments and users in comment text using #comment-id and @username tags. Mentioned users receive email notifications.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: enableCommentMentioning -->
        <div class="wpd-opt-row" data-wpd-opt="enableCommentMentioning">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable mentioning by comment ID:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-enableCommentMentioning" checked/>
                    <label for="wucm-pro-enableCommentMentioning"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: guestMentioning -->
        <div class="wpd-opt-row" data-wpd-opt="guestMentioning">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable guest mentioning:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-guestMentioning"/>
                    <label for="wucm-pro-guestMentioning"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: displayNicename -->
        <div class="wpd-opt-row" data-wpd-opt="displayNicename">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display user nicename (names for mentioning) in user search result:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-displayNicename" checked/>
                    <label for="wucm-pro-displayNicename"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: viewAvatarInComment -->
        <div class="wpd-opt-row" data-wpd-opt="viewAvatarInComment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display mentioned user avatar with username link:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-viewAvatarInComment" checked/>
                    <label for="wucm-pro-viewAvatarInComment"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: viewAvatarInTooltip -->
        <div class="wpd-opt-row" data-wpd-opt="viewAvatarInTooltip">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display avatar in user pop-up information:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-viewAvatarInTooltip" checked/>
                    <label for="wucm-pro-viewAvatarInTooltip"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: viewID -->
        <div class="wpd-opt-row" data-wpd-opt="viewID">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Mention user by user ID in comment content", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-viewID"/>
                    <label for="wucm-pro-viewID"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: textLength -->
        <div class="wpd-opt-row" data-wpd-opt="textLength">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Text length in user/comment pop-up information:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="150" min="0" class="wpd-num-input"/>&nbsp;<?php esc_html_e("characters", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: userListCount -->
        <div class="wpd-opt-row" data-wpd-opt="userListCount">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('Maximum number of users in "User Selector" bar:', "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="8" min="1" class="wpd-num-input"/>&nbsp;<?php esc_html_e("items", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle">
            <?php esc_html_e("Comment mentioning through #comment-id", "wpdiscuz"); ?>
            <strong><?php esc_html_e("Message to mentioned comment author", "wpdiscuz"); ?></strong>
        </div>

        <!-- Option start: adminEmail -->
        <div class="wpd-opt-row" data-wpd-opt="adminEmail">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable Email Notification", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-adminEmail" checked/>
                    <label for="wucm-pro-adminEmail"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: authorMailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="authorMailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <i>[blogTitle] - <?php esc_html_e("Blog Name", "wpdiscuz"); ?></i><br/>
                    <i>[postTitle] - <?php esc_html_e("Post Title", "wpdiscuz"); ?></i>
                </p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Your Comment has been mentioned", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: authorMailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="authorMailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Body", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <i>[mentionedUserName] - <?php esc_html_e("Mentioned comment author name", "wpdiscuz"); ?></i><br/>
                    <i>[blogTitle] - <?php esc_html_e("Blog Name", "wpdiscuz"); ?></i><br/>
                    <i>[postTitle] - <?php esc_html_e("Post Title", "wpdiscuz"); ?></i><br/>
                    <i>[authorUserName] - <?php esc_html_e("Comment author name", "wpdiscuz"); ?></i><br/>
                    <i>[commentURL] - <?php esc_html_e("Comment URL", "wpdiscuz"); ?></i><br/>
                    <i>[commentContent] - <?php esc_html_e("Comment content", "wpdiscuz"); ?></i>
                </p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled class="wpd-teaser-textarea" rows="6"><?php esc_html_e("Hi [mentionedUserName]!\r\nYour comment on \"[postTitle]\" post has been mentioned by [authorUserName].\r\n\r\nComment URL: [commentURL]", "wpdiscuz"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle">
            <?php esc_html_e("User mentioning through @username", "wpdiscuz"); ?>
            <strong><?php esc_html_e("Message to mentioned user", "wpdiscuz"); ?></strong>
        </div>

        <!-- Option start: userEmail -->
        <div class="wpd-opt-row" data-wpd-opt="userEmail">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable Email Notification", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wucm-pro-userEmail" checked/>
                    <label for="wucm-pro-userEmail"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: userMailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="userMailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <i>[blogTitle] - <?php esc_html_e("Blog Name", "wpdiscuz"); ?></i><br/>
                    <i>[postTitle] - <?php esc_html_e("Post Title", "wpdiscuz"); ?></i>
                </p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have been mentioned in comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: userMailMessage -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="userMailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Body", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <i>[mentionedUserName] - <?php esc_html_e("Mentioned user name", "wpdiscuz"); ?></i><br/>
                    <i>[blogTitle] - <?php esc_html_e("Blog Name", "wpdiscuz"); ?></i><br/>
                    <i>[postTitle] - <?php esc_html_e("Post Title", "wpdiscuz"); ?></i><br/>
                    <i>[authorUserName] - <?php esc_html_e("Comment author name", "wpdiscuz"); ?></i><br/>
                    <i>[commentURL] - <?php esc_html_e("Comment URL", "wpdiscuz"); ?></i><br/>
                    <i>[commentContent] - <?php esc_html_e("Comment content", "wpdiscuz"); ?></i>
                </p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled class="wpd-teaser-textarea" rows="6"><?php esc_html_e("Hi [mentionedUserName]!\r\nYou have been mentioned in a comment posted on \"[postTitle]\" post by [authorUserName].\r\n\r\nComment URL: [commentURL]", "wpdiscuz"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Front-end Phrases", "wpdiscuz"); ?></div>

        <!-- Option start: posts -->
        <div class="wpd-opt-row" data-wpd-opt="posts">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Posts:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Posts", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: comments -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="comments">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comments:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comments", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-user-comment-mentioning/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get User &amp; Comment Mentioning Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
