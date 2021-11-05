<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

	JLoader::register('CommonHogehsHelper', JPATH_COMPONENT.'/helpers/common.php');
	JLoader::register('BrewerHbeerrecipesHelper',  JPATH_COMPONENT.'/helpers/brewer.php');
/**
 * Hiots Component Helper.
 *
 * @since  1.5
 */
class IotHiotsHelper{

	public static function tilttoplato($tilt,$a,$b,$c)
	{
		if ($tilt){
			$plato=$a*pow($tilt,2)+$b*$tilt+$c;
		} else $plato=0;
		return $plato;
	}



	public static function show_meshcontroller_graph($itemid,$records){
		$graphdata='';
		foreach ($records as $i=>$record){
			$date1=strtotime( $record->tdate);
			if (isset($record->params->current_status))$status=$record->params->current_status; else $status=0;
			$graphdata=$graphdata.self::makegraphdata($record->tdate,$record->params->temperature,$status);
		}
		$graphoptions=array();		
		array_push($graphoptions,"legend:{position: 'top'} ");
		array_push($graphoptions, 'height: 350');
		array_push($graphoptions, "courveType: 'function'");
		array_push($graphoptions, "interpolateNulls: 'true'");
//		array_push($graphoptions, "series: { 0: { lineDashStyle: [2, 2],lineWidth: 1 }}");
//		array_push($graphoptions, "vAxes: {0: {title: '".JText::_('COM_HIOTS_TEMPERATURE')."'}}");
		array_push($graphoptions,"colors: ['blue','green']");
		self::preparegraph($graphoptions,$graphdata,JText::_('COM_HIOTS_TEMPERATURE'),JText::_('COM_HIOTS_CURRENT_STATUS'),NULL,"LineChart", 'corechart',$itemid);
	}

	public static function show_heating_graph($itemid,$records){
		$graphdata='';
		$sumoff=0;
		$sumon=0;
		$oldtdate=0;
		foreach ($records as $i=>$record){
			$date1=JFactory::getDate($record->tdate);
			if (!$oldtdate) $oldtdate=$date1; 
			$diff = $date1->getTimestamp()-$oldtdate->getTimestamp();
			$oldtdate=$date1;
			if (isset($record->params->current_status))$status=$record->params->current_status; else $status=0;
			$graphdata=$graphdata.self::makegraphdata($record->tdate,$record->params->temperature,$status);
			if ($status) {
				$sumon=$sumon+$diff;
			} else { 
				$sumoff=$sumoff+$diff;
			}
		}
		$stati= new stdClass();
		$stati->sumon=$sumon;
		$stati->sumoff=$sumoff;
		$graphoptions=array();		
		array_push($graphoptions,"legend:{position: 'top'} ");
		array_push($graphoptions, 'height: 350');
		array_push($graphoptions, "courveType: 'function'");
		array_push($graphoptions, "interpolateNulls: 'true'");
//		array_push($graphoptions, "series: { 0: { lineDashStyle: [2, 2],lineWidth: 1 }}");
//		array_push($graphoptions, "vAxes: {0: {title: '".JText::_('COM_HIOTS_TEMPERATURE')."'}}");
		array_push($graphoptions,"colors: ['blue','green']");
		self::preparegraph($graphoptions,$graphdata,JText::_('COM_HIOTS_TEMPERATURE'),JText::_('COM_HIOTS_CURRENT_STATUS'),NULL,"LineChart", 'corechart',$itemid);
		return $stati;
	}


	
	public static function show_ispindel_graph($itemid,$params,$records){
		$graphdata='';
		$plato0=BrewerHbeerrecipesHelper::getcorrectedplato($records[0]->params->temperature, $params->a*pow($records[0]->params->angle,2)+$params->b*$records[0]->params->angle+$params->c);
		$date0=strtotime( $records[0]->tdate)-100;
		$di=13;
		foreach ($records as $i=>$record){
			$plato=BrewerHbeerrecipesHelper::getcorrectedplato($record->params->temperature, $params->a*pow($record->params->angle,2)+$params->b*$record->params->angle+$params->c);
			$date1=strtotime( $record->tdate);
			$gaerdauer=$date1-$date0 ;
			$dp=$plato0-$plato;
			$dpg=max($dp/$gaerdauer*3600*24,0);
			$graphdata=$graphdata.self::makegraphdata($record->tdate,$record->params->temperature,$plato,$dpg);
			if ($i>=$di){
				$plato0=BrewerHbeerrecipesHelper::getcorrectedplato($records[$i-$di]->params->temperature, $params->a*pow($records[$i-$di]->params->angle,2)+$params->b*$records[$i-$di]->params->angle+$params->c);
				$date0=strtotime( $records[$i-$di]->tdate)-100;
			}
		}
		$graphoptions=array();		
		array_push($graphoptions,"legend:{position: 'top'} ");
		array_push($graphoptions, 'height: 350');
		array_push($graphoptions, "courveType: 'function'");
		array_push($graphoptions, "interpolateNulls: 'true'");
		//array_push($graphoptions, "series: { 1: {targetAxisIndex: 0 },0:{targetAxisIndex: 1, lineDashStyle: [2, 2],lineWidth: 2},2: {targetAxisIndex: 0 }}");
		//array_push($graphoptions, "vAxes: {1: {title: 'Temps (Celsius)'}, 0: {title: '°Plato'}}");
		array_push($graphoptions,"colors: ['blue','red','green']");
		self::preparegraph($graphoptions,$graphdata,JText::_('COM_HIOTS_TEMPERATURE'),JText::_('COM_HIOTS_SPECIFIC_GRAVATY'),JText::_('COM_HIOTS_FERMENTAIONACTIVITY'),"LineChart", 'corechart',$itemid);
	}


