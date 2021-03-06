jQuery(document).ready(function (a) {
    "use strict";

    function e(a, e) {
        return '<div id="widget-tpl-agama-' + e + '-1" class="widget-tpl pro-widget"><a href="https://theme-vision.com/agama-pro/" target="_blank"><div class="widget-overlay">' + agama_builder.proWidgetDesc + '</div></a><div id="widget-3-agama-' + e + '-__i__" class="widget"><div class="widget-top"><div class="widget-title"><h3>' + a + '<span class="in-widget-title"></span></h3></div></div><div class="widget-description">' + agama_builder.proWidgetDesc + "</div></div></div>"
    }
    
    var i = "select[data-id=agama_page_builder_page]";
    
    a(i).attr("value", ""), a(document.body).on("change", i, function () {
        var e = a(this).val(),
            i = "sidebar-widgets-page-widget-" + e,
            t = {
                action: "agama_ajax_get_permalink",
                id: e
            };
        
        jQuery.post(agama_builder.ajax_url, t, function (e) {
            wp.customize.previewer.previewUrl.set(e), wp.customize.previewer.bind("focus-on-widget", function (e) {
                a("#sub-accordion-section-" + e + " button.add-new-widget").click()
            })
        }), 
        wp.customize.section(i).activate(), wp.customize.section(i).focus(), a("#sub-accordion-section-" + i + " .customize-section-back").on("click", function () {
            wp.customize.section("agama_page_builder_section").focus()
        })
    }),
    
    a(document.body).on("change", function () {
        wp.customize.previewer.bind("focus-on-widget", function (e) {
            wp.customize.section(e).focus(), a("#sub-accordion-section-" + e + " button.add-new-widget").click()
        })
    }), 
        
    a("#available-widgets-list").prepend('<ul id="agama-widgets-selector"><li class="agama-widgets active"><span>' + agama_builder.agamaWidgetsLabel + '</span></li><li class="other-widgets"><span>' + agama_builder.otherWidgetsLabel + "</span></li></ul>"), 
        
    a('#available-widgets-list [id*="widget-tpl-agama_"]').wrapAll('<div class="agama-widgets-wrapper"></div>'), 
    a("#available-widgets-list > .widget-tpl").wrapAll('<div class="other-widgets-wrapper"></div>'), 
    
    a("#agama-widgets-selector li").click(function () {
        a(this).siblings().removeClass("active"), 
        a(this).addClass("active"), 
        a(this).hasClass("other-widgets") ? (
            a(".agama-widgets-wrapper").fadeOut(), 
            a(".other-widgets-wrapper").fadeIn()
        ) : (
            a(".other-widgets-wrapper").fadeOut(), 
            a(".agama-widgets-wrapper").fadeIn()
        )
    })
});
