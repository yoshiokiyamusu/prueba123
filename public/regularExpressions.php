<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
<?php
$string="es Yoshio, Yoshio es mi nombre";
//$string="MI NOMBRE ES JSDHNF";
//$result = preg_match("/yoshio/",$string); //para ver si la palabra esta adentro
//$result = preg_match_all("/yoshio/",$string,$array);
//$result = preg_replace("/yoshio/","tio",$string); // para reemplazar
//$result = preg_match("/./",$string); //any character
//$result = preg_match("/(a|o)/",$string); //esta a o o en el string? almenos 1 tiene q hacer match para ser true
//$result = preg_match("/[abc]/",$string); //buscar a,b, o c en el string
//$result = preg_match("/[pvxj]/",$string); // buscar p,v,x,j
//$result = preg_match("/[^pvxj]/",$string);// negacion de: buscar p,v,x,j
//$result = preg_match("/[a-z]/",$string);//lower case buscar en el rango de a-z
//$result = preg_match("/[a-zA-Z]/",$string);//buscar mayusculas y minusculasS
//$result = preg_match("/[0-9]/",$string);//buscar caracteres numeros
//$result = preg_match("/Y*/",$string);//at least string has 0 or more 'Y'
//preg_match_all("/Y.*/",$string,$array); print_r($array); //botar todo lo que viene despues de Y
//preg_match_all("/Y.*n/",$string,$array); print_r($array); //botar todo lo que viene despues de Y y para en n
//preg_match_all("/Y+/",$string,$array); print_r($array); //botar las Ys

/*
if($result){
   echo 'true';
}else{
  echo 'no match';
}
*/

$input = 'foo,';
$pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

if (preg_match($pattern, $input)){
    echo ' SIII tenemos un match de simbolos';
}else{
  echo 'NOOO tenemos match de simbolos';
}





?>
</body>
</html>
