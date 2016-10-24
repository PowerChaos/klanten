/*
 * Add click handlers to links to force a pjax (partial) load
 * http://pjax.heroku.com/
 */
bootcards.addPJaxHandlers = function(pjaxTarget) {

	//add pjax click handler to links
	$('a.pjax').off().on('click', function(e) {
		var $this = $(this);
		var tgtUrl = $this.attr('href');

		$.pjax( {
			container : pjaxTarget,
			url : tgtUrl
		});

		//add active class if this is a list item (removing it from all siblings)
		if ($this.hasClass('list-group-item')) {
			$this
				.addClass('active')
				.siblings()
					.removeClass('active');
		}

		e.preventDefault();
	});

};

//pjax on all a's that have the data-pjax attribute (the attribute's value is the pjax target container)
$(document).ready( function() {

	//publish event when changing main menu option
	$("a[data-title]").on("click", function() {
		$.Topic( "navigateTo" ).publish( $(this).data("title") );
	});

	var $body = $("body");

	//fix for status bar bug in iOS 8
	if (bootcards.isFullScreen) {
        $body
        	.prepend("<div class='statusbar' />")
            .addClass("fullscreen");
    }

    //destroy modals on close (to reload the contents when using the remote property)
    $body.on('hidden.bs.modal', '.modal', function () {  	
  		$(this).removeData('bs.modal');
	});

	var pjaxTarget = (bootcards.isXS() ? '#list' : '#listDetails');

	bootcards.addPJaxHandlers(pjaxTarget);

	$(document)
	.pjax('a[data-pjax]')
	.on('submit', 'form[data-pjax]', function(event) {
		//use pjax to submit forms
  		$.pjax.submit(event);
	})
	.on('pjax:start', function(event) {

		//hide the offcanvas menu
		$("#offCanvasMenu").removeClass("active");
		$("#main").removeClass("active");

	})
	.on('pjax:end', function(event) {

		var $tgt = $(event.target);
		var tgtId = $tgt.attr('id');
		bootcards.addPJaxHandlers(pjaxTarget);

		//highlight first list group option (if non active yet)
		if ( $('.list-group a.active').length === 0 ) {
			$('.list-group a').first().addClass('active');
		}

		//enable single pane portrait mode when loading content with pjax
		if ( tgtId == 'main' && bootcards.portraitModeEnabled ) {

			//do some cleaning up first
            if (bootcards.listOffcanvasToggle) {
                bootcards.listOffcanvasToggle.remove();
                bootcards.listTitleEl.remove();
                Bootcards.OffCanvas.$menuTitleEl.remove();
            }
            bootcards.listOffcanvasToggle = null;
            bootcards.listTitleEl = null;
            Bootcards.OffCanvas.$menuTitleEl = null;
            bootcards.listEl = null;
            bootcards.cardsEl = null;

			bootcards._setOrientation(true);

			if (bootcards.listTitleEl) {
				bootcards.listTitleEl.find('button').show();
			}

               
		}

	})
	.on('pjax:complete', function(event) {
		//called after a pjax content update
		
		//check for any modals to close
		var modal = $(event.relatedTarget).closest('.modal');
		if (modal.length) {
			modal.modal('hide');
		}

	});

});

/*
 * Enable FTLabs' FastClick
 * https://github.com/ftlabs/fastclick
 */
window.addEventListener('load', function() {
    FastClick.attach(document.body);
}, false);

//functions to perform if the main menu option has changed
$.Topic( "navigateTo" ).subscribe( function(value) {
	
	//change active menu option in all navigation menus
	$("a[data-title='" + value + "']").each( function() {

		var $this = $(this);
		var $li = $this.parent('li');

		//add active class to either a parent LI or current A
		($li.length>0 ? $li : $this)
			.addClass('active')
			.siblings('.active')
				.removeClass('active');
	});

} );
