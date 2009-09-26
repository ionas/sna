<?php
class AvatarableBehavior extends ModelBehavior {
	
	var $name = 'Avatarable';
	
	function setup(&$Model, $settings = array()) {
		$this->settings[$Model->alias] = array(
			'fieldname' => 'picture',
			'deletefield' => 'picture_do_delete',
			'publicDirectory' => 'data/img',
			'defaultQuality' => 75,
			'smallWidth'   => 64,
			'smallHeight'  => 64,
			'mediumWidth'  => 128,
			'mediumHeight' => 128,
			'largeWidth'   => 256,
			'largeHeight'  => 256,
			'saved' => false,
		);
		if (!is_array($settings)) {
			$settings = array();
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
		$this->settings['uploadDirectory'] = APP . WEBROOT_DIR . DS
			. $this->settings[$Model->alias]['publicDirectory'] . DS
			. Inflector::tableize($Model->alias);
	}
	
	function beforeValidate(&$Model) {
		$this->settings[$Model->alias]['saved'] = true;
		$imageData = $Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']];
		if(isset($Model->data[$Model->alias][$this->settings[$Model->alias]['deletefield']]) and 
		$Model->data[$Model->alias][$this->settings[$Model->alias]['deletefield']] == 1 ) {
			@unlink($this->settings['uploadDirectory'] . DS . $Model->id . '_small');
			@unlink($this->settings['uploadDirectory'] . DS . $Model->id . '_medium');
			@unlink($this->settings['uploadDirectory'] . DS . $Model->id . '_large');
		}
		// No image, in this case, continue
		if (empty($imageData['name'])) {
			$this->settings[$Model->alias]['saved'] = false;
			return true;
		}
		$imageInfo = $this->_separateFilenameFromExt($imageData);
		// TODO, check FILESIZE(!), Check via GetImageSize($file);
		if (!in_array($imageInfo['ext'], array('jpg', 'png', 'gif'))) {
			$Model->invalidate($this->settings[$Model->alias]['fieldname'],
				__('Your picture may be only be of format jpg, png or gif.', true));
			$this->settings[$Model->alias]['saved'] = false;
		}
		// Check permissions
		if (!is_dir($this->settings['uploadDirectory'])) {
			if (!mkdir($this->settings['uploadDirectory'], 0777, true)) {
				$this->log($this->name . ': Could not create uploadDirectory '
					. $this->settings['uploadDirectory'], 'error');
				$Model->invalidate($this->settings[$Model->alias]['fieldname'],
					__('Internal error, please try again later.', true));
				$this->settings[$Model->alias]['saved'] = false;
			}
		}
		if (!is_writable($this->settings['uploadDirectory'])) {
			$this->log($this->name . ': Cannot write to uploadDirectory '
				. $this->settings['uploadDirectory'], 'error');
			$Model->invalidate($this->settings[$Model->alias]['fieldname'],
				__('Internal error, please try again later.', true));
			$this->settings[$Model->alias]['saved'] = false;
		}
		return true;
	}
	
	function beforeSave(&$Model) {
		$Model->getDataSource()->begin($Model); // Start Transaction
		$imageData = $Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']];
		$imageInfo = $this->_separateFilenameFromExt($imageData);
		// Try saving
		if ($this->settings[$Model->alias]['saved'] != false) {
			$uploadFilepath = $this->settings['uploadDirectory'] . DS 
				. $Model->id . '_small';
			if (!$this->_saveResized($Model, $imageData['tmp_name'], $uploadFilepath, $imageInfo['ext'],
				$this->settings[$Model->alias]['smallWidth'],
				$this->settings[$Model->alias]['smallHeight'])) {
				$this->settings[$Model->alias]['saved'] = false;
			}
			$uploadFilepath = $this->settings['uploadDirectory'] . DS 
				. $Model->id . '_medium';
			if (!$this->_saveResized($Model, $imageData['tmp_name'], $uploadFilepath, $imageInfo['ext'],
				$this->settings[$Model->alias]['mediumWidth'],
				$this->settings[$Model->alias]['mediumHeight'])) {
				$this->settings[$Model->alias]['saved'] = false;
			}
			$uploadFilepath = $this->settings['uploadDirectory'] . DS 
				. $Model->id . '_large';
			if (!$this->_saveResized($Model, $imageData['tmp_name'], $uploadFilepath, $imageInfo['ext'],
				$this->settings[$Model->alias]['largeWidth'],
				$this->settings[$Model->alias]['largeHeight'])) {
				$this->settings[$Model->alias]['saved'] = false;
			}
		}
		@unlink($imageData['tmp_name']);
		return true;
	}
	
	function afterSave(&$Model, $created) {
		if ($this->settings[$Model->alias]['saved'] == true) {
			$Model->getDataSource()->commit($Model);
		} else {
			$this->log($this->name . ': Cannot save pictures, Rolling back...', 'error');
			/*
			// RACE CONDITION!
			@unlink($this->settings['uploadDirectory'] . DS . $Model->id . '_small.' 
				. $imageInfo['ext']);
			@unlink($this->settings['uploadDirectory'] . DS . $Model->id . '_medium.' 
				. $imageInfo['ext']);
			@unlink($this->settings['uploadDirectory'] . DS . $Model->id . '_large.' 
				. $imageInfo['ext']);
			*/
			$Model->getDataSource()->rollback($Model);
		}
	}
	
	function _separateFilenameFromExt(&$file) {
		$pathinfo = pathinfo($file['name']);
		return array(
			'name' => $pathinfo['filename'],
			'ext' => $this->_getExtByFileType($file['tmp_name']));
	}
	
	function _getExtByFileType(&$file) {
		// By trial and error, it seems that a file has to be 12 bytes or larger in order to avoid
		// a "Read error!".  Here's a work-around to avoid an error being thrown:
		if (filesize($file) > 11) {
		    $type = exif_imagetype($file);
		} else {
		    $type = null;
		}
		switch ($type) {
			case IMAGETYPE_PNG     : return 'png';
			case IMAGETYPE_GIF     : return 'gif';
			case IMAGETYPE_JPEG    : return 'jpg';
			case IMAGETYPE_JP2     : return 'jp2';
			case IMAGETYPE_BMP     : return 'bmp';
			case IMAGETYPE_IFF     : return 'aiff';
			case IMAGETYPE_TIFF_II : return 'tiff';
			case IMAGETYPE_TIFF_MM : return 'tiff';
			case IMAGETYPE_SWF     : return 'swf';
			case IMAGETYPE_PSD     : return 'psd';
			case IMAGETYPE_JPC     : return 'jpc';
			case IMAGETYPE_JPX     : return 'jpf';
			case IMAGETYPE_JB2     : return 'jb2';
			case IMAGETYPE_SWC     : return 'swc';
			case IMAGETYPE_WBMP    : return 'wbmp';
			case IMAGETYPE_XBM     : return 'xbm';
			default                : return false;
		}
	}
	
	function _saveResized(&$Model, $image, $uploadFilepath, $ext, $newWidth = null, $newHeight = null, 
			$quality = null) {
		if ($quality == null) {
			$quality = $this->settings[$Model->alias]['defaultQuality'];
		}
		// Delete existing file
		if (file_exists($uploadFilepath)) {
			if (!unlink($uploadFilepath)) {
				$this->log($this->name . ': Could not delete existing picture "' 
					. uploadFilepath . '"', 'debug');
				return false;
			}
		}
		// Calculate new size
		$orgInfo = getimagesize($image);
		$oldWidth = $orgInfo[0];
		$oldHeight = $orgInfo[1];
		// Ratios
		if ($newWidth > $oldWidth) {
			$newWidth = $oldWidth;
		}
		$ratioX = $newWidth / $oldWidth;	
		if ($newHeight > $oldHeight) {
			$newHeight = $oldHeight;
		}
		$ratioY = $newHeight / $oldHeight;
		// Propotion priority
		if ($ratioX < $ratioY) {
			$startX = round(($oldWidth - ($newWidth / $ratioY)) / 2);
			$startY = 0;
			$oldWidth = round($newWidth / $ratioY);
			$oldHeight = $oldHeight;
		} else {
			$startX = 0;
			$startY = round(($oldHeight - ($newHeight / $ratioX)) / 2);
			$oldWidth = $oldWidth;
			$oldHeight = round($newHeight / $ratioX);
		}
		// Create working copy of source file
		switch ($ext) {
			case 'gif':
				$source = imagecreatefromgif($image);
				break;
			case 'png':
				$source = imagecreatefrompng($image);
				break;
			case 'jpg':
				$source = imagecreatefromjpeg($image);
				break;
			default:
				return false;
		}
		// Create working copy of target file
		$target = imagecreatetruecolor($newWidth, $newHeight);
		// Resize and copy image from source to target image
		imagecopyresampled($target, $source, 0, 0, $startX, $startY, $newWidth, $newHeight,
			$oldWidth, $oldHeight);
		imagedestroy($source); // Destroy working copy source
		// Save as image type
		$return = false;
		switch ($ext) {
			case 'gif':
				$return = imagegif ($target, $uploadFilepath, $quality);
				break;
			case 'png':
				$return = imagepng($target, $uploadFilepath, round($quality / 10));
				break;
			case 'jpg':
				$return = imagejpeg($target, $uploadFilepath, $quality);
		}
		// Destroy working copy target
		imagedestroy($target);
		return $return;
	}
	
}
?>