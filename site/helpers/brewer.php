<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hbeerrecipes
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Hbeerrecipes Component Helper.
 *
 * @since  1.5
 */
class BrewerHbeerrecipesHelper{

	public static function test($temp)
	{
		echo 'kkk';
		return $temp;
	}
	public static function platotosg($plato)
	{
		$sg = 1 + ( $plato / (258.6 -( ($plato/258.2) *227.1)));
		return $sg;
	}
	public static function sgtoplato($sg)
	{
		$plato = (-1 * 616.868) + (1111.14 * $sg)-(630.272 * $sg**2) + (135.997 * $sg**3) ;
		return $plato;
	}
	
 

	public static function getcorrectedplato($temp, $plat)
	{
		if ($plat>=29) {
			$plat=29;
		}
		$plato[0]= array();
		$plato[1]= array();
		$plato[2]= array();
		$plato[3]= array();
		$plato[4]= array();
		$plato[5]= array();
		$plato[6]= array();
		$plato[7]= array();
		$plato[8]= array();
		$plato[9]= array();
		$plato[10]= array();
		$plato[11]= array();
		$plato[12]= array();
		$plato[13]= array();
		$plato[14]= array();
		$plato[15]= array();
		$plato[16]= array();
		$plato[17]= array();
		$plato[18]= array();
		$plato[19]= array();
		$plato[20]= array();
		$plato[21]= array();
		$plato[22]= array();
		$plato[23]= array();
		$plato[24]= array();
		$plato[25]= array();
		$plato[26]= array();
		$plato[27]= array();
		$plato[28]= array();
		$plato[29]= array();
		$plato[30]= array();
		array_push($plato[0],-0.48,-0.38,-0.23,0,0.29,0.66,1.09,1.56,2.09,2.67,3.29,3.94,4.63,5.36,6.12,6.91,7.74,8.59,9.46);
		array_push($plato[1],0.51,0.6,0.77,1,1.3,1.67,2.09,2.56,3.09,3.68,4.29,4.94,5.63,6.35,7.11,7.89,8.82,9.56,10.43);
		array_push($plato[2],1.49,1.59,1.76,2,2.3,2.67,3.09,3.56,4.1,4.68,5.29,5.94,6.62,7.34,8.1,8.88,9.7,10.54,11.41);
		array_push($plato[3],2.48,2.58,2.76,3,3.31,3.68,4.09,4.56,5.1,5.68,6.29,6.93,7.62,8.34,9.09,9.87,10.68,11.52,12.38);
		array_push($plato[4],3.46,3.57,3.75,4,4.31,4.68,5.09,5.56,6.1,6.69,7.29,7.93,8.61,9.33,10.08,10.86,11.67,12.5,13.36);
		array_push($plato[5],4.43,4.56,4.75,5,5.31,5.68,6.09,6.57,7.1,7.69,8.29,8.93,9.61,10.33,11.07,11.85,12.66,13.48,14.34);
		array_push($plato[6],5.41,5.54,5.74,6,6.31,6.68,7.1,7.57,8.11,8.69,9.29,9.93,10.61,11.32,12.07,12.85,13.64,14.46,15.31);
		array_push($plato[7],6.38,6.53,6.74,7,7.31,7.68,8.1,8.57,9.11,9.69,10.29,10.93,11.61,12.32,13.06,13.84,14.63,15.45,16.29);
		array_push($plato[8],7.35,7.52,7.73,8,8.31,8.68,9.1,9.58,10.11,10.69,11.29,11.94,12.62,13.32,14.06,14.83,15.61,16.42,17.26);
		array_push($plato[9],8.33,8.51,8.73,9,9.31,9.68,10.11,10.59,11.12,11.69,12.3,12.95,13.62,14.32,15.05,15.82,16.6,17.4,18.23);
		array_push($plato[10],9.3,9.5,9.73,10,10.32,10.68,11.11,11.6,12.12,12.69,13.3,13.96,14.62,15.31,16.04,16.8,17.58,18.38,19.21);
		array_push($plato[11],10.28,10.49,10.73,11,11.32,11.69,12.12,12.6,13.13,13.69,14.31,14.96,15.62,16.31,17.03,17.78,18.55,19.35,20.17);
		array_push($plato[12],11.27,11.48,11.72,12,12.32,12.69,13.13,13.61,14.13,14.69,15.31,15.96,16.62,17.3,18.02,18.76,19.53,20.33,21.14);
		array_push($plato[13],12.26,12.48,12.72,13,13.32,13.7,14.13,14.62,15.13,15.69,16.31,16.96,17.61,18.29,19.01,19.74,20.51,21.3,22.1);
		array_push($plato[14],13.25,13.47,13.72,14,14.33,14.7,15.14,15.62,16.14,16.69,17.31,17.96,18.61,19.29,19.99,20.73,21.49,22.27,23.06);
		array_push($plato[15],14.25,14.47,14.72,15,15.33,15.71,16.14,16.62,17.14,17.7,18.31,18.96,19.61,20.28,20.99,21.72,22.47,23.24,24.02);
		array_push($plato[16],15.25,15.46,15.71,16,16.33,16.71,17.15,17.63,18.15,18.71,19.32,19.96,20.61,21.28,21.98,22.71,23.46,24.22,24.99);
		array_push($plato[17],16.25,16.46,16.71,17,17.34,17.72,18.16,18.64,19.15,19.72,20.33,20.96,21.61,22.28,22.98,23.7,24.44,25.19,25.96);
		array_push($plato[18],17.25,17.46,17.71,18,18.34,18.73,19.17,19.65,20.16,20.73,21.33,21.97,22.61,23.28,23.97,24.7,25.43,26.17,26.94);
		array_push($plato[19],18.24,18.45,18.7,19,19.35,19.74,20.18,20.66,21.18,21.74,22.34,22.97,23.61,24.27,24.97,25.68,26.41,27.15,27.91);
		array_push($plato[20],19.24,19.44,19.7,20,20.35,20.75,21.19,21.68,22.19,22.75,23.35,23.97,24.61,25.27,25.96,26.67,27.39,28.13,28.89);
		array_push($plato[21],20.22,20.43,20.69,21,21.36,21.76,22.2,22.68,23.2,23.75,24.35,24.96,25.6,26.25,26.94,27.64,28.36,29.1,29.86);
		array_push($plato[22],21.2,21.42,21.68,22,22.36,22.76,23.2,23.68,24.2,24.76,25.34,25.95,26.58,27.24,27.92,28.62,29.33,30.7,30.83);
		array_push($plato[23],22.17,22.4,22.68,23,23.36,23.76,24.21,24.69,25.21,25.75,26.33,26.94,27.57,28.22,28.9,29.59,30.3,31.04,31.8);
		array_push($plato[24],23.14,23.39,23.67,24,24.36,24.76,25.21,25.69,26.2,26.75,27.33,27.93,28.53,29.21,29.88,30.57,31.28,32.02,32.77);
		array_push($plato[25],24.12,24.38,24.67,25,25.36,25.77,26.21,26.69,27.2,27.74,28.32,28.92,29.55,30.19,30.86,31.55,32.26,32.99,33.74);
		array_push($plato[26],25.1,25.37,25.67,26,26.37,26.77,27.22,27.69,28.2,28.74,29.32,29.92,30.54,31.19,31.85,32.54,33.25,33.97,34.72);
		array_push($plato[27],26.1,26.37,26.67,27,27.37,27.78,28.22,28.7,29.2,29.74,30.32,30.92,31.54,32.18,32.84,33.53,34.23,34.96,35.7);
		array_push($plato[28],27.1,27.36,27.66,28,28.38,28.79,29.23,29.7,30.21,30.75,31.32,31.93,32.54,33.18,33.84,34.52,35.22,35.94,36.68);
		array_push($plato[29],28.1,28.36,28.66,29,29.38,29.79,30.24,30.71,31.21,31.76,32.33,32.93,33.54,34.17,34.83,35.51,36.2,36.92,37.65);
		array_push($plato[30],28.1,28.36,28.66,29,29.38,29.79,30.24,30.71,31.21,31.76,32.33,32.93,33.54,34.17,34.83,35.51,36.2,36.92,37.65);
		$a1=floor($plat);
		if ($a1<0){$a1=0;}
		if ($a1>29){$a1=29;}
		$a2=$a1+1;
		$k1=intdiv($temp,5);
		$k2=$k1+1;
		$x1=$k1*5;
		$x2=$k2*5;
		$y11=$plato[$a1][max($k1-1,0)];
		$y12=$plato[$a1][$k2-1];
		$y21=$plato[$a2][max($k1-1,0)];
		$y22=$plato[$a2][$k2-1];
		$m1=($y12-$y11)/($x2-$x1);
		$p1=$y11+($temp-$x1)*$m1;
		$m2=($y22-$y21)/($x2-$x1);
		$p2=$y21+($temp-$x1)*$m2;
		$m=($p2-$p1)/($a2-$a1);
		$p=$p1+$m*($plat-$a1);
	return $p;
	}
	
	
	public static function EBCrechner($paramstring){
		$sp=json_decode($paramstring,1);
		if (isset($sp['l_beercolorvalue']) AND $sp['l_beercolorvalue'])
		{
			return (int) $sp['l_beercolorvalue'];
		} else {
			$menge=0;
			for ($i = 1; $i <= 20; $i++) {
				if (isset($sp['l_malz'.$i.'menge'])) $menge=$menge+$sp['l_malz'.$i.'menge'];
			}
			if ($menge){
				$ebc=0;
				for ($i = 1; $i <= 20; $i++) {
					if (isset($sp['l_malz'.$i.'menge'])) {
						if (isset($sp['l_malz'.$i.'EBC'])) {
							$ebc=$ebc+$sp['l_malz'.$i.'menge']*$sp['l_malz'.$i.'EBC'];
						} else {
							return JText::_('COM_HBEERRECIPES_MALTEBCMISSING').$i;
						}
					}
				}
				$ebc=$ebc/$menge;
				$stammwuerze=self::getstammwuerze($paramstring);
				if (!$stammwuerze) $stammwuerze=12;
				$ebc=$ebc*$stammwuerze/9;
			} else {
				$ebc=0;
			}
			return (int) $ebc;
		}
	}
	
	

