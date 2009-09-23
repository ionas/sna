<?php
class AvatarableBehavior extends ModelBehavior {
	
	var $name = 'Avatarable';
	
	function setup(&$Model, $settings = array()) {
		$this->settings[$Model->alias] = array(
			'fieldname' => 'image',
			'publicDirectory' => 'data/img',
			'useTransactions' => true,
		);
		if (!is_array($settings)) {
			$settings = array();
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
		$this->settings['uploadDirectory'] = APP . WEBROOT_DIR . DS
			. $this->settings[$Model->alias]['publicDirectory'] . DS
			. Inflector::tableize($Model->alias);
	}
	
	function beforeSave(&$Model) {
		// Start Transaction
		$Model->getDataSource()->begin($Model);
		return true;
	}
	
	function afterSave(&$Model, $created) {
		$imageData = $Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']];
		$imageInfo = $this->_separateFilenameFromExt($imageData);
		if(!in_array($imageInfo['ext'], array('jpg', 'gif', 'png'))) {
			$this->_rollback($Model);
		}
		$uploadFilename = $Model->id . '.' . $imageInfo['name'] . '.' . $imageInfo['ext'];
		if (!is_dir($this->settings['uploadDirectory'])) {
			if(!mkdir($this->settings['uploadDirectory'], 0777, true)) {
				$this->log($this->name . ': Could not create uploadDirectory '
					. $this->settings['uploadDirectory'], 'error');
			}
		}
		if(!is_writable($this->settings['uploadDirectory'])) {
			$this->log($this->name . ': Cannot write to uploadDirectory '
				. $this->settings['uploadDirectory'], 'error');
			$this->_rollback($Model);
		}
		if(!is_writable($this->settings['uploadDirectory'] . DS . $uploadFilename)) {
			$this->log($this->name . ': Cannot write to file '
				. $this->settings['uploadDirectory'] . DS . $uploadFilename, 'error');
			$this->_rollback($Model);
		}
		if (@move_uploaded_file($imageData['tmp_name'],
				$this->settings['uploadDirectory'] . DS . $uploadFilename)) {
			$this->log($this->name . ': File is valid, and was successfully uploaded to '
				. $this->settings['uploadDirectory'] . DS . $uploadFilename, 'debug');
			// $this->_resizeImage($image['tmp_name'], 180, 180);
		} else {
			$this->log($this->name . ': Possible file upload attack!', 'debug');
			$Model->getDataSource()->commit($Model);
		}
	}
	
	function _rollback(&$Model) {
		$Model->getDataSource()->rollback($Model);
		return false;
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
	
	function _createThumbnail(&$file, $maxw, $maxh, $thumbscalew, $thumbscaleh, $folderName) {
		$size = GetImageSize($file);
		/*
		 *	Generate the big version of the image with max of $imgscale in either directions
		 */
		$this->resizeImage('resize', $file, $saveDirectory, $filename, $width, $height, 85);
		/*
		 *	Generate the small thumbnail version of the image with scale of $thumbscalew and $thumbscaleh
		 */
		$this->resizeImage('resizeCrop', $file, $saveDirectory, $filename, $width, $height, 75);
		
		// Delete temporary image
		unlink($file);
		
		// Image thumbnailed
	}
	
	function resizeImage($cType = 'resize', $tmpfile, $dstfolder, $dstname = false, $newWidth=false, $newHeight=false, $quality = 75)
	{
		$srcimg = $tmpfile;
		list($oldWidth, $oldHeight, $type) = getimagesize($srcimg);
		$ext = $this->image_type_to_extension($type);

		// If file is writeable, create destination (tmp) image
		if (is_writeable($dstfolder)) {
			$dstimg = $dstfolder.DS.$dstname;
		} else {
			// if dirFolder not writeable, let developer know
			debug("You must allow proper permissions for image processing. And the folder has to be writable.");
			debug("Run \"chmod 777 on '$dstfolder' folder\"");
			exit();
		}

		// Check if something is requested, otherwise do not resize
		if ($newWidth or $newHeight) {
			/* If tmp file exists, delete it */
			if(file_exists($dstimg)) {
				unlink($dstimg);
			} else {
				switch ($cType) {
				default:
				case 'resize':
					// Maintains the aspect ratio of the image and makes sure
					// that it fits within the maxW and maxH
					$widthScale = 2;
					$heightScale = 2;

					// Check to see over-resizing, or set new scale
					if($newWidth) {
						if($newWidth > $oldWidth) $newWidth = $oldWidth;
						$widthScale = 	$newWidth / $oldWidth;
					}
					if($newHeight) {
						if($newHeight > $oldHeight) $newHeight = $oldHeight;
						$heightScale = $newHeight / $oldHeight;
					}
					if($widthScale < $heightScale) {
						$maxWidth = $newWidth;
						$maxHeight = false;
					} elseif ($widthScale > $heightScale ) {
						$maxHeight = $newHeight;
						$maxWidth = false;
					} else {
						$maxHeight = $newHeight;
						$maxWidth = $newWidth;
					}

					if($maxWidth > $maxHeight){
						$applyWidth = $maxWidth;
						$applyHeight = ($oldHeight*$applyWidth)/$oldWidth;
					} elseif ($maxHeight > $maxWidth) {
						$applyHeight = $maxHeight;
						$applyWidth = ($applyHeight*$oldWidth)/$oldHeight;
					} else {
						$applyWidth = $maxWidth;
						$applyHeight = $maxHeight;
					}
					$startX = 0;
					$startY = 0;
					break;

				case 'resizeCrop':
					// Check to see that we are not over resizing, otherwise, set the new scale
					// -- resize to max, then crop to center
					if($newWidth > $oldWidth) $newWidth = $oldWidth;
						$ratioX = $newWidth / $oldWidth;

					if($newHeight > $oldHeight) $newHeight = $oldHeight;
						$ratioY = $newHeight / $oldHeight;

					if ($ratioX < $ratioY) {
						$startX = round(($oldWidth - ($newWidth / $ratioY))/2);
						$startY = 0;
						$oldWidth = round($newWidth / $ratioY);
						$oldHeight = $oldHeight;
					} else {
						$startX = 0;
						$startY = round(($oldHeight - ($newHeight / $ratioX))/2);
						$oldWidth = $oldWidth;
						$oldHeight = round($newHeight / $ratioX);
					}
					$applyWidth = $newWidth;
					$applyHeight = $newHeight;
					break;

				case 'crop':
					// straight centered crop
					$startY = ($oldHeight - $newHeight)/2;
					$startX = ($oldWidth - $newWidth)/2;
					$oldHeight = $newHeight;
					$applyHeight = $newHeight;
					$oldWidth = $newWidth;
					$applyWidth = $newWidth;
					break;
				}

				switch($ext) {
				case 'gif' :
					$oldImage = imagecreatefromgif($srcimg);
					break;
				case 'png' :
					$oldImage = imagecreatefrompng($srcimg);
					break;
				case 'jpg' :
				case 'jpeg' :
					$oldImage = imagecreatefromjpeg($srcimg);
					break;
				default :
					//image type is not a possible option
					return false;
					break;
				}

				// Create new image
				$newImage = imagecreatetruecolor($applyWidth, $applyHeight);
				// Put old image on top of new image
				imagecopyresampled($newImage, $oldImage, 0, 0, $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);

				switch($ext) {
				case 'gif' :
					imagegif($newImage, $dstimg, $quality);
					break;
				case 'png' :
					imagepng($newImage, $dstimg, round($quality/10));
					break;
				case 'jpg' :
				case 'jpeg' :
					imagejpeg($newImage, $dstimg, $quality);
					break;
				default :
					return false;
					break;
				}

				imagedestroy($newImage);
				imagedestroy($oldImage);

				return true;
			}

		} else {
			return false;
		}
	}
	
}
?>