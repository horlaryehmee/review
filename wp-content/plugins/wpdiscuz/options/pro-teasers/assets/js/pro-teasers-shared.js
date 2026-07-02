/**
 * wpDiscuz Pro Teasers — shared script
 *
 * All teaser sidebar items and dashboard cards are rendered and ordered
 * server-side (new add-ons first, then rest by priority). This script
 * only handles accordion toggling and fake-tab form blocking.
 */
(function ($) {
    $(document).ready(function () {

        // -------------------------------------------------------
        // Accordion toggle
        // -------------------------------------------------------
        $(document).on("click", ".wpd-pro-teaser-header", function () {
            $(this).closest(".wpd-pro-teaser-wrap").toggleClass("wpd-pro-collapsed");
        });

        // -------------------------------------------------------
        // Auto-expand and scroll when navigated via anchor link
        // (e.g. sidebar "Media Uploader" / "Google reCAPTCHA")
        // -------------------------------------------------------
        var hash = window.location.hash;
        if (hash) {
            var target = $(hash + ".wpd-pro-teaser-wrap");
            if (target.length) {
                $("html").scrollTop(target.offset().top - 30);
                target.removeClass("wpd-pro-collapsed");
                var body = target.find(".wpd-pro-teaser-body");
                body.hide();
                body.slideDown(700, function () {
                    $("html").animate({scrollTop: target.offset().top - 30}, 500);
                });
            }
        }

        // -------------------------------------------------------
        // Pro Add-ons sidebar menu collapse
        // -------------------------------------------------------
        var menuGroup = $("#wpd-setbox .wpd-setbar .wpd-menu-group-teasers");
        if (menuGroup.length) {
            var menuHead = menuGroup.find("li.wpd-menu-head");
            var icon = menuHead.find(".dashicons");
            var teaserItems = menuGroup.find("li.wpd-pro-teaser-menu-item");
            var count = teaserItems.length;
            var hasNew = teaserItems.find(".wpd-new-badge").length > 0;

            if (count > 0) {
                menuHead.find(".wpd-menu-head-label").append('<span class="wpd-pro-addons-count"> (' + count + ')</span>');
            }

            var headNewBadge = null;
            if (hasNew) {
                var clonedBadge = teaserItems.find(".wpd-new-badge").first().clone();
                clonedBadge.addClass("wpd-menu-head-new-badge");
                menuHead.find(".wpd-menu-head-label").append(clonedBadge);
                headNewBadge = menuHead.find(".wpd-menu-head-new-badge");
            }

            // Collapse by default unless a teaser tab is currently active
            var hasActiveTeaser = teaserItems.filter(".wpd-active").length > 0;
            if (!hasActiveTeaser) {
                teaserItems.hide();
                icon.removeClass("dashicons-arrow-up").addClass("dashicons-arrow-down");
                // Badge stays visible — group is collapsed
            } else {
                // Group is expanded — hide the head badge (items show their own badges)
                if (headNewBadge) {
                    headNewBadge.hide();
                }
            }

            // Make the whole head row clickable — delegate to the dashicons so the
            // existing wpdiscuz-options.js handler (line 787) drives show/hide.
            menuHead.on("click", function (e) {
                if (!$(e.target).closest(".dashicons").length) {
                    icon.trigger("click");
                }
            });

            // Sync head badge visibility with collapse state after each toggle.
            // setTimeout(0) lets wpdiscuz-options.js finish toggling the icon class first.
            if (headNewBadge) {
                icon.on("click.wpdTeaserBadge", function () {
                    setTimeout(function () {
                        var isCollapsed = icon.hasClass("dashicons-arrow-down");
                        headNewBadge.toggle(isCollapsed);
                    }, 0);
                });
            }
        }

        // -------------------------------------------------------
        // Fake-tab forms: block submission
        // Only applies to full fake-tab teaser pages (no real save
        // button rendered). Inline teasers live inside real settings
        // tab forms that DO have a save button — skip those so that
        // saving real settings still works normally.
        // -------------------------------------------------------
        $("form").each(function () {
            var form = $(this);
            if (!form.find(".wpd-pro-teaser-wrap").length) {
                return;
            }

            if (form.find("input[name='wc_submit_options']").length) {
                return;
            }

            form.on("submit", function (e) {
                e.preventDefault();
            });
        });

    });
})(jQuery);
