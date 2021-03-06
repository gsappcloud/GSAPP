$(document) .ready(function () {

	var resizeFunc = function(){
		var ww = window.innerWidth;
		if(ww >= 1250){
			$('#three_col_rt #content').css('width', '780px');
		}else{
			$('#three_col_rt #content').css('width', '520px');
		}
	}
	resizeFunc();
	$(window).resize(resizeFunc);




	var htmlForEvents = '<h2 class="title" style="text-align:left;">This Week at GSAPP</h2><img src="http://www.arch.columbia.edu/files/gsapp/imceshared/lld2117/uptodate.png" /><a target="_blank" id="cc-sprite-left" href="http://ccgsapp.org/">CC: Weekly Update</a><a target="_blank" id="cc-sprite-right" href="http://www.arch.columbia.edu/weekly-listing/subscribe">Subscribe</a><div><iframe src="http://events.gsapp.org/featured_event" width="220px" height="350px" style="overflow:hidden;" frameborder="0" scrolling="no"></iframe></div><style type="text/css">#two_col_rt #one_col_lt{text-align:center;}#cc-sprite-left {display:block; margin-bottom:40px; width:118px; height:88px; float:left; background:url("http://www.arch.columbia.edu/files/gsapp/imceshared/lld2117/Update_sprite.png") no-repeat 0 0; text-indent:-9999px; }#cc-sprite-left:hover {background:url("http://www.arch.columbia.edu/files/gsapp/imceshared/lld2117/Update_sprite.png") no-repeat 0 -88px; }#cc-sprite-right {display:block; margin-bottom:40px; width:118px; height:88px; float:right; background:url("http://www.arch.columbia.edu/files/gsapp/imceshared/lld2117/Subscribe_sprite.png") no-repeat 0 0; text-indent:-9999px; } #cc-sprite-right:hover {background:url("http://www.arch.columbia.edu/files/gsapp/imceshared/lld2117/Subscribe_sprite.png") no-repeat 0 -88px; }</style>';
	
	$("#two_col_rt #one_col_lt").html(htmlForEvents);

    /* menu */
    if ($(".not-front #one_col_lt").size()) {
      $(".not-front #one_col_lt div.block-menu_block:first").addClass("first");
    }

    /* delete me - video added to events list
    var videosnippet = '<iframe width="217" height="180" src="http://www.youtube.com/embed/zGOcZO5uOS4" frameborder="0" allowfullscreen></iframe>';
	videosnippet = '<div id="videosnippettext">The Torre Cube 1 by Carme Pinos</div><div id="videosnippet">' + videosnippet + '</div>'; */

	/* Publications */
	var publicationsMenuHTML = '<div id="publications-series-submenu" class="block"><h2>Series</h2><ul class="menu"><li class="leaf first"><a href="/publications/abstract" title="Abstract">Abstract</a></li><li class="leaf"><a href="/publications/futureanterior" title="Future Anterior">Future Anterior</a></li><li class="leaf"><a href="/publications/sourcebooks" title="GSAPP Sourcebooks">GSAPP Sourcebooks</a></li><li class="leaf"><a href="/publications/materials" title="Materials">Materials</a></li><li class="leaf"><a href="/publications/studiox" title="Studio-X">Studio-X</a></li><li class="leaf"><a href="/publications/urbanmagazine" title="URBAN Magazine">URBAN Magazine</a></li><li class="leaf last"><a href="/publications/volume" title="Volume">Volume</a></li></ul></div>';
	
	//$('body.section-publications #one_col_lt').append(publicationsMenuHTML);
	

    
    /*google search*/
   

    /*events */
    if ($(".date-display-start").length) {
      $(".date-display-start") .before("<br class='line-break'/>");
    }
    
    /*search */
    if ($("#search-form").length) {
      $("#search-form fieldset") .removeClass('collapsed');
      $("#search-form .form-item label:contains('Enter your keywords')") .text('Keywords');
      $("#search-form .search-advanced .form-item label:contains('Keywords')") .text('Keywords:');
      $("#search-form .search-advanced #edit-category") .parent() .hide();
    }
    
    if ($("#edit-or-wrapper").length) {
      $("#edit-or-wrapper") .parent() .before($("#edit-keys-wrapper") .parent() .parent());
    }
    
    if ($("#search-taxonomy-filter").length) {
      toggleCheckboxes();
      $("#search-taxonomy-filter .form-checkboxes input") .click(function () {
          toggleCheckboxes();
      });
      $("#search-taxonomy-filter .form-item label:first") .text('Only in Program(s):');
    }
    
    /* search results pager */
    if ($(".section-search").length) {
      $(".section-search .pager-next a:contains('next')") .text('Next Page >>');
      $(".section-search .pager-previous a:contains('previous')") .text('<< Previous Page');
      $(".section-search .tabs li a span:contains('Help')").parent().parent().hide();
    }
    
    function toggleCheckboxes() {
      if ($("#search-taxonomy-filter .form-checkboxes #edit-Filter--wrapper input") .attr('checked')) {
        $("#search-taxonomy-filter .form-checkboxes input") .attr('checked', 0);
        $("#search-taxonomy-filter .form-checkboxes #edit-Filter--wrapper input") .attr('checked', 1);
      }
    }

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
