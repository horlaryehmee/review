<?php
/**
 * Pro-specific snippet manager page.
 *
 * @package WPCode
 */

/**
 * Class WPCode_Admin_Page_Snippet_Manager_Pro.
 */
class WPCode_Admin_Page_Snippet_Manager_Pro extends WPCode_Admin_Page_Snippet_Manager {
	use WPCode_Revisions_Display;
	/**
	 * Page-specific hooks.
	 */
	public function page_hooks() {
		parent::page_hooks();
		if ( isset( $_GET['snippet_id'] ) && wpcode_testing_mode_enabled() ) {
			// Let's grab the snippet object from the testing mode data.
			$this->snippet    = WPCode_Testing_Mode::get_instance()->get_snippet_by_id( absint( $_GET['snippet_id'] ) );
			$this->snippet_id = $this->snippet->get_id();
		}

		add_filter( 'wpcode_admin_js_data', array( $this, 'add_strings' ) );
	}

	/**
	 * Save to library button.
	 *
	 * @return void
	 */
	public function save_to_library_button() {
		if ( isset( $this->snippet ) ) { ?>
			<button
					class="wpcode-button wpcode-button-text wpcode-button-save-to-library"
					id="wpcode_save_to_cloud"
					data-id="<?php echo absint( $this->snippet_id ); ?>"
					data-cloud-id="<?php echo esc_attr( $this->snippet->get_cloud_id() ); ?>"
					data-has-auth="<?php echo wpcode()->library_auth->has_auth() ? 1 : 0; ?>"
					type="button">
				<?php
				wpcode_icon( 'cloud', 16, 12 );
				esc_html_e( 'Save to Library', 'wpcode-premium' );
				?>
			</button>
			<?php
		}
	}

	/**
	 * Show a publish to production button if the snippet has been updated in the testing mode.
	 *
	 * @return void
	 */
	public function update_button() {
		if ( isset( $this->snippet ) ) {
			// Let's see if this snippet has been updated in the testing mode and if so, show a "publish changes to production" button.
			if ( wpcode_testing_mode_enabled() && WPCode_Testing_Mode::get_instance()->is_snippet_changed( $this->snippet_id ) ) {
				?>
				<button
						class="wpcode-button wpcode-button-secondary wpcode-button-publish-changes"
						id="wpcode_publish_changes"
						type="button">
					<?php
					esc_html_e( 'Publish Changes', 'wpcode-premium' );
					?>
				</button>
				<?php
			}
		}
		parent::update_button();
	}

	/**
	 * Get a relevant library id based on data from the library.
	 *
	 * @return false|string
	 */
	public function get_library_id_for_display() {
		if ( ! isset( $this->snippet ) ) {
			return '';
		}

		if ( ! wpcode()->my_library->grab_snippet_from_api( $this->snippet->get_cloud_id() ) ) {
			return '';
		}

		return $this->snippet->get_cloud_id();
	}

	/**
	 * Add page-specific localised strings to be used in JS.
	 *
	 * @param array $data The localised data.
	 *
	 * @return array
	 */
	public function add_strings( $data ) {
		$new_strings = array(
			'save_confirm_title'   => __( 'Are you sure you want to save the snippet?', 'wpcode-premium' ),
			'save_confirm_text'    => __( 'Any changes you made to the snippet in another site or on the cloud will be overwritten.', 'wpcode-premium' ),
			'save_confirm_button'  => __( 'Save to Library', 'wpcode-premium' ),
			'auth_needed_title'    => __( 'Connect with WPCode Cloud Library to Save Snippets', 'wpcode-premium' ),
			'auth_needed_text'     => __( 'Before we can save your snippets, you must connect with WPCode Library, so we can securely save snippets in your account.', 'wpcode-premium' ),
			'auth_needed_confirm'  => __( 'Connect with WPCode Library', 'wpcode-premium' ),
			'save_changes_title'   => __( 'You have unsaved changes', 'wpcode-premium' ),
			'save_changes_text'    => __( 'Please make sure all your changes are saved before saving the snippet in the library.', 'wpcode-premium' ),
			'save_changes_confirm' => __( 'Save Changes Now', 'wpcode-premium' ),
			'save_success_confirm' => __( 'OK', 'wpcode-premium' ),
			'save_success_cancel'  => __( 'Edit in Library', 'wpcode-premium' ),
		);

		$data['save_blocks_title']   = __( 'Save snippet?', 'wpcode-premium' );
		$data['save_blocks_text']    = __( 'In order to load the block editor we need to first save your snippet, do you want to save your snippet now?', 'wpcode-premium' );
		$data['yes']                 = __( 'Yes', 'wpcode-premium' );
		$data['no']                  = __( 'No', 'wpcode-premium' );
		$data['switch_blocks_title'] = __( 'Blocks content will be deleted', 'wpcode-premium' );
		$data['switch_blocks_text']  = __( 'Please note that changing the code type will erase your blocks content when you save the snippet with the new code type. Switch back to Blocks Snippet if you want to keep the blocks content.', 'wpcode-premium' );
		$data['blocks_text']         = __( 'Please add your license key in the WPCode settings panel to unlock all Pro features', 'wpcode-premium' );
		$data['blocks_url']          = admin_url( 'admin.php?page=wpcode-settings' );
		$data['blocks_button']       = __( 'Add license key', 'wpcode-premium' );

		return array_merge( $data, $new_strings );
	}

