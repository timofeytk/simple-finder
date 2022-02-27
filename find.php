<?
// ini_set("max_execution_time", 900);
$bitrix_prolog = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";
$bitrixTemplatePath = '';
$find = '';
if(file_exists($bitrix_prolog)) {
    require($bitrix_prolog);
    if(!$USER->IsAuthorized()) {
        echo 'Вы не авторизованы';die();
    }
    $bitrixTemplatePath= SITE_TEMPLATE_PATH;
}

if(isset($_POST['find'])) {
    $find = $_POST['find'];
    $path = $_SERVER['DOCUMENT_ROOT'].$_POST['folder'];
}
?>
<form method="POST" action="find.php">
    Поиск <br /> <textarea name="find" cols="30" rows="2"><?=$find?></textarea><br />
    Путь где искать <br /> <input type="text" name="folder" size="40" value="<?=isset($_POST['folder'])?$_POST['folder']:$bitrixTemplatePath?>" /> <br />
    Расширение <br /> <input type="text" name="extension" size="40" value="<?=isset($_POST['extension'])?$_POST['extension']:'php'?>" /> <br /><br />
	<input type="checkbox" name="w" id="w" <?=isset($_POST['w'])?'CHECKED':''?> /> <label for="w">Искать слово целиком?</label> <br />
    <input type="checkbox" name="i" id="i" <?=isset($_POST['i'])?'CHECKED':''?> /> <label for="i">Не учитывать регистр?</label> <br />
    <input type="checkbox" name="l" id="l" <?=isset($_POST['l'])?'CHECKED':''?> /> <label for="l">Выводить только имя файла?</label> <br /><br />
    <button type="submit">Найти</button>
</form>

<?
if(isset($_POST['find'])) {
    $include = '';
    if($_POST['extension']) $include = '--include=*.'.$_POST['extension'];
    
    $w = $_POST['w'] ? 'w' : '';
    $i = $_POST['i'] ? 'i' : '';
    $l = $_POST['l'] ? 'l' : '';
    
    echo 'Искомое слово: <b>'.$find.'</b> <br />';
    echo '<pre>'.shell_exec("grep -rn{$w}{$i}{$l} {$include} '{$find}' {$path}").'</pre>';
}
