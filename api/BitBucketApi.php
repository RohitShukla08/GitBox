<?php
/*
 * Created on Dec 17, 2014
 * This script will create issues(tickets) in Bitbucket account
 *  Module written by Rohit Shukla <rohitshukla08@gmail.com>
 *  The author of the Post issue on repository module is Rohit Shukla
 *  @version 0.1.0: PostIssuesRequest.php,v 1.0 Dec 18, 2014 22:30:49
 *  @copyright (C) 2014 - 2014 Rohitshukla08
 *  @author   Rohit Shukla <rohitshukla08@gmail.com>
 *  @link  'https://confluence.atlassian.com/display/BITBUCKET/Bitbucket+Documentation+Home'
 */

/**
 * Class Name: BitBucketApi
 * Child Class that extends PostDataRequestAbstract Abstract Class
 * @function PUBLIC PostDataLog
 */
class BitBucketApi extends PostDataRequestAbstract
{
 /**
  * Function to post the Issue to the BitBucket Repository
  * @param  - Array  $inputData            The input data as paased as arguments to the script
  * @param  - String $repositoryOwnerName  The Name of the owner of the repository as extracted from the repository URL
  * @param  - String $repositoryName       The Name of the repository as extracted from the repository URL
  * @return - Array The result of the API call
  */
   public function PostDataLog($inputData, $repositoryOwnerName, $repositoryName) {
       $bitBucketUrlToPostIssue = "https://bitbucket.org/api/1.0/repositories/{$repositoryOwnerName}/{$repositoryName}/issues";
      // Creates an array of post data
       $postData = array(
          'title' => $inputData['issueTitle'],
          'content' => $inputData['issueDescription']
       );
       // Calls the function to make api call to the BitBucket and create a new post
       $postIssueResultEnocoded = $this->ServicesApiCall($bitBucketUrlToPostIssue, $inputData['username'], $inputData['password'], $postData, FALSE);
       $postIssueResult = json_decode($postIssueResultEnocoded, TRUE);
       $result = array();
       if (isset($postIssueResult['local_id']) && $postIssueResult['local_id']) {
          $result = array(
             'result' => TRUE,
             'message' => "\n Issue successfully created to {$inputData['repositoryUrl']} \nYou can check the issue by visiting this link: {$inputData['repositoryUrl']}/issue/{$postIssueResult['local_id']}"
          );
      } else {
         $result = array(
           'result' => FALSE,
           'message' => "\nThere was some error in posting the issue to {$inputData['repositoryUrl']}"
         );
     }
     return $result;
   }
}
/* BitBucketApi Class End Here  */
?>
