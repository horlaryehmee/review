<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-shield"></span>
            <?php esc_html_e("Front-end Moderation Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Give trusted users moderation powers directly from the front end. Allow commenters to delete their own comments, let moderators approve, unapprove, trash, spam, blacklist, move, and email comment authors — all without leaving the page. Every action label and confirmation message is fully customizable.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: userCanDelete -->
        <div class="wpd-opt-row" data-wpd-opt="userCanDelete">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow Users Delete Comment", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="fem-pro-userCanDelete" checked/>
                    <label for="fem-pro-userCanDelete"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: displayFilterButton -->
        <div class="wpd-opt-row" data-wpd-opt="displayFilterButton">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display Unapproved Comments Filtering Button", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="fem-pro-displayFilterButton" checked/>
                    <label for="fem-pro-displayFilterButton"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle">
            <span class="dashicons dashicons-paperclip"></span> <?php esc_html_e("Front-end Phrases", "wpdiscuz"); ?>
        </div>

        <!-- Option start: approve -->
        <div class="wpd-opt-row" data-wpd-opt="approve">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Approve", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Approve", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: unapprove -->
        <div class="wpd-opt-row" data-wpd-opt="unapprove">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Unapprove", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Unapprove", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: trash -->
        <div class="wpd-opt-row" data-wpd-opt="trash">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Trash", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Trash", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: spam -->
        <div class="wpd-opt-row" data-wpd-opt="spam">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Spam", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Spam", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: email -->
        <div class="wpd-opt-row" data-wpd-opt="email">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Email", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: move -->
        <div class="wpd-opt-row" data-wpd-opt="move">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Move", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Move", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: blacklist -->
        <div class="wpd-opt-row" data-wpd-opt="blacklist">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Blacklist", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Blacklist", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: delete -->
        <div class="wpd-opt-row" data-wpd-opt="delete">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Delete", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Delete", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: email_subject -->
        <div class="wpd-opt-row" data-wpd-opt="email_subject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Email Subject", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: email_message -->
        <div class="wpd-opt-row" data-wpd-opt="email_message">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enter your message here", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Enter your message here", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: going_to_mail -->
        <div class="wpd-opt-row" data-wpd-opt="going_to_mail">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("You are going to send email to", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You are going to send email to", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: send -->
        <div class="wpd-opt-row" data-wpd-opt="send">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Send", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Send", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: move_comment -->
        <div class="wpd-opt-row" data-wpd-opt="move_comment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Move Comment", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Move Comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: post_title -->
        <div class="wpd-opt-row" data-wpd-opt="post_title">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enter post title...", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Enter post title...", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: unapproved_confirm -->
        <div class="wpd-opt-row" data-wpd-opt="unapproved_confirm">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Are you sure you want to set this comment as unapproved", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Are you sure you want to set this comment as unapproved", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: approved_confirm -->
        <div class="wpd-opt-row" data-wpd-opt="approved_confirm">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Are you sure you want to set this comment as approved", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Are you sure you want to set this comment as approved", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: trashed_confirm -->
        <div class="wpd-opt-row" data-wpd-opt="trashed_confirm">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Are you sure you want to set this comment as trashed", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Are you sure you want to set this comment as trashed", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: spam_confirm -->
        <div class="wpd-opt-row" data-wpd-opt="spam_confirm">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Are you sure you want to set this comment as spam", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Are you sure you want to set this comment as spam", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: confirm_blacklist -->
        <div class="wpd-opt-row" data-wpd-opt="confirm_blacklist">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Are you sure you want to move this user into blacklist", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Are you sure you want to move this user into blacklist", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: confirm_delete -->
        <div class="wpd-opt-row" data-wpd-opt="confirm_delete">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Are you sure you want to delete this comment", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Are you sure you want to delete this comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: status_trashed -->
        <div class="wpd-opt-row" data-wpd-opt="status_trashed">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment successfully trashed", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comment successfully trashed", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: status_spam -->
        <div class="wpd-opt-row" data-wpd-opt="status_spam">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment set as spam successfully", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comment set as spam successfully", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: ops_message -->
        <div class="wpd-opt-row" data-wpd-opt="ops_message">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Ops!!! Something is wrong", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Ops!!! Something is wrong", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: cant_moderate -->
        <div class="wpd-opt-row" data-wpd-opt="cant_moderate">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("You can't moderate this comment", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You can't moderate this comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: blacklist_success -->
        <div class="wpd-opt-row" data-wpd-opt="blacklist_success">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("User is added to the blacklist successfully", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("User is added to the blacklist successfully", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: blacklist_ops_message -->
        <div class="wpd-opt-row" data-wpd-opt="blacklist_ops_message">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Ops!!! Something is wrong. Maybe this user already exist in the blacklist", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Ops!!! Something is wrong. Maybe this user already exist in the blacklist", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: blacklist_cant_set -->
        <div class="wpd-opt-row" data-wpd-opt="blacklist_cant_set">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("The user cannot be added in blacklist", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("The user cannot be added in blacklist", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: ok -->
        <div class="wpd-opt-row" data-wpd-opt="ok">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("OK", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("OK", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: move_response_success -->
        <div class="wpd-opt-row" data-wpd-opt="move_response_success">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment successfully moved", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comment successfully moved", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: fill_correct_data -->
        <div class="wpd-opt-row" data-wpd-opt="fill_correct_data">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Please fill correct data", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Please fill correct data", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: delete_cant_delete -->
        <div class="wpd-opt-row" data-wpd-opt="delete_cant_delete">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("You can't delete this comment", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You can't delete this comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: email_cant_mail -->
        <div class="wpd-opt-row" data-wpd-opt="email_cant_mail">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("You can't send mail to this user", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You can't send mail to this user", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: email_dont_sended -->
        <div class="wpd-opt-row" data-wpd-opt="email_dont_sended">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Message has not been sent", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Message has not been sent", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: email_success -->
        <div class="wpd-opt-row" data-wpd-opt="email_success">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Your message has been sent successfully", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Your message has been sent successfully", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: please_fill -->
        <div class="wpd-opt-row" data-wpd-opt="please_fill">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Please fill out the field", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Please fill out the field", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: choose_post -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="choose_post">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Please choose post", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Please choose post", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-frontend-moderation/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Front-end Moderation Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
