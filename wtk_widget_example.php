<?php

if(!class_exists('WTK_Widget')) {
	add_action('admin_notices', function() {
		echo '<div class="error"><p>Please enable the WTK plugin.</p></div>';
	});
}

final class wtk_widget_example extends WTK_Widget
{

	public function __construct() {
		parent::__construct(
			'wtk_widget_example',
			'WTK Widget Example',
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
				'type' => 'textarea',
				'default' => 'This is a default description'
			),
			array(
				'name' => 'select',
				'label' => 'Select',
				'type' => 'select',
				'options' => array($this, 'test_options')
			),
			array(
				'name' => 'checkbox',
				'label' => 'This is a checkbox',
				'type' => 'checkbox'
			)
		);
	}

	public function test_options()
	{
		return array('Option A', 'Option B', 'Option C');
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
				. '<dd>' . $instance[$element->get_name()] . '</dd>';
		}

		echo '</dl>';

		echo $args['after_widget'];
	}

}

add_action('widgets_init', function(){
	register_widget( 'wtk_widget_example' );
});