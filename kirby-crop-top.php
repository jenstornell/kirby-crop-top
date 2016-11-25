<?php
include(__DIR__ . DS . 'simpleimage/simpleimage.php');

page::$methods['cropTop'] = function($page, $filename, $args = array()) {
	$crop_top = new CropTop();
	$url = $crop_top->run($page, $filename, $args);
	return $url;
};

class CropTop {
	function run($page, $filename, $args) {
		$this->page = $page;
		$this->filename = $filename;
		$this->args = $args;
		$this->setPaths();
		$this->addDir();
		$this->addThumb();
		return $this->url_thumb_file;
	}

	function setPaths() {
		if( $this->image = $this->page->image($this->filename) ) {
			$this->path_image_file = kirby()->roots()->content() . DS . str_replace('/', DS, $this->image->diruri());

			$this->setSuffix();

			$this->setPathThumbUri();
			$this->setPathThumbDir();
			$this->setPathThumbFile();

			$this->setUrlThumbFile();
		}
	}

	function addDir() {
		if( ! file_exists( $this->path_thumb_dir ) ) {
			dir::make($this->path_thumb_dir);
		}
	}

	function addThumb() {
		if( ! file_exists( $this->path_thumb_file ) ) {
			$this->object = new abeautifulsite\SimpleImage($this->path_image_file);
			$this->object->thumbnail($this->args['width'], $this->args['height'], 'top')->save($this->path_thumb_file);
		}
	}

	function setPathImageFile() {
		$root = kirby()->roots()->content();
		$uri = str_replace('/', DS, $this->image->diruri());
		$this->path_image_file = $root . DS . $uri;
	}

	function setPathThumbUri() {
		$this->path_thumb_uri = str_replace( kirby()->roots()->content() . DS, '', $this->image->dir() );
	}

	function setPathThumbDir() {
		$root = kirby()->roots()->thumbs();
		$prefix = 'crop-top';
		$uri = str_replace('/', DS, $this->image->uri());
		$this->path_thumb_dir = dirname( $root . DS . $prefix . DS . $uri );
	}

	function setPathThumbFile() {
		$dir = $this->path_thumb_dir;
		$filename = $this->image->name() . $this->suffix . '.' . $this->image->extension();
		$this->path_thumb_file = $this->path_thumb_dir . DS . $filename;
	}

	function setSuffix() {
		if( ! empty( $this->args['width'] ) && ! empty( $this->args['height'] ) ) {
			$this->suffix = '-' . $this->args['width'] . 'x' . $this->args['height'];
		} elseif( ! empty( $this->args['width'] ) ) {
			$this->suffix = '-' . $this->args['width'];
		} elseif( ! empty( $this->args['height'] ) ) {
			$this->suffix = '-' . $this->args['height'];
		} else {
			$this->suffix = '';
		}
	}

	function setUrlThumbFile() {
		$root = kirby()->roots()->index();
		$uri = str_replace($root . DS, '', $this->path_thumb_file);
		$uri = str_replace(DS , '/', $uri);
		$this->url_thumb_file = u() . '/' . $uri;
	}
}