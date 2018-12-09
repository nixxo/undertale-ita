<?php
//Tool written to convert
//the old translation for the old game version
//into the new game version (1.08)
//

$ita = array();
$eng = array();

//italian strings translation file
$fn = "..\\Strings\\strings.ita.txt";
//$fn = "translated.txt";
$f = fopen($fn, "r") or die("Unable to open file!");
$fc = fread($f, filesize($fn));
fclose($f);
$ita = explode("\x0D\x0A", $fc);
echo count($ita) . " > " . count(array_unique($ita)) . PHP_EOL;

//var_dump($ita);
//original string for reference
$fn = "..\\Strings\\strings.eng.txt";
$f = fopen($fn, "r") or die("Unable to open file!");
$fc = fread($f, filesize($fn));
fclose($f);
$eng = explode("\x0D\x0A", $fc);
echo count($eng) . " > " . count(array_unique($eng)) . PHP_EOL;
//$in['e'] = array_flip($in['e']);
//exit;

//for ($i = 0; $i < count($ita); $i++) {
foreach ($ita as $k => $l) {
	$exc =
		['^(obj|scr|spr|credits|room|fnt|monstername|donate)_',
		'^SCR_\w', '^(external|music)/',
		'^gml_(Object|RoomCC|Room|Script)_',
		'^(item|mett|mettquiz|castroll|snd|mus|blt|path|bg)_',
		'^shop\d_', '^buttonL*_'];
	$exc =
		['^\w+_\w+', '^(external|music)/'];
	$f = false;
	//if (isJapanese($ita[$i])) {
	if (strlen($l) > 400 || strlen($l) < 3) {
		unset($ita[$k]);
		echo "L";
		continue;
	}
	if (isJapanese($l)) {
		unset($ita[$k]);
		//unset($eng[$k]);
		echo "#";
		continue;
	}
	foreach ($exc as $v) {
		//if (preg_match("@$v@", $ita[$i])) {
		if (preg_match("@$v@", $l)) {
			unset($ita[$k]);
			//unset($eng[$k]);
			echo ":";
			$f = true;
			break;
		}
	}
	if (!$f) {
		if ($ita[$k] != $eng[$k]) {
			unset($ita[$k]);
			//unset($eng[$k]);
			echo "!";
		} else {
			echo ".";
		}
	}
}

//saving the translated file
$fn = "not_translated.txt";
$f = fopen($fn, "w+") or die("Unable to open file!");
foreach ($ita as $v) {
	fwrite($f, $v . "\x0D\x0A");
}
fclose($f);

function isKanji($str) {
	return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
}

function isHiragana($str) {
	return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
}

function isKatakana($str) {
	return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
}

function isJapanese($str) {
	return isKanji($str) || isHiragana($str) || isKatakana($str);
}

?>