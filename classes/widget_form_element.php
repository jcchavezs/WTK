<?php

final class WTK_Widget_Form_Element
{
	protected $id;

	protected $name;

	protected $type;

	protected $label;

	protected $description = '';

	protected $attributes = array('class' => '');

	protected $options = array();

	protected $value = array();

    protected $filters = array('trim');

	public function __construct(array $config)
	{
		$this->id = $config['name'];

		$this->name = $config['name'];

		$this->type = $config['type'];

		$this->label = $config['label'];

		if(array_key_exists('description', $config)) {
			$this->description = $config['description'];
		}

		if(array_key_exists('attributes', $config)) {
			$this->attributes = array_merge($this->attributes, $config['attributes']);
		}

		if(array_key_exists('options', $config)) {
			$this->options = $config['options'];
		}

        if(array_key_exists('default', $config)) {
            $this->value = $config['default'];
        }

        if(array_key_exists('filters', $config)) {
            $this->filters = $config['filters'];
        }
	}

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function set_id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function set_name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of type.
     *
     * @return mixed
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * Sets the value of type.
     *
     * @param mixed $type the type
     *
     * @return self
     */
    protected function set_type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Gets the value of label.
     *
     * @return mixed
     */
    public function get_label()
    {
        return $this->label;
    }

    /**
     * Sets the value of label.
     *
     * @param mixed $label the label
     *
     * @return self
     */
    public function set_label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return mixed
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param mixed $description the description
     *
     * @return self
     */
    protected function set_description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of attributes.
     *
     * @return mixed
     */
    public function get_attributes()
    {
        return $this->attributes;
    }

    /**
     * Sets the value of attributes.
     *
     * @param mixed $attributes the attributes
     *
     * @return self
     */
    public function set_attributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function add_class($class)
    {
    	$this->attributes['class'] .= ' ' . $class;
    }

    public function set_attribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function get_attribute($key, $default_value = false)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : $default_value;
    }

    /**
     * Gets the value of options.
     *
     * @return mixed
     */
    public function get_options()
    {
        return $this->options;
    }

    /**
     * Sets the value of options.
     *
     * @param mixed $options the options
     *
     * @return self
     */
    public function set_options($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Gets the value of value.
     *
     * @return mixed
     */
    public function get_value()
    {
        return $this->value;
    }

    /**
     * Sets the value of value.
     *
     * @param mixed $value the value
     *
     * @return self
     */
    public function set_value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Gets the value of filters.
     *
     * @return mixed
     */
    public function get_filters()
    {
        return $this->filters;
    }

    /**
     * Sets the value of filters.
     *
     * @param mixed $filters the filters
     *
     * @return self
     */
    protected function set_filters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Adds a filter to the form element.
     * @param string|array|Closure
     */
    protected function add_filter($filter)
    {
        $this->filters[] = $filter;

        return $this;
    }
}