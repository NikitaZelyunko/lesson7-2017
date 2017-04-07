<?php
/*
Необходимо создать многостраничную форму, используя описание струтуры формы в массиве:

 - реализовать функцию отображения формы по заданной структуре;
 - реализовать обработку перехода между страницами и передачу ранее введенных данных.

*/
define("SEX_MALE", 		0);
define("SEX_FEMALE", 	1);

define('SKILL_PHP', 	0);
define('SKILL_HTML', 	1);
define('SKILL_NODEJS', 	2);

$FORM_DATA = [
	'sex' => [
		[
			'name' => 'Male',
			'value' => SEX_MALE,
		],
		[
			'name' => 'Female',
			'value' => SEX_FEMALE,
		],
	],
	
	'skill' => [
		[
			'name' => 'PHP',
			'value' => SKILL_PHP,
		],
		[
			'name' => 'HTML',
			'value' => SKILL_HTML,
		],
		[
			'name' => 'Nndejs',
			'value' => SKILL_NODEJS,
		],
	],
	
];


$form =[
 	// form 1
	[
		[
			'type' => 'text',
			'name' => 'name',
			'label' => 'Name',
		],
		[
			'type' => 'text',
			'name' => 'surname',
			'label' => 'Surname',
		],
		[
			'type' => 'select',
			'name' => 'sex',
			'label' => 'Sex',
			'value' => $FORM_DATA['sex'],
		],
	],
	// form 2
	[
		[
			'type' => 'checkbox',
			'name' => 'skill',
			'label' => 'Skills',
			'value' => $FORM_DATA['skill'],
		],
	],
];


if (!isset($_POST['next']) && !isset($_POST['ok'])) {
	showForm1($_POST);
}
elseif (!isset($_POST['ok'])) {
	showForm2($_POST);
}
else {
	processData($_POST);
}





function showForm1($data = []) {
	global $FORM_DATA;
	
	$out = '<h1>Step1</h1><form method="post">';
	
	$out .= 'Name:<br/><input type="text" value="'. q($data, 'name') .'" name="name" /><br/>';
	$out .= 'Surname<br/><input type="text" value="'. q($data, 'surname') .'" name="surname" /><br/>';
	$out .= 'Sex:<br/><select name="sex">';
	foreach ($FORM_DATA['sex'] as $opt) {
		$out .= '<option value="'. $opt['value'] .'" '. c($data, 'sex', $opt['value'], 'selected') .'>'. $opt['name'] .'</option>';
	}
	//<option value="'. SEX_FEMALE .'" '. c($data, 'sex', SEX_FEMALE, 'selected') .'>Female</option>
	$out .= '</select><br/>';

	$out .= '<br/><input type="submit" value="next" name="next" />';

	$out .= '</form>';
	
	echo $out;
}

function showForm2($data = []) {
	global $FORM_DATA;
	
	$out = '<h1>Step2</h1><form method="post">';
	
	$out .= 'Skills:<br/>';
	foreach ($FORM_DATA['skill'] as $opt) {
		$out .= '<input type="checkbox" name="skill['. $opt['value'] .']" '. chk_skill($data, $opt['value'], 'checked') .' /> '. $opt['name'] .'<br/>';
	}

	$out .= '<br/><input type="submit" value="prev" name="prev" /> ';
	$out .= '<input type="submit" value="ok" name="ok" />';

	foreach ($_POST as $key => $val) {
		$out .= '<input type="hidden" value="'. $val .'" name="'. $key .'" />';
	}

	$out .= '</form>';
	
	echo $out;
}

function processData($data) {
	print '<pre>';
	print_r($data);
	print '</pre>';
}


function q($v, $index) {
	return (isset($v[$index]) ? $v[$index] : '');
}

function c($v, $index, $x, $s) {
	if (isset($v[$index]) && ($v[$index] == $x)) {
		return $s;
	}
	
	return '';	
}

function chk_skill($v, $skill, $s) {
	if (isset($v['skill'][$skill]) && ($v['skill'][$skill] == 'on')) {
		return $s;
	}
	
	return '';	
}
