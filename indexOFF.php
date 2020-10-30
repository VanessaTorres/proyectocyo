<?php
date_default_timezone_set("America/Bogota");
$array=[];
$int1="";
exec("minizinc --solver osicbc planta.mzn datos_henry.dzn",$array,$int1);

$fecha = new DateTime();
echo str_replace(":","",str_replace("-","", str_replace(" ","",$fecha->format('Y-m-d H:i'))));

echo "<pre>";
print_r($array);


//echo exec("whoami");
//echo shell_exec("ipconfig/all");
//echo shell_exec("dir");

?>