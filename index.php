<?php 
declare(strict_types=1);

spl_autoload_register(function ($class) {
    include __DIR__ . '/class/'.$class.'.php';
});

include(__DIR__.'/config.php');
$dbh = DB::getInstance()->connect();


############### Пример аттрибутов товара################
$input=array('розмір', 'цвет', 'пол', 'возраст');

$language_id=3;
$filter_group_id=2;

$filters=array();


foreach($input as $value)
{
    $result = (new CheckFilter($value, $language_id))->check($dbh);
      
    if(!$result)
    {
        $new_filter = (new AddFilter($dbh))->add($filter_group_id, $language_id, $value);  
        if($new_filter)
        {
            $filters[]=$new_filter;
        }         
    } else {        
        $filters[]=$result;
    }  
}

print_r($filters);



//CheckAttribute
?>