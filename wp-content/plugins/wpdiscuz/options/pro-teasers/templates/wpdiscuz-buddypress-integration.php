<?php

if (!defined("ABSPATH")) {
    exit();
}

$bpiImgUrl = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img";

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-groups"></span>
            <?php esc_html_e("BuddyPress Integration Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Fully integrates wpDiscuz with BuddyPress. Adds BuddyPress notifications and activity stream entries for comment votes, post ratings, mentions, replies, subscriptions, and follows. Adds dedicated profile tabs for discussions, subscriptions, reactions, rates, votes, following, and followers. Users can manage their own notification and email preferences directly from their BuddyPress profile.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: changeUserSettingsButton -->
        <div class="wpd-opt-row" data-wpd-opt="changeUserSettingsButton">
            <div class="wpd-opt-name">
                <label><?php esc_html_e('Link "My Content and Settings" Button to Profile Discussions Tab.', "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e('The "My Content & Settings" button opens a pop-up window allowing users to manage their comments, subscriptions and more... Because of the BuddyPress Integration addon creates Discussions Tab with the same sub-tabs in the users\' profile page, it\'s recommended to link this button to the Discussions Tab.', "wpdiscuz"); ?><br><br>
                    <img src="<?php echo esc_url($bpiImgUrl); ?>/bpi-my-settings-btn.png" class="bpi-settings-img"/></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wbpi-pro-changeUserSettingsButton"/>
                    <label for="wbpi-pro-changeUserSettingsButton"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Profile Tabs", "wpdiscuz"); ?></div>

        <!-- Option start: enabledProfileTabs -->
        <div class="wpd-opt-row" data-wpd-opt="enabledProfileTabs">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enabled Profile Tabs", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("BuddyPress Integration addon adds Discussions Tab in the user profile page. All these tabs (Comments, Subscriptions, Reactions...) become sub-tabs of the main Discussions Tab.", "wpdiscuz"); ?><br><br>
                    <img src="<?php echo esc_url($bpiImgUrl); ?>/bpi-profile-discussions-settings-tab.png" class="wpd-teaser-img"/></p>
            </div>
            <div class="wpd-opt-input">
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileCommentsTab" checked/>
                    <label for="wbpi-pro-enableProfileCommentsTab"><?php esc_html_e("Comments", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileSubscriptionsTab" checked/>
                    <label for="wbpi-pro-enableProfileSubscriptionsTab"><?php esc_html_e("Subscriptions", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileReactionsTab" checked/>
                    <label for="wbpi-pro-enableProfileReactionsTab"><?php esc_html_e("Reactions", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileRatesTab" checked/>
                    <label for="wbpi-pro-enableProfileRatesTab"><?php esc_html_e("Rates", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileVotesTab" checked/>
                    <label for="wbpi-pro-enableProfileVotesTab"><?php esc_html_e("Votes", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileFollowingTab" checked/>
                    <label for="wbpi-pro-enableProfileFollowingTab"><?php esc_html_e("Following", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-enableProfileFollowersTab" checked/>
                    <label for="wbpi-pro-enableProfileFollowersTab"><?php esc_html_e("Followers", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileDiscussionsTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileDiscussionsTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Discussions Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Discussions", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileCommentsTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileCommentsTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comments Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comments", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileSubscriptionsTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileSubscriptionsTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Subscriptions Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Subscriptions", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileReactionsTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileReactionsTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Reactions Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Reactions", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileRatesTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileRatesTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Rates Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Rates", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileVotesTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileVotesTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Votes Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Votes", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileFollowingTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileFollowingTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Following Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Following", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileFollowersTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="profileFollowersTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Followers Tab Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Followers", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: guestPhrase -->
        <div class="wpd-opt-row" data-wpd-opt="guestPhrase">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Guest", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Guest", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle wpd-subtitle-mt"><?php esc_html_e("Activity", "wpdiscuz"); ?></div>

        <!-- Option start: enabledActivities -->
        <div class="wpd-opt-row" data-wpd-opt="enabledActivities">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Integrated Activities", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Comment section activities generate activity entries in the BuddyPress Activity page. Here you can enable or disable activities coming from the comment section.", "wpdiscuz"); ?><br><br>
                    <img src="<?php echo esc_url($bpiImgUrl); ?>/bpi-profile-activities-tab.png" class="wpd-teaser-img"/></p>
            </div>
            <div class="wpd-opt-input">
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-activityForCommentVote" checked/>
                    <label for="wbpi-pro-activityForCommentVote"><?php esc_html_e("Voting a comment", "wpdiscuz"); ?></label>
                </div>
                <div>
                    <input type="checkbox" disabled value="1" id="wbpi-pro-activityForPostRating" checked/>
                    <label for="wbpi-pro-activityForPostRating"><?php esc_html_e("Rating a post", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentUpvoteActivityMessage -->
        <div class="wpd-opt-row" data-wpd-opt="commentUpvoteActivityMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Activity Text for Comment Upvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_AUTHOR_NAME]</span> <span class="wc_available_variable">[COMMENT_AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[VOTER_URL]'>[VOTER_NAME]</a> upvoted <a href='[COMMENT_URL]'>comment</a> on the post <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentDownvoteActivityMessage -->
        <div class="wpd-opt-row" data-wpd-opt="commentDownvoteActivityMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Activity Text for Comment Downvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[VOTER_URL]</span> <span class="wc_available_variable">[COMMENT_AUTHOR_NAME]</span> <span class="wc_available_variable">[COMMENT_AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[VOTER_URL]'>[VOTER_NAME]</a> downvoted <a href='[COMMENT_URL]'>comment</a> on the post <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: postRatingActivityMessage -->
        <div class="wpd-opt-row" data-wpd-opt="postRatingActivityMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Activity Text for Post Rating", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[RATER_NAME]</span> <span class="wc_available_variable">[RATER_URL]</span> <span class="wc_available_variable">[POST_AUTHOR_NAME]</span> <span class="wc_available_variable">[POST_AUTHOR_URL]</span> <span class="wc_available_variable">[RATING]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[RATER_URL]'>[RATER_NAME]</a> rated [RATING] stars <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle wpd-subtitle-mt"><?php esc_html_e("Notifications", "wpdiscuz"); ?></div>

        <!-- Option start: notificationSettingsTabTitle -->
        <div class="wpd-opt-row" data-wpd-opt="notificationSettingsTabTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification Settings Tab Name", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This addon integrates wpDiscuz with BuddyPress Notification system. All actions in the comment section generate corresponding notifications in users Notifications Tab. The Settings Sub-tab allows users to turn on/off certain notification.", "wpdiscuz"); ?><br><br>
                    <img src="<?php echo esc_url($bpiImgUrl); ?>/bpi-profile-notifications-settings-tab.png" class="wpd-teaser-img"/></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Settings", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: enabledNotifications -->
        <div class="wpd-opt-row" data-wpd-opt="enabledNotifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enabled Notifications", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("There are many types of user notifications coming from the comment section. Here you can manage them for all users. Users can set their own notifications preferences in the Notifications > Settings Tab.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForCommentVote" checked/> <label for="wbpi-pro-notificationForCommentVote"><?php esc_html_e("Someone votes on my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForFollow" checked/> <label for="wbpi-pro-notificationForFollow"><?php esc_html_e("Someone follows me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForPostRating" checked/> <label for="wbpi-pro-notificationForPostRating"><?php esc_html_e("Someone rated my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForApprovedComment" checked/> <label for="wbpi-pro-notificationForApprovedComment"><?php esc_html_e("My comment is approved", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForReply" checked/> <label for="wbpi-pro-notificationForReply"><?php esc_html_e("Someone replied to my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForCommentOnPost" checked/> <label for="wbpi-pro-notificationForCommentOnPost"><?php esc_html_e("Someone commented on my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForMention" checked/> <label for="wbpi-pro-notificationForMention"><?php esc_html_e("Someone mentioned me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForSubscriptions" checked/> <label for="wbpi-pro-notificationForSubscriptions"><?php esc_html_e("New comment on subscribed post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForFollows" checked/> <label for="wbpi-pro-notificationForFollows"><?php esc_html_e("New comment by followed user", "wpdiscuz"); ?></label></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: defaultNotifications -->
        <div class="wpd-opt-row" data-wpd-opt="defaultNotifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Default Notifications for New Users", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This is the notifications preferences set by default for users who have not managed his/her notifications yet.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForCommentVoteForNewUsers" checked/> <label for="wbpi-pro-notificationForCommentVoteForNewUsers"><?php esc_html_e("Someone votes on my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForFollowForNewUsers" checked/> <label for="wbpi-pro-notificationForFollowForNewUsers"><?php esc_html_e("Someone follows me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForPostRatingForNewUsers" checked/> <label for="wbpi-pro-notificationForPostRatingForNewUsers"><?php esc_html_e("Someone rated my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForApprovedCommentForNewUsers" checked/> <label for="wbpi-pro-notificationForApprovedCommentForNewUsers"><?php esc_html_e("My comment is approved", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForReplyForNewUsers" checked/> <label for="wbpi-pro-notificationForReplyForNewUsers"><?php esc_html_e("Someone replied to my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForCommentOnPostForNewUsers" checked/> <label for="wbpi-pro-notificationForCommentOnPostForNewUsers"><?php esc_html_e("Someone commented on my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForMentionForNewUsers" checked/> <label for="wbpi-pro-notificationForMentionForNewUsers"><?php esc_html_e("Someone mentioned me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForSubscriptionsForNewUsers" checked/> <label for="wbpi-pro-notificationForSubscriptionsForNewUsers"><?php esc_html_e("New comment on subscribed post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-notificationForFollowsForNewUsers" checked/> <label for="wbpi-pro-notificationForFollowsForNewUsers"><?php esc_html_e("New comment by followed user", "wpdiscuz"); ?></label></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: enabledEmailNotifications -->
        <div class="wpd-opt-row" data-wpd-opt="enabledEmailNotifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enabled Email Notifications", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("All kind of notifications can be sent via email as well. It depends on the email notification preferences. You can either disable certain email notification for all users or enable them for all letting them manage their email notifications by their own.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForCommentVote"/> <label for="wbpi-pro-emailForCommentVote"><?php esc_html_e("Someone votes on my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForFollow" checked/> <label for="wbpi-pro-emailForFollow"><?php esc_html_e("Someone follows me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForPostRating" checked/> <label for="wbpi-pro-emailForPostRating"><?php esc_html_e("Someone rated my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForApprovedComment" checked/> <label for="wbpi-pro-emailForApprovedComment"><?php esc_html_e("My comment is approved", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForMention" checked/> <label for="wbpi-pro-emailForMention"><?php esc_html_e("Someone mentioned me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForReply" checked/> <label for="wbpi-pro-emailForReply"><?php esc_html_e("Someone replied to my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForCommentOnPost" checked/> <label for="wbpi-pro-emailForCommentOnPost"><?php esc_html_e("Someone commented on my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForSubscriptions" checked/> <label for="wbpi-pro-emailForSubscriptions"><?php esc_html_e("New comment on subscribed post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForFollows" checked/> <label for="wbpi-pro-emailForFollows"><?php esc_html_e("New comment by followed user", "wpdiscuz"); ?></label></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: defaultEmailNotifications -->
        <div class="wpd-opt-row" data-wpd-opt="defaultEmailNotifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Default Email Notifications for New Users", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This is the email notifications preferences set by default for users who have not managed his/her notifications yet.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForCommentVoteForNewUsers"/> <label for="wbpi-pro-emailForCommentVoteForNewUsers"><?php esc_html_e("Someone votes on my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForFollowForNewUsers" checked/> <label for="wbpi-pro-emailForFollowForNewUsers"><?php esc_html_e("Someone follows me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForPostRatingForNewUsers" checked/> <label for="wbpi-pro-emailForPostRatingForNewUsers"><?php esc_html_e("Someone rated my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForApprovedCommentForNewUsers" checked/> <label for="wbpi-pro-emailForApprovedCommentForNewUsers"><?php esc_html_e("My comment is approved", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForMentionForNewUsers" checked/> <label for="wbpi-pro-emailForMentionForNewUsers"><?php esc_html_e("Someone mentioned me", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForReplyForNewUsers" checked/> <label for="wbpi-pro-emailForReplyForNewUsers"><?php esc_html_e("Someone replied to my comment", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForCommentOnPostForNewUsers" checked/> <label for="wbpi-pro-emailForCommentOnPostForNewUsers"><?php esc_html_e("Someone commented on my post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForSubscriptionsForNewUsers" checked/> <label for="wbpi-pro-emailForSubscriptionsForNewUsers"><?php esc_html_e("New comment on subscribed post", "wpdiscuz"); ?></label></div>
                <div><input type="checkbox" disabled value="1" id="wbpi-pro-emailForFollowsForNewUsers" checked/> <label for="wbpi-pro-emailForFollowsForNewUsers"><?php esc_html_e("New comment by followed user", "wpdiscuz"); ?></label></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentUpvoteNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="commentUpvoteNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - comment upvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[VOTER_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[VOTER_URL]'>[VOTER_NAME]</a> gave you an <a href='[COMMENT_URL]'>upvote</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleCommentUpvoteNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleCommentUpvoteNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - comment upvotes (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new upvotes", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentDownvoteNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="commentDownvoteNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - comment downvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[VOTER_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[VOTER_URL]'>[VOTER_NAME]</a> gave you an <a href='[COMMENT_URL]'>downvote</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleCommentDownvoteNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleCommentDownvoteNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - comment downvotes (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new downvotes", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: followNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="followNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new follower", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[FOLLOWER_NAME]</span> <span class="wc_available_variable">[FOLLOWER_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[FOLLOWER_URL]'>[FOLLOWER_NAME]</a> followed you"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleFollowNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleFollowNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new followers (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new followers", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: postRatingNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="postRatingNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new post rating", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[RATER_NAME]</span> <span class="wc_available_variable">[RATER_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[RATING]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[RATER_URL]'>[RATER_NAME]</a> rated your post: <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multiplePostRatingNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multiplePostRatingNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new post ratings (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new post ratings", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: approvedCommentNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="approvedCommentNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - comment is approved", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[COMMENT_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("Your <a href='[COMMENT_URL]'>comment</a> is approved"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleApprovedCommentNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleApprovedCommentNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - comments are approved (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d approved comments", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: mentionNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="mentionNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - you've been mentioned", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("You have been <a href='[COMMENT_URL]'>mentioned</a> by <a href='[AUTHOR_URL]'>[AUTHOR_NAME]</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleMentionNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleMentionNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - you've been mentioned (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new mentions", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: replyNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="replyNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new reply", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[AUTHOR_URL]'>[AUTHOR_NAME]</a> has <a href='[COMMENT_URL]'>replied</a> to your comment under the post: <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleReplyNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleReplyNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new replies (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new replies", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentOnPostNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="commentOnPostNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new comment (post author)", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[AUTHOR_URL]'>[AUTHOR_NAME]</a> has <a href='[COMMENT_URL]'>commented</a> on your post: <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleCommentOnPostNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleCommentOnPostNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new comments (post author) (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new comments on your posts", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: subscriptionsNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="subscriptionsNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new comment (subscriber)", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[AUTHOR_URL]'>[AUTHOR_NAME]</a> has <a href='[COMMENT_URL]'>commented</a> on <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleSubscriptionsNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleSubscriptionsNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new comments (subscriber) (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("You have %d new comments from your subscriptions", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: followsNotificationMessage -->
        <div class="wpd-opt-row" data-wpd-opt="followsNotificationMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new comment (by user you follow)", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="4" class="wpd-teaser-textarea"><?php echo esc_textarea("<a href='[AUTHOR_URL]'>[AUTHOR_NAME]</a> has left a <a href='[COMMENT_URL]'>comment</a> on <a href='[POST_URL]'>[POST_TITLE]</a>"); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: multipleFollowsNotificationsMessage -->
        <div class="wpd-opt-row" data-wpd-opt="multipleFollowsNotificationsMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification - new comments (by users you follow) (grouped)", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("%d new comments from users you follow", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: upvoteEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="upvoteEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject for Upvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("[VOTER_NAME] gave you an upvote", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: upvoteEmailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="upvoteEmailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Message for Upvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[SUBSCRIBER_NAME]</span> <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[VOTER_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span> <span class="wc_available_variable">[SITE_URL]</span> <span class="wc_available_variable">[NOTIFICATIONS_PAGE_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="10" class="wpd-teaser-textarea"><?php echo esc_textarea("Hi [SUBSCRIBER_NAME],\n\n[VOTER_NAME] gave you an upvote."); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: downvoteEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="downvoteEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject for Downvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("[VOTER_NAME] gave you a downvote", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: downvoteEmailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="downvoteEmailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Message for Downvote", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[SUBSCRIBER_NAME]</span> <span class="wc_available_variable">[VOTER_NAME]</span> <span class="wc_available_variable">[VOTER_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span> <span class="wc_available_variable">[SITE_URL]</span> <span class="wc_available_variable">[NOTIFICATIONS_PAGE_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="10" class="wpd-teaser-textarea"><?php echo esc_textarea("Hi [SUBSCRIBER_NAME],\n\n[VOTER_NAME] gave you a downvote."); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: followEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="followEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject for Follow", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[FOLLOWER_NAME]</span> <span class="wc_available_variable">[BLOG_TITLE]</span></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("[FOLLOWER_NAME] followed you", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: followEmailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="followEmailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Message for Follow", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[SUBSCRIBER_NAME]</span> <span class="wc_available_variable">[FOLLOWER_NAME]</span> <span class="wc_available_variable">[FOLLOWER_URL]</span> <span class="wc_available_variable">[BLOG_TITLE]</span> <span class="wc_available_variable">[SITE_URL]</span> <span class="wc_available_variable">[NOTIFICATIONS_PAGE_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="10" class="wpd-teaser-textarea"><?php echo esc_textarea("Hi [SUBSCRIBER_NAME],\n\n[FOLLOWER_NAME] is now following you."); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: postRatingEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="postRatingEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject for Post Rating", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[RATER_NAME]</span> <span class="wc_available_variable">[RATING]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("[RATER_NAME] rated your post", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: postRatingEmailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="postRatingEmailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Message for Post Rating", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[SUBSCRIBER_NAME]</span> <span class="wc_available_variable">[RATER_NAME]</span> <span class="wc_available_variable">[RATER_URL]</span> <span class="wc_available_variable">[RATING]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[BLOG_TITLE]</span> <span class="wc_available_variable">[SITE_URL]</span> <span class="wc_available_variable">[NOTIFICATIONS_PAGE_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="10" class="wpd-teaser-textarea"><?php echo esc_textarea("Hi [SUBSCRIBER_NAME],\n\n[RATER_NAME] rated your post: [POST_TITLE]."); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: replyEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="replyEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject for Reply", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("[AUTHOR_NAME] has replied to your comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: replyEmailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="replyEmailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Message for Reply", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[SUBSCRIBER_NAME]</span> <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[BLOG_TITLE]</span> <span class="wc_available_variable">[SITE_URL]</span> <span class="wc_available_variable">[NOTIFICATIONS_PAGE_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="10" class="wpd-teaser-textarea"><?php echo esc_textarea("Hi [SUBSCRIBER_NAME],\n\n[AUTHOR_NAME] has replied to your comment under the post: [POST_TITLE]."); ?></textarea></div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentOnPostEmailSubject -->
        <div class="wpd-opt-row" data-wpd-opt="commentOnPostEmailSubject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject for Comment on Post", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[BLOG_TITLE]</span></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("[AUTHOR_NAME] has commented on your post", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: commentOnPostEmailMessage -->
        <div class="wpd-opt-row" data-wpd-opt="commentOnPostEmailMessage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Message for Comment on Post", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>: <span class="wc_available_variable">[SUBSCRIBER_NAME]</span> <span class="wc_available_variable">[AUTHOR_NAME]</span> <span class="wc_available_variable">[AUTHOR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[BLOG_TITLE]</span> <span class="wc_available_variable">[SITE_URL]</span> <span class="wc_available_variable">[NOTIFICATIONS_PAGE_URL]</span></p>
            </div>
            <div class="wpd-opt-input"><textarea disabled rows="10" class="wpd-teaser-textarea"><?php echo esc_textarea("Hi [SUBSCRIBER_NAME],\n\n[AUTHOR_NAME] has commented on your post: [POST_TITLE]."); ?></textarea></div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-buddypress-integration/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get BuddyPress Integration Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