	public static function bierstyle($catid)
	{
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
			$query->select('a.title');
			$query->from($db->quoteName('#__categories').' AS a');
			$query->where('a.id='.(int)$catid);
			$db->setQuery($query);
			$item= $db->loadresult();
			return $item;
	}
	
	public static function IBUrechner($paramstring){
		$params=json_decode($paramstring, 1);
		$stammwuerze=self::getstammwuerze($paramstring);
		$ibu= new stdClass();
		if (isset($params['l_bitterevalue']) and $params['l_bitterevalue'])
		{
			$ibu->value=$params['l_bitterevalue'];
		} else {
			$ibu->value=0;
			if( $params["l_wuerzekochenendtime"]){
				$nitemp=$params["l_whirlpooltemp"];
				$kochzeit=date_diff(DateTime::createFromFormat('d.m.Y H:i:s', $params["l_wuerzekochenendtime"]),DateTime::createFromFormat('d.m.Y H:i:s',$params["l_wuerzekochenstarttime"]));
				$kochzeit=$kochzeit->h*60+$kochzeit->i;
				$volumen=$params["l_wuerzekochenendmenge"]*0.96;
				$nizeit=date_diff(DateTime::createFromFormat('d.m.Y H:i:s', $params["l_whirlpooltime"]),DateTime::createFromFormat('d.m.Y H:i:s',$params["l_wuerzekochenendtime"]));
				$nizeit=$nizeit->h*60+$nizeit->i;
				for ($x = 1; $x <= 21; $x++){
					if (isset($params["l_hop".$x."time"])){
						if (date_diff(DateTime::createFromFormat('d.m.Y H:i:s', $params["l_whirlpooltime"]),DateTime::createFromFormat('d.m.Y H:i:s',$params["l_hop".$x."time"] ))->invert){
							$hoptype=0;
							if (isset($params["l_hop".$x."type"]))$hoptype=$params["l_hop".$x."type"];;
							$hopmenge=$params["l_hop".$x."menge"];
							if ($hopmenge){
								if (isset($params["l_hop".$x.'saeure'])){
									$alphasaeure=$params["l_hop".$x.'saeure'];
									$hkochzeit=date_diff(DateTime::createFromFormat('d.m.Y H:i:s', $params["l_wuerzekochenendtime"]),DateTime::createFromFormat('d.m.Y H:i:s',$params["l_hop".$x."time"] ));
									$hkochzeit=min($hkochzeit->h*60+$hkochzeit->i,$kochzeit);
									if (($kochzeit-$hkochzeit)>=15) {
										$factor1=1.1;
									} else {
										$factor1=1;
									}
									if (!$hoptype) {
										$factor5=1.1;
									} else {
										$factor5=1;
									}
									$niaddontime=0.046* exp(0.031*$nitemp)*$nizeit;
									$factor2=$hopmenge*$alphasaeure*10/$volumen;
									$factor3=1.65*pow(0.000125,(0.004*$stammwuerze));
									$factor4=(1-exp(-0.04*($hkochzeit+$niaddontime)))/4.14;
									$ibux=$factor1*$factor2*$factor3*$factor4*$factor5;
									$ibu->value=$ibu->value+$ibux;
								} else {
									$ibu->value=0;
									$ibu->bittere='Alphasäuregehalt fehlt bei Hopfengabe '.$x;
									return $ibu;
								}
								
							}
						}
					}
				}
			}
		}
		$rel=$ibu->value/$stammwuerze;
		if ($rel>=4){
			$ibu->bittere='mega herb';
		} elseif ($rel>=3) {
			$ibu->bittere='sehr herb';
		} elseif ($rel>=2.5) {
			$ibu->bittere='moderat herb';
		} elseif ($rel>=1.5) {
			$ibu->bittere='ausgewogen';
		} elseif ($rel>=1) {
			$ibu->bittere='mild';
		} elseif ($rel<1) {
			$ibu->bittere='sehr mild';
		}
		return $ibu;
	}
	
