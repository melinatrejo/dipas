! function (e) {
    function t(t) {
        t.find(".color-picker").wpColorPicker({
            change: _.throttle(function () {
                e(this).trigger("change"), wp.customize.previewer.refresh()
            }, 2e3)
        })
    }
    e(document).on("widget-added widget-updated", function (e, i) {
        t(i)
    }), e(document).ready(function () {
        e("#widgets-right .widget:has(.color-picker)").each(function () {
            t(e(this))
        })
    })
}(jQuery), WPEditorWidget = {
    currentContentId: "",
    currentEditorPage: "",
    wpFullOverlayOriginalZIndex: 0,
    showEditor: function (e) {
        jQuery("#wp-editor-widget-backdrop").show(), jQuery("body.widgets-php #wp-editor-widget-container, body.post-type-page #wp-editor-widget-container, body.fl-builder #wp-editor-widget-container").show(), jQuery("body.wp-customizer #wp-editor-widget-container").fadeIn(100).animate({
            left: "0"
        }), this.currentContentId = e, jQuery("body").hasClass("wp-customizer") ? this.currentEditorPage = "wp-customizer" : jQuery("body").hasClass("widgets-php") ? this.currentEditorPage = "widgets-php" : this.currentEditorPage = "wp-pagescreen", "wp-customizer" == this.currentEditorPage && (this.wpFullOverlayOriginalZIndex = parseInt(jQuery(".wp-full-overlay").css("zIndex")), jQuery(".wp-full-overlay").css({
            zIndex: 49e3
        })), this.setEditorContent(e)
    },
    hideEditor: function () {
        jQuery("#wp-editor-widget-backdrop").hide(), jQuery("body.widgets-php #wp-editor-widget-container, body.post-type-page #wp-editor-widget-container, body.fl-builder #wp-editor-widget-container").hide(), jQuery("body.wp-customizer #wp-editor-widget-container").animate({
            left: "-650px"
        }).fadeOut(), "wp-customizer" == this.currentEditorPage && jQuery(".wp-full-overlay").css({
            zIndex: this.wpFullOverlayOriginalZIndex
        })
    },
    setEditorContent: function (e) {
        var t = tinyMCE.EditorManager.get("wpeditorwidget"),
            i = jQuery("#" + e).val();
        "object" == typeof t && null !== t && t.setContent(i), jQuery("#wpeditorwidget").val(i)
    },
    updateWidgetAndCloseEditor: function () {
        jQuery("#wpeditorwidget-tmce").trigger("click");
        var e = tinyMCE.EditorManager.get("wpeditorwidget");
        if (void 0 === e || null == e || e.isHidden()) var t = jQuery("#wpeditorwidget").val();
        else t = e.getContent();
        if (jQuery("#" + this.currentContentId).val(t), "wp-customizer" == this.currentEditorPage && "editorfield" == jQuery("#" + this.currentContentId).attr("class")) {
            var i = jQuery("#" + this.currentContentId).data("customize-setting-link");
            setTimeout(function () {
                wp.customize(i, function (t) {
                    t.set(e.getContent())
                })
            }, 1e3)
        } else if ("wp-customizer" == this.currentEditorPage) {
            var r = jQuery("#" + this.currentContentId).closest("div.form").find("input.widget-id").val();
            wp.customize.Widgets.getWidgetFormControlForWidget(r).updateWidget()
        } else "widgets-php" == this.currentEditorPage ? wpWidgets.save(jQuery("#" + this.currentContentId).closest("div.widget"), 0, 1, 0) : jQuery("#" + this.currentContentId).closest("div.form").find("input.widget-id").val(e.getContent());
        this.hideEditor()
    }
};
