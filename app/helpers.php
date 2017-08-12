<?php
/*sadece data icerisindeki degiskenlerini alt alta ekrana bassin diye
oylesine ekledigim test amacli fonksiyon. projenin amaci bir odev oldugu icin
cok fazla veri olan sayfalarda bu fonksiyon ile verileri ekrana basacagim,
sayfada tum verileri tek tek  formatlamak ile ugrasmayayim diye. ozetle dummy bir
fonksiyonve test amacli sadece*/

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