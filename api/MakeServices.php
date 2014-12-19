<?php
/*
 * Created on Dec 17, 2014
 *  This script will create issues(tickets) in Github/Bitbucket account
 *  Module written by Rohit Shukla <rohitshukla08@gmail.com>
 *  The author of the Post issue on repository module is Rohit Shukla
 *  @version 0.1.0: MakeServices.php,v 1.0 Dec 17, 2014 23:13:28
 *  @copyright (C) 2014 - 2014 Rohitshukla08
 *  @author   Rohit Shukla <rohitshukla08@gmail.com>
 *  @link  'https://developer.github.com/v3/'
 *  @link  'https://confluence.atlassian.com/display/BITBUCKET/Bitbucket+Documentation+Home'
 */

/**
 * This Class Used to validate parameters
 * Class Name: MakeServices
 * Child Class that extends PostDataRequestAbstract Abstract Class
 * @function PUBLIC ValidateServiceParams
 */
class MakeServices extends PostDataRequestAbstract
{
   /**
	* Function Name : ValidateServiceParams()
	* Function to check the required details are passed as arguments to the script in the command line
	* If no arguments are passed, then asks users to enter each argument manually
	* Script Requires following parameters:
	* username           - Name of the user posting the issue
	* password           - Password of the user posting the issue
	* repositoryUrl      - The URL of the repository where issue is to be posted
	* issueTitle         - The Title of the issue
	* issueDescription   - The Description of the issue
	* @return            - Return Array all Store passed argument
	*
    * @throws            - Exception for invalid command
    * @throws            - Exception when Repository Name and the User name not in the repository URL.
    * @throws            - Exception when Repository URL seems to be incorrect.
    * @throws            - Exception when invalid URL in the Params.
	*/

   public function ValidateServiceParams() {
	     $ParametersArray                     = array();                         //An $ParametersArray array to store all the input parameters
	     $ParametersArray['username']         = trim($_SERVER['argv'][2]);      //Get User name is passed as an argument
         $ParametersArray['password']         = trim($_SERVER['argv'][4]);     //Get Password is passed as an argument
		 $ParametersArray['repositoryUrl']    = trim($_SERVER['argv'][5]);    //Get repository Name is passed as an argument
         $ParametersArray['issueTitle']       = trim($_SERVER['argv'][6]);   //Get Title String is passed as an argument
		 $ParametersArray['issueDescription'] = trim($_SERVER['argv'][7]);  // Get Description String are passed as an argument

		 if( trim($_SERVER['argv'][1]) !='-u' ||
		     trim($_SERVER['argv'][3]) !='-p' ||
		     trim($ParametersArray['username']) =='' ||
		     trim($ParametersArray['password']) =='' ||
		     trim($ParametersArray['repositoryUrl']) =='' ||
		     trim($ParametersArray['issueTitle']) =='' ||
		     trim($ParametersArray['issueDescription']) ==''
		 	){
		 	      throw new Exception("\n\n invalid comman it must be in format.\n e.g. php FileName -u YourAppUsername -p YourAppPassword RepositoryURL/:username/:repository  'Title String' 'Description String' \n\n");
     		      return false;
     		}else{
		     	  /**
			       * parse_url to get the domain from the URL entered in the arguments  [http://php.net/manual/en/function.parse-url.php]
			       * Inspecting the repository url
			       * @return - Array With indexes as the domain, Username and the repository name
			       */
			     $repositoryUrlDetails  = parse_url($ParametersArray['repositoryUrl']);

				 if (isset($repositoryUrlDetails['host']) && ! empty($repositoryUrlDetails['host'])) {
					   $urlPath              = explode("/", $repositoryUrlDetails['path']);
					   $ParametersArray['repositoryOwnerName']  = (isset($urlPath[1]) && ! empty($urlPath[1])) ? $urlPath[1] : FALSE;
					   $ParametersArray['repositoryName']       = (isset($urlPath[2]) && ! empty($urlPath[2])) ? $urlPath[2] : FALSE;

					   if ( !($ParametersArray['repositoryOwnerName']) || !($ParametersArray['repositoryName'])) {
					     throw new Exception("Repository Name and the User name in the repository URL are mandatory.");
					     return false;
					   }
					/**
					 * Determine which service to use by inspecting the repository url.
					 * To Extend Service just add extend if else condition before end else
					 */
					   if ($repositoryUrlDetails['host'] == 'github.com' || $repositoryUrlDetails['host'] == 'www.github.com') {
							 $ParametersArray['ClassName']      = 'GitHubApi';    //File Name GitHubApi.php
					   } else if ($repositoryUrlDetails['host'] == 'bitbucket.org' || $repositoryUrlDetails['host'] == 'www.bitbucket.org') {
					   	    $ParametersArray['ClassName']      = 'BitBucketApi'; //File Name BitBucketApi.php
					   }/* else if ($repositoryUrlDetails['host'] == 'NewHostName' || $repositoryUrlDetails['host'] == 'www.NewHostName') {
					   		$ParametersArray['ClassName']      = 'NewClassFileName';
					   }
					   */
					    else {
					     	throw new Exception("Repository URL seems to be incorrect. You can currently only post issues to bitbucket.org and github.com");
					     	return false;
					   }
				 }else {
				   $e = new Exception("The URL entered is invalid. Run the script again with correct values to continue.");
				   throw $e;
				   return false;
				 }

     		}
	    return $ParametersArray;
    }

	/**
     * Function to Post data log to the Other Repository
     * @param - Array   $inputData            The input data as paased as arguments to the script
     * @param - String  $repositoryOwnerName  The Name of the owner of the repository as extracted from the repository URL
     * @param - String  $repositoryName       The Name of the repository as extracted from the repository URL
     * @return - Array The result of the API call
     */
      public function PostDataLog($inputData, $repositoryOwnerName, $repositoryName) {
  			// PostData Body Here...
     }
}
/* MakeServices Class End Here  */
?>
