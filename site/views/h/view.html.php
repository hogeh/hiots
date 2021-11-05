 <?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JLoader::register('CommonHogehsHelper', JPATH_SITE . '/components/com_hiots/helpers/common.php');
JLoader::register('IotHiotsHelper', JPATH_SITE . '/components/com_hiots/helpers/iot.php');
	
class hiotsViewH extends JViewLegacy
{

	protected $item;

	protected $return_page;

	protected $state;

	public function display($tpl = null)
	{
		$app 		= JFactory::getApplication();
		$data=$app->input;
		file_put_contents(JPATH_SITE . '/components/com_hiots/views/h/access5.log',var_export($data, FILE_APPEND));
		$data=$this->validate_input($data);
		if ($data){
			$this->process_iot_device_request($data);
		} else file_put_contents(JPATH_SITE . '/components/com_hiots/views/h/errorval.log', wh_log($data), FILE_APPEND);
 
	}
	
	public function wh_log($log_msg)
	{
		if (is_array($log_msg) || is_object($log_msg)) 
		{
			$dat='ARRAY{';
			foreach ($log_msg->post as  $key => $param ){
				 $dat=$dat.'"'.$key.'":"'.$param.'",';
			}
			$dat=$dat.'}';
			$log_msg=$dat;
		}
		return $log_msg;
	}		
	
	public function validate_input($postdata)
	{
		$inputdata=$postdata->post->getArray();
		if (isset($inputdata['name'])){
			$data=(object)$inputdata;
			$dat='{"status":"OK",time:'.date('Y-m-d h:m:s').'}';//
			return $data;
		} else{
			$data=json_decode(file_get_contents('php://input'));
//			$data=json_decode('{"name":"ispindelhogeh1","ID":3269282,"token":"12345","angle":57.47289,"temperature":24.1875,"temp_units":"C","battery":3.607925,"gravity":12.88377,"interval":20,"RSSI":-88}');
//			$data=json_decode('{"name":"IOThogeh1","ID":2,"token":"123456","current_status":1,"temperature":18.1875,"temp_units":"C","interval":20}');
			if (isset($data->name)){
				$dat='{"status":"OK",time:'.date('Y-m-d h:m:s').'}';//
				return $data;
			} else {
				$dat='{"status":"not OK","iot_action":0,"status_message":"No valid JSON string",time:'.date('Y-m-d h:m:s').'}';//
				echo $dat;
				file_put_contents(JPATH_SITE . '/components/com_hiots/views/h/error.log',$dat.json_encode($inputdata), FILE_APPEND);
				exit;
			}
		}
	}
	
	public function process_iot_device_request($data){
		$model=$this->getModel();
		$iot_device=$model->get_iot_device($data->name,$data->token);
		$iotaction=0;// default off
		$setinterval=60; //default
		$status_message='COM_HIOTS_NOSTATUS';
		if (isset($iot_device->pass) and $iot_device->pass){ //IOT device found in db and password valid
			if (isset($iot_device->params->setinterval)){
				$setinterval=$iot_device->params->setinterval;
			} 
			$status="OK";
			if ($iot_device->iot_type==0){ //if ispindel
					$status_message='COM_HIOTS_ISPINDEL_RECORD_RECORDED';
			}
			if (($iot_device->iot_type>=1) AND ($iot_device->iot_type<=3)){ //if mesh-controller OR HEATING OR COOLING
				$mode=$iot_device->params->mode;
				if ($mode==2){ //automatic mode
					if ($iot_device->iot_type==1){ //if mesh-controller
						$session_item=$model->get_iot_device_session($iot_device->params->current_session_id);
						if ($session_item){ //mesh controller connected to brew log
							$ret=$this->process_mesh_controller($model,$session_item,$data,$iot_device->params);
						} else {//mesh controller NOT connected to brew log
							$status="not OK";
							$status_message='COM_HIOTS_DEVICE_NOT_CONNECTED_TO_BREWLOG';
						}
					}
					if ($iot_device->iot_type==2){ //if heating
						$ret=$this->process_heating($data,$iot_device->params);
					}
					if ($iot_device->iot_type==3){ //if cooling
						$ret=$this->process_cooling($data,$iot_device->params);
					
					}
					$iotaction=$ret->action;
					$status_message=$ret->status_message;
				} else { //not automatic
					if ($mode==0){//always off
						$status_message='COM_HIOTS_ALWAYSOFF';
					} else {//always on
						$status_message='COM_HIOTS_ALWAYSON';
						$iotaction=1;// default off
					}
				}
			} 
		} else { //IOT Device not found or password invalid!
			$status="not OK";
			$status_message='COM_HIOTS_DEVICE_NOT_FOUND_OR_INVALID_TOKEN';
		}
		$statchange=false;
		if (isset($data->current_status)){
			if ($data->current_status<>$ret->action){
				$statchange=true;
			}
		}
		if ($this->store_this_value_to_detail_recs($iot_device,$data)||$statchange){
			$model->store_detail_device_record($iot_device,$data); //store detail record
			$stored=1;//update device status 
		} else {
			$stored=0;
		}
		$data->status_message=$status_message;
		$model->store_latest_value_to_device($iot_device,$data);
		echo '{"status":"'.$status.'","iot_action":'.$iotaction.',"setinterval":'.$setinterval.',"stored":'.(int)$stored.',"status_message":"'.Jtext::_($status_message).'"}'; //send action: 1=heating on, 0=heating off
		exit;  
	}
	