	public static function alkoholrechner($paramstring){
		$params=json_decode($paramstring, 1);
		$stammwuerze=self::getstammwuerze($paramstring);
		$restextrakt=$stammwuerze;
		$i=0;
		while (isset($params['l_gaerstatus'.($i+1).'time'])) {$i++;}
		if ($i)	{$restextrakt=self::getcorrectedplato($params['l_gaerstatus'.($i).'temp'],$params['l_gaerstatus'.($i).'grad']);}
		$evg= new stdClass();;
		if ($stammwuerze){
			$evg->sevg=($stammwuerze - $restextrakt) * 100 / $stammwuerze;
			$evg->tevg=$evg->sevg*0.81;
			$evg->tre= 0.1808 *$stammwuerze + 0.8192 * $restextrakt;
			$dichte=261.1/(261.53-$restextrakt);
			$evg->alk=$dichte*($stammwuerze-$evg->tre)/(2.0665 - 0.010665 * $stammwuerze)/0.795;
			if(isset($params['l_zuckergabemenge'])) $evg->alk=$evg->alk+$params['l_zuckergabemenge']/20;
			if(isset($params['l_zuckerdosemenge'])) $evg->alk=$evg->alk+$params['l_zuckerdosemenge']/20;
			$evg->kcal=(6.9 * $evg->alk + 4 * ($evg->tre-0.1))* 10 * 0.1*$dichte ;//* $dichte;
			$evg->sw=$stammwuerze ;
			$evg->re=$restextrakt ;
		} else {
			$evg->sevg=0;
			$evg->tevg=0;
			$evg->tre= 0;
			$evg->kcal=0;
			$evg->alk=0 ;
			$evg->sw=0 ;
			$evg->re=0 ;
		}
		return $evg;
	}
	
	
	public static function getvergaerungsparams($params,$records){
		$result= new stdClass();
		$result->gaerdauer=0;
		if ($records) {		
			$maxi=$records[0];
			$mini=$records[count($records)-1];
			$maxparams=$maxi->params;
			$minparams=$mini->params;
			$pmaxi=self::getcorrectedplato($maxparams->temperature,IotHiotsHelper::tilttoplato($maxparams->angle,$params->a,$params->b,$params->c));
			$pmini=self::getcorrectedplato($minparams->temperature,IotHiotsHelper::tilttoplato($minparams->angle,$params->a,$params->b,$params->c));
			$paramstring='{"l_ausschlagwuerzegrad":'. $pmaxi .',"l_ausschlagwuerzetemp":20,"l_wuerzekochenendmenge":1,"l_gaerstatus1time":"31.10.2018 10:55:11","l_gaerstatus1temp":20,"l_gaerstatus1grad":'. $pmini .'}';
			$result=self::alkoholrechner($paramstring);//stdClass Object ( [sevg] => 0 [tevg] => 0 [tre] => 29 [alk] => 0 [kcal] => 115.6 ) 
			$result->gaerdauer= (strtotime($mini->tdate)-strtotime($maxi->tdate))/3600/24 ;
			$result->stammwuerze=$pmaxi;
			$result->restextract=$pmini; 
		}			
		return $result;
	}

