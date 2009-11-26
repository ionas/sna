<?php
$test =
'<b>1.</b> This is a long text for testing plaintext to a userfriendly nl2p. The first example contains no tabs, no newlines but spaces. The second example contains single newlines only. The third example contains single and multiple newline. The forth example contains single and multiple newlines that are encapsulated by tabs.

<b>2.</b> This is a long text for testing plaintext to a userfriendly nl2p. The first example contains no tabs, no newlines but spaces.
The second example contains single newlines only. The third example contains single and multiple newline.
The forth example contains single and multiple newlines that are encapsulated by tabs.

<b>3.</b> This is a long text for testing plaintext to a userfriendly nl2p.
The first example contains no tabs, no newlines but spaces.

The second example contains single newlines only.

The third example contains single and multiple newline.
The forth example contains single and multiple newlines that are encapsulated by tabs.

<b>4.</b> This is a long text for testing plaintext to a userfriendly nl2p.  
	The first example contains no tabs, no newlines but spaces.

The second example contains single newlines only.

The third example contains single and multiple newline.  

	The forth example contains single and multiple newlines that are encapsulated by tabs.

<b>5.</b> This additional example will have indents at its starting line, tabs and whitespaces:

	this line is tabbed
	this line is tabbed

 this line is spaced
 this line is spaced

	this line is tabbed with space at the end 
	this line is tabbed with space at the end 

 this line is spaced           with space at the end
 this line is spaced with space at the end                

	this line is tabbed with tab at the end
	this line is tabbed with tab at the end	

 this line is spaced with tab at the end	
 this line is spaced with tab at the end	

<b>6.</b>

i hate this thing
you know

grr how i hate it

double space  this is after double space

 
  
	
	 	
 	 	

'; $text = $test;

$p_start = '<p>';
$p_end = '</p>';
$br = '<br />';
if(!empty($text)) {
	$text = utf8_encode($text); // encode to utf8
	$text = trim($text);
	$text = preg_replace('/[\040|\011]{1,}/u',' ',$text); // 040 space, 011 tab, replace by single space
	$text = preg_replace('/[\n|\r][\040|\011]{1,}/u', "\n",$text); // remove trailing tabs and spaces
	$text = preg_replace('/[\040|\011]{1,}[\n|\r]/u', "\n",$text); // remove ending tabs and spaces
	$text = $p_start . preg_replace('#(\r?\n){2,}(\s+)?#u', $p_end . $p_start, $text) . $p_end; // replace double newlines with <p>
	$text = preg_replace('#\r?\n#u', $br, $text); // replace single newlines with <br>
	$text = preg_replace(array('#' . $p_end . '#u', '#' . $br . '#u'), array($p_end . "\n", $br . "\n"), $text); // add newlines to sourcecode for sourcode readabilityy
}

?>
<pre>
<?php echo $test?>
</pre>
<hr id="result" />
<style>
p { border: 1px solid red;}
</style>
<?php echo $text?>