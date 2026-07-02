<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-flag"></span>
            <?php esc_html_e("Report and Flagging Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Adds comment reporting and flagging features. Lets guests and users flag bad comments, shows a reporting pop-up with category selection and message, and automatically unapproves or trashes comments that exceed configurable flag or dislike thresholds.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: showFlag -->
        <div class="wpd-opt-row" data-wpd-opt="showFlag">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show flag icon on comments", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("If this option is disabled, comment auto-moderation will only be based on down votes / dislikes.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrf-pro-showFlag" checked/>
                    <label for="wrf-pro-showFlag"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: guestToFlag -->
        <div class="wpd-opt-row" data-wpd-opt="guestToFlag">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow guests to flag and report comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrf-pro-guestToFlag" checked/>
                    <label for="wrf-pro-guestToFlag"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: sendFlagMessage -->
        <div class="wpd-opt-row" data-wpd-opt="sendFlagMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable comment reporting pop-up form for registered users", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("For security reasons comment reporting form is disabled for guests by default. Guests are still able to flag without sending message. However you can enable this for guests using the option below.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrf-pro-sendFlagMessage" checked/>
                    <label for="wrf-pro-sendFlagMessage"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: sendFlagMessageGuest -->
        <div class="wpd-opt-row" data-wpd-opt="sendFlagMessageGuest">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable comment reporting pop-up form for guests", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrf-pro-sendFlagMessageGuest"/>
                    <label for="wrf-pro-sendFlagMessageGuest"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: autoModerateCommentType -->
        <div class="wpd-opt-row" data-wpd-opt="autoModerateCommentType">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable auto-moderation for flagged/disliked comments:", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This will automatically Unapprove or Trash comments which reached the maximum number of flags or dislikes set below", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="unapprove" checked id="wrf-pro-unapprove"/>
                    <label for="wrf-pro-unapprove" class="wpd-radio-lbl"><?php esc_html_e("unapprove", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="trash" id="wrf-pro-trash"/>
                    <label for="wrf-pro-trash" class="wpd-radio-lbl"><?php esc_html_e("trash", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: flagCount -->
        <div class="wpd-opt-row" data-wpd-opt="flagCount">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Do auto-moderation if comment is flagged more than", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="5" min="1" class="wpd-num-input"/>&nbsp; <?php esc_html_e("times", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: voteCount -->
        <div class="wpd-opt-row" data-wpd-opt="voteCount">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Do auto-moderation if comment is down voted more than", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="1" class="wpd-num-input"/>&nbsp; <?php esc_html_e("times", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: notifyWhenFlagged -->
        <div class="wpd-opt-row" data-wpd-opt="notifyWhenFlagged">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notify admin when comment is flagged more than 5 times.", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrf-pro-notifyWhenFlagged" checked/>
                    <label for="wrf-pro-notifyWhenFlagged"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: notifyAdmin -->
        <div class="wpd-opt-row" data-wpd-opt="notifyAdmin">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notify admin when comment is auto-moderated", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrf-pro-notifyAdmin" checked/>
                    <label for="wrf-pro-notifyAdmin"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: flaggedMailTo -->
        <div class="wpd-opt-row" data-wpd-opt="flaggedMailTo">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Admin Email", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php echo esc_attr(get_option("admin_email")); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Email Templates section -->
        <div class="wpd-subtitle wpd-subtitle-mt"><?php esc_html_e("Email Templates", "wpdiscuz"); ?></div>

        <div class="wpd-subtitle">
            <?php esc_html_e("Comment reporting message from reporter to admin", "wpdiscuz"); ?>
            <p class="wpd-info"><?php esc_html_e("This message comes from comment reporting pop-up form. It includes reporter message and bad comment category (reason).", "wpdiscuz"); ?></p>
        </div>

        <!-- Option start: flagedMailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="flagedMailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Report message subject", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("New comment report", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: flagedMailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="flagedMailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Report message body", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <i>[userInfo] - <?php esc_html_e("username", "wpdiscuz"); ?></i><br/>
                    <i>[reason] - <?php esc_html_e("bad comment category", "wpdiscuz"); ?></i><br/>
                    <i>[message] - <?php esc_html_e("report message", "wpdiscuz"); ?></i><br/>
                    <i>[postTitle] - <?php esc_html_e("post title", "wpdiscuz"); ?></i><br/>
                    <i>[commentInfo] - <?php esc_html_e("comment text or URL", "wpdiscuz"); ?></i>
                </p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled rows="6" class="wpd-teaser-textarea"><?php echo esc_textarea("<h2>Report details:</h2>\n<p>Name: [userInfo]</p>\n<p>Reason: [reason]</p>\n<p>Message: [message]</p>\n<p>Post: [postTitle]</p>\n<p>Comment URL: [commentInfo]</p>"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle">
            <?php esc_html_e("Auto-moderation notification to admin", "wpdiscuz"); ?>
            <p class="wpd-info"><?php esc_html_e("This message will be sent to admin once maximum number of flags or dislikes is reached for certain comment and this comment is auto-moderated (trashed or unapproved)", "wpdiscuz"); ?></p>
        </div>

        <!-- Option start: moderateEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="moderateEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Auto-moderation message subject", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e('Please do not remove %s variable at end of this phrase. This variable will be changed to auto-moderation mode "flags" or "dislikes".', "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("New comment has reached to the maximum number of %s", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: reportedMailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="reportedMailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Auto-moderation message body", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <i>[status] - comment status</i><br/>
                    <i>[postName] - post URL</i><br/>
                    <i>[postTitle] - post title</i><br/>
                    <i>[userLogin] - user login</i><br/>
                    <i>[userEmail] - user email</i><br/>
                    <i>[commentContent] - reported comment content</i>
                </p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled rows="6" class="wpd-teaser-textarea"><?php echo esc_textarea("You have a new [status] comment on the post [postTitle].\n[postName]\nComment details:\nAuthor: [userLogin]\nEmail: [userEmail]\nComment: [commentContent]"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <!-- Front-end Phrases section -->
        <div class="wpd-subtitle wpd-subtitle-mt"><?php esc_html_e("Front-end Phrases", "wpdiscuz"); ?></div>

        <!-- Option start: reportPopupTitle -->
        <div class="wpd-opt-row" data-wpd-opt="reportPopupTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment reporting pop-up form title:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Report this comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: sendBtn -->
        <div class="wpd-opt-row" data-wpd-opt="sendBtn">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Report button:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Send", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: alreadyFlagged -->
        <div class="wpd-opt-row" data-wpd-opt="alreadyFlagged">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Already flagged:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Already flagged", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: emailNotSend -->
        <div class="wpd-opt-row" data-wpd-opt="emailNotSend">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email not send:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Message sending problem", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dataNotInserted -->
        <div class="wpd-opt-row" data-wpd-opt="dataNotInserted">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Data not inserted:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Data are not inserted", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: emailSend -->
        <div class="wpd-opt-row" data-wpd-opt="emailSend">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Message sent:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Message sent", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: checkReportType -->
        <div class="wpd-opt-row" data-wpd-opt="checkReportType">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Select report category:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Select bad comment category", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: fillMsgField -->
        <div class="wpd-opt-row" data-wpd-opt="fillMsgField">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Insert message:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Please Insert message", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: reportOther -->
        <div class="wpd-opt-row" data-wpd-opt="reportOther">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Report type other:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Other", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: messageField -->
        <div class="wpd-opt-row" data-wpd-opt="messageField">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Report message placeholder:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Enter message", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: flagTitleOn -->
        <div class="wpd-opt-row" data-wpd-opt="flagTitleOn">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('Flag title when "Comment Reporting" pop-up form is enabled', "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Click to flag and open «Comment Reporting» form. You can choose reporting category and send message to website administrator. Admins may or may not choose to remove the comment or block the author. And please don't worry, your report will be anonymous.", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: flagTitleOff -->
        <div class="wpd-opt-row" data-wpd-opt="flagTitleOff">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('Flag title when "Comment Reporting" pop-up form is disabled', "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You can flag a comment by clicking its flag icon. Website admin will know that you reported it. Admins may or may not choose to remove the comment or block the author. And please don't worry, your report will be anonymous.", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: optionType -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="optionType">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Bad comment categories:", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php
                $defaultCategories = [
                    __("This comment is spam", "wpdiscuz"),
                    __("This comment should be marked mature", "wpdiscuz"),
                    __("This comment is abusive", "wpdiscuz"),
                    __("This comment promotes self-harm", "wpdiscuz"),
                ];
                foreach ($defaultCategories as $category) : ?>
                    <span class="wrf-pro-option-entry">
                        <input type="text" disabled value="<?php echo esc_attr($category); ?>" class="wpd-teaser-input"/>
                        <input type="button" disabled class="report_remove" value=""/>
                    </span>
                <?php endforeach; ?>
                <input type="button" disabled class="button" value="<?php esc_attr_e("Add new", "wpdiscuz"); ?>"/>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-report-flagging/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Report and Flagging Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