	public static function kostenrechner($paramstring){
		$kostenobject= new stdClass();;
		$params=json_decode($paramstring, 1);
		$kosten=0;
		if (isset($params['l_wasseraufbereitungpreis']))$kosten=$params['l_wasseraufbereitungpreis'];
		for ($x = 1; $x <= 16; $x++){
			if (isset($params['l_malz'.$x.'price']))$kosten=$kosten+$params['l_malz'.$x.'price']*$params['l_malz'.$x.'menge'];
		}
		for ($x = 1; $x <= 20; $x++){
			if (isset($params['l_hop'.$x.'price']))$kosten=$kosten+$params['l_hop'.$x.'price']*$params['l_hop'.$x.'menge']/1000;
		}
		for ($x = 1; $x <= 16; $x++){
			if (isset($params['l_ing'.$x.'price']))$kosten=$kosten+$params['l_ing'.$x.'price']*$params['l_ing'.$x.'menge']/1000;
		}
		if (isset($params['l_yeastprice']))$kosten=$kosten+$params['l_yeastprice']*$params['l_yeastmenge'];
		$kostenobject->zutaten=round($kosten,2);
		$volume=0;
		$i=1;
		while (isset($params['l_abfuellung'.$i.'time'])) {
			$volume=$volume+$params['l_abfuellung'.($i).'menge']*$params['l_abfuellung'.($i).'volume'];
			$i++;
		}
		$kostenobject->abfuellung=round($volume,1);
		if (!$volume){
			$volume=$params['l_ausschlagwuerzemenge']*0.9;
		}
		$kostenobject->volume=$volume;
		$kostenobject->resources=round(3,2);
		$kostenobject->preisprovol=round(($kosten+$kostenobject->resources)/$volume,2);
	return $kostenobject;
	}
	
	
	public static function sudhausausbeute($paramstring){
		$params=json_decode($paramstring,1);
		$schuettung=0;
		for ($x = 1; $x <= 6; $x++) {
			if (isset($params['l_malz'.$x.'menge'])) $schuettung=$schuettung+(float)$params['l_malz'.$x.'menge'];
		}
		$stammwuerze=self::getstammwuerze($paramstring);
		$volumen=$params["l_wuerzekochenendmenge"];
		return  ( $stammwuerze *0.96/$schuettung* $volumen );
	}

	
	public static function speisegabe($targetcarb,$paramstring,$type){
		$brewlogarray=json_decode($paramstring, 1);
		
		$i=1;
		$temp=0;
		$stammwuerze=self::getstammwuerze($paramstring);
		$restextract=$stammwuerze;
		while (isset($brewlogarray['l_gaerstatus'.$i.'time'])){
			$temp=$temp+$brewlogarray['l_gaerstatus'.$i.'temp'];
			
			$restextract=self::getcorrectedplato($brewlogarray['l_gaerstatus'.$i.'temp'],$brewlogarray['l_gaerstatus'.$i.'grad']);
			$i++;
		}
		if ($i>1) $temp=$temp/($i-1);
		$co2_0pressure = 10.13 * exp(-10.73797 + (2617.25 / ($temp + 273.15)));
		if(!$targetcarb){
			$targetcarb=5.5;
		}
		$co2_difference = $targetcarb - $co2_0pressure;
		if (!$type){
			$speisegehalt = $stammwuerze * 8.1 * (1 - ($restextract / $stammwuerze));
			$puresuggar=$co2_difference/0.5;
			if ($speisegehalt) return Round(1000 * $puresuggar / $speisegehalt); else return 0;
		} else {
			if ($type==1){
				$puresuggar=$co2_difference/0.51;
				
			} else {
				$puresuggar=$co2_difference/0.44;
			}	
			return round($puresuggar,1);
		}		
	}

	public static function getstammwuerze($paramstring){
		$brewlogarray=json_decode($paramstring, 1);
			$stammwuerze=self::getcorrectedplato($brewlogarray["l_ausschlagwuerzetemp"],$brewlogarray["l_ausschlagwuerzegrad"]);
			$wasserzugabe=0;
			if (isset($brewlogarray['l_wasserzugabe0time'])){
				$wasserzugabe=$brewlogarray['l_wasserzugabe0menge'];
			}
			$stammwuerze=$stammwuerze*$brewlogarray['l_wuerzekochenendmenge']*0.96/($brewlogarray['l_wuerzekochenendmenge']*0.96+$wasserzugabe);
		return $stammwuerze;
	}
	
	
	public static function karbonisierung($paramstring){
		$brewlogarray=json_decode($paramstring, 1);
		if (isset($brewlogarray['l_speisegabetime'])){
			$type=0;
			$gabe=$brewlogarray['l_speisegabemenge'];
		} else {
			if (isset($brewlogarray['l_zuckergabetime'])){
				$type=1;
				$gabe=$brewlogarray['l_zuckergabemenge'];
			} else {
				if (isset($brewlogarray['l_zuckerdosetime'])){
					$type=1;
					$gabe=$brewlogarray['l_zuckerdosemenge'];
				} else{
					$type=0;
					$gabe=0;
				}
			}
		}
		$i=0;
		$temp=0;
		$stammwuerze=self::getstammwuerze($paramstring);
		$restextract=$stammwuerze;
		while (isset($brewlogarray['l_gaerstatus'.($i+1).'time'])){
			$temp=$temp+$brewlogarray['l_gaerstatus'.($i+1).'temp'];
			
			$restextract=self::getcorrectedplato($brewlogarray['l_gaerstatus'.($i+1).'temp'],$brewlogarray['l_gaerstatus'.($i+1).'grad']);
			$i++;
		}
		if ($i) $temp=$temp/($i);
		$co2_0pressure = 10.13 * exp(-10.73797 + (2617.25 / ($temp + 273.15)));
		if (!$type){
			$speisegehalt = $stammwuerze * 8.1 * (1 - ($restextract / $stammwuerze));
			$puresuggar= $gabe/1000* $speisegehalt;
			$co2_difference=$puresuggar*0.5;
		} else {
			if ($type==1){
				$co2_difference=$gabe*0.51;
				
			} else {
				$co2_difference=$gabe*0.44;
			}	
		}		
		$targetcarb = $co2_difference  + $co2_0pressure;
		return round($targetcarb,2);
	}
	function EBCtocolor($color){
		$ebc=$this->getEBCarray();
		return $ebc[(int)$color][3];
	} 
	
