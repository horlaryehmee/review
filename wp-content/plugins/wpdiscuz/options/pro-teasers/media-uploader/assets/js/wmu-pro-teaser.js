jQuery(document).ready(function ($) {
    $(document).on("click", ".wpd-pro-teaser-header", function () {
        $(this).closest(".wpd-pro-teaser-wrap").toggleClass("wpd-pro-collapsed");
    });
});
