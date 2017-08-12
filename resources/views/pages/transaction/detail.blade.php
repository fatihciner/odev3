<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 14:02
 */
//var_dump($result);
function loop($obj, $key = null)
{
	if (is_object($obj)) {
		foreach ($obj as $x => $value) {
			echo "<div style='width: 200px; float: left; '><b>{$key}</b><br>";
			loop($value, $x);
			echo '</div>';
		}
	} else {
		echo "{$key} : {$obj} <br>";
	}
}
?>
<div style="position: relative">
<?php
loop($result['data']);
?>
</div>
