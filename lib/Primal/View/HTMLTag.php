<?php 
namespace Primal\View;

class HTMLTag extends Wrapper {
	
	/**
	 * HTML Tag Type
	 *
	 * @var string
	 */
	protected $tagType;
	
	/**
	 * Tag Attributes
	 *
	 * @var array
	 */
	protected $attributes = array();
	
	
	function __construct($tag, $contents = null, $attr = null) {
		$this->tagType = $tag;
		if ($contents !== null) $this[] = $contents;
		if (is_array($attr)) $this->attributes = $attr;
		$this->rebuildWrapper();
	}
	
	/**
	 * Changes tag type
	 *
	 * @param string $tag 
	 * @return $this
	 */
	public function setTagType($tag) {
		$this->tagType = $tag;
		$this->rebuildWrapper();
		return $this;
	}
	
	/**
	 * Sets the value of a tag attribute
	 *
	 * @param string $name Attribute name
	 * @param string $value Data of the attribute
	 * @return $this
	 */
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
		$this->rebuildWrapper();
		return $this;
	}
	
	/**
	 * Returns the current value of a tag attribute, or false if the attribute is not defined
	 *
	 * @param string $name Attribute name
	 * @return string
	 */
	public function getAttribute($name) {
		return isset($this->attributes[$name]) ? $this->attributes[$name] : false;
	}
	
	
	/**
	 * Identifies is a tag attribute has been defined
	 *
	 * @param string $name Attribute name
	 * @return boolean
	 */
	public function hasAttribute($name) {
		return isset($this->attributes[$name]);
	}
	
	
	/**
	 * Removes the defined attribute from the tag
	 *
	 * @param string $name Attribute name
	 * @return $this
	 */
	public function removeAttribute($name) {
		unset($this->attributes[$name]);
		return $this;
	}
	
	
	/**
	 * Adds a css class to the tag
	 *
	 * @param string $name Class name
	 * @return $this
	 */
	public function addClass($class) {
		if ($this->hasAttribute('class')) {
			$classes = preg_split('/\s+/', $this->getAttribute('class'));
		} else {
			$classes = array();
		}
		
		if (!in_array($class, $classes)) {
			$classes[] = $class;
		}
		
		$this->setAttribute('class', implode(' ', $classes));
		return $this;
	}
	
	
	/**
	 * Removes a css class from the tag
	 *
	 * @param string $name Class name
	 * @return $this
	 */
	public function removeClass($class) {
		if (!$this->hasClass($class)) {
			return $this;
		}
		
		$classes = preg_split('/\s+/', $this->getAttribute('class'));
		$classes = array_filter($classes, function ($c) use ($class) {
			return $c && $c != $class;
		});
		
		$this->setAttribute('class', implode(' ', $classes));
		return $this;
		
	}
	
	/**
	 * Identifies if the tag has the specified css class
	 *
	 * @param string $name Class name
	 * @return boolean
	 */
	public function hasClass($class) {
		if (!$this->hasAttribute('class')) {
			return $this;
		}
		
		$classes = preg_split('/\s+/', $this->getAttribute('class'));
		
		return in_array($class, $classes);
	}
	
	
	/**
	 * Reconstructs the Wrapper prefix and postfix tag values
	 *
	 * @return void
	 */
	protected function rebuildWrapper() {
		$stack = array('<',$this->tagType);
		
		foreach ($this->attributes as $name=>$content) {
			$stack[] = " $name=\"";
			$stack[] = htmlentities($content, ENT_QUOTES, "UTF-8");
			$stack[] = '"';
		}
		
		$noclosing = false;
		if (in_array(strtolower($this->tagType), array('br','img'), true)) {
			$stack[] = '/';
			$noclosing = true;
		}
		
		$stack[] = '>';
		
		$this->prefix = implode('', $stack);


		if (!$noclosing) {
			$this->suffix = "</{$this->tagType}>";
		} else {
			$this->suffix = null;
		}
	}
}

