( function () {
	'use strict';

	var nav = document.querySelector( '.kf-nav' );
	if ( ! nav ) {
		return;
	}

	var toggle = nav.querySelector( '.kf-nav__toggle' );
	if ( ! toggle ) {
		return;
	}

	toggle.addEventListener( 'click', function () {
		var open = nav.classList.toggle( 'is-open' );
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
	} );

	document.addEventListener( 'click', function ( event ) {
		if ( ! nav.classList.contains( 'is-open' ) ) {
			return;
		}
		if ( nav.contains( event.target ) ) {
			return;
		}
		nav.classList.remove( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'false' );
	} );

	var dismiss = document.querySelector( '.kf-demo-banner__dismiss' );
	if ( dismiss ) {
		dismiss.addEventListener( 'click', function () {
			var banner = document.querySelector( '.kf-demo-banner' );
			if ( banner ) {
				banner.hidden = true;
			}
			var url = dismiss.getAttribute( 'data-dismiss-url' );
			if ( url ) {
				window.location.href = url;
			}
		} );
	}
} )();
