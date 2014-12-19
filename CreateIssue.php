<?php
/*
 * Created on Dec 17, 2014
 * This script will create issues(tickets) in Github/Bitbucket account
 *  Module written by Rohit Shukla <rohitshukla08@gmail.com>
 *  The author of the Post issue on repository module is Rohit Shukla
 *  @version 0.1.0: PostIssuesRequest.php,v 1.0 Dec 18, 2014 21:10:07
 *  @copyright (C) 2014 - 2014 Rohitshukla08
 *  @author   Rohit Shukla <rohitshukla08@gmail.com>
 */

/**
 * __autoload function is a magic function.
 * __auotload including classes automatically without the having to add a very large number of include statements.
 */
function __autoload($ClassName) {
	 if (file_exists('api/'.$ClassName . '.php')) {
          require_once ('api/'.$ClassName . '.php');
          return true;
        }
     throw new Exception("\n\n Unable to loadss $ClassName. You can currently only post issues to bitbucket.org and github.com \n\n");
     return false;
}
/**
 * Error Handling Om Main Part of the Program Executions
 * @throws Exception when data not posted on Repository and return some error
 */

	try
	{  // try body here
	   /**
	    * MakeServices Class
        * Validate URL to check if it is a valid url - define a standard function in class
        * Validate if repository is one of the supported from your scripts
        * Validate Parameter count, report error is count not as expected
        * @return  Api input parameters
        */
		  $ServicesObject        = new MakeServices();
		  $ServiceData           = $ServicesObject->ValidateServiceParams();
		  $ObjectClassName       = $ServiceData['ClassName'];
		  $repositoryOwnerName   = $ServiceData['repositoryOwnerName'];
		  $repositoryName        = $ServiceData['repositoryName'];
		  $LogIssueObject        = new $ObjectClassName(); // Call _autoload function
		  $resultPostIssue       = $LogIssueObject->PostDataLog($ServiceData, $repositoryOwnerName, $repositoryName);
		   if (isset($resultPostIssue['result']) && $resultPostIssue['result']) {
		        echo $resultPostIssue['message'];
		   } else {
		        $e   = new Exception($resultPostIssue['message']);
		        throw $e;
		   }
	} catch(Exception $e){ // catch body here
		echo "Error Occured. ".$e->getMessage()."\n\n";
		return false;
	}
exit();
?>
