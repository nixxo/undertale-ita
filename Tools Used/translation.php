<?php
//Tool written to convert
//the old translation for the old game version
//into the new game version (1.08)
//

$in = array();
$out = array();
$in['i'] = array();
$in['e'] = array();

//spaghetti project translation file
$fn = "Translation.txt";
$f = fopen($fn, "r") or die("Unable to open file!");
$fc = fread($f, filesize($fn));
fclose($f);
$in['i'] = explode("\x0D\x0A", $fc);
echo count($in['i']) . " > " . count(array_unique($in['i'])) . PHP_EOL;

//original string - version for reference
$fn = "string08.txt";
$f = fopen($fn, "r") or die("Unable to open file!");
$fc = fread($f, filesize($fn));
fclose($f);
$in['e'] = explode("\x0D\x0A", $fc);
echo count($in['e']) . " > " . count(array_unique($in['e'])) . PHP_EOL;
$in['e'] = array_flip($in['e']);

//original string - target version
$fn = "string10.txt";
$f = fopen($fn, "r") or die("Unable to open file!");
$fc = fread($f, filesize($fn));
fclose($f);
$out = explode("\x0D\x0A", $fc);
echo count($out) . " > " . count(array_unique($out)) . PHP_EOL;

//scroll through the target array
//finding in the reference array
//the same string and
//replacing it with the translated one
for ($i = 0; $i < count($out); $i++) {
	$o = $out[$i];
	if (isset($in['e'][$o])) {
		$ix = $in['e'][$o];
		$out[$i] = $in['i'][$ix];
		unset($in['i'][$ix]);
		unset($in['e'][$o]);
		echo ":";
	} else {
		echo ".";
	}
}

//saving the translated file
$fn = "string.new.txt";
$f = fopen($fn, "w+") or die("Unable to open file!");
for ($i = 0; $i < count($out); $i++) {
	fwrite($f, $out[$i] . "\x0D\x0A");
}
fclose($f);

//saving the leftovers translation file
//due to same formatting differences with the old version
//not every string can be automatically replaced.
//the rest has to be done manually
$fn = "Translation.new.txt";
$f = fopen($fn, "w+") or die("Unable to open file!");
foreach ($in['i'] as $v) {
	fwrite($f, $v . "\x0D\x0A");
}
fclose($f);

?>