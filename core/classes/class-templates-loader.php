<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Templates_Loader' ) ) {
	/**
	 * Class Cheers_Forms_Templates_Loader
	 *
	 * It renders JS templates for fields and default parts in a form
	 */
	class Cheers_Forms_Templates_Loader {

		/**
		 * It saves a list of templates that have been already loaded
		 * so we don't render the same template twice
		 *
		 * @var array
		 */
		private static $templates_loaded = array();

		/**
		 * Load a step template inside a form
		 */
		public static function load_step_template() {
			if ( in_array( 'step', self::$templates_loaded ) ) {
				// Already loaded
				return;
			}

			self::$templates_loaded[] = 'step';
			?>
			<script type="text/html" id="tmpl-cform-step">
				<div class="cform-step-{{ data.step }}">
					<# for i in data.fields {#>
						<div class="cform-field" id="cform-field-wrap-{{ data.formId }}-{{ data.fields[i].id }}">
							{{{ data.fields[i].content }}}
						</div>
					<# } #>
				</div>
			</script>
			<?php
		}

		/**
		 * Load a field template
		 *
		 * @param Cheers_Forms_Field_Controller $field_controller
		 */
		public static function load_field_template( $field_controller ) {
			if ( in_array( $field_controller->type, self::$templates_loaded ) ) {
				// Already loaded
				return;
			}

			self::$templates_loaded[] = $field_controller->type;
			$field = $field_controller->get_field();
			?>
				<script type="text/html" id="tmpl-cform-field-<?php echo esc_attr( $field_controller->type ); ?>">
					<?php echo $field->render_template( $field_controller ); ?>
				</script>
			<?php
		}

	}
}
