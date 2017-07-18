<?php
$gdim=[31,28,31,30,31,30,31,31,30,31,30,31];
$jdim=[31,31,31,31,31,31,30,30,30,30,30,29];
function div($a,$b){return (int)($a/$b);}
function g2j($gy,$gm,$gd,$str=1){
	global $gdim,$jdim;$gy-=1600;--$gm;--$gd;
	$gdn=365*$gy+div($gy+3,4)-div($gy+99,100)+div($gy+399,400);
	for($i=0;$i<$gm;++$i)
		$gdn+=$gdim[$i];
	if($gm>1&&(($gy%4==0&&$gy%100)||!($gy%400))) $gdn++;
	$gdn+=$gd;
	$jdn=$gdn-79;
	$j_np=div($jdn,12053);
	$jdn%=12053;
	$jy=979+33*$j_np+4*div($jdn,1461);
	$jdn%=1461;
	if($jdn>365){$jy+=div($jdn-1,365);$jdn=($jdn-1)%365;}
	for($i=0;$i<11&&$jdn>=$jdim[$i];++$i)
		$jdn-=$jdim[$i];
	$jm=$i+1;
	$jd=$jdn+1;
	return $str?$jy.'/'.$jm.'/'.$jd:[$jy,$jm,$jd];
}
function j2g($jy,$jm,$jd,$str=1){
	global $gdim,$jdim;$jy-=979;--$jm;--$jd;
	$jdn=365*$jy+div($jy,33)*8+div($jy%33+3,4);
	for($i=0;$i<$jm;++$i)
		$jdn+=$jdim[$i];
	$jdn+=$jd;
	$gdn=$jdn+79;
	$gy=1600+400*div($gdn,146097);
	$gdn%=146097;
	$leap=1;
	if($gdn>36524){
		$gy+=100*div(--$gdn,36524);
		$gdn%=36524;
		if($gdn>364) $gdn++;
		else $leap=0;}
	$gy+=4*div($gdn,1461);
	$gdn%=1461;
	if($gdn>365){
		$gy+=div(--$gdn,365);
		$gdn%=365;
		$leap=0;} 
	for($i=0;$gdn>=($Q=$gdim[$i]+($i==1&&$leap));$i++)
		$gdn-=$Q;
	$gm=$i+1;
	$gd=$gdn+1;
	return $str?$gy.'/'.$gm.'/'.$gd:[$gy,$gm,$gd];
} 
function cmp($j,$g){
	$J=explode('/',$j);$G=explode('/',$g);$arr=j2g($J[0],$J[1],$J[2]);
	if($G[0]>$arr[0]) return false;
	if($G[0]==$arr[0]&&$G[1]>$arr[1]) return false;
	if($G[0]==$arr[0]&&$G[1]==$arr[1]&&$G[2]>$arr[2]) return false;return true;	
}

?>
