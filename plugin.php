<?php

defined( 'ABSPATH' ) || exit;

add_action( 'elementor/element/kit/section_woocommerce_pages/after_section_end', function( $element ) {
   ob_start(); ?>
      <# 
         ( function( $ ) { 
            var timer = setTimeout(function() {
               var colors = {
                  hywd_color_woocommerce: '--woocommerce',
                  hywd_color_wc_green: '--wc-green',
                  hywd_color_red: '--wc-red',
                  hywd_color_orange: '--wc-orange',
                  hywd_color_blue: '--wc-blue',
                  hywd_color_primary: '--wc-primary',
                  hywd_color_primary_text: '--wc-primary-text',
                  hywd_color_secondary: '--wc-secondary',
                  hywd_color_secondary_text: '--wc-secondary-text',
                  hywd_color_highlight: '--wc-highlight',
                  hywd_color_highligh_text: '--wc-highligh-text',
                  hywd_color_content_bg: '--wc-content-bg',
                  hywd_color_subtext: '--wc-subtext'
               }
               var preview_document = window[0].document
               var previewStyles = getComputedStyle( preview_document.documentElement );

               $.each( colors, function( index, item ) {
                  var color = previewStyles.getPropertyValue( item );
                  if ( ! elementor.settings.page.model.attributes[index] ) {
                     elementor.settings.page.model.setExternalChange( index, color );
                     elementor.settings.page.model.attributes[index] = '';
                  } else {
                     var label_el = $( '#elementor-kit-panel-content-controls' ).find( '.elementor-control-' + index + ' .elementor-control-title' );
                     var original_label = elementor.settings.page.model.controls[index].label;
                     label_el.text( original_label + ' (changed)' );
                  }
                  elementor.settings.page.addChangeCallback( index, function( value ) {
                     var label_el = $( '#elementor-kit-panel-content-controls' ).find( '.elementor-control-' + index + ' .elementor-control-title' );
                     var original_label = elementor.settings.page.model.controls[index].label;

                     if ( value == '' ) {
                        setTimeout( function() {
                           var preview_document = window[0].document
                           var previewStyles = getComputedStyle( preview_document.documentElement );
                           var color = previewStyles.getPropertyValue( item );
                           elementor.settings.page.model.setExternalChange( index, color );
                           elementor.settings.page.model.attributes[index] = '';
                           label_el.text( original_label );
                        }, 100 );
                     } else {
                        label_el.text( original_label  + ' (changed)' );
                     }
                  } );	
               } );
            }, 100 );	
         } )( jQuery );
      #>
   <?php $script = ob_get_clean();

   $element->start_controls_section( 'section_woo_global_styles', [
      'tab' => 'settings-woocommerce',
      'label' => __( 'Woo Global Styles', 'woo-global-styles' )
   ] );

   $color_controls = array(
      'hywd_color_woocommerce' => '--woocommerce',
      'hywd_color_wc_green' => '--wc-green',
      'hywd_color_red' => '--wc-red',
      'hywd_color_orange' => '--wc-orange',
      'hywd_color_blue' => '--wc-blue',
      'hywd_color_primary' => '--wc-primary',
      'hywd_color_primary_text' => '--wc-primary-text',
      'hywd_color_secondary' => '--wc-secondary',
      'hywd_color_secondary_text' => '--wc-secondary-text',
      'hywd_color_highlight' => '--wc-highlight',
      'hywd_color_highligh_text' => '--wc-highligh-text',
      'hywd_color_content_bg' => '--wc-content-bg',
      'hywd_color_subtext' => '--wc-subtext',
   );

   foreach ( $color_controls as $index => $key ) {
      $element->add_control( $index, [
         'label' => $key,
         'type' => Elementor\Controls_Manager::COLOR,
         'selectors' => [
            ':root' => $key . ': {{VALUE}};',
         ],
      ] );
   }
   $element->add_control( 'hywd_get_colors_script', [
      'type' => Elementor\Controls_Manager::RAW_HTML,
      'raw' => $script,
   ] );

   $element->end_controls_section();
}, 10 );