	public static function makegraphdata($date,$param1,$param2=NULL,$param3=NULL){
			$date1=DateTime::createFromFormat('Y-m-d H:i:s', $date);
			$m=$date1->format('m') - 1;
			$retstring=",[new Date(	".$date1->format('Y').",".$m .",".$date1->format('d').",".$date1->format('H').",".$date1->format('i').",".$date1->format('s')."),".$param1;
			if (isset($param2)){ $retstring=$retstring.",".$param2;}
			if (isset($param3)){ $retstring=$retstring.",".$param3;}
			$retstring=$retstring."]";
			return $retstring;
		}
		
		

	/**
	 * Prepares the document
	 *
	 * @return  void
	 */
	
	protected static function preparegraph($graphoptions,$graphdata,$param1,$param2=NULL,$param3=NULL,$chart_gallery='LineChart',$package = 'corechart',$id=1)
	{
		$scripts='if(typeof google !== "undefined") google.load("visualization", "1", {packages:["' . $package . '"]});';
		$scripts=$scripts.'google.setOnLoadCallback(drawIOTChart'.$id . ');';
		$scripts=$scripts."function drawIOTChart" .$id. "() {
			var data = new google.visualization.DataTable();
				data.addColumn('datetime', 'Date');
				data.addColumn('number', '".$param1."');";
		if ($param2) $scripts=$scripts."data.addColumn('number', '".$param2."');";		
		if ($param3) $scripts=$scripts."data.addColumn('number', '".$param3."');";		
			 $scripts=$scripts."data.addRows([".trim($graphdata,',').']);			
			var options = {'.implode(',', $graphoptions).'};
			var chart = new google.visualization.' . $chart_gallery . '(document.getElementById("iotgraph'.$id . '"));
			chart.draw(data, options);
			}';
		$doc = JFactory::getDocument();
		$doc->addScript('https://www.google.com/jsapi');//Add chart api script
		$doc->addScriptDeclaration ($scripts);
	}

	public static function getminmaxavg($id,$session_id,$backviewdays=NULL)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('min(tilt) as mini,max(tilt) as maxi,s_id,avg(TO_SECONDS(tdate)) as avgx,avg(tilt)as avgy,min(TO_SECONDS(tdate)) as minx,max(TO_SECONDS(tdate)) as maxx,session_id,min(tdate),max(tdate)');
		$query->from($db->quoteName('#__hiots_records').' AS a');
		$query->where('s_id='.(int)$id);
		$query->where('session_id='.(int)$session_id);
		if ($backviewdays){
			$anfdatback= new JDate();
			$anfdatback= date_modify($anfdatback, '-'.($backviewdays).' day');
			$query->where('a.tdate >= "'.$anfdatback->format('Y-m-d H:i:s').'"');
		}		
		$query->group('s_id,session_id');
		$db->setQuery($query);
		$record= $db->loadobject();
		return $record;
	}
	
	public static function find_attached_IOT($userid,$sessionid,$devicetype=0){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('s_id');
		$query->From($db->quoteName('#__hiots_records'));
		$query->where('session_id = '.$sessionid);
		$query->where('state=1');
		$query->Group('s_id');
		try{
			$db->setQuery($query);
			$devicenosr=$db->loadobjectlist();
			if ($devicenosr){
				//print_r($devicenosr);exit;
				$deviceno=0;
				$devicenos= array();
				foreach ($devicenosr as $deviceno){
						array_push($devicenos,$deviceno->s_id);
				}
				
				if ($deviceno){
					$query = $db->getQuery(true);
					$query->select('*');
					$query->From($db->quoteName('#__hiots'));
					$query->where('created_by = '.(int)$userid);
					$query->where('iot_type = '.(int)$devicetype);
					$query->where('id IN ('.implode(',', $devicenos).')');
					try{
						$db->setQuery($query);
						$item=$db->loadObject();
						if ($item){
							$item->params=json_decode($item->params);
							return $item;
						} else return false;
					}catch (RuntimeException $e){
						JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'));
						return false;
					}
				} else return false;
			} else return false;
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'));
			return false;
		}
	}
	
	
	
	public static  function getrecords($s_id=NULL,$session_id,$backviewdays=NULL,$iot_type=NULL)
	{
		$timezone	= CommonHogehsHelper::getTimeZone();
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.*');
		$query->from($db->quoteName('#__hiots_records').' AS a');
		if ($backviewdays){
			$anfdatback= new JDate();
			$anfdatback= date_modify($anfdatback, '-'.($backviewdays).' day');
			$query->where('a.tdate >= "'.$anfdatback->format('Y-m-d H:i:s').'"');
		}		
		if (isset($s_id)) $query->where('s_id='.(int)$s_id);
		$query->where('a.state=1');
		$query->where('session_id = '.(int)$session_id);
		if (isset($iot_type)) $query->where('iot_type = '.(int)$iot_type);
		try{
			$db->setQuery($query);
			$records=$db->loadObjectlist();
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR1'));
			return false;
		}
		foreach ($records as $record){
			$record->params=json_decode($record->params);
			$record->tdate=CommonHogehsHelper::showlocaltime($timezone,NULL,$form='Y-m-d H:i:s',$record->tdate);
		}
		return $records;
	}
}

