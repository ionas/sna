

function nl2p_($string) {
	$string = '
	
	Foo123
	Bar
	
	Quux
	
	LOL

Foo123
Bar
Quux QUux Quux

LolRofl LolRofl



LolRofl LolRofl
	
	';
$string = preg_replace('#\n|\r#', '</p>$0<p>', $string);

	
	$string = '
	
</p><p>
</p>	<p>
</p>
<p>
</p>

<p>
</p> 

<p>
Foo
</p><p>
</p>	<p>
</p>
<p>
</p>

<p>
</p> 

<p>	
	';
	// $string = preg_replace('/\s\s+/', ' ', $string);
	// $string = preg_replace('#\s*[<p></p>]\s*#', '<br />', $string);
	
	$string = '<div>1. This is a long text for testing plaintext to a userfriendly nl2p. The first example contains no tabs, no newlines but spaces. The second example contains single newlines only. The third example contains single and multiple newline. The forth example contains single and multiple newlines that are encapsulated by tabs.</div><div>2. This is a long text for testing plaintext to a userfriendly nl2p.
The first example contains no tabs, no newlines but spaces.
The second example contains single newlines only. The third example contains single and multiple newline.
The forth example contains single and multiple newlines that are encapsulated by tabs.</div><div>3. This is a long text for testing plaintext to a userfriendly nl2p.
The first example contains no tabs, no newlines but spaces.

The second example contains single newlines only.

The third example contains single and multiple newline.
The forth example contains single and multiple newlines that are encapsulated by tabs.</div><div>4. This is a long text for testing plaintext to a userfriendly nl2p.  
The first example contains no tabs, no newlines but spaces.

The second example contains single newlines only.

The third example contains single and multiple newline.  

The forth example contains single and multiple newlines that are encapsulated by tabs.</div>';

	// 1. trim();
	// 2. BR on single
	// 3. Paragraph
	// 4. P stripping

//	$string = preg_replace('#[^\S\r\n]*\n[^\S\r\n]*#', '[BR]', $string);
	$string = '<pre>'.$string.'</pre><br>'.preg_replace('/(?<!\n)\n(?!\n)/', '[br]', $string);
//	$string = '<pre>'.$string.'</pre><br>'.preg_replace('/(?<!\n|\s)\n(?!\n|\s)/', '<br>', $string);
	return $string;
// 		return str_replace('<p></p>', '', '<p>' . preg_replace(
//			'#\n|\r#', '</p>$0<p>', $string) . '</p>')
		
		// Replace single newlines with <br />
		// $string = preg_replace('/(?<!\n)\n(?!\n)/', '[BR /]', $string);
		$string = preg_replace('/(?<!\n|\s)\n(?!\n|\s)/', '[BR]', $string);
		// Replace any newlines with </p><p> and wrap everything into <p></p>
		// $string = '<p>'. preg_replace('#(\n|\r)#', '</p>$0<p>', $string) . '</p>';
		$string = '[p]'. preg_replace('#(?<!\w)\n(?!\w)#', '[/p]$0[p]', $string) . '[/p]';
		// Remove empty paragraphs
	
}

	function __nl2p($string) {
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

this line is spaced with space at the end
this line is spaced with space at the end

this line is tabbed with tab at the end
this line is tabbed with tab at the end	

this line is spaced with tab at the end	
this line is spaced with tab at the end	

<b>6.</b>

i hate this thing
you know

grr how i hate it

';
		
$original = '
<pre>
'.$test.'
</pre>
';
$string = $test;
// $original = '
// <pre>
// '.$string.'
// </pre>
// ';
		
		// Strip whitespaces from start and end
		$string = trim($string);
		// Remove tab/white tailings (required by below, else example 5 fails)
		$string = preg_replace('#[ |\t]+\n#', "\n", $string);
		// Remove tab/white tailings (required by below, else example 5 fails)
		$string = preg_replace('#$[ |\t]#', '', $string);
		// Replace any double newlines with </p><p> and wrap everything into <p></p>
		$string = '<p>'. preg_replace('#(?<!\w)\n(?!\w)#', '</p>$0<p>', $string) . '</p>';
		// Remove empty paragraphs
		$string = preg_replace('#\s*<p\>\s*</p\>\s*#', '', $string);
		// Remove whitespaces around <p>
		$string = preg_replace('#\s*<p>s*#', '<p>', $string);
		$string = preg_replace('#\s*</p>\s*#', '</p>', $string);
		// Remove errorous <p>\s<br>
		$string = preg_replace('#<p>\s+\n#', '<p>', $string);
		// Replace single newlines with <br />
		$string = preg_replace('#(?<!<p>)\n(?!</p>)#', '<br />', $string);
		$string = $original . $string;
		return $string;
	}
	
	function nl2p___($string) {
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

this line is spaced with space at the end
this line is spaced with space at the end

this line is tabbed with tab at the end
this line is tabbed with tab at the end	

this line is spaced with tab at the end	
this line is spaced with tab at the end	

<b>6.</b>

i hate this thing
you know

grr how i hate it


'
	;
	$text = $test;
	
	// $text = preg_replace('/\t+/', ' ', $text);
//		$text = preg_replace("/\s^[\n|\r]+/", ' ', $text);
//		$text = preg_replace("#\t#", ' ', $text);
//		$text = preg_replace("/^[ \t]+|[ \t]+$/", ' ', $text);
	$text = preg_replace('/\040{1,}/',' ',$text);

	$out = '<pre>' . "\n" . $test . "\n" .'</pre>';
	$out .= '<hr><pre>' . "\n" . $text . "\n" .'</pre>';
	var_dump($out);
	die;
	return $out;
	
	
}