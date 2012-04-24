$(document) .ready(function () {
    /* menu */
    if ($(".not-front #one_col_lt").size()) {
      $(".not-front #one_col_lt div.block-menu_block:first").addClass("first");
    }
    
    
var htmlForEvents = '<br><div class="views-row-2 views-row-even views-row-last"><div class="views-field-field-assign-date-value"><span class="field-content">04.26.12</span></div><div class="views-field-title"><span class="field-content"><a href="http://events.gsapp.org/event/book-launch-for-post-ductility-metals-in-architecture-and-engineering-1" target="_blank">Book Launch for Post-Ductility: Metals in Architecture and Engineering</a></span></div><div class="views-field-field-assign-time-value"><span class="field-content">7:00PM</span></div><div class="views-field-field-location-value"><span class="field-content"><p>Van Alen Institute, New York</p></span></div><div class="views-field-field-image-fid"><span class="field-content"><img src="http://events.gsapp.org/sites/default/files/event/240/poster-book-launch-for-post-ductility-metals-in-architecture-and-engineering-1292.jpg" alt="event" title="event"  width="217" height="273" /></span></div></div>';

$('.front #block-block-21 .view-content').append(htmlForEvents);

    /* sundial item edit form */    
    if ($(".node-type-aggregation-item #content").length) {
      $(".node-type-aggregation-item #content #node-form fieldset legend a:contains('Vocabularies')") .parent() .parent() .after("<div class='sundial-edit-message'>Please make all other changes to this item directly in Sundial.</div>");
      $(".node-type-aggregation-item #content #node-form fieldset legend a:contains('Vocabularies')") .parent() .parent() .show().find(".form-item") .show();
      $(".node-type-aggregation-item #content #node-form #edit-taxonomy-7-wrapper") .hide();
    }
    
    if ($("#block-views-calendar-calendar_block").length) {
      $("#block-views-calendar-calendar_block .mini-day-off a") .attr('href', '#').attr('onclick', 'return false');
    }
    if ($("#edit-taxonomy-4").length) {
      $("#edit-taxonomy-4 option:contains('All')") .hide();
    }
    
    if ($(".node-type-overview-page").length) {
      $(".node-type-overview-page #content .left-overview-content .entry").after($(".node-type-overview-page #comments"));
      $(".node-type-overview-page #comments").before($(".node-type-overview-page #comments-title"));
    }
    
    if ($(".menu-item-form").length) {
      $(".menu-item-form").removeClass('collapsed');
    }
    
    if ($(".section-node-add .faculty, .section-node-edit .faculty").length) {
      $(".section-node-add .faculty fieldset").addClass('collapsible');
      $(".section-node-add .faculty fieldset").addClass('collapsed');
      $(".section-node-add .faculty .menu-item-form").removeClass('collapsed');
      $(".section-node-add .faculty fieldset legend:contains('Content')").parent().removeClass('collapsed');
      
      $(".section-node-edit .faculty fieldset").addClass('collapsible');
      $(".section-node-edit .faculty fieldset").addClass('collapsed'); 
      $(".section-node-edit .faculty .menu-item-form").removeClass('collapsed');
      $(".section-node-edit .faculty fieldset legend:contains('Content')").parent().removeClass('collapsed');
    }
    
    if ($(".section-my-site").length) {
      $(".section-my-site .more-link a").text("Read More");
      $(".section-my-site .views-field-edit-node .field-content:contains('')").parent().hide();
    }

    if ($("fieldset legend").length) {
      $("fieldset legend a:contains('Vocabularies')").text('Classification');
    }
    if ($("#guestbook-form-entry-form").length) {
      $("#guestbook-form-entry-form #edit-submit").val('Save');
    }
    if ($(".imce #simplemenu").length) {
      $(".imce #simplemenu").hide();
    }
});