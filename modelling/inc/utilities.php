<?php
if(!defined('CP_MODELLING_RUNNING')){
    exit(1);
}

require_once 'constants.php';
class utilities{
    # stores the api address (read from environment variable that is set up in apache conf)
    protected $api='';
    # stores the api key for getting design collateral (read from environment variable that is set up in apache conf)
    protected $key='';
    
    public function __construct() {
       # $this->api=getenv('cupprint-api');
       # $this->key=getenv('cupprint-key');
        $this->api=CP_API_ENDPOINT;
        $this->key=CP_API_KEY;
        $message="api ". $this->api . "  and key " . $this->key;
        error_log($message);
    }
    
    
    
    
    
    
    /**
     * Returns html needed to render 3D proof
     * @return string
     */
    public function renderDesign(){
        $result = $this->getDesignCollateral();
        
        $scene=$result['design3d'];
        $source=$result['url'].$result['designSource'];
        
        $html='<div class="wrapModelArea" data-caption="'. $result['designName'].'">';
        
        
        $html.='    <div class="panel panel-default">';
        $html.='        <div class="panel-body">';
        $html.='            <div class="wrapModel" data-address="' . $result['url'] . '" data-source="' . $source. '" data-scene="' . $scene. '">';
        $html.='        	   <canvas id="modelCanvas"></canvas>';
        $html.='            </div>';
        $html.='        </div>';
        $html.='    </div>';
        
        $html.='</div>';
        return $html; 
        
    }
    
    
    
    
    
    /**
     * Returns the design collateral requested
     */
    private function getDesignCollateral(){
        $result=[];
        # validate that we have valid query
        $md=$this->checkForValue($_REQUEST, 'k', '');
        if (strlen($md)!=32){
            # invalid - exit
            return $result;
        }
        $params=[];
        $params['hash']=$md;
        
        
        $url=$this->api . 'model/';
        $data=$this->put($this->key, $url, $params);
        
        return $data;
        
    }
    
    
    
    
    
    /**
     * Checks passed object to see if requested key exists and returns it's value if it does, if not returns the default proposed
     * @param unknown $postedData
     * @param unknown $key
     * @param unknown $default
     * @return unknown
     */
    private function checkForValue($postedData,$key, $default){
        $return=$default;
        if ( isset( $postedData[$key] ) ) {
            $return=$postedData[$key];
        }
        return $return;
    }
    
       /**
     * Execute a PUT
     * @param unknown $key
     * @param unknown $url
     * @param unknown $fields
     * @return boolean|mixed
     */
    private function put($key,$url,$fields){
        $result=false;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_HTTPHEADER => array(
                "api-key: " . $key,
                "Cache-Control: no-cache",
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
        #echo 'url:' . $url;
        
        $response = curl_exec($curl);
        #var_dump($response);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            $message=print_r( $err, true );
            error_log($message);
            
        } else {
            $result=json_decode($response,true);
        }
        return $result;
    }
    
    
    
}