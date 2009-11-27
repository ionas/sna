<?php
class MyhtmlHelper extends AppHelper {
	
	var $helpers = array('Html');
	
	function clean($text, $maxLength = '40') {
		if (mb_detect_encoding($text) != 'UTF-8') {
			$text = utf8_encode($text); // Encode text in UTF-8
		}
		$text = trim($text); // Remove spaces, tabs and newlines at the beginning and end of text
		// Remove ending tabs and spaces
		$text = preg_replace(
			array(
				'/[\040|\011]{1,}/u', // Matches double spaces or tabs
				'/[\n|\r][\040|\011]{1,}/u', // Matches spaces or tabs at line start
				'/[\040|\011]{1,}[\n|\r]/u', // Matches spaces or tabs at line end
			),
			array(
				' ',
				"\n",
				"\n",
			),
			$text);
		return $text;
	}
	
	function maxLen($text, $len = 70) {
		return wordwrap($text, $len, "\n", true);
	}
	
	function nl2p($text, $options = array(), $enforceMaxLen = true) {
		$pS = $this->Html->tag('p', null, $options);
		$pE = '</p>';
		$br = '<br />';
		if (!empty($text)) {
			// Clean double whitespaces, tabs as well as trailing and starting whitespaces and tabs
			$text = $this->clean($text);
			// Max length auto line break, if enabled
			if ($enforceMaxLen) {
				if (isset($options['maxLen'])) {
					$maxLen = (int)$options['maxLen'];
				}
				$text = $this->maxLen($text);
			}
			// Replace double newlines with <p>
			$text = $pS . preg_replace('#(\r?\n){2,}(\s+)?#u', $pE . $pS, $text) . $pE;
			// Replace single newlines with <br>
			$text = preg_replace('#\r?\n#u', $br, $text);
			// Add newlines to sourcecode for sourcode readability
			$text = preg_replace(
				array(
					'#' . $pE . '#u', // Matches $pE (like </p>)
					'#' . $br . '#u', // Matches $br (like <br />)
				),
				array(
					$pE . "\n",
					$br . "\n",
				),
				$text);
		}
		return $text;
	}
	
}
?>