	static 	function getebcarray(){
	$ebc[0]=array()	;	$plato=array(0,255,255,255,"#FFFFFF")	;	$ebc[0]=$plato;
	$ebc[1]=array()	;	$plato=array(1,255,250,198,"#FFFAC6")	;	$ebc[1]=$plato;
	$ebc[2]=array()	;	$plato=array(2,255,246,149,"#FFF695")	;	$ebc[2]=$plato;
	$ebc[3]=array()	;	$plato=array(3,255,241,94,"#FFF15E")	;	$ebc[3]=$plato;
	$ebc[4]=array()	;	$plato=array(4,255,225,74,"#FFE14A")	;	$ebc[4]=$plato;
	$ebc[5]=array()	;	$plato=array(5,255,206,57,"#FFCE39")	;	$ebc[5]=$plato;
	$ebc[6]=array()	;	$plato=array(6,255,188,37,"#FFBC25")	;	$ebc[6]=$plato;
	$ebc[7]=array()	;	$plato=array(7,255,168,16,"#FFA810")	;	$ebc[7]=$plato;
	$ebc[8]=array()	;	$plato=array(8,255,154,0,"#FF9A0")	;	$ebc[8]=$plato;
	$ebc[9]=array()	;	$plato=array(9,251,150,0,"#FB960")	;	$ebc[9]=$plato;
	$ebc[10]=array()	;	$plato=array(10,247,147,0,"#F7930")	;	$ebc[10]=$plato;
	$ebc[11]=array()	;	$plato=array(11,243,142,0,"#F38E0")	;	$ebc[11]=$plato;
	$ebc[12]=array()	;	$plato=array(12,237,140,0,"#ED8C0")	;	$ebc[12]=$plato;
	$ebc[13]=array()	;	$plato=array(13,233,136,0,"#E9880")	;	$ebc[13]=$plato;
	$ebc[14]=array()	;	$plato=array(14,229,132,0,"#E5840")	;	$ebc[14]=$plato;
	$ebc[15]=array()	;	$plato=array(15,226,129,0,"#E2810")	;	$ebc[15]=$plato;
	$ebc[16]=array()	;	$plato=array(16,221,126,0,"#DD7E0")	;	$ebc[16]=$plato;
	$ebc[17]=array()	;	$plato=array(17,218,124,0,"#DA7C0")	;	$ebc[17]=$plato;
	$ebc[18]=array()	;	$plato=array(18,214,119,0,"#D6770")	;	$ebc[18]=$plato;
	$ebc[19]=array()	;	$plato=array(19,211,111,0,"#D36F0")	;	$ebc[19]=$plato;
	$ebc[20]=array()	;	$plato=array(20,204,101,0,"#CC650")	;	$ebc[20]=$plato;
	$ebc[21]=array()	;	$plato=array(21,203,89,0,"#CB590")	;	$ebc[21]=$plato;
	$ebc[22]=array()	;	$plato=array(22,199,79,0,"#C74F0")	;	$ebc[22]=$plato;
	$ebc[23]=array()	;	$plato=array(23,194,70,0,"#C2460")	;	$ebc[23]=$plato;
	$ebc[24]=array()	;	$plato=array(24,192,62,0,"#C03E0")	;	$ebc[24]=$plato;
	$ebc[25]=array()	;	$plato=array(25,186,49,0,"#BA310")	;	$ebc[25]=$plato;
	$ebc[26]=array()	;	$plato=array(26,181,43,0,"#B52B0")	;	$ebc[26]=$plato;
	$ebc[27]=array()	;	$plato=array(27,177,41,0,"#B1290")	;	$ebc[27]=$plato;
	$ebc[28]=array()	;	$plato=array(28,171,39,0,"#AB270")	;	$ebc[28]=$plato;
	$ebc[29]=array()	;	$plato=array(29,165,37,0,"#A5250")	;	$ebc[29]=$plato;
	$ebc[30]=array()	;	$plato=array(30,161,34,0,"#A1220")	;	$ebc[30]=$plato;
	$ebc[31]=array()	;	$plato=array(31,155,32,0,"#9B200")	;	$ebc[31]=$plato;
	$ebc[32]=array()	;	$plato=array(32,149,31,0,"#951F0")	;	$ebc[32]=$plato;
	$ebc[33]=array()	;	$plato=array(33,143,28,0,"#8F1C0")	;	$ebc[33]=$plato;
	$ebc[34]=array()	;	$plato=array(34,140,26,0,"#8C1A0")	;	$ebc[34]=$plato;
	$ebc[35]=array()	;	$plato=array(35,134,24,0,"#86180")	;	$ebc[35]=$plato;
	$ebc[36]=array()	;	$plato=array(36,130,21,0,"#82150")	;	$ebc[36]=$plato;
	$ebc[37]=array()	;	$plato=array(37,124,18,0,"#7C120")	;	$ebc[37]=$plato;
	$ebc[38]=array()	;	$plato=array(38,119,16,0,"#77100")	;	$ebc[38]=$plato;
	$ebc[39]=array()	;	$plato=array(39,114,14,0,"#72E0")	;	$ebc[39]=$plato;
	$ebc[40]=array()	;	$plato=array(40,107,11,0,"#6BB0")	;	$ebc[40]=$plato;
	$ebc[41]=array()	;	$plato=array(41,103,11,0,"#67B0")	;	$ebc[41]=$plato;
	$ebc[42]=array()	;	$plato=array(42,96,7,0,"#6070")	;	$ebc[42]=$plato;
	$ebc[43]=array()	;	$plato=array(43,92,4,0,"#5C40")	;	$ebc[43]=$plato;
	$ebc[44]=array()	;	$plato=array(44,86,2,0,"#5620")	;	$ebc[44]=$plato;
	$ebc[45]=array()	;	$plato=array(45,81,0,0,"#5100")	;	$ebc[45]=$plato;
	$ebc[46]=array()	;	$plato=array(46,78,0,0,"#4E00")	;	$ebc[46]=$plato;
	$ebc[47]=array()	;	$plato=array(47,75,0,0,"#4B00")	;	$ebc[47]=$plato;
	$ebc[48]=array()	;	$plato=array(48,72,0,0,"#4800")	;	$ebc[48]=$plato;
	$ebc[49]=array()	;	$plato=array(49,70,0,0,"#4600")	;	$ebc[49]=$plato;
	$ebc[50]=array()	;	$plato=array(50,68,0,0,"#4400")	;	$ebc[50]=$plato;
	$ebc[51]=array()	;	$plato=array(51,68,0,0,"#4400")	;	$ebc[51]=$plato;
	$ebc[52]=array()	;	$plato=array(52,66,0,0,"#4200")	;	$ebc[52]=$plato;
	$ebc[53]=array()	;	$plato=array(53,66,0,0,"#4200")	;	$ebc[53]=$plato;
	$ebc[54]=array()	;	$plato=array(54,66,0,0,"#4200")	;	$ebc[54]=$plato;
	$ebc[55]=array()	;	$plato=array(55,65,0,0,"#4100")	;	$ebc[55]=$plato;
	$ebc[56]=array()	;	$plato=array(56,65,0,0,"#4100")	;	$ebc[56]=$plato;
	$ebc[57]=array()	;	$plato=array(57,65,0,0,"#4100")	;	$ebc[57]=$plato;
	$ebc[58]=array()	;	$plato=array(58,64,0,0,"#4000")	;	$ebc[58]=$plato;
	$ebc[59]=array()	;	$plato=array(59,64,0,0,"#4000")	;	$ebc[59]=$plato;
	$ebc[60]=array()	;	$plato=array(60,64,0,0,"#4000")	;	$ebc[60]=$plato;
	$ebc[61]=array()	;	$plato=array(61,63,0,0,"#3F00")	;	$ebc[61]=$plato;
	$ebc[62]=array()	;	$plato=array(62,63,0,0,"#3F00")	;	$ebc[62]=$plato;
	$ebc[63]=array()	;	$plato=array(63,63,0,0,"#3F00")	;	$ebc[63]=$plato;
	$ebc[64]=array()	;	$plato=array(64,62,0,0,"#3E00")	;	$ebc[64]=$plato;
	$ebc[65]=array()	;	$plato=array(65,62,0,0,"#3E00")	;	$ebc[65]=$plato;
	$ebc[66]=array()	;	$plato=array(66,62,0,0,"#3E00")	;	$ebc[66]=$plato;
	$ebc[67]=array()	;	$plato=array(67,61,0,0,"#3D00")	;	$ebc[67]=$plato;
	$ebc[68]=array()	;	$plato=array(68,61,0,0,"#3D00")	;	$ebc[68]=$plato;
	$ebc[69]=array()	;	$plato=array(69,61,0,0,"#3D00")	;	$ebc[69]=$plato;
	$ebc[70]=array()	;	$plato=array(70,61,0,0,"#3D00")	;	$ebc[70]=$plato;
	$ebc[71]=array()	;	$plato=array(71,60,0,0,"#3C00")	;	$ebc[71]=$plato;
	$ebc[72]=array()	;	$plato=array(72,60,0,0,"#3C00")	;	$ebc[72]=$plato;
	$ebc[73]=array()	;	$plato=array(73,59,0,0,"#3B00")	;	$ebc[73]=$plato;
	$ebc[74]=array()	;	$plato=array(74,59,0,0,"#3B00")	;	$ebc[74]=$plato;
	$ebc[75]=array()	;	$plato=array(75,58,0,0,"#3A00")	;	$ebc[75]=$plato;
	$ebc[76]=array()	;	$plato=array(76,58,0,0,"#3A00")	;	$ebc[76]=$plato;
	$ebc[77]=array()	;	$plato=array(77,57,0,0,"#3900")	;	$ebc[77]=$plato;
	$ebc[78]=array()	;	$plato=array(78,57,0,0,"#3900")	;	$ebc[78]=$plato;
	$ebc[79]=array()	;	$plato=array(79,56,0,0,"#3800")	;	$ebc[79]=$plato;
	$ebc[80]=array()	;	$plato=array(80,56,0,0,"#3800")	;	$ebc[80]=$plato;
	$ebc[81]=array()	;	$plato=array(81,56,0,0,"#3800")	;	$ebc[81]=$plato;
	$ebc[82]=array()	;	$plato=array(82,56,0,0,"#3800")	;	$ebc[82]=$plato;
	$ebc[83]=array()	;	$plato=array(83,55,0,0,"#3700")	;	$ebc[83]=$plato;
	$ebc[84]=array()	;	$plato=array(84,55,0,0,"#3700")	;	$ebc[84]=$plato;
	$ebc[85]=array()	;	$plato=array(85,55,0,0,"#3700")	;	$ebc[85]=$plato;
	$ebc[86]=array()	;	$plato=array(86,55,0,0,"#3700")	;	$ebc[86]=$plato;
	$ebc[87]=array()	;	$plato=array(87,54,0,0,"#3600")	;	$ebc[87]=$plato;
	$ebc[88]=array()	;	$plato=array(88,54,0,0,"#3600")	;	$ebc[88]=$plato;
	$ebc[89]=array()	;	$plato=array(89,54,0,0,"#3600")	;	$ebc[89]=$plato;
	$ebc[90]=array()	;	$plato=array(90,54,0,0,"#3600")	;	$ebc[90]=$plato;
	$ebc[91]=array()	;	$plato=array(91,53,0,0,"#3500")	;	$ebc[91]=$plato;
	$ebc[92]=array()	;	$plato=array(92,53,0,0,"#3500")	;	$ebc[92]=$plato;
	$ebc[93]=array()	;	$plato=array(93,53,0,0,"#3500")	;	$ebc[93]=$plato;
	$ebc[94]=array()	;	$plato=array(94,52,0,0,"#3400")	;	$ebc[94]=$plato;
	$ebc[95]=array()	;	$plato=array(95,52,0,0,"#3400")	;	$ebc[95]=$plato;
	$ebc[96]=array()	;	$plato=array(96,52,0,0,"#3400")	;	$ebc[96]=$plato;
	$ebc[97]=array()	;	$plato=array(97,51,0,0,"#3300")	;	$ebc[97]=$plato;
	$ebc[98]=array()	;	$plato=array(98,51,0,0,"#3300")	;	$ebc[98]=$plato;
	$ebc[99]=array()	;	$plato=array(99,51,0,0,"#3300")	;	$ebc[99]=$plato;
	$ebc[100]=array()	;	$plato=array(100,50,0,0,"#3200")	;	$ebc[100]=$plato;
	$ebc[101]=array()	;	$plato=array(101,50,0,0,"#3200")	;	$ebc[101]=$plato;
	$ebc[102]=array()	;	$plato=array(102,49,0,0,"#3100")	;	$ebc[102]=$plato;
	$ebc[103]=array()	;	$plato=array(103,49,0,0,"#3100")	;	$ebc[103]=$plato;
	$ebc[104]=array()	;	$plato=array(104,49,0,0,"#3100")	;	$ebc[104]=$plato;
	$ebc[105]=array()	;	$plato=array(105,48,0,0,"#3000")	;	$ebc[105]=$plato;
	$ebc[106]=array()	;	$plato=array(106,48,0,0,"#3000")	;	$ebc[106]=$plato;
	$ebc[107]=array()	;	$plato=array(107,48,0,0,"#3000")	;	$ebc[107]=$plato;
	$ebc[108]=array()	;	$plato=array(108,47,0,0,"#2F00")	;	$ebc[108]=$plato;
	$ebc[109]=array()	;	$plato=array(109,47,0,0,"#2F00")	;	$ebc[109]=$plato;
	$ebc[110]=array()	;	$plato=array(110,46,0,0,"#2E00")	;	$ebc[110]=$plato;
	$ebc[111]=array()	;	$plato=array(111,46,0,0,"#2E00")	;	$ebc[111]=$plato;
	$ebc[112]=array()	;	$plato=array(112,45,0,0,"#2D00")	;	$ebc[112]=$plato;
	$ebc[113]=array()	;	$plato=array(113,45,0,0,"#2D00")	;	$ebc[113]=$plato;
	$ebc[114]=array()	;	$plato=array(114,45,0,0,"#2D00")	;	$ebc[114]=$plato;
	$ebc[115]=array()	;	$plato=array(115,44,0,0,"#2C00")	;	$ebc[115]=$plato;
	$ebc[116]=array()	;	$plato=array(116,44,0,0,"#2C00")	;	$ebc[116]=$plato;
	$ebc[117]=array()	;	$plato=array(117,44,0,0,"#2C00")	;	$ebc[117]=$plato;
	$ebc[118]=array()	;	$plato=array(118,43,0,0,"#2B00")	;	$ebc[118]=$plato;
	$ebc[119]=array()	;	$plato=array(119,43,0,0,"#2B00")	;	$ebc[119]=$plato;
	$ebc[120]=array()	;	$plato=array(120,43,0,0,"#2B00")	;	$ebc[120]=$plato;
	$ebc[121]=array()	;	$plato=array(121,42,0,0,"#2A00")	;	$ebc[121]=$plato;
	$ebc[122]=array()	;	$plato=array(122,42,0,0,"#2A00")	;	$ebc[122]=$plato;
	$ebc[123]=array()	;	$plato=array(123,42,0,0,"#2A00")	;	$ebc[123]=$plato;
	$ebc[124]=array()	;	$plato=array(124,41,0,0,"#2900")	;	$ebc[124]=$plato;
	$ebc[125]=array()	;	$plato=array(125,41,0,0,"#2900")	;	$ebc[125]=$plato;
	$ebc[126]=array()	;	$plato=array(126,41,0,0,"#2900")	;	$ebc[126]=$plato;
	$ebc[127]=array()	;	$plato=array(127,40,0,0,"#2800")	;	$ebc[127]=$plato;
	$ebc[128]=array()	;	$plato=array(128,40,0,0,"#2800")	;	$ebc[128]=$plato;
	$ebc[129]=array()	;	$plato=array(129,40,0,0,"#2800")	;	$ebc[129]=$plato;
	$ebc[130]=array()	;	$plato=array(130,39,0,0,"#2700")	;	$ebc[130]=$plato;
	$ebc[131]=array()	;	$plato=array(131,39,0,0,"#2700")	;	$ebc[131]=$plato;
	$ebc[132]=array()	;	$plato=array(132,38,0,0,"#2600")	;	$ebc[132]=$plato;
	$ebc[133]=array()	;	$plato=array(133,38,0,0,"#2600")	;	$ebc[133]=$plato;
	$ebc[134]=array()	;	$plato=array(134,37,0,0,"#2500")	;	$ebc[134]=$plato;
	$ebc[135]=array()	;	$plato=array(135,37,0,0,"#2500")	;	$ebc[135]=$plato;
	$ebc[136]=array()	;	$plato=array(136,37,0,0,"#2500")	;	$ebc[136]=$plato;
	$ebc[137]=array()	;	$plato=array(137,36,0,0,"#2400")	;	$ebc[137]=$plato;
	$ebc[138]=array()	;	$plato=array(138,36,0,0,"#2400")	;	$ebc[138]=$plato;
	$ebc[139]=array()	;	$plato=array(139,36,0,0,"#2400")	;	$ebc[139]=$plato;
	$ebc[140]=array()	;	$plato=array(140,35,0,0,"#2300")	;	$ebc[140]=$plato;
	$ebc[141]=array()	;	$plato=array(141,35,0,0,"#2300")	;	$ebc[141]=$plato;
	$ebc[142]=array()	;	$plato=array(142,34,0,0,"#2200")	;	$ebc[142]=$plato;
	$ebc[143]=array()	;	$plato=array(143,34,0,0,"#2200")	;	$ebc[143]=$plato;
	$ebc[144]=array()	;	$plato=array(144,34,0,0,"#2200")	;	$ebc[144]=$plato;
	$ebc[145]=array()	;	$plato=array(145,33,0,0,"#2100")	;	$ebc[145]=$plato;
	$ebc[146]=array()	;	$plato=array(146,33,0,0,"#2100")	;	$ebc[146]=$plato;
	$ebc[147]=array()	;	$plato=array(147,32,0,0,"#2000")	;	$ebc[147]=$plato;
	$ebc[148]=array()	;	$plato=array(148,32,0,0,"#2000")	;	$ebc[148]=$plato;
	$ebc[149]=array()	;	$plato=array(149,32,0,0,"#2000")	;	$ebc[149]=$plato;
	$ebc[150]=array()	;	$plato=array(150,31,0,0,"#1F00")	;	$ebc[150]=$plato;
	$ebc[200]=array()	;	$plato=array(200,21,0,0,"#1500")	;	$ebc[200]=$plato;
	$ebc[250]=array()	;	$plato=array(250,14,0,0,"#E00")	;	$ebc[250]=$plato;
	$ebc[300]=array()	;	$plato=array(300,0,0,0,"#000")	;	$ebc[300]=$plato;
	;
		return $ebc;
	} 
	

