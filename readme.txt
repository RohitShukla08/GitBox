|||||||||||||||||||||||||||||
||      version 0.1.0      ||
|||||||||||||||||||||||||||||

Php Script to create gitHub and BitBucket issues using APIs.It contains a Php script that is used to post issues to GitHub and BitBucket repositories by calling the APIs provided by GitHub and BitBucket respectively.
The script can be extended to include other repositories as well by creating a class and a function to post issue for that repository.

GitHub and BitBucket Documentation Web Links
BitBucket :: 'https://developer.github.com/v3/'
GitHub    :: 'https://confluence.atlassian.com/display/BITBUCKET/Bitbucket+Documentation+Home'

Download the Php script from github repository

Setup Instructions :
Step 1) Download the php script from github repository.
Step 2) Save the Files
		  CreateIssue.php
		  readme.txt
		  |---api|PostDataRequestAbstract.php
		  |--|api|MakeServices.php
		  |--|api|BitBucketApi.php
		  |--|api|GitHubApi.php
Step 3) Open command prompt.
=============  Manually enter the input parameters from the command line =================================
Step 4)  php CreateIssue.php -u YourAppUsername -p YourAppPassword RepositoryURL  'Title String' 'Description String'

NOTE: This script uses CURL to connect to APIs, Please uncomment the extension=php_curl.dll extension in the php.ini file for windows and/or use the following commands in Linux(Ubuntu) sudo apt-get install php5-curl sudo /etc/init.d/apache2 restart to enable this script to execute

============= Extend Application =========================================================================

To Extend Application :
 Step 1) Create php file under api folder MYNewApp.php and write class MYNewApp with method PostDataLog($Input,$Owner,$RName) as per requirement, filename and class name must be same.
 Step 2) Update MakeServices.php method ValidateServiceParams replace accordgily.

e.g.
   if ($repositoryUrlDetails['host'] == 'github.com' || $repositoryUrlDetails['host'] == 'www.github.com') {
		 $ParametersArray['ClassName']      = 'GitHubApi';
   } else if ($repositoryUrlDetails['host'] == 'bitbucket.org' || $repositoryUrlDetails['host'] == 'www.bitbucket.org') {
   	    $ParametersArray['ClassName']      = 'BitBucketApi';
   } else if ($repositoryUrlDetails['host'] == 'NewHostName' || $repositoryUrlDetails['host'] == 'www.NewHostName') {
   		$ParametersArray['ClassName']      = 'NewClassFileName';
   } else {
     	throw new Exception("Repository URL seems to be incorrect. You can currently only post issues to bitbucket.org and github.com");
     	return false;
   }




