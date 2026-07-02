<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-bell"></span>
            <?php esc_html_e("User Notifications Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Two options of user notifications are available. You can put the notification bell in the main menu using %wpdiscuz-bell% shortcode as a Custom Link URL. As a second option, use the [wpdiscuz_bell] shortcode in blocks and widgets. Web Push Notifications are also supported — displayed on screen even when the browser is minimized.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: loadMethod -->
        <div class="wpd-opt-row" data-wpd-opt="loadMethod">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notifications loading method:", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("By default, notifications are loaded by WordPress's REST API. If the REST API is not available or works with errors, change to AJAX.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="rest" id="wun-pro-loadMethodRest" checked/>
                    <label for="wun-pro-loadMethodRest" class="wpd-radio-lbl"><?php esc_html_e("REST", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="ajax" id="wun-pro-loadMethodAjax"/>
                    <label for="wun-pro-loadMethodAjax" class="wpd-radio-lbl"><?php esc_html_e("AJAX", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: notifications -->
        <div class="wpd-opt-row" data-wpd-opt="notifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notify me when:", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("There are many types of user notifications coming from the comment section. Here you can manage them for all users.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-myCommentVote" checked/>
                        <label for="wun-pro-myCommentVote"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-myCommentVote"><?php esc_html_e("someone votes on my comment", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-newFollower" checked/>
                        <label for="wun-pro-newFollower"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-newFollower"><?php esc_html_e("someone follows me", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-myPostRate" checked/>
                        <label for="wun-pro-myPostRate"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-myPostRate"><?php esc_html_e("someone rates my post", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-mention" checked/>
                        <label for="wun-pro-mention"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-mention"><?php esc_html_e("someone mentioned me", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-myCommentReply" checked/>
                        <label for="wun-pro-myCommentReply"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-myCommentReply"><?php esc_html_e("someone replied to my comment", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-myPostComment" checked/>
                        <label for="wun-pro-myPostComment"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-myPostComment"><?php esc_html_e("someone commented on my post", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-subscribedPostComment" checked/>
                        <label for="wun-pro-subscribedPostComment"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-subscribedPostComment"><?php esc_html_e("new comment on subscribed post", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-followingUserComment" checked/>
                        <label for="wun-pro-followingUserComment"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-followingUserComment"><?php esc_html_e("new comment by followed user", "wpdiscuz"); ?></label>
                    </div>
                </div>

                <div class="wpd-opt-input-wtext">
                    <div class="wpd-switcher wpd-switcher-wtext">
                        <input type="checkbox" disabled value="1" id="wun-pro-myCommentApprove" checked/>
                        <label for="wun-pro-myCommentApprove"></label>
                    </div>
                    <div class="wpd-switcher-label">
                        <label for="wun-pro-myCommentApprove"><?php esc_html_e("my comment is approved", "wpdiscuz"); ?></label>
                    </div>
                </div>

            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: adminBarBell -->
        <div class="wpd-opt-row" data-wpd-opt="adminBarBell">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show notification bell in the top admin bar", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-adminBarBellOn" checked/>
                    <label for="wun-pro-adminBarBellOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-adminBarBellOff"/>
                    <label for="wun-pro-adminBarBellOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: browserNotifications -->
        <div class="wpd-opt-row" data-wpd-opt="browserNotifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Web Push Notifications", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Web Push allows websites to notify you of new messages or updated content. While the browser is open, websites which have been granted permission can send notifications to your browser, which displays them on the screen.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-browserNotificationsOn" checked/>
                    <label for="wun-pro-browserNotificationsOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-browserNotificationsOff"/>
                    <label for="wun-pro-browserNotificationsOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: setReadOnLoad -->
        <div class="wpd-opt-row" data-wpd-opt="setReadOnLoad">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Set notifications as [READ] on load", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("If you enable this option the notifications will be set as [READ] once they have been loaded.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-setReadOnLoadOn"/>
                    <label for="wun-pro-setReadOnLoadOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-setReadOnLoadOff" checked/>
                    <label for="wun-pro-setReadOnLoadOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: bellForRoles -->
        <div class="wpd-opt-row" data-wpd-opt="bellForRoles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display notification bell for roles", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("User roles who are allowed to see the bell and receive notifications.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) { ?>
                    <div class="wpd-mublock-inline wpd-mublock-wide">
                        <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" checked/>
                        <label><?php echo esc_html($info["name"]); ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: bellForGuests -->
        <div class="wpd-opt-row" data-wpd-opt="bellForGuests">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display notification bell for guests", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Display the bell and allow to receive notifications for non-logged-in users.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-bellForGuestsOn" checked/>
                    <label for="wun-pro-bellForGuestsOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-bellForGuestsOff"/>
                    <label for="wun-pro-bellForGuestsOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: bellForVisitors -->
        <div class="wpd-opt-row" data-wpd-opt="bellForVisitors">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display notification bell for new visitors", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("New visitors have never commented on your website and do not have commenter name and email information in cookies. This kind of visitors cannot be tracked for notifications.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-bellForVisitorsOn"/>
                    <label for="wun-pro-bellForVisitorsOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-bellForVisitorsOff" checked/>
                    <label for="wun-pro-bellForVisitorsOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: lastXDays -->
        <div class="wpd-opt-row" data-wpd-opt="lastXDays">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show notifications for last X days", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" min="1" value="30" disabled class="wpd-num-input"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: liveUpdate -->
        <div class="wpd-opt-row" data-wpd-opt="liveUpdate">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Live update", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-liveUpdateOn" checked/>
                    <label for="wun-pro-liveUpdateOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-liveUpdateOff"/>
                    <label for="wun-pro-liveUpdateOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: updateTimer -->
        <div class="wpd-opt-row" data-wpd-opt="updateTimer">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Update every", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <select>
                    <option value="30"><?php esc_html_e("30 Seconds", "wpdiscuz"); ?></option>
                    <option value="60" selected><?php esc_html_e("1 Minute", "wpdiscuz"); ?></option>
                    <option value="180"><?php esc_html_e("3 Minutes", "wpdiscuz"); ?></option>
                    <option value="300"><?php esc_html_e("5 Minutes", "wpdiscuz"); ?></option>
                    <option value="600"><?php esc_html_e("10 Minutes", "wpdiscuz"); ?></option>
                </select>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: perLoad -->
        <div class="wpd-opt-row" data-wpd-opt="perLoad">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notifications count per load", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" min="1" value="25" disabled class="wpd-num-input"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: showCountOfNotLoaded -->
        <div class="wpd-opt-row" data-wpd-opt="showCountOfNotLoaded">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display the count of not loaded notifications on load more button.", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="1" id="wun-pro-showCountOn" checked/>
                    <label for="wun-pro-showCountOn" class="wpd-radio-lbl"><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0" id="wun-pro-showCountOff"/>
                    <label for="wun-pro-showCountOff" class="wpd-radio-lbl"><?php esc_html_e("Disable", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: soundUrl -->
        <div class="wpd-opt-row" data-wpd-opt="soundUrl">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notification sound URL", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Please note that notifications sound will work with .mp3 files only and when the user already interacted with the website.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="...plugins/wpdiscuz-user-notifications/assets/audio/pristine.mp3" class="wun-pro-sound-input"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: playSoundWhen -->
        <div class="wpd-opt-row" data-wpd-opt="playSoundWhen">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Play the sound when notification is:", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("[NEW] plays the sound on every new notification. [UNREAD] plays the sound if there is an unread notification on every page loading and notification checking actions.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="new" id="wun-pro-playSoundNew" checked/>
                    <label for="wun-pro-playSoundNew"><?php esc_html_e("New", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="unread" id="wun-pro-playSoundUnread"/>
                    <label for="wun-pro-playSoundUnread"><?php esc_html_e("Unread", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: bellStyle -->
        <div class="wpd-opt-row" data-wpd-opt="bellStyle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Bell Style", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="bordered" id="wun-pro-bellStyleBordered" checked/>
                    <label for="wun-pro-bellStyleBordered" class="wun-bell-style-lbl">
                        <svg class="wun-bell-style" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.25 26.5c0-0.141-0.109-0.25-0.25-0.25-1.234 0-2.25-1.016-2.25-2.25 0-0.141-0.109-0.25-0.25-0.25s-0.25 0.109-0.25 0.25c0 1.516 1.234 2.75 2.75 2.75 0.141 0 0.25-0.109 0.25-0.25zM3.844 22h20.312c-2.797-3.156-4.156-7.438-4.156-13 0-2.016-1.906-5-6-5s-6 2.984-6 5c0 5.563-1.359 9.844-4.156 13zM27 22c0 1.094-0.906 2-2 2h-7c0 2.203-1.797 4-4 4s-4-1.797-4-4h-7c-1.094 0-2-0.906-2-2 2.312-1.953 5-5.453 5-13 0-3 2.484-6.281 6.625-6.891-0.078-0.187-0.125-0.391-0.125-0.609 0-0.828 0.672-1.5 1.5-1.5s1.5 0.672 1.5 1.5c0 0.219-0.047 0.422-0.125 0.609 4.141 0.609 6.625 3.891 6.625 6.891 0 7.547 2.688 11.047 5 13z"></path>
                        </svg>
                        <?php esc_html_e("Bordered", "wpdiscuz"); ?>
                    </label>
                    <input type="radio" disabled value="filled" id="wun-pro-bellStyleFilled"/>
                    <label for="wun-pro-bellStyleFilled" class="wun-bell-style-lbl">
                        <svg class="wun-bell-style" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.25 26.5c0-0.141-0.109-0.25-0.25-0.25-1.234 0-2.25-1.016-2.25-2.25 0-0.141-0.109-0.25-0.25-0.25s-0.25 0.109-0.25 0.25c0 1.516 1.234 2.75 2.75 2.75 0.141 0 0.25-0.109 0.25-0.25zM27 22c0 1.094-0.906 2-2 2h-7c0 2.203-1.797 4-4 4s-4-1.797-4-4h-7c-1.094 0-2-0.906-2-2 2.312-1.953 5-5.453 5-13 0-3 2.484-6.281 6.625-6.891-0.078-0.187-0.125-0.391-0.125-0.609 0-0.828 0.672-1.5 1.5-1.5s1.5 0.672 1.5 1.5c0 0.219-0.047 0.422-0.125 0.609 4.141 0.609 6.625 3.891 6.625 6.891 0 7.547 2.688 11.047 5 13z"></path>
                        </svg>
                        <?php esc_html_e("Filled", "wpdiscuz"); ?>
                    </label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: containerAnimationInMs -->
        <div class="wpd-opt-row" data-wpd-opt="containerAnimationInMs">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Notifications' container animation speed in milliseconds.", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" min="1" value="300" disabled class="wpd-num-input"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: colors -->
        <div class="wpd-opt-row" data-wpd-opt="colors">
            <div class="wpd-opt-input wpd-opt-input-full-row">
                <h2 class="wun-pro-colors-h2"><?php esc_html_e("Colors", "wpdiscuz"); ?></h2>
                <hr/>
                <div class="wpd-un-bell-colors">
                    <h4 class="wun-pro-colors-h4"><?php esc_html_e("Default Bell", "wpdiscuz"); ?></h4>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#00B38F;"></span>
                        <input type="text" disabled value="#00B38F"/>
                        <label><?php esc_html_e("Bell icon", "wpdiscuz"); ?></label>
                    </div>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#ffffff; border:1px solid #ccc;"></span>
                        <input type="text" disabled value="#ffffff"/>
                        <label><?php esc_html_e("Counter text", "wpdiscuz"); ?></label>
                    </div>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#ff6b4f;"></span>
                        <input type="text" disabled value="#ff6b4f"/>
                        <label><?php esc_html_e("Counter background", "wpdiscuz"); ?></label>
                    </div>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#dd6650;"></span>
                        <input type="text" disabled value="#dd6650"/>
                        <label><?php esc_html_e("Counter box shadow", "wpdiscuz"); ?></label>
                    </div>
                </div>
                <div class="wpd-un-bar-bell-colors">
                    <h4 class="wun-pro-colors-h4"><?php esc_html_e("Admin Bar Bell", "wpdiscuz"); ?></h4>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#effff4;"></span>
                        <input type="text" disabled value="#effff4"/>
                        <label><?php esc_html_e("Bell icon", "wpdiscuz"); ?></label>
                    </div>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#000000;"></span>
                        <input type="text" disabled value="#000000"/>
                        <label><?php esc_html_e("Counter text", "wpdiscuz"); ?></label>
                    </div>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#effff4;"></span>
                        <input type="text" disabled value="#effff4"/>
                        <label><?php esc_html_e("Counter background", "wpdiscuz"); ?></label>
                    </div>
                    <div class="wpd-color-wrap">
                        <span class="wpd-color-swatch" style="background:#f4fff7;"></span>
                        <input type="text" disabled value="#f4fff7"/>
                        <label><?php esc_html_e("Counter box shadow", "wpdiscuz"); ?></label>
                    </div>
                </div>
                <div class="wpd-clear"></div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: DB management -->
        <div class="wpd-opt-row" data-wpd-opt="deleteNotifications">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Database Management", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Manage stored notifications in the database.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <button type="button" disabled class="button button-secondary wun-pro-db-btn"><?php esc_html_e("Delete All Notifications (0)", "wpdiscuz"); ?></button>
                <button type="button" disabled class="button button-secondary wun-pro-db-btn"><?php esc_html_e("Delete Expired Notifications (0)", "wpdiscuz"); ?></button>
                <button type="button" disabled class="button button-secondary wun-pro-db-btn"><?php esc_html_e("Delete Read Notifications (0)", "wpdiscuz"); ?></button>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Phrases: Notifications' Texts + Container Texts accordion -->
        <div id="wun-pro-phrases-accordion">

            <!-- Accordion item: Notifications' Texts -->
            <div class="wun-accordion-item wun-accordion-current">
                <div class="wpd-subtitle fas wpd-subtitle-mt wun-accordion-title">
                    <p><?php esc_html_e("Notifications' Texts", "wpdiscuz"); ?></p>
                </div>
                <div class="wun-accordion-content">

                    <!-- Comment Like -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("The user's comment has been liked", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleCommentLike">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Like", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New like", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageCommentLike">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Like", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[COMMENT_CONTENT]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> liked your <a href='[COMMENT_URL]'>comment</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- Comment Dislike -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("The user's comment has been disliked", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleCommentDislike">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Dislike", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New dislike", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageCommentDislike">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Dislike", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[COMMENT_CONTENT]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> disliked your <a href='[COMMENT_URL]'>comment</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- New Follower -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("The user has gained a new follower", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleNewFollower">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Follower", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New follower", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageNewFollower">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Follower", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> has started following you <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- My Post Rate -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("The user's post has received a new rating", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleMyPostRate">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Rate", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New rate on my post", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageMyPostRate">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Rate", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[RATING]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> has rated ([RATING]) your post - <a href='[POST_URL]'>[POST_TITLE]</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- Mention -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("The user has been mentioned in a comment", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleMention">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Mention", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New mention", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageMention">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Mention", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[COMMENT_CONTENT]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("You have been mentioned by <strong>[NOTIFIER]</strong> in this <a href='[COMMENT_URL]'>comment</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- My Comment Reply -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("Someone has replied to the user's comment", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleMyCommentReply">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Reply", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New Reply", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageMyCommentReply">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Reply", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[COMMENT_CONTENT]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> has replied to your <a href='[COMMENT_URL]'>comment</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- My Post Comment -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("Someone has commented on the user's post", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleMyPostComment">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - New Post Comment", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New Comment", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageMyPostComment">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - New Post Comment", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> has <a href='[COMMENT_URL]'>commented</a> on your post: <a href='[POST_URL]'>[POST_TITLE]</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- Subscribed Post Comment -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("New comment on a post the user subscribed to", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleSubscribedPostComment">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - Subscribed Post Comment", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New Comment", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageSubscribedPostComment">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - Subscribed Post Comment", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> has left a <a href='[COMMENT_URL]'>comment</a> on your subscribed post: <a href='[POST_URL]'>[POST_TITLE]</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- Following User Comment -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("A followed user has left a new comment", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleFollowingUserComment">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - Following User Comment", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("New Comment", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageFollowingUserComment">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - Following User Comment", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[NOTIFIER]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_IMG]</span> <span class="wc_available_variable">[NOTIFIER_AVATAR_URL]</span> <span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[POST_TITLE]</span> <span class="wc_available_variable">[POST_URL]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("<strong>[NOTIFIER]</strong> has left a <a href='[COMMENT_URL]'>comment</a> on <a href='[POST_URL]'>[POST_TITLE]</a> <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- My Comment Approve -->
                    <div class="wpd-subtitle wpd-subtitle-mt wun-subtitle"><?php esc_html_e("The user's comment has been approved", "wpdiscuz"); ?></div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTitleMyCommentApprove">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Notification Title - Comment Approved", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Comment Approved", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMessageMyCommentApprove">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Notification Message - Comment Approved", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Available shortcodes", "wpdiscuz"); ?>:</p>
                            <p class="wpd-desc"><span class="wc_available_variable">[COMMENT_URL]</span> <span class="wc_available_variable">[DATE]</span> <span class="wc_available_variable">[MARK_READ_URL]</span> <span class="wc_available_variable">[MARK_READ_UNREAD_TEXT]</span></p>
                        </div>
                        <div class="wpd-opt-input"><textarea disabled rows="4"><?php echo esc_textarea("Your <a href='[COMMENT_URL]'>comment</a> has been approved <time class='wun-date'>[DATE]</time> <a href='[MARK_READ_URL]'>[MARK_READ_UNREAD_TEXT]</a>"); ?></textarea></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                </div><!-- .wun-accordion-content -->
            </div><!-- .wun-accordion-item: Notifications' Texts -->

            <!-- Accordion item: Container Texts -->
            <div class="wun-accordion-item wun-accordion-current">
                <div class="wpd-subtitle fas wpd-subtitle-mt wun-accordion-title">
                    <p><?php esc_html_e("Container Texts", "wpdiscuz"); ?></p>
                </div>
                <div class="wun-accordion-content">

                    <div class="wpd-opt-row" data-wpd-opt="ntfContainerTitle">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Container Title", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Notifications", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTabUnreadTitle">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Unread Tab Title", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Unread", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfTabReadTitle">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Read Tab Title", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Read", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfLoadMore">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Load More Button Text", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Load More", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfDeleteAll">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Delete All Button Text", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Delete all", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfNoNotifications">
                        <div class="wpd-opt-name"><label><?php esc_html_e("No Notifications Text", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("No notifications", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMarkAsRead">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Mark as Read Text", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Mark as read", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfMarkAsUnread">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Mark as Unread Text", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Mark as unread", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <div class="wpd-opt-row" data-wpd-opt="ntfConfirmDeleteAll">
                        <div class="wpd-opt-name"><label><?php esc_html_e("Delete All Confirm Text", "wpdiscuz"); ?></label></div>
                        <div class="wpd-opt-input"><input type="text" disabled value="<?php esc_attr_e("Are you sure you want to delete all notifications?", "wpdiscuz"); ?>"/></div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                </div><!-- .wun-accordion-content -->
            </div><!-- .wun-accordion-item: Container Texts -->

        </div><!-- #wun-pro-phrases-accordion -->

    </div><!-- .wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-user-notifications/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get User Notifications", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- .wpd-pro-teaser-wrap -->
