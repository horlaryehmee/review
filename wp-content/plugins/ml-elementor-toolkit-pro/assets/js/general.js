jQuery(document).ready(function ($) {
    $("body").on("click", ".mlt-carousel-next-btn", function (e) {
        console.log($(this).parents(".elementor-widget"));
        e.preventDefault(), $(this).closest(".elementor-widget").find(".owl-carousel").trigger("next.owl.carousel")
    });
    $("body").on("click", ".mlt-carousel-prev-btn", function (e) {
        e.preventDefault(), $(this).closest(".elementor-widget").find(".owl-carousel").trigger("prev.owl.carousel")
    });

    $(document).on("click",".cts-open-chat",function(e){
        e.preventDefault();
        var t = $(this).data("user-id") || null,
            i = $(this).data("post-data");
        if (!$("body").hasClass("logged-in")) return $("#sign-in-modal").modal("toggle");
        MyListing.Messages.open(t, i), setTimeout(function () {
            $(MyListing.Messages.$el).find("#ml-conv-textarea").focus()
        }, 150)
    })
});