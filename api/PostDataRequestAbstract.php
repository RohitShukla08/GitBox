<?php
/*
 *  Created on Dec 17, 2014
 *  Module written by Rohit Shukla <rohitshukla08@gmail.com>
 *  The author of the Post issue on repository module is Rohit Shukla
 *  @version 0.1.0: PostDataRequestAbstract.php,v 1.0 Dec 17, 2014 21:13:28
 *  @copyright (C) 2014 - 2014 Rohitshukla08
 *  @author   Rohit Shukla <rohitshukla08@gmail.com>
 */

/**
 * Class Name: PostDataRequestAbstract
 * Abstract class that has extends by other Class (MakeServices,GitHubApi,BitBucketApi,...)
 * @function Abstract PROTECTED PostDataRequestAbstract
 * @function PUBLIC PostDataLog
 * @function PUBLIC ServicesApiCall
 */

abstract class PostDataRequestAbstract
{
   /**
    * Force Extending class to define this method
    * Abstract Function to post the Data to the Repository
    * Mandatory for class that inherits it to define this function
    * @param  - Array   $inputData             The input data as paased as arguments to the script
    * @param  - String  $repositoryOwnerName   The Name of the owner of the repository as extracted from the repository URL
    * @param  - String  $repositoryName        The Name of the repository as extracted from the repository URL
    * @return - Array                          The result of the API call
    */

   abstract protected function PostDataLog($inputData, $repositoryOwnerName, $repositoryName);

   /**
    * Function to Build API Call to the URL passed as parameter
    * @param  - String  $url             The URL to which api call is to be made
    * @param  - String  $username        The USERNAME of the user in the repository site
    * @param  - String  $password        The PASSWORD of the user
    * @param  - Array   $postData        The post data that is to be passed to the api (default empty array)
    * @param  - Array   $jsonDecodeData  Checks if the post data need to be json decoded or not
    * @return - Array
    */
   public function ServicesApiCall($url, $username, $password, $postData = array(), $jsonDecodeData = FALSE) {
     try {
     	// PHP Client URL Library [http://php.net/manual/en/book.curl.php]
	     $ClientUrlLib        = curl_init();
	     //set the url
	     curl_setopt($ClientUrlLib, CURLOPT_URL, $url);
	     curl_setopt($ClientUrlLib, CURLOPT_USERAGENT, 'User-Agent: Issue Creation Script');

	     if ($jsonDecodeData) {
	       $postData = json_encode($postData);
	       curl_setopt($ClientUrlLib, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($postData)));
	     }
	     curl_setopt($ClientUrlLib, CURLOPT_CUSTOMREQUEST, "POST");
	     curl_setopt($ClientUrlLib, CURLOPT_POSTFIELDS, $postData);
	     curl_setopt($ClientUrlLib, CURLOPT_SSL_VERIFYHOST, FALSE);
	     curl_setopt($ClientUrlLib, CURLOPT_SSL_VERIFYPEER, FALSE);
	     curl_setopt($ClientUrlLib, CURLOPT_RETURNTRANSFER, TRUE);
	     curl_setopt($ClientUrlLib, CURLOPT_FOLLOWLOCATION, TRUE);
	     curl_setopt($ClientUrlLib, CURLOPT_CONNECTTIMEOUT, 5);
	     curl_setopt($ClientUrlLib, CURLOPT_USERPWD, "$username:$password");
	     curl_setopt($ClientUrlLib, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	     //execute post
	     $result_encoded = curl_exec($ClientUrlLib);
	     curl_close($ClientUrlLib);
	     return $result_encoded;
     } catch(Excepition $e){
	       $e = new Exception("There was some error in connecting to {$url}. Please try again after sometime");
	       throw $e;
     }
   }
}
/* Abstract PostDataRequest Class End Here  */

?>