	public function store_this_value_to_detail_recs($iot_device,$data){
		$model=$this->getModel();
		$sm=$iot_device->params->storemode;
		if ($sm==0){ //never store
			return false;
		} else {
			if ($sm==1){//always store
				return true;
			} else{
				$params=$model->get_last_stored_record($iot_device->id);
				if ($sm>=10){
					$now=strtotime(JFactory::getDate()->toSql());
					$old=strtotime($params->tdate);
					$diff=$now-$old;
					if ($diff>$sm){
						return true;
				//		file_put_contents(JPATH_SITE . '/components/com_hiots/views/h/requests.log', $status_message, FILE_APPEND);
					}else{
						return false;
					}
				} else {
					$dangle=0;
					if (isset($params->angle)) $dangle=abs((float)$params->angle-(float)$data->angle);
					$dtemp=abs((float)$params->temperature-(float)$data->temperature);
					$asm=abs(1/$sm);
					if (($dangle>=$asm) OR ($dtemp>=$asm)){
						return true;
					} else {
						return false;
					}
				}
			}
		}
//		echo '<br>';print_r($iot_device);print_r($data);
	}
	
	public function process_heating($data,$params){
		$temperature=$data->temperature;
		if (isset($data->current_status)) $current_status=$data->current_status; else $current_status=1;
		$threshold=$params->threshold;
		$hysterese=$params->hysterese;
		if ($temperature<$threshold AND $current_status){
			$action="1"; //aufheizen
			$actionstring='COM_HIOTS_HEATUP_TO_THRESHOLD';
		} else {
			if ($current_status==1) //heating is on
			{
				$action="0"; //aufheizen ende
				$actionstring='COM_HIOTS_THRESHOLD_REACHED';
			} else {	
				if ($temperature<($threshold-$hysterese)) //heating is on
				{
					$action="1"; //aufheizen again
					$actionstring='COM_HIOTS_HEATUP_TO_KEEP_THRESHOLD';
				} else {				
					$action="0"; //wait
					$actionstring='COM_HIOTS_KEEP_THRESHOLD';
				}
			}
		}
		$ret =new stdClass();
		$ret->action=$action;
		$ret->status_message=$actionstring;
		return $ret;
	}
	
