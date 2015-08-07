<?php

final class wtk_widget_example extends WTK_Widget
{

	public function __construct() {
		parent::__construct(
			'wtk_widget_example',
			'An example of widget',
			array( 'description' => 'Description for the widget' )
		);
	}

	protected function get_form_specs()
	{
		return array(
			array(
				'name' => 'image',
				'label' => 'Thumbnail',
				'type' => 'image'
			),
			array(
				'name' => 'title',
				'label' => 'Title',
				'type' => 'text'
			),
			array(
				'name' => 'description',
				'label' => 'Description',
				'type' => 'textarea'
			),
			array(
				'name' => 'select',
				'label' => 'Select',
				'type' => 'select',
				'options' => array($this->test_options())
			)
		);
	}

	public function test_options()
	{
		return array('Option A', 'Option B', 'Option C')
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		echo '<dl>';

		foreach($this->form->get_elements() as $element) {
			if($element->get_name() === 'title') {
				continue;
			}

			echo
				'<dt>' . $element->get_label() . '</dt>'
				. '<dd>' . $element->get_value() . '</dd>';
		}

		echo '</dl>';

		echo $args['after_widget'];
	}

}

add_action('widgets_init', function(){
	register_widget( 'wtk_widget_example' );
});