portfolio_gallery_backend_script = (function () {
    var i = jQuery,
        e = {};
    return (
        (e.isBackendInitialized = !1),
        (e.init = function () {
            e.isBackendInitialized || ((e.isBackendInitialized = !0), i(document).trigger("slideshowBackendReady"));
        }),
        i(document).ready(e.init),e
    );
})();
portfolio_gallery_backend_script.generalSettings = (function () {
    var e = jQuery,
        i = {};
    return (
        (i.isCurrentPage = !1),
        (i.init = function () {
            "portgal_page_general_settings" === window.pagenow && ((i.isCurrentPage = !0), i.activateUserCapabilities());
        }),
        (i.activateUserCapabilities = function () {
            e("input").change(function (i) {
                var t,
                    a,
                    s,
                    r = e(i.currentTarget),
                    n = "portfolio-gallery-add-slideshows",
                    d = "portfolio-gallery-edit-slideshows",
                    l = "portfolio-gallery-delete-slideshows";
                "checkbox" == r.attr("type").toLowerCase() &&
                    ((t = r.attr("id").split("_")),
                    (a = t.shift()),
                    (s = t.join("_")),
                    a !== d || r.attr("checked") ? (a === n || a === l) && e("#" + d + "_" + s).attr("checked", !0) : (e("#" + n + "_" + s).attr("checked", !1), e("#" + l + "_" + s).attr("checked", !1)));
            });
        }),
        e(document).bind("slideshowBackendReady", i.init),
        i
    );
})();
portfolio_gallery_backend_script.generalSettings.customStyles = (function () {
    var e = jQuery,
        t = {};
    return (
        (t.init = function () {
            portfolio_gallery_backend_script.generalSettings.isCurrentPage && t.activateNavigation();
        }),
        (t.activateNavigation = function () {
            e(".nav-tab").click(function (t) {
                var a,
                    i = e(t.currentTarget),
                    r = e(".nav-tab-active");
                r.removeClass("nav-tab-active"),
                    i.addClass("nav-tab-active"),
                    e(r.attr("href").replace("#", ".")).hide(),
                    e(i.attr("href").replace("#", ".")).show(),
                    (a = e("input[name=_wp_http_referer]")),
                    a.attr("value", a.attr("value").split("#").shift() + i.attr("href"));
            }),
                e('a[href="#' + document.URL.split("#").pop() + '"]').trigger("click");
        }),
        e(document).bind("slideshowBackendReady", t.init),
        t
    );
})();


