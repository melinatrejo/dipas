( function( $ ) {
    
    if ('undefined' !== typeof themevision) {
        var wiki = $('<a class="themevision-wiki-link"></a>')
            .attr('href', themevision.wikiURL)
            .attr('target', '_blank')
            .text(themevision.wikiLabel)
            .css({
                'display': 'inline-block',
                'background-color': 'rgb(162, 198, 5)',
                'color': '#fff',
                'text-transform': 'uppercase',
                'margin-top': '6px',
                'padding': '3px 6px',
                'font-size': '9px',
                'letter-spacing': '1px',
                'line-height': '1.5',
                'clear': 'both'
            })
		;
		var support = $('<a class="themevision-support-link"></a>')
			.attr('href', themevision.supportURL)
			.attr('target', '_blank')
			.text(themevision.supportLabel)
			.css({
                'display': 'inline-block',
                'background-color': 'rgb(162, 198, 5)',
                'color': '#fff',
                'text-transform': 'uppercase',
                'margin-top': '6px',
                'padding': '3px 6px',
                'font-size': '9px',
                'letter-spacing': '1px',
                'line-height': '1.5',
				'float': 'right'
            })
		;
        setTimeout(function () {
            $('.preview-notice').append(wiki);
			$('.preview-notice').append(support);
            $('.customize-panel-back').css('height', '97px');
        }, 200);
        // Remove accordion click event
        $('.themevision-wiki-link').on('click', function (e) {
            e.stopPropagation();
        });
		$('.themevision-support-link').on('click', function (e) {
            e.stopPropagation();
        });
    }
    
    // Media Devices Logo
    wp.customize( 'agama_media_logo', function( value ) {
        var current = value.call( wp.customize );
        
        $( document ).ready(function() {
            if( 'desktop' == current ) {
                $('#customize-control-agama_mobile_logo').slideUp();
                $('#customize-control-agama_mobile_logo_max_height').slideUp();

                $('#customize-control-agama_logo').slideDown();
                $('#customize-control-agama_logo_max_height').slideDown();
                $('#customize-control-agama_logo_shrinked_max_height').slideDown();
                $('#customize-control-agama_logo_align').slideDown();
            } else if( 'mobile' == current ) {
                $('#customize-control-agama_logo').slideUp();
                $('#customize-control-agama_logo_max_height').slideUp();
                $('#customize-control-agama_logo_shrinked_max_height').slideUp();
                $('#customize-control-agama_logo_align').slideUp();

                $('#customize-control-agama_mobile_logo').slideDown();
                $('#customize-control-agama_mobile_logo_max_height').slideDown();
            }
        });
        
        value.bind( function( device ) {
            if( device == 'desktop' ) {
                $('.devices .preview-desktop').click();
                
                $('#customize-control-agama_mobile_logo').slideUp();
                $('#customize-control-agama_mobile_logo_max_height').slideUp();
                
                $('#customize-control-agama_logo').slideDown();
                $('#customize-control-agama_logo_max_height').slideDown();
                $('#customize-control-agama_logo_shrinked_max_height').slideDown();
                $('#customize-control-agama_logo_align').slideDown();
            }
            if( device == 'mobile' ) {
                $('.devices .preview-tablet').click();
                
                $('#customize-control-agama_logo').slideUp();
                $('#customize-control-agama_logo_max_height').slideUp();
                $('#customize-control-agama_logo_shrinked_max_height').slideUp();
                $('#customize-control-agama_logo_align').slideUp();
                
                $('#customize-control-agama_mobile_logo').slideDown();
                $('#customize-control-agama_mobile_logo_max_height').slideDown();
            }
        });
    });

} )( jQuery );