	public static function labelzeile1($paramstring,$catid) {
		$params=json_decode($paramstring);
		$biertitle=''.JText::_($params->l_biernamentitle).'';
		$bierstil=' ('.JText::_(self::bierstyle($catid)).') ';//;
		$line1=$biertitle.$bierstil;
		return $line1;
	}
	
	public static function labelzeile2($paramstring) {
		$params=json_decode($paramstring);
		if($params->l_wuerzekochenendtime and isset($params->l_anstellwuerzetemp) and isset($params->l_anstellwuerzegrad)){
			$ww=self::getcorrectedplato($params->l_anstellwuerzetemp,$params->l_anstellwuerzegrad);
			$stammwuerze=JText::_('COM_HBEERRECIPES_ORIGINAL_GRAVITY').': '.number_format($ww,1).'%, ';
			if (!$ww){
				$stammwuerze=JText::_('COM_HBEERRECIPES_ORIGINAL_GRAVITY').': '.number_format(self::getcorrectedplato($params->l_ausschlagwuerzetemp,$params->l_ausschlagwuerzegrad),1).'%, ';
			}
		} else
		{$stammwuerze='';}
		$bieralk=JText::_('COM_HBEERRECIPES_ABV').': '.number_format(self::alkoholrechner($paramstring)->alk,1).' vol%, ';
		$brennwert=' '.number_format(self::alkoholrechner($paramstring)->kcal,0).' kcal/100g ('.
			number_format(self::alkoholrechner($paramstring)->kcal*4.18684,0). 'kJ/100g) ';
		$gebraut=' ';	
		if ($params->l_yeasttime){
				$gebraut=JText::_('COM_HBEERRECIPES_BREWED').' '.DateTime::createFromFormat('d.m.Y H:i:s', $params->l_yeasttime)->format('d.m');
		}
		$abgefuellt='';
		if ($params->l_gaerenendtime){
				$abgefuellt='/'.DateTime::createFromFormat('d.m.Y H:i:s', $params->l_gaerenendtime)->format('d.m.Y').' - ';
		}
		$bierfarbe=Jtext::_('COM_HBEERRECIPES_COLOR').': '.number_format(self::EBCrechner($paramstring),0).' EBC, ';
		$bierbittere=Jtext::_('COM_HBEERRECIPES_BITTERNESS').': '.number_format(self::IBUrechner($paramstring)->value,0).' IBU, '; 
		$line2=$gebraut.$abgefuellt.$stammwuerze.$bieralk.$bierfarbe.$bierbittere.$brennwert;
		return $line2;
	}

	public static function labelzeile3($paramstring) {
		$params=json_decode($paramstring,1);
		$line3=Jtext::_('COM_HBEERRECIPES_INGREDIENS').':'.Jtext::_('COM_HBEERRECIPES_GRAINBILL').':';
		$i=1;
		while (isset($params["l_malz".$i."time"])){  
			$line3=$line3.' '.$params["l_malz".$i."title"].',';
			$i=$i+1;
		}	
		$i=1;
		$line3=trim($line3,',').' - '.Jtext::_('COM_HBEERRECIPES_HOPS').':';
		while (isset($params["l_hop".$i."time"])){  
			$line3=$line3.' '.$params["l_hop".$i."title"].',';
			$i=$i+1;
		}	
		$line3=trim($line3,',');
		return $line3;
	}

}

