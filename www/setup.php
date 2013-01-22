<?php

//cache lifetime of 10 minutes
define('CALLOWED_TIMEOUT', 600);
//Number of words that you are requiring the person to enter
define('WORDS_FILENAME', 'words');
//Number of words that you are requiring the person to enter
define('NUM_WORDS', 2);
//Your Tropo designated phone number
define('PHONENUMBER', '');
//Where to write Tropo connection errors to
define('ERROR_FILE','error.txt');


set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/library'),
    get_include_path(),
)));

require_once 'Zend/Cache.php';



/**
 * genereate an array of random words
 * @param string $filename wordfile
 * @param int $cnt
 * @return mixed false if cnt=0, otherwise array of words
 * @throws FileNotFoundException 
 */
function generateWords($filename,$cnt)
{
    if (!is_file($filename)){
        throw new Excetion('File not found');
    }
    if ($cnt<=0){
        return false;
    }
    $list=array();
    $words = file($filename);
    $keylist = (array)array_rand($words,$cnt);
    foreach($keylist as $index){
        $list[]=trim($words[$index]);
    }
    return $list;
}

/**
 * Data to verify
 * @param string $words 
 * @param Zend_Cache $cache
 */
function verifyWords($words,$cache)
{
    try{
        
        $res = $cache->load($words);
        
    } catch (Exception $e) {
        $res= false;
    }
    return $res;
}


$frontendOptions = array(
   'lifetime' => CALLOWED_TIMEOUT, 
   'automatic_serialization' => true
);
 
$backendOptions = array(
    'cache_dir' => './tmp/' // Directory where to put the cache files
);
 
// getting a Zend_Cache_Core object
$cache = Zend_Cache::factory('Core', 'File',  $frontendOptions,$backendOptions);

