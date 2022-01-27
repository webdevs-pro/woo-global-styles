<?php

defined( 'ABSPATH' ) || exit;

add_action( 'elementor/element/kit/section_woocommerce_pages/after_section_end', function( $element ) {
   ob_start(); ?>
      <# 
         ( function( $ ) { 
            var timer = setTimeout(function() {
               elementor.settings.page.model.setExternalChange( 'hywd_color_woocommerce', '#fff' );
               console.log( elementor.settings.page.model.getActiveControls() );
               // elementor.panel.currentView.getCurrentPageView().render(); 
            }, 100 );		
            elementor.settings.page.model.setExternalChange('hywd_color_woocommerce', '#fff')
         } )( jQuery );
      #>
   <?php $script = ob_get_clean();

   $element->start_controls_section( 'section_woo_global_styles', [
      'tab' => 'settings-woocommerce',
      'label' => __( 'Woo Global Styles', 'woo-global-styles' )
   ] );

   $element->add_control( 'hywd_color_woocommerce', [
      'label' => __( '--woocommerce', 'woo-global-styles' ),
      'type' => Elementor\Controls_Manager::COLOR,
      'selectors' => [
         ':root' => '--woocommerce: {{VALUE}};',
      ],
   ] );
   $element->add_control( 'hywd_color_wc_green', [
      'label' => __( '--wc-green', 'woo-global-styles' ),
      'type' => Elementor\Controls_Manager::COLOR,
      'selectors' => [
         ':root' => '--wc-green: {{VALUE}};',
      ],
   ] );

   $element->add_control( 'hywd_get_colors_script', [
      'type' => Elementor\Controls_Manager::RAW_HTML,
      'raw' => $script,
   ] );

   $element->end_controls_section();
}, 10 );