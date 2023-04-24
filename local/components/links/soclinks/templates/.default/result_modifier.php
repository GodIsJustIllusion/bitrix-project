<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult as $key => $item) {
    
    $arResult[$key]['SRC'] = CFile::GetPath($item['SRC']);
    
    // echo '<pre>'. print_r($iff) . '</pre>';
}   

?>