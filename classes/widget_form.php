<?php

final class WTK_Widget_Form
{
	protected $elements = array();

	/**
	 * The constructro
	 * @param array $specs The specifications for the elements of the form.
	 */
	public function __construct(array $specs)
	{
		foreach($specs as $spec) {
			$this->add_element(new WTK_Widget_Form_Element($spec));
		}
	}

	/**
	 * Adds an element to the form.
	 *
	 * @param WTK_Widget_Form_Element $element
	 */
	public function add_element(WTK_Widget_Form_Element $element)
	{
		$this->elements[$element->get_name()] = $element;

		return $this;
	}

	/**
	 * Removes an element based on its name.
	 *
	 * @param  string	$element_name
	 * @return WTK_Widget_Form
	 */
	public function remove_element($element_name)
	{
		unset($this->elements[$element_name]);

		return $this;
	}

	/**
	 * Returns an element based on its name.
	 *
	 * @param  string	$element_name
	 * @return WTK_Widget_Form_Element
	 */
	public function get_element($element_name)
	{
		return $this->elements[$element_name];
	}

	/**
	 * Returns all the elements in the form.
	 *
	 * @return array
	 */
	public function get_elements()
	{
		return $this->elements;
	}

	/**
	 * Binds the provided values to the form.
	 *
	 * @param  array $instance The values to be binded.
	 */
	public function bind_values(array $instance)
	{
		foreach($this->elements as &$element) {
			if(!array_key_exists($element->get_name(), $instance)){
				continue;
			}

			$element->set_value($instance[$element->get_name()]);
		}
	}

	/**
	 * Checks wether the form is valid or not. The implementation will come in future versions.
	 *
	 * @return boolean
	 */
	public function is_valid()
	{
		return true;
	}

	/**
	 * Returns the data from the form.
	 * @return array
	 */
	public function get_data()
	{
		$data = array();

		foreach($this->elements as &$element) {
			$value = $element->get_value();

			foreach($element->get_filters() as $filter) {
				$value = call_user_func($filter, $value);
			}

			$data[$element->get_name()] = $value;
		}

		return $data;
	}

}