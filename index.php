<?php 
declare(strict_types=1);

spl_autoload_register(function ($class) {
    include __DIR__ . '/class/'.$class.'.php';
});

include(__DIR__.'/config.php');
$dbh = DB::getInstance()->connect();


############### Пример аттрибутов товара################
$input=array(
'вес'=>'100 гр',
'цвет'=>'черный',
'пол'=>'мужской',
'возраст'=>'12 лет'
);

$language_id=3;
$attribute_group_id=370;

$attributes=array();


foreach($input as $key=>$value)
{
    $result = (new CheckAttribute($key, $language_id))->check($dbh);
      
    if(!$result)
    {
         $new_attr = (new AddAttribute($dbh))->add($attribute_group_id, $language_id, $key);  
        if($new_attr)
        {
            $attributes[]=array('attribute_id'=>$new_attr, 'text'=>$value);
        }         
    } else {        
        $attributes[]=array('attribute_id'=>$result, 'text'=>$value);
    }  
}

print_r($attributes);



//CheckAttribute
?>