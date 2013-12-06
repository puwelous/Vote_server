<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Survey_c extends REST_Controller
{
	function survey_get()
    {
        if (!$this->get('s_id'))
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_SURVEY_ID',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$survey = $this->survey_model->get_by_id( $this->get('s_id') );
    	
        if ($survey == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEY_BY_ID_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEY_BY_ID_FOUND',
				'v_data' => $survey
				), 
			200
			);
    }
    
    function user_post()
    {
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
    	//$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function surveys_get()
    {
		
		$all_surveys = $this->survey_model->get_all();
        
        if( $all_surveys == NULL )
        {
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'NO_SURVEYS_FOUND',
						'v_data' => NULL
						), 
					200
					);
		}else{
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'ALL_SURVEYS_FOUND',
						'v_data' => $all_surveys
						), 
					200
					);
		}
    }
    
    /*
     * Get all surveys which belong to certain user as creator.
     */ 
	function surveys_by_creator_get()
    {
        if (!$this->get('s_creator'))
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_CREATOR_ID',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$surveys = $this->survey_model->get_by_creator_id( $this->get('s_creator') );
    	
        if ($surveys == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEYS_BY_CREATOR_ID_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEYS_BY_CREATOR_ID_FOUND',
				'v_data' => $surveys
				), 
			200
			);
    } 
    
    
	function surveys_by_ids_get()
    {
        if ( !$this->get('k_name') )
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_KEYWORD_NAME',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$keywords_by_name = $this->keyword_model->get_by_name( $this->get('k_name') );
    	
    	// array of surveys' ids
    	$surveys_ids = array();
    	
    	//print_r( $keywords_by_name );
    	foreach ( $keywords_by_name as $single_keyword )
		{
			array_push($surveys_ids, $single_keyword->k_survey);
		}
    	
    	$surveys_by_ids = $this->survey_model->get_by_ids( $surveys_ids );
    	
    	//print_r( $surveys_by_ids );
    	
        if ($surveys_by_ids == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEYS_BY_IDS_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEYS_BY_IDS_FOUND',
				'v_data' => $surveys_by_ids
				), 
			200
			);
    }     


	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}
