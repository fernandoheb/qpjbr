<?php
chdir(dirname(__DIR__));
$vet[1]=@$_GET["img1"];
$vet[2]=@$_GET["img2"];
$vet[3]=@$_GET["img3"];
$vet[4]=@$_GET["img4"];
$vet[5]=@$_GET["img5"];
$vet[6]=@$_GET["img6"];
$vet[7]=@$_GET["img7"];
$vet[8]=@$_GET["img8"];
$vet[9]=@$_GET["img9"];
$vet[10]=@$_GET["img10"];


function GeraImgShare($vetimg){
$num = 0;
header('Content-Type: image/png');
$imsource[0]=imagecreatefrompng( "imgfb/blank.png" );
$imresult = imagecreatetruecolor( 600, 315 );
imagecopyresized($imresult,$imsource[0],0,0,0,0,600,315,1,1);
$imsource[999]=imagecreatefrompng( "imgfb/fundo.png" );
//imagecopyresized($imresult,$imsource[999],0,0,0,0,600,315,1400,630);
$i = 0;
while($i<11){
if(isset($vetimg[$i])&&$vetimg[$i]==1){$num++;$imsource[$i]=1;}
$i++;
}


if($num==1){
$i=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
imagecopyresampled($imresult,$imsource[$i],200+50,5,0,0,$width/1.35,$height/1.35,$width,$height);
}
$i++;
}
}

if($num==2){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],320+50,5,0,0,$width/1.35,$height/1.35,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(300-$width)+50,5,0,0,$width/1.35,$height/1.35,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==3){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],420,20,0,0,$width/1.5,$height/1.5,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(310-$width/3),20,0,0,$width/1.5,$height/1.5,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(200-$width/1.5),20,0,0,$width/1.5,$height/1.5,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==4){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(75-$width/4),40,0,0,$width/2,$height/2,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],(150+75-$width/4),40,0,0,$width/2,$height/2,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(300+75-$width/4),40,0,0,$width/2,$height/2,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(450+75-$width/4),40,0,0,$width/2,$height/2,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==5){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==5){imagecopyresampled($imresult,$imsource[$i],(60-$width/5),60,0,0,$width/2.6,$height/2.6,$width,$height);$imagem++;}
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(180-$width/5),60,0,0,$width/2.6,$height/2.6,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],(300-$width/5),60,0,0,$width/2.6,$height/2.6,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(420-$width/5),60,0,0,$width/2.6,$height/2.6,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(540-$width/5),60,0,0,$width/2.6,$height/2.6,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==6){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==6){imagecopyresampled($imresult,$imsource[$i],430-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==5){imagecopyresampled($imresult,$imsource[$i],(310-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(200-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],430-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(310-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(200-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==7){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==7){imagecopyresampled($imresult,$imsource[$i],480-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==6){imagecopyresampled($imresult,$imsource[$i],430-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==5){imagecopyresampled($imresult,$imsource[$i],(310-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(200-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],370-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(260-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(150-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==8){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==8){imagecopyresampled($imresult,$imsource[$i],480-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==7){imagecopyresampled($imresult,$imsource[$i],480-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==6){imagecopyresampled($imresult,$imsource[$i],370-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==5){imagecopyresampled($imresult,$imsource[$i],(260-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(150-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],370-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(260-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(150-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
}
$i++;
}
}


if($num==9){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==9){imagecopyresampled($imresult,$imsource[$i],550-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==8){imagecopyresampled($imresult,$imsource[$i],440-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==7){imagecopyresampled($imresult,$imsource[$i],480-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==6){imagecopyresampled($imresult,$imsource[$i],370-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==5){imagecopyresampled($imresult,$imsource[$i],(260-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(150-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],330-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(220-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(110-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
}
$i++;
}
}

if($num==10){
$i=1;$imagem=1;
while($i<11){
if(isset($imsource[$i])){
$imsource[$i]=imagecreatefrompng("imgfb/".$i.".png");
list($width, $height) = getimagesize("imgfb/".$i.".png");
if($imagem==10){imagecopyresampled($imresult,$imsource[$i],550-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==9){imagecopyresampled($imresult,$imsource[$i],550-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==8){imagecopyresampled($imresult,$imsource[$i],440-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==7){imagecopyresampled($imresult,$imsource[$i],440-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==6){imagecopyresampled($imresult,$imsource[$i],330-$width/6,160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==5){imagecopyresampled($imresult,$imsource[$i],(220-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==4){imagecopyresampled($imresult,$imsource[$i],(110-$width/6),160,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==3){imagecopyresampled($imresult,$imsource[$i],330-$width/6,5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==2){imagecopyresampled($imresult,$imsource[$i],(220-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
if($imagem==1){imagecopyresampled($imresult,$imsource[$i],(110-$width/6),5,0,0,$width/3,$height/3,$width,$height);$imagem++;}
}
$i++;
}
}
//imagefilter($imresult,IMG_FILTER_SMOOTH,20);
imagepng($imresult);

}

GeraImgShare($vet);
?>
