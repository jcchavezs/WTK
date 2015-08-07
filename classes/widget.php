<?php

abstract class WTK_Widget extends WP_Widget
{
	protected $form;

	/**
	 * Returns the specifications for the form.
	 * @return array
	 */
	abstract protected function get_form_specs();

	/**
	 * The constructor.
	 *
	 * @param string $id_base         Optional Base ID for the widget, lowercase and unique. If left empty,
	 *                                a portion of the widget's class name will be used Has to be unique.
	 * @param string $name            Name for the widget displayed on the configuration page.
	 * @param array  $widget_options  Optional. Widget options. See {@see wp_register_sidebar_widget()} for
	 *                                information on accepted arguments. Default empty array.
	 * @param array  $control_options Optional. Widget control options. See {@see wp_register_widget_control()}
	 *                                for information on accepted arguments. Default empty array.
	 */
	public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
	{
		parent::__construct($id_base, $name, $widget_options, $control_options);

		$this->form = new WTK_Widget_Form($this->get_form_specs());
	}

	/**
	 * Renders the form associated to the widget.
	 *
	 * @param  WTK_Widget_Form $form The form to be rendered
	 */
	private function render_form()
	{
		foreach($this->form->get_elements() as &$element)
		{
			$this->render_form_row($element);
		}

		wp_enqueue_script('wtk-image');
	}

	/**
	 * Echoes the markup of the row for the provided element
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 */
	private function render_form_row(WTK_Widget_Form_Element $element)
	{
		$element_markup = $this->render_form_element($element);

		if(false === $element_markup) {
			return '';
		}

		$id = $this->get_field_id($element->get_id());
		$label = $element->get_label();

		if($element->get_type() !== 'checkbox') {
			$label = sprintf('%s:', $label);
		}

		if ($description = $element->get_description()) {
			$label .= '<small class="description">' . $description . '</small>';
		}

		echo '<p class="wtk-row wtk-row-' . $element->get_type() . '">';

		switch($element->get_type()) {
			case 'checkbox':
				printf(
					'<label>%s %s</label>',
					$element_markup,
					$label
				);
				break;
			default:
				printf(
					'<label for="%s">%s</label> %s',
					$this->get_field_id($id),
					$label,
					$element_markup
				);
				break;
		}

		echo '</p>';
	}

	/**
	 * Renders the provided form element
	 *
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 * @return string
	 */
	private function render_form_element(WTK_Widget_Form_Element $element)
	{
		switch($element->get_type()) {
			case 'text':
			case 'number':
			case 'email':
			case 'url':
				return $this->render_element_as_input($element);
				break;
			case 'checkbox':
			case 'radio':
				return $this->render_element_as_input_option($element);
				break;
			case 'textarea':
				return $this->render_element_as_textarea($element);
				break;
			case 'select':
			case 'multiselect':
				return $this->render_element_as_select($element);
				break;
			case 'image':
				return $this->render_element_as_image($element);
				break;
			default:
				return $this->render_element_as_input($element);
				break;
		}
	}

	/**
	 * Renders the provided element as an image.
	 *
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 * @return string
	 */
	private function render_element_as_image(WTK_Widget_Form_Element $element)
	{
		$image_id = $element->get_value();

		$image_src = wp_get_attachment_image_src($element->get_value(), 'large');

		$image_placeholder_src = 'http://placehold.it/400x240';

		if(!$image_id || !$image_src) {
			$image_src = array($image_placeholder_src);
		}

		$output =	'<input name="' . $this->get_field_name($element->get_name()) . '" class="wtk-image-input" type="hidden" value="' . $image_id . '" />';

		$output .=  '<a
						href="#"
						title="' . __('Select an image', 'wtk') . '"
						onclick="wtk.openUploader(this' . ( $image_id ? ',' . $image_id : '' ) . '); return false;"
						class="button wtk-button-block"
					>' . __('Select an image', 'wtk') . '</a>';

		$output .=	'<img class="wtk-image-placeholder" src="' . $image_src[0] . '" data-default-src="' . $image_placeholder_src . '" />';

		return $output;
	}

	/**
	 * Renders the provided element as an input.
	 *
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 * @return string
	 */
	private function render_element_as_input(WTK_Widget_Form_Element $element)
	{
		$element->add_class('widefat');

		return sprintf(
			'<input name="%s" id="%s" type="%s" value="%s" %s />',
			$this->get_field_name($element->get_name()),
			$this->get_field_id($element->get_id()),
			$element->get_type(),
			$element->get_value(),
			$this->render_element_attributes($element)
		);
	}

	/**
	 * Renders the provided element as an input.
	 *
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 * @return string
	 */
	private function render_element_as_input_option(WTK_Widget_Form_Element $element)
	{
		$element->add_class('widefat');

		return sprintf(
			'<input name="%s" id="%s" type="%s" %s />',
			$this->get_field_name($element->get_name()),
			$this->get_field_id($element->get_id()),
			$element->get_type(),
			($element->get_value() === 'on' ? 'checked ' : '') . $this->render_element_attributes($element)
		);
	}

	/**
	 * Renders the provided element as a select.
	 *
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 * @return string|false
	 */
	private function render_element_as_select(WTK_Widget_Form_Element $element)
	{

		$element->add_class('widefat');

		$output = sprintf(
			'<select name="%s" id="%s" %s>',
			$this->get_field_name($element->get_name()) . ($element->get_type() === 'multiselect' ? '[]' : '' ),
			$this->get_field_id($element->get_id()),
			$this->render_element_attributes($element)
		);

		if(is_callable($element->get_options())) {
			$options = call_user_func($element->get_options());
		} else {
			$options = $element->get_options();
		}

		if(empty($options)) {
			return false;
		}

		foreach($options as $key => $label) {
			$output .= '<option ' . selected($key, $element->get_value(), false)  . ' value="' . $key . '">' . $label . '</option>';
		}

		$output .= '</select>';

		return $output;
	}

	/**
	 * Renders the element as a textarea.
	 *
	 * @param  WTK_Widget_Form_Element $element The element to be rendered
	 * @return string
	 */
	private function render_element_as_textarea(WTK_Widget_Form_Element $element)
	{
		$element
			->set_attribute('rows', 4)
			->add_class('widefat');

		return sprintf(
			'<textarea name="%s" id="%s" %s>%s</textarea>',
			$this->get_field_name($element->get_name()),
			$this->get_field_id($element->get_id()),
			$this->render_element_attributes($element),
			$element->get_value()
		);
	}

	/**
	 * Renders the string of HTML attributes for an element.
	 *
	 * @param  WTK_Widget_Form_Element $element The element whose attributes are being rendered
	 * @return string
	 */
	private function render_element_attributes(WTK_Widget_Form_Element $element)
	{
		$attributes = array();

		foreach($element->get_attributes() as $key => $value) {
			switch(gettype($value)) {
				case 'string':
					$attributes[] = $key . '="' . trim($value) . '"';
					break;
				case 'boolean':
					if($value === true)
						$attributes[] = $key;
					break;
				default:
					$attributes[] = $key . "='" . json_encode($value) . "'";
					break;
			}
		}

		return implode(' ', $attributes);
	}

	/**
	 * Output the settings update form.
	 *
	 * @param array $instance Current settings.
	 * @return string
	 */
	public function form($instance)
	{
		$this->form->bind_values($instance);

		echo $this->render_form();
	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly. The newly-calculated
	 * value of `$instance` should be returned. If false is returned, the instance won't be
	 * saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            {@see WTK_Widget::form()}.
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance )
	{
		$this->form->bind_values($new_instance);

		if($this->form->is_valid()) {
			return $this->form->get_data();
		}

		return $new_instance;
	}
}
