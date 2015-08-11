<?php

final class WTK_Widget_Form_Element
{
    /**
     * The ID of the element.
     *
     * @var [type]
     */
	protected $id;

    /**
     * The name of the element.
     *
     * @var string
     */
	protected $name;

    /**
     * The type of element.
     *
     * @var string
     */
	protected $type;

    /**
     * The label of the element.
     *
     * @var string
     */
	protected $label;

    /**
     * The description for the element.
     *
     * @var string
     */
	protected $description = '';

    /**
     * The HTML attributes for the element.
     *
     * @var array
     */
	protected $attributes = array('class' => '');

    /**
     * The options in case a select or radio element.
     *
     * @var array
     */
	protected $options = array();

    /**
     * The current value of the element
     *
     * @var int|string|null
     */
	protected $value;

    /**
     * The filters that will be applied to the value of the element.
     * @var array
     */
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

    /**
     * Adds a CSS class to the element.
     *
     * @param string $class The CSS class to be added.
     *
     * @return self
     */
    public function add_class($class)
    {
    	$this->attributes['class'] .= ' ' . trim($class);

        return $this;
    }

    /**
     * Set the value of an attribute.
     *
     * @param string $key   The key name for the attribute.
     * @param string $value The value for the attribute.
     *
     * @return self
     */
    public function set_attribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Returns the value of an attribute.
     *
     * @param  string              $key           The key name of the attribute
     * @param  null|string|boolean $default_value The default value in case the attribute haven't been declared before.
     * @return string
     */
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