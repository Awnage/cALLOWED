<?php

require 'setup.php';
require_once 'Zend/Cache.php';


$frontendOptions = array(
   'lifetime' => CALLOWED_TIMEOUT, 
   'automatic_serialization' => true
);
 
$backendOptions = array(
    'cache_dir' => './tmp/' // Directory where to put the cache files
);
 
// getting a Zend_Cache_Core object
$cache = Zend_Cache::factory('Core', 'File',  $frontendOptions,$backendOptions);

try{
    
//TROPO is sending something to us
if (isset($HTTP_RAW_POST_DATA)&&$HTTP_RAW_POST_DATA!=''){
    $decode = json_decode($HTTP_RAW_POST_DATA);
    if ($decode==null){
        header("Bad Request",'',400);
        return;
    }
    
    //step 1
    if(isset($decode->session)){
        //initial post to us from TROPO
        //generate the words to store in our cache
        $publicwords=generateWords(WORDS_FILENAME,NUM_WORDS);
        $cache->load(implode('_',$publicwords));
        $cache->save($decode->session);
        
        
        //step 2, send response to tropo with the words to say
        $data = array('tropo'=>array(
            array(
                "on"=>array(
                    array('event'=>'continue',
                          'next'=>'session.php'),
                    array('event'=>'incomplete',
                          'next'=>'session.php'),

                )),
            array(
                "ask"=>array(
                    "bargein"=>true,
                    "required"=>true,
                    "timeout"=>30,
                    "say"=>array(
                        'voice'=>'allison',
                        'value'=>"Please enter the following words on the website, , ".implode(',, ',$publicwords)." , , Those words again were  , , ".implode(',, ',$publicwords)
                    ),
                    "name"=>"account_number",
                ),
            ),
        ));

        echo json_encode($data);
        return;
    }
    
    //step 3 of process
    if (isset($decode->result)){
        $data=array(
            'tropo'=>array(
                "say"=>array(
                    "value"=>"Thank you"
                ),
                "hangup"=>null,
        ));
        echo json_encode($data);
        return;
    }
    
}
else{
    header("Bad Request",'',400);
}

} catch (Exception $e){
    file_put_contents(ERROR_FILE, $e->getMessage()."\n".$e->getTrace());
}