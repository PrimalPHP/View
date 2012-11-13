<?php 
namespace Primal\View;

class Page extends HTMLTag {
	
	/**
	 * View containing the contents of the <head> tag
	 *
	 * @var HTMLTag
	 */
	public $head;
	
	/**
	 * View containing the contents of the <body> tag
	 *
	 * @var HTMLTag
	 */
	public $body;
	
	
	function __construct($head = null, $body = null) {
		parent::__construct('html');
		
		$this[] = $this->head = $head ?: new HTMLTag('head');
		$this[] = $this->body = $body ?: new Body();
		
		$this->setAttribute('lang', 'US-en');
		
		$this->setMetaEquiv('Content-Type', 'text/html; charset=utf-8');
				
		//Favicon
		$this->setFavicon('/favicon.ico');
		
		//HTML5 polyfill
		$this->head->add('<!--[if lt IE 9]><script>var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(\',\');for (var i = 0; i < e.length; i++) document.createElement(e[i]);</script><![endif]-->');
	}
	
	
	/**
	 * Defines the page title.
	 *
	 * @param string $title 
	 * @return Page
	 */
	function setTitle($title) {
		$this->head['title'] = new HTMLTag('title', $title);
	}
	
	/**
	 * Defines the page favicon graphic.
	 *
	 * @param string $url 
	 * @return Page
	 */
	function setFavicon($url) {
		$this->head['favicon'] = new HTMLTag('link', null, array('rel'=>"shortcut icon", 'href'=>$url));
	}
	
	
	/**
	 * Add named meta tag to the document head
	 *
	 * @param string $name 
	 * @param string $content 
	 * @return Page
	 */
	function setMeta($name, $content) {
		$this->head["meta-$name"] = new HTMLTag('meta', null, array('name'=>$name, 'content'=>$content));
		return $this;
	}


	/**
	 * Add named meta HTTP-EQUIV tag (pseudo response header) to the document head
	 *
	 * @param string $name 
	 * @param string $content 
	 * @return Page
	 */
	function setMetaEquiv($name, $content) {
		$this->head["metaequiv-$name"] = new HTMLTag('meta', null, array('http-equiv'=>$name, 'content'=>$content));
		return $this;
	}
	
	
	/**
	 * Adds raw html directly to the head tag
	 *
	 * @param string $content 
	 * @return Page
	 */
	function addRawHeadHTML($content, $index = null) {
		if ($index !== null) {
			$this->head[$index] = $content;
		} else {
			$this->head[]=$content;
		}
		return $this;
	}
	
	/**
	 * Adds a stylesheet link to the document head.
	 *
	 * @param string $path 
	 * @param string $media 
	 * @return Page
	 */
	function addStylesheet($path, $media='') {
		$link = new HTMLTag('link');
		$link->setAttribute('rel', 'stylesheet');
		$link->setAttribute('href', $path);
		if ($media) $link->setAttribute('media', $media);
		
		$this->head[] = $link;
		
		return $this;
	}
	
	
	/**
	 * Adds a javascript include to the document head
	 *
	 * @param string $path 
	 * @return Page
	 */
	function addScript($path) {
		$link = new HTMLTag('script');
		$link->setAttribute('type', 'text/javascript');
		$link->setAttribute('charset', 'utf-8');
		$link->setAttribute('src', $path);

		$this->head[] = $link;
		
		return $this;
	}
	
	
	
	/**
	 * Sets an attribute on the <body> tag
	 *
	 * @param string $attribute 
	 * @param string $value 
	 * @return Page
	 */
	function setBodyAttribute($attribute, $value) {
		$this->body->setAttribute($attribute, $value);
		return $this;
	}
	
	/**
	 * Adds a css class name to the <body> tag.
	 *
	 * @param string $class The css class to add.
	 * @return Page
	 */
	function addClass($class) {
		$this->body->addClass($class);
		return $this;
	}
	
	
	/**
	 * Appends content to the body tag
	 *
	 * @param string $content 
	 * @return void
	 */
	function add($content, $index = null) {
		$this->body->add($content, $index);
		return $this;
	}


	/**
	 * Removes content from the body tag
	 *
	 * @param string $content 
	 * @return void
	 */
	function remove($content) {
		$this->body->remove($content);
		return $this;
	}
	
	
	/**
	 * Render the page contents, including doctype, and return.
	 *
	 * @return void
	 */
	public function render() {
		return '<!DOCTYPE HTML>'.parent::render();
	}
	
}