	/**
	 * Get the markup of the custom shortcode row.
	 *
	 * @return void
	 */
	public function get_input_row_custom_shortcode() {

		$button = wpcode_get_copy_target_button( 'wpcode-custom-shortcode', '[', ']' );
		$input  = sprintf(
			'<div class="wpcode-input-with-button"><input type="text" id="wpcode-custom-shortcode" placeholder="%1$s" value="%2$s" class="wpcode-input-text" name="wpcode_custom_shortcode_name" />%3$s</div>',
			__( 'Shortcode name', 'wpcode-premium' ),
			isset( $this->snippet ) ? $this->snippet->get_custom_shortcode() : '',
			$button
		);

		$this->metabox_row(
			__( 'Custom Shortcode', 'wpcode-premium' ),
			$input,
			'',
			'',
			'',
			__( 'Use this field to define a custom shortcode name instead of the id-based one.', 'wpcode-premium' )
		);
	}

	/**
	 * Add extra snippet data.
	 *
	 * @param WPCode_Snippet $snippet Snippet about to be saved, passed by reference.
	 *
	 * @return void
	 */
	public function add_extra_snippet_data( &$snippet ) {
		if ( ! isset( $_REQUEST[ $this->nonce_name ] ) || ! wp_verify_nonce( sanitize_key( $_REQUEST[ $this->nonce_name ] ), $this->action ) ) {
			// Nonce is missing, so we're not even going to try.
			return;
		}

		if ( isset( $_POST['wpcode_custom_shortcode_name'] ) ) {
			$custom_shortcode          = sanitize_title( wp_unslash( $_POST['wpcode_custom_shortcode_name'] ) );
			$snippet->custom_shortcode = str_replace( '-', '_', $custom_shortcode );
		}

		if ( isset( $_POST['wpcode-device-type'] ) ) {
			$device_type = 'any';
			switch ( $_POST['wpcode-device-type'] ) {
				case 'desktop':
					$device_type = 'desktop';
					break;
				case 'mobile':
					$device_type = 'mobile';
					break;
			}
			$snippet->device_type = $device_type;
		}

		$schedule = array();
		if ( isset( $_POST['wpcode-schedule-start'] ) ) {
			$schedule['start'] = sanitize_text_field( wp_unslash( $_POST['wpcode-schedule-start'] ) );
		}
		if ( isset( $_POST['wpcode-schedule-end'] ) ) {
			$schedule['end'] = sanitize_text_field( wp_unslash( $_POST['wpcode-schedule-end'] ) );
		}
		$snippet->schedule = $schedule;

		// If we reached this point all checks have passed so let's see if testing mode is enabled and hijack the saving
		// to the testing mode option.
		if ( wpcode_testing_mode_enabled() ) {
			$message_number = 5;
			if ( 0 === $snippet->get_id() ) {
				// If creating a new snippet in the testing mode handle this separately.
				WPCode_Testing_Mode::get_instance()->add_new_snippet( $snippet );
			}
			WPCode_Testing_Mode::get_instance()->update_snippet( $snippet );

			wp_safe_redirect( $this->get_after_save_redirect_url( $snippet->get_id(), $message_number ) );
			exit;
		}
	}