	public function process_cooling($data,$params){
		$temperature=$data->temperature;
		if (isset($data->current_status)) $current_status=$data->current_status; else $current_status=1;
		$threshold=$params->threshold;
		$hysterese=$params->hysterese;
		if ($temperature>$threshold AND $current_status){
			$action="1"; //cooling
			$actionstring='COM_HIOTS_COOLDOWN_TO_THRESHOLD';
		} else {
			if ($current_status==1) //cooling is on
			{
				$action="0"; //cooling end
				$actionstring='COM_HIOTS_THRESHOLD_REACHED';
			} else {	
				if ($temperature>($threshold+$hysterese)) //heating is on
				{
					$action="1"; //cooling again
					$actionstring='COM_HIOTS_COOL_TO_KEEP_THRESHOLD';
				} else {				
					$action="0"; //wait
					$actionstring='COM_HIOTS_KEEP_THRESHOLD';
				}
			}
		}
		$ret =new stdClass();
		$ret->action=$action;
		$ret->status_message=$actionstring;
		return $ret;
	}
	
	
	public function process_mesh_controller($model,$sessionitem,$data,$iotparams){
		$temperature=$data->temperature;
		$myTimezone = CommonHogehsHelper::getTimeZone();
	    $timeZone = JFactory::getConfig()->get('offset');
		$params=json_decode($sessionitem->params,1); //Current recipe parameters
		$sessionparams=json_decode($sessionitem->session_params,1); //Current brew log parameter
		if (isset($sessionparams["l_hauptgussstarttime"]) AND !isset($sessionparams["l_abmaischtime"])){ //if automatic process is started and not ended
			if (!isset($sessionparams["l_einmaischentime"])){ //if not yet eingemaischt
				$targettemp=$params["einmaischtemp"]; //then target temp is eimaischtemp
				if ($targettemp>$temperature){ // if current temp smaller than einmaischteim then
					$action="1"; //aufheizen
					$actionstring='COM_HIOTS_HEATUP_TO_MESHIN';
				} else {
					$action="0"; //else nicht heizen, einmaisch temp erreicht, wait for manual mesh-in button
					$actionstring='COM_HIOTS_MESHIN_TEMP_READY';
				}	
			} else { //if eingemaischt
				$i=1;
				while (isset($sessionparams["l_rast".$i."starttime"])){ //detect current Rast
					$i++;
				} // Current Rast = $i-1 .... next Rest = $i
				if (isset($sessionparams["l_rast".($i-1)."endtime"]) or (($i==1) AND isset($sessionparams["l_hauptgussstarttime"]))){//if current rest is done or just meshed-in
					if(($params["rast".$i])){ //if next rest i finds in recipe
						$targettemp=$params["rast".$i]; //then target temp is: next rast temp
						if ($targettemp>$temperature){ // if current temp smaller than next rast temp then
							$action="1"; //aufheizenheizen
							$actionstring='COM_HIOTS_HEATUP_TO_REST'.($i);
						} else {
							$action="0"; //aufheizen ende 
							$sessionparams["l_rast".($i)."starttime"]=JFactory::getDate('now')->format( 'd.m.Y H:i:s'); //start Rast
							$sessionparams["l_rast".($i)."starttemp"]=$temperature;
							$model->saveautoparam($sessionitem->id,$sessionparams); //mark in brew log
							$actionstring='COM_HIOTS_KEEP_REST_TEMP'.($i);
						}	
					} else { //no further rest inrecipe -> mesh out
						$targettemp=$params["abmaischtemp"]; //then abmaischen
						if ($targettemp>$temperature){// if current temp smaller than mesh-out then
							$action="1"; //aufheizen
							$actionstring='COM_HIOTS_HEATUP_FOR_MESHOUT';
						} else {
							$action="0"; //aufheizen ende, wait for mesh out button manually to end process
							$actionstring='COM_HIOTS_MESHOUT_TEMP_READY';
						}	
					} 
				} else { //Current Rast end not reached (Rast ongoing....)
					$starttime=DateTime::createFromFormat('d.m.Y H:i:s',$sessionparams["l_rast".($i-1)."starttime"],new DateTimeZone($timeZone));
					$currenttime= JFactory::getDate();
					$currenttime->setTimezone($myTimezone);
					$diff=date_diff($starttime,$currenttime);
					$diffmin=$diff->s/60+$diff->i+$diff->h*60+$diff->d*24; //current Rast duration in Min
					if ($diffmin>$params["rast".($i-1).'dauer']){ //if rest time is over
						if(($params["rast".$i])){ //if next rest i finds in recipe
							$targettemp=$params["rast".$i]; //then target temp is: rasttemp
						} else { //if no further Rest in recipe
							$targettemp=$params["abmaischtemp"]; //then abmaischen
						}
						if ($targettemp>$temperature){// if current temp smaller than next rast or mesh-out temp then
							$action="1"; //aufheizen
							$actionstring='COM_HIOTS_HEATUP_FOR_NEXTSTEP';
						} else {
							$action="0"; //aufheizen ende
							$actionstring='COM_HIOTS_READY_FOR_NEXTSTEP';
						}
						$sessionparams["l_rast".($i-1)."endtime"]=JFactory::getDate('now')->format( 'd.m.Y H:i:s');
						$sessionparams["l_rast".($i-1)."endtemp"]=$temperature;
						$model->saveautoparam($sessionitem->id,$sessionparams);//mark in brew log
					} else { //if rest time is not yet over....Rest ongoing...
						$targettemp=$params["rast".($i-1)]; //then target temp is: rasttemp
						if ($targettemp>$temperature){
							$action="1"; //heizen
							$actionstring='COM_HIOTS_HEATUP_WITHIN_REST'.($i-1);
						} else {
							$action="0"; //heizen ende
							$actionstring='COM_HIOTS_HOLD_TEMP_IN_REST'.($i-1);
						}
					}	
				}
			}
		}  else {//if automatic process is not started and ended 
			$action='0';
			if (!isset($sessionparams["l_abmaischtime"])){
				$actionstring='COM_HIOTS_MESH_PROCESS_NOT_YET_STARTED';
			}else{
				$actionstring='COM_HIOTS_MESH_PROCESS_ENDED';
			}	
				
		}
		$ret =new stdClass();
		$ret->action=$action;
		$ret->status_message=$actionstring;
		return $ret;
	}		



	
		
	
	
		
	

	
	
	
	

}