portfolio_gallery_backend_script.generalSettings.customStyles = (function () {
    var t = jQuery,
        e = {};
    return (
        (e.init = function () {
            portfolio_gallery_backend_script.generalSettings.isCurrentPage && (e.activateActionButtons(), e.activateDeleteButtons());
        }),
        (e.activateActionButtons = function () {
            t(".custom-styles-tab .styles-list .style-action.style-default").click(function (s) {
                var l,
                    i,
                    o,
                    n,
                    a,
                    c = t(s.currentTarget),
                    y = c.closest("li").find(".style-title").html(),
                    u = c.closest("li").find(".style-content").html(),
                    r = window.portfolio_gallery_backend_script_generalSettings,
                    m = "portfolio-gallery-custom-styles";
                "string" != typeof u ||
                    u.length <= 0 ||
                    ("object" == typeof r &&
                        ("object" == typeof r.localization && void 0 !== r.localization.newCustomizationPrefix && r.localization.newCustomizationPrefix.length > 0 && (y = r.localization.newCustomizationPrefix + " - " + y),
                        "object" == typeof r.data && void 0 !== r.data.customStylesKey && r.data.customStylesKey.length > 0 && (m = r.data.customStylesKey)),
                    (l = m + "_" + (e.getHighestCustomStyleID() + 1)),
                    (n = t(".custom-styles-tab .custom-style-templates")),
                    (i = n.find(".style-editor").clone()),
                    i.addClass(l),
                    i.find(".new-custom-style-title").attr("value", y),
                    i.find(".new-custom-style-content").html(u),
                    i.find(".new-custom-style-title").attr("name", m + "[" + l + "][title]"),
                    i.find(".new-custom-style-content").attr("name", m + "[" + l + "][style]"),
                    t(".custom-styles-tab .style-editors").append(i),
                    setTimeout(function () {
                        i.fadeIn(200);
                    }, 200),
                    (o = n.find(".custom-styles-list-item").clone(!0)),
                    o.removeClass("custom-styles-list-item"),
                    o.find(".style-title").html(y),
                    o.find(".style-action").addClass(l),
                    o.find(".style-delete").addClass(l),
                    (a = t(".custom-styles-tab .styles-list .custom-styles-list")),
                    a.find(".no-custom-styles-found").remove(),
                    a.append(o));
            }),
                t(".custom-styles-tab .styles-list .style-action, .custom-styles-tab .custom-style-templates .custom-styles-list-item .style-action").click(function (e) {
                    var s = t(e.currentTarget).attr("class").split(" ")[1];
                    void 0 !== s &&
                        (t(".custom-styles-tab .style-editors .style-editor").each(function (e, s) {
                            t(s).fadeOut(200);
                        }),
                        setTimeout(function () {
                            t(".style-editor." + s).fadeIn(200);
                        }, 200));
                });
        }),
        (e.activateDeleteButtons = function () {
            t(".custom-styles-tab .styles-list .style-delete, .custom-styles-tab .custom-style-templates .custom-styles-list-item .style-delete").click(function (e) {
                var s = t(e.currentTarget),
                    l = s.attr("class").split(" ")[1],
                    i = window.portfolio_gallery_backend_script_generalSettings,
                    o = "Are you sure you want to delete this custom style?";
                void 0 !== l &&
                    ("object" == typeof i && "object" == typeof i.localization && void 0 !== i.localization.confirmDeleteMessage && i.localization.confirmDeleteMessage.length > 0 && (o = i.localization.confirmDeleteMessage),
                    confirm(o) && (t(".custom-styles-tab .style-editors .style-editor." + l).remove(), s.closest("li").remove()));
            });
        }),
        (e.getHighestCustomStyleID = function () {
            var e = 0;
            return (
                t(".custom-styles-tab .style-editors .style-editor").each(function (s, l) {
                    var i = parseInt(t(l).attr("class").split("_").pop(), 10);
                    i > e && (e = i);
                }),
                parseInt(e, 10)
            );
        }),
        t(document).bind("slideshowBackendReady", e.init),
        e
    );
})();
portfolio_gallery_backend_script.editSlideshow = (function () {
    var i = jQuery,
        e = {};
    return (
        (e.isCurrentPage = !1),
        (e.init = function () {
            "portgal" === window.pagenow && ((e.isCurrentPage = !0), e.activateSettingsVisibilityDependency());
        }),
        (e.activateSettingsVisibilityDependency = function () {
            i(".depends-on-field-value").each(function (t, n) {
                var s = i(n),
                    a = s.attr("class").split(" "),
                    o = s.closest("tr");
                i('input[name="' + a[1] + '"]:checked').val() == a[2] ? o.show() : o.hide(),
                    i('input[name="' + a[1] + '"]').change(a, function (t) {
                        var n = i("." + a[3]).closest("tr");
                        i(t.currentTarget).val() == a[2] ? e.animateElementVisibility(n, !0) : e.animateElementVisibility(n, !1);
                    });
            });
        }),
        (e.animateElementVisibility = function (e, t) {
            var n = i(e);
            void 0 === t && (n.stop(!0, !0), (t = !n.is(":visible"))),
                t
                    ? (n.stop(!0, !0).show().css("background-color", "#c0dd52"),
                      setTimeout(function () {
                          n.stop(!0, !0).animate({ "background-color": "transparent" }, 1500);
                      }, 500))
                    : (n.stop(!0, !0).css("background-color", "#d44f6e"),
                      setTimeout(function () {
                          n.stop(!0, !0).hide(1500, function () {
                              n.css("background-color", "transparent");
                          });
                      }, 500));
        }),
        i(document).bind("slideshowBackendReady", e.init),
        e
    );
})();
portfolio_gallery_backend_script.editSlideshow.slideManager = (function () {

    var e = jQuery,
        i = {};
    return (
        (i.uploader = null),
        (i.init = function () {
	
            portfolio_gallery_backend_script.editSlideshow.isCurrentPage && i.activate();
        }),
        (i.activate = function () {
		
            i.indexSlidesOrder(),
                e(".sortable-slides-list").sortable({
                    revert: !0,
                    placeholder: "sortable-placeholder",
                    forcePlaceholderSize: !0,
                    stop: function () {
                        i.indexSlidesOrder();
                    },
                    cancel: "input, select, textarea",
                }),
                e(".wp-color-picker-field").wpColorPicker({ width: 234 }),
                e(".open-slides-button").on("click", function (i) {
                    i.preventDefault(),
                        e(".sortable-slides-list .sortable-slides-list-item").each(function (i, t) {
                            var l = e(t);
                            l.find(".inside").is(":visible") || l.find(".handlediv").trigger("click");
                        });
                }),
                e(".close-slides-button").on("click", function (i) {
                    i.preventDefault(),
                        e(".sortable-slides-list .sortable-slides-list-item").each(function (i, t) {
                            var l = e(t);
                            l.find(".inside").is(":visible") && l.find(".handlediv").trigger("click");
                        });
                }),
                e(".slideshow-insert-text-slide").off().on("click", i.insertTextSlide),
                e(".slideshow-insert-video-slide").off().on("click", i.insertVideoSlide),
                e(".slideshow-insert-image-slide").off().on("click", i.mediaUploader),
				e(".mediachange").off().on("click", i.mediaChange),
                e(".slideshow-delete-slide").off().on("click", function (t) {
                    i.delete(e(t.currentTarget).closest(".pg-list-item"));
                });
        }),
        (i.delete = function (e) {
            var i = "Are you sure you want to?",
                t = window.portfolio_gallery_backend_script_editSlideshow;
            "object" == typeof t && "object" == typeof t.localization && void 0 !== t.localization.confirm && t.localization.confirm.length > 0 && (i = t.localization.confirm), confirm(i) && e.remove();
        }),
        (i.indexSlidesOrder = function () {
            e(".sortable-slides-list .sortable-slides-list-item").each(function (i, t) {
				
				  e(this).attr("id", "listpg"+(i+1));
				e(this).find(".mediachange").attr("id", (i+1));
				  
                e.each(e(t).find("input, select, textarea"), function (t, l) {
                    var d = e(l),
                        n = d.attr("name");
                    void 0 === n || n.length <= 0 || ((n = n.replace(/[\[\]']+/g, " ").split(" ")), d.attr("name", n[0] + "[" + (i + 1) + "][" + n[2] + "]"));
                });
            });
        }),
		(i.mediaChange = function (e) {
            e.preventDefault();
			
			var idx=jQuery(this).attr('id');

			
            var t, l;
            return i.uploader
                ? ((l = window.portfolio_gallery_backend_script_editSlideshow),
                  (t = ""),
                  "object" == typeof l && "object" == typeof l.localization && void 0 !== l.localization.uploaderTitle && l.localization.uploaderTitle.length > 0 && (t = l.localization.uploaderTitle),
                  (i.uploader = wp.media.frames.portfolio_gallery_uploader = wp.media({ frame: "select", title: t, multiple: !0, library: { type: "image" } })),
                  i.uploader.on("select", function () {
                      var e,
                          t,
                          l = i.uploader.state().get("selection").toJSON();
                      for (t in l) l.hasOwnProperty(t) && ((e = l[t]), i.changeImageSlide(idx, e.id, e.title, e.description, e.url, e.alt));
                  }),
                  i.uploader.open(),
                  void 0)
                : ((l = window.portfolio_gallery_backend_script_editSlideshow),
                  (t = ""),
                  "object" == typeof l && "object" == typeof l.localization && void 0 !== l.localization.uploaderTitle && l.localization.uploaderTitle.length > 0 && (t = l.localization.uploaderTitle),
                  (i.uploader = wp.media.frames.portfolio_gallery_uploader = wp.media({ frame: "select", title: t, multiple: !0, library: { type: "image" } })),
                  i.uploader.on("select", function () {
                      var e,
                          t,
                          l = i.uploader.state().get("selection").toJSON();
                      for (t in l) l.hasOwnProperty(t) && ((e = l[t]), i.changeImageSlide(idx, e.id, e.title, e.description, e.url, e.alt));
                  }),
                  i.uploader.open(),
                  void 0);
        }),
        (i.changeImageSlide = function (id, t, l, d, n, a) {

	
            var s = jQuery("#listpg"+id);
	
            s.find(".attachment").attr("src", n),
                s.find(".attachment").attr("title", l),
                s.find(".attachment").attr("alt", a),
                s.find(".title").attr("value", l),
				  s.find(".slide-title").html( l),
                s.find(".description").html(d),
                s.find(".alternativeText").attr("value", a),
                s.find(".postId").attr("value", t);

        }),
        (i.mediaUploader = function (e) {
            e.preventDefault();
            var t, l;
            return i.uploader
                ? (i.uploader.open(), void 0)
                : ((l = window.portfolio_gallery_backend_script_editSlideshow),
                  (t = ""),
                  "object" == typeof l && "object" == typeof l.localization && void 0 !== l.localization.uploaderTitle && l.localization.uploaderTitle.length > 0 && (t = l.localization.uploaderTitle),
                  (i.uploader = wp.media.frames.portfolio_gallery_uploader = wp.media({ frame: "select", title: t, multiple: !0, library: { type: "image" } })),
                  i.uploader.on("select", function () {
                      var e,
                          t,
                          l = i.uploader.state().get("selection").toJSON();
                      for (t in l) l.hasOwnProperty(t) && ((e = l[t]), i.insertImageSlide(e.id, e.title, e.description, e.url, e.alt));
                  }),
                  i.uploader.open(),
                  void 0);
        }),
        (i.insertImageSlide = function (t, l, d, n, a) {
            var s = e(".image-slide-template").find(".pg-list-item").clone(!0, !0);
            s.find(".attachment").attr("src", n),
                s.find(".attachment").attr("title", l),
                s.find(".attachment").attr("alt", a),
                s.find(".title").attr("value", l),
                s.find(".description").html(d),
                s.find(".alternativeText").attr("value", a),
                s.find(".postId").attr("value", t),
				  s.find(".postId").attr("value", t),
                s.find(".title").attr("name", "slides[0][title]"),
                s.find(".titleElementTagID").attr("name", "slides[0][titleElementTagID]"),
                s.find(".description").attr("name", "slides[0][description]"),
                s.find(".descriptionElementTagID").attr("name", "slides[0][descriptionElementTagID]"),
                s.find(".url").attr("name", "slides[0][url]"),
                s.find(".urlTarget").attr("name", "slides[0][urlTarget]"),
                s.find(".alternativeText").attr("name", "slides[0][alternativeText]"),
                s.find(".noFollow").attr("name", "slides[0][noFollow]"),
                s.find(".type").attr("name", "slides[0][type]"),
                s.find(".postId").attr("name", "slides[0][postId]"),
                e(".sortable-slides-list").prepend(s),
                i.indexSlidesOrder();
        }),
        (i.insertTextSlide = function (e) {
			 e.preventDefault();var e = jQuery;
            var t = e(".text-slide-template").find(".pg-list-item").clone(!0, !0);
            t.find(".title").attr("name", "slides[0][title]"),
                t.find(".titleElementTagID").attr("name", "slides[0][titleElementTagID]"),
                t.find(".description").attr("name", "slides[0][description]"),
                t.find(".descriptionElementTagID").attr("name", "slides[0][descriptionElementTagID]"),
                t.find(".textColor").attr("name", "slides[0][textColor]"),
                t.find(".color").attr("name", "slides[0][color]"),
                t.find(".url").attr("name", "slides[0][url]"),
                t.find(".urlTarget").attr("name", "slides[0][urlTarget]"),
                t.find(".noFollow").attr("name", "slides[0][noFollow]"),
                t.find(".type").attr("name", "slides[0][type]"),
                t.find(".color, .textColor").wpColorPicker(),
                e(".sortable-slides-list").prepend(t),
                i.indexSlidesOrder();
        }),
        (i.insertVideoSlide = function (e) {
			 e.preventDefault();var e = jQuery;
            var t = e(".video-slide-template").find(".pg-list-item").clone(!0, !0);
            t.find(".videoId").attr("name", "slides[0][videoId]"),
                t.find(".showRelatedVideos").attr("name", "slides[0][showRelatedVideos]"),
				t.find(".title").attr("name", "slides[0][title]"),
				t.find(".description").attr("name", "slides[0][description]"),
                t.find(".type").attr("name", "slides[0][type]"),
                e(".sortable-slides-list").prepend(t),
                i.indexSlidesOrder();
        }),
        e(document).bind("slideshowBackendReady", i.init),
        i
    );
})();
portfolio_gallery_backend_script.shortcode = (function () {
    var e = jQuery,
        o = {};
    return (
        (o.init = function () {
            o.activateShortcodeInserter();
        }),
        (o.activateShortcodeInserter = function () {
            e(".insertSlideshowShortcodeSlideshowInsertButton").click(function () {
                var o = "No slideshow selected.",
                    t = "gallery_show",
                    i = parseInt(e("#insertSlideshowShortcodeSlideshowSelect").val(), 10),
                    d = window.portfolio_gallery_backend_script_shortcode;
                return (
                    "object" == typeof d &&
                        ("object" == typeof d.data && void 0 !== d.data.shortcode && d.data.shortcode.length > 0 && (t = d.data.shortcode),
                        "object" == typeof d.localization && void 0 !== d.localization.undefinedSlideshow && d.localization.undefinedSlideshow.length > 0 && (o = d.localization.undefinedSlideshow)),
                    isNaN(i) ? (alert(o), !1) : (send_to_editor("[" + t + " id='" + i + "']"), tb_remove(), !0)
                );
            }),
                e(".insertSlideshowShortcodeCancelButton").click(function () {
                    return tb_remove(), !1;
                });
        }),
        e(document).bind("slideshowBackendReady", o.init),
        o
    );
})();

function ShowPGTab(TabName) {
    jQuery(".PGtab-content").each(function () {
        jQuery(this).hide();
        //jQuery(this).removeClass("PGActiveTab");
    });
    jQuery("#" + TabName).show();
    jQuery("#" + TabName).addClass("PGActiveTab");

    jQuery(".nav-tab").each(function () {
        jQuery(this).removeClass("nav-tab-active");
    });
    jQuery("#" + "pgnt" + TabName).addClass("nav-tab-active");
}
function ShowPGSubTab(TabName) {
    jQuery(".PGsubtab-content").each(function () {
        jQuery(this).hide();
        //jQuery(this).removeClass("PGActiveTab");
    });
    jQuery("#" + TabName).show();
    jQuery("#" + TabName).addClass("PGActivesubTab");

    jQuery("#pgssubtabs .nav-tab").each(function () {
        jQuery(this).removeClass("nav-tab-active");
    });
    jQuery("#pgssubtabs #" + "pgnt" + TabName).addClass("nav-tab-active");
}
