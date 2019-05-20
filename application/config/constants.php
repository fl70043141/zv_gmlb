<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);


/*
|--------------------------------------------------------------------------
| INITIAL VALUES 
|--------------------------------------------------------------------------
|
| These are containing intial stup values
|
*/

define('REPNO_PREFIX',	'BGL'.date('ym').'-');

/*
|--------------------------------------------------------------------------
| DB Tables
|--------------------------------------------------------------------------
|
| These are used to database table  name
|
*/
//FL TABLE PREFIX
define('TB_PREFIX',      		'');

define('USER_TBL',      		TB_PREFIX.'user_auth');
define('USER_ROLE',      		TB_PREFIX.'user_role');
define('USER',                          TB_PREFIX.'user_details');
define('MODULES',                       TB_PREFIX.'modules');
define('MODULES_ACTION',                TB_PREFIX.'module_actions');
define('MODULE_USER_ROLE_ACT',          TB_PREFIX.'module_user_role');
//define('HOTELS',                        TB_PREFIX.'hotels');
define('COMPANIES',                     TB_PREFIX.'company');
define('COUNTRY_LIST',                  TB_PREFIX.'countries');
define('FLOORS',                        TB_PREFIX.'floors');
define('PROPERTY',                      TB_PREFIX.'hotel_property');
define('PROPERTY_TYPE',                 TB_PREFIX.'hotel_property_type');
define('TARRIF_TYPE',                   TB_PREFIX.'tarrif_type');
define('TIME_BASE',                     TB_PREFIX.'time_base');
define('AGENTS',                        TB_PREFIX.'agents');
define('AGENT_TYPE',                        TB_PREFIX.'agent_type');
define('LAB_REPORT',                        TB_PREFIX.'lab_report');
define('SPEC_COST',                        TB_PREFIX.'additional_cost');
define('CUST_DISCOUNT',                        TB_PREFIX.'customer_base_discount');
define('GEM_CAT',                        TB_PREFIX.'gem_category');
define('LAB_REPORT_SYNC',                        TB_PREFIX.'lab_report_sync');
define('DROPDOWN_LIST',                        TB_PREFIX.'dropdown_list');
define('DROPDOWN_LIST_NAMES',                        TB_PREFIX.'dropdown_list_names');

/*
|--------------------------------------------------------------------------
| STORAGE PLACES 
|--------------------------------------------------------------------------
|
| These are containing all the file storage places
|
*/

//define('HOTEL_LOGO',	'./storage/images/company/');
define('COMPANY_LOGO',	'./storage/images/company/');
define('LAB_REPORT_IMAGES',	'./storage/images/lab_reports/');
define('LAB_REPORT_PDF',	'./storage/pdf/lab_reports/');
define('LAB_REPORT_PVC_PDF',	'./storage/pdf/lab_reports_pvc/');
define('LAB_REPORT_PDF_TRASH',	'./storage/pdf/lab_reports_trash/');
define('LAB_REPORT_PVC_PDF_TRASH',	'./storage/pdf/lab_reports_pvc_trash/');
define('LAB_E_REPORT_PDF',	'./storage/pdf/lab_e_reports/');
define('OTHER_IMAGES',	'./storage/images/other/');
define('XML_DATA',	'./storage/xml/');
define('DB_BACKUPS',	'./backups/db/');
define('FILE_BACKUPS',	'./backups/files/');
define('FILE_BACKUP_SOURCE',	'./storage/');


/*
|--------------------------------------------------------------------------
| MESSAGES 
|--------------------------------------------------------------------------
|
| These are containing all the errors, Warning, Inf and success messages
|
*/

define('RECORD_ADD',	'Record added successfully.');
define('ERROR',			'An error has occured.');
define('WARN',			'An error has occured.Please check the form and try again.');
define('RECORD_UPDATE',	'Record updated successfully.');
define('RECORD_DELETE',	'Record deleted successfully.');
define('NO_REC',		'No records to display');
define('NO_SUCH',		'No such records to ');
define('SUM_GEN_SUCCESS','Summary generated successfully');
define('NO_REC_FOR_UNIT','No shift records for selected unit');
define('NO_REC_FOR_PERIOD','No shift records for selected time period');
define('NO_REC_FOR_ID',  'No records for entered id');
define('NOT_ALLOWED_EDITING',  'Selected record was not allowed to edit');
define('NOT_ALLOWED_DELETE',  'Selected record was not allowed to delete');

define('INVALID_USERNAME'   ,"Email doesn't exist.");
define('TEST_NO_EMAIL','Password has been changed successfully. Email not Sent.'); // Test-> Send Email Unsuccess
define('FORGOT_PASSWORD'    ,"Your Password Resetted,Please Check Your Email.");



/*
|--------------------------------------------------------------------------
| ENCRYPTION 
|--------------------------------------------------------------------------
|
| 
|Define a 32-byte (64 character) hexadecimal encryption key
| Note: The same encryption key used to encrypt the data must be used to decrypt the data
|
*/
define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