	/**
	 * Get the url to view a revision in the admin.
	 *
	 * @param int $revision_id The revision id to grab the URL for.
	 *
	 * @return string
	 */
	public function get_revision_url( $revision_id ) {
		return add_query_arg(
			array(
				'page'     => 'wpcode-revisions',
				'revision' => $revision_id,
			),
			admin_url( 'admin.php' )
		);
	}

	/**
	 * Get the url to view revision compare screen.
	 *
	 * @param int $revision_id The revision id to grab the URL for.
	 *
	 * @return string
	 */
	public function get_compare_revision_url( $revision_id ) {
		return add_query_arg(
			array(
				'page'     => 'wpcode-revisions',
				'revision' => $revision_id,
				'compare'  => '',
			),
			admin_url( 'admin.php' )
		);
	}

	/**
	 * This method returns the markup for the device type radio input picker, the
	 * three options available are Any device type, Desktop only and Mobile only.
	 * By default, any device type is selected.
	 *
	 * @return string
	 */
	public function device_type_picker() {
		$device_type = isset( $this->snippet ) ? $this->snippet->get_device_type() : 'any';

		$html = '<div class="wpcode-device-type-picker">';
		$html .= $this->get_radio_field_icon( 'devices', esc_html__( 'Any device type', 'wpcode-premium' ), 'any', 'wpcode-device-type', 'any' === $device_type );
		$html .= $this->get_radio_field_icon( 'desktop', esc_html__( 'Desktop only', 'wpcode-premium' ), 'desktop', 'wpcode-device-type', 'desktop' === $device_type );
		$html .= $this->get_radio_field_icon( 'mobile', esc_html__( 'Mobile only', 'wpcode-premium' ), 'mobile', 'wpcode-device-type', 'mobile' === $device_type );
		$html .= '</div>';

		return $html;
	}


	/**
	 * Get the markup of the schedule main dates inputs.
	 *
	 * @return void
	 */
	public function get_input_row_schedule() {
		$schedule = isset( $this->snippet ) ? $this->snippet->get_schedule() : array();
		$start    = isset( $schedule['start'] ) ? $schedule['start'] : '';
		$end      = isset( $schedule['end'] ) ? $schedule['end'] : '';
		?>
		<div class="wpcode-schedule-form-fields">
			<?php
			$schedule_label = __( 'Schedule snippet', 'wpcode-premium' );
			$this->metabox_row(
				$schedule_label,
				$this->get_input_row_schedule_contents( $start, $end ),
				'wpcode_schedule'
			);
			?>
		</div>
		<?php
	}

	/**
	 * Override the lite version of the code editor to add the pro-specific fields (block editor).
	 *
	 * @return void
	 */
	public function field_code_editor() {
		$snippet_id       = isset( $this->snippet_id ) ? $this->snippet_id : 0;
		$blocks_supported = function_exists( 'do_blocks' );

		parent::field_code_editor();
		?>
		<div id="wpcode_block_editor">
			<div class="wpcode-block-editor-area">
				<div>
					<?php if ( $blocks_supported ) { ?>
						<button type="submit" class="wpcode-button wpcode-button-large" id="wpcode-unsaved-blocks-enable" value="<?php echo absint( $snippet_id ); ?>" name="use_block_editor"><?php esc_html_e( 'Edit with Block Editor', 'wpcode-premium' ); ?></button>
						<p><?php esc_html_e( 'Click the button above to load the block editor in which you can create and edit blocks for your snippet.', 'wpcode-premium' ); ?></p>
					<?php } else { ?>
						<p><?php esc_html_e( 'The block editor is not supported on your site. Please upgrade to WordPress 5.0 or higher to use this feature.', 'wpcode-premium' ); ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Get the URL to redirect to after a snippet is saved.
	 *
	 * @param int $snippet_id The snippet id that was just saved.
	 * @param int $message_number The message number to display.
	 *
	 * @return string
	 */
	protected function get_after_save_redirect_url( $snippet_id, $message_number = 1 ) {
		if ( isset( $_REQUEST['use_block_editor'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			// They clicked the Edit with block editor button so let's go to that flow.
			return wpcode()->snippet_block_editor->get_edit_with_block_editor_link( $snippet_id );
		}

		return parent::get_after_save_redirect_url( $snippet_id, $message_number );
	}
}
