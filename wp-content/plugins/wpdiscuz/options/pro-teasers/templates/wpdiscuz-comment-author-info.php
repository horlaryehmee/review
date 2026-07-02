<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-admin-users"></span>
            <?php esc_html_e("Comment Author Info Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Adds an author info pop-up on every comment — click the author name or avatar to open a panel with their full profile, comment activity, voted comments, subscriptions, following/followers, and blacklist. Each tab is individually configurable and can be restricted by user role.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: sections -->
        <div class="wpd-opt-row" data-wpd-opt="sections">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment Author Tabs", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (["profile", "activity", "votes", "subscription", "follows", "blacklist"] as $section) : ?>
                <div class="wpd-mublock-inline">
                    <input type="checkbox" disabled value="<?php echo esc_attr($section); ?>" id="wcai-pro-section-<?php echo esc_attr($section); ?>" checked/>
                    <label for="wcai-pro-section-<?php echo esc_attr($section); ?>" class="wpd-check-label"><?php echo esc_html(ucfirst($section)); ?></label>
                </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: showForRoles -->
        <div class="wpd-opt-row" data-wpd-opt="showForRoles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display comment author information for user roles", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) : ?>
                <div class="wpd-mublock-inline">
                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" id="wcai-pro-role-<?php echo esc_attr($role); ?>" checked/>
                    <label for="wcai-pro-role-<?php echo esc_attr($role); ?>" class="wpd-check-label"><?php echo esc_html($info["name"]); ?></label>
                </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: showForGuests -->
        <div class="wpd-opt-row" data-wpd-opt="showForGuests">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display comment author information for guests", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-showForGuests" checked/>
                    <label for="wcai-pro-showForGuests"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: shortInfoOnAvatarHover -->
        <div class="wpd-opt-row" data-wpd-opt="shortInfoOnAvatarHover">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display comment author short information on avatar hover", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-shortInfoOnAvatarHover" checked/>
                    <label for="wcai-pro-shortInfoOnAvatarHover"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: fullInfoOnUsernameClick -->
        <div class="wpd-opt-row" data-wpd-opt="fullInfoOnUsernameClick">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display comment author full information on username click", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-fullInfoOnUsernameClick" checked/>
                    <label for="wcai-pro-fullInfoOnUsernameClick"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Profile Information", "wpdiscuz"); ?></div>

        <!-- Option start: profileShowDisplayName -->
        <div class="wpd-opt-row" data-wpd-opt="profileShowDisplayName">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display Name", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-profileShowDisplayName" checked/>
                    <label for="wcai-pro-profileShowDisplayName"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileShowNickName -->
        <div class="wpd-opt-row" data-wpd-opt="profileShowNickName">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display Nickname", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-profileShowNickName" checked/>
                    <label for="wcai-pro-profileShowNickName"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileShowBio -->
        <div class="wpd-opt-row" data-wpd-opt="profileShowBio">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display Comment Author Biography", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-profileShowBio" checked/>
                    <label for="wcai-pro-profileShowBio"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileShowWebUrl -->
        <div class="wpd-opt-row" data-wpd-opt="profileShowWebUrl">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display Website", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-profileShowWebUrl" checked/>
                    <label for="wcai-pro-profileShowWebUrl"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileShowStatistics -->
        <div class="wpd-opt-row" data-wpd-opt="profileShowStatistics">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display Comment Statistics", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This information is available for admins only", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-profileShowStatistics" checked/>
                    <label for="wcai-pro-profileShowStatistics"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: profileShowMycredData -->
        <div class="wpd-opt-row" data-wpd-opt="profileShowMycredData">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display MyCRED Information", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("User Badges and Rank", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wcai-pro-profileShowMycredData" checked/>
                    <label for="wcai-pro-profileShowMycredData"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: perPage -->
        <div class="wpd-opt-row" data-wpd-opt="perPage">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pagination items per page", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="5" min="0" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Phrases", "wpdiscuz"); ?></div>

        <!-- Option start: phraseProfileSectionTitle -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileSectionTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Profile tab title", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Profile", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseActivitySectionTitle -->
        <div class="wpd-opt-row" data-wpd-opt="phraseActivitySectionTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Activity tab title", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Activity", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseVotesSectionTitle -->
        <div class="wpd-opt-row" data-wpd-opt="phraseVotesSectionTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Voted Comments tab title", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Votes", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseSubscriptionsSectionTitle -->
        <div class="wpd-opt-row" data-wpd-opt="phraseSubscriptionsSectionTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Subscriptions tab title", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Subscriptions", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseFollowsSectionTitle -->
        <div class="wpd-opt-row" data-wpd-opt="phraseFollowsSectionTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Follows tab title", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Follows", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseBlacklistSectionTitle -->
        <div class="wpd-opt-row" data-wpd-opt="phraseBlacklistSectionTitle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Blacklist tab title", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Blacklist", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseNotAvailable -->
        <div class="wpd-opt-row" data-wpd-opt="phraseNotAvailable">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Not Available", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Not available", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseNoData -->
        <div class="wpd-opt-row" data-wpd-opt="phraseNoData">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("No Data", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("No Data", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseFullInfo -->
        <div class="wpd-opt-row" data-wpd-opt="phraseFullInfo">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("View Full Info", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("View full info", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <h4 class="wpd-subtitle"><?php esc_html_e("Profile Tab", "wpdiscuz"); ?></h4>

        <!-- Option start: phraseProfileBlock -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileBlock">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Block", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Block", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileUnblock -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileUnblock">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Unblock", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Unblock", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileLastActivity -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileLastActivity">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Last Activity", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Last Activity:", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileComments -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileComments">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comments", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfilePosts -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfilePosts">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Posts", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Posts", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileReceivedLikes -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileReceivedLikes">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Received Likes", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Received Likes", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileReceivedDisikes -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileReceivedDisikes">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Received Disikes", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Received Disikes", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileAuthorBio -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileAuthorBio">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment Author Biography", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comment Author Biography", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileCommentsStat -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileCommentsStat">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comments Statistic", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comments Statistic", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileCommentsStatAll -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileCommentsStatAll">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("All", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("All", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileCommentsStatApproved -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileCommentsStatApproved">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Approved", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Approved", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileCommentsStatPending -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileCommentsStatPending">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pending", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Pending", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileCommentsStatSpam -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileCommentsStatSpam">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Spam", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Spam", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseProfileCommentsStatTrashed -->
        <div class="wpd-opt-row" data-wpd-opt="phraseProfileCommentsStatTrashed">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Trashed", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Trashed", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <h4 class="wpd-subtitle"><?php esc_html_e("Activity Tab", "wpdiscuz"); ?></h4>

        <!-- Option start: phraseActivityInResponseTo -->
        <div class="wpd-opt-row" data-wpd-opt="phraseActivityInResponseTo">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("In Response To", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("In Response To:", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <h4 class="wpd-subtitle"><?php esc_html_e("Votes Tab", "wpdiscuz"); ?></h4>

        <!-- Option start: phraseVotesInResponseTo -->
        <div class="wpd-opt-row" data-wpd-opt="phraseVotesInResponseTo">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("In Response To", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("In Response To:", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <h4 class="wpd-subtitle"><?php esc_html_e("Subscriptions Tab", "wpdiscuz"); ?></h4>

        <!-- Option start: phraseSubscriptionsReply -->
        <div class="wpd-opt-row" data-wpd-opt="phraseSubscriptionsReply">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Subscribed to replies to this comment", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("subscribed to replies to this comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseSubscriptionsAllComment -->
        <div class="wpd-opt-row" data-wpd-opt="phraseSubscriptionsAllComment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Subscribed to replies to own comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("subscribed to replies to own comments", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phraseSubscriptionsPost -->
        <div class="wpd-opt-row" data-wpd-opt="phraseSubscriptionsPost">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Subscribed to all follow-up comments of this post", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("subscribed to all follow-up comments of this post", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <h4 class="wpd-subtitle"><?php esc_html_e("Pagination", "wpdiscuz"); ?></h4>

        <!-- Option start: phrasePaginationFirst -->
        <div class="wpd-opt-row" data-wpd-opt="phrasePaginationFirst">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("First", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="&laquo;" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phrasePaginationPrevious -->
        <div class="wpd-opt-row" data-wpd-opt="phrasePaginationPrevious">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Previous", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="&lsaquo;" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phrasePaginationNext -->
        <div class="wpd-opt-row" data-wpd-opt="phrasePaginationNext">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Next", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="&rsaquo;" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: phrasePaginationLast -->
        <div class="wpd-opt-row" data-wpd-opt="phrasePaginationLast">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Last", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="&raquo;" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-comment-author-info/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Comment Author Info Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
