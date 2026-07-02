<?php
add_action( 'admin_menu', 'mlt_add_admin_menu' );
add_action( 'admin_init', 'mlt_settings_init' );

function mlt_get_option($option){
    $options = get_option( 'mlt_settings' );
    return isset($options[$option]) ? $options[$option] : false;
}


function mlt_add_admin_menu(  ) { 

	add_options_page( 'MyListing Elementor Toolkit', 'MyListing Elementor Toolkit', 'manage_options', 'mylisting_elementor_toolkit', 'mlt_options_page' );

}


function mlt_settings_init(  ) { 

	register_setting( 'mlt_general', 'mlt_settings' );

	add_settings_section(
		'mlt_mlt_general_section', 
		__( 'MyListing Elementor Toolkit Settings', 'ml-elementor-toolkit-pro' ), 
		'mlt_settings_section_callback', 
		'mlt_general'
	);

    add_settings_field( 
		'mlt_checkbox_add_link_to_card', 
		__( 'Add link to full preview card', 'ml-elementor-toolkit-pro' ), 
		'mlt_checkbox_add_link_to_card_render', 
		'mlt_general', 
		'mlt_mlt_general_section' 
	);

	add_settings_field( 
		'mlt_checkbox_use_elementor_taxonomy', 
		__( 'Design taxonomy pages using Elementor', 'ml-elementor-toolkit-pro' ), 
		'mlt_checkbox_use_elementor_taxonomy_render', 
		'mlt_general', 
		'mlt_mlt_general_section' 
	);

	add_settings_field( 
		'mlt_checkbox_use_elementor_bookmarks', 
		__( 'Design bookmarks account section using Elementor', 'ml-elementor-toolkit-pro' ), 
		'mlt_checkbox_use_elementor_bookmarks_render', 
		'mlt_general', 
		'mlt_mlt_general_section' 
	);


}


function mlt_checkbox_use_elementor_taxonomy_render(  ) { 

	?>
	<input type='checkbox' name='mlt_settings[mlt_checkbox_use_elementor_taxonomy]' 
    <?php checked( mlt_get_option('mlt_checkbox_use_elementor_taxonomy'), 1 ); ?> 
    value='1'>
	<?php

}

function mlt_checkbox_use_elementor_bookmarks_render(  ) { 

	?>
	<input type='checkbox' name='mlt_settings[mlt_checkbox_use_elementor_bookmarks]' 
    <?php checked( mlt_get_option('mlt_checkbox_use_elementor_bookmarks'), 1 ); ?> 
    value='1'>
	<?php

}


function mlt_checkbox_add_link_to_card_render(  ) { 

	?>
	<input type='checkbox' name='mlt_settings[mlt_checkbox_add_link_to_card]' 
    <?php checked( mlt_get_option('mlt_checkbox_add_link_to_card'), 1 ); ?> 
    value='1'>
	<?php

}


function mlt_settings_section_callback(  ) { 

    echo __( 'Use these options to determine how the plugin functions.', 'ml-elementor-toolkit-pro' );
    echo '<br>';
	echo __( 'You <b>need to resave permalinks</b> after changing the settings below!', 'ml-elementor-toolkit-pro' );
    echo '<br>';
	echo __( 'You can do this by going to Settings -> Permalinks, and hitting the Save button!', 'ml-elementor-toolkit-pro' );
    echo '<br>';
	echo '<span style="color:red;">';
	echo sprintf( 
		__( 'Use the %s setting with caution, if it breaks your styling you have nested links and should turn it off!',
		 'ml-elementor-toolkit-pro' ), 
		'<b>' . __( 'Add link to full preview card', 'ml-elementor-toolkit-pro' ) .'</b>'
	);
	echo '</span>';

}

function mlt_options_page() { 

    global $ml_toolkit_pro_updater;

    ?>
    <div class="wrap">
        <h2>MyListing Elementor Toolkit General Settings</h2>
        <form action='options.php' method='post'>

            <?php
            settings_fields( 'mlt_general' );
            do_settings_sections( 'mlt_general' );
            submit_button();
            ?>

        </form>
    </div>

    <?php

    $ml_toolkit_pro_updater->config_page();

}

