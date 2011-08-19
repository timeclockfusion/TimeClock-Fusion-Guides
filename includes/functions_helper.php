<?php
/***********************************************************************
 ***                  Generic  functions                             ***
 ***         These are included in base project template             ***
 ***********************************************************************/
//Include all classes and other required files.
$_SESSION['localPath'] = BASEPATH;
//function __autoload($class_name) {
//    require_once BASEPATH . '/classes/' . $class_name . '.php';
//}

    function check_error($location, $table = false){
        if (isset($_SESSION['specificErrors'][$location])){
            foreach ($_SESSION['specificErrors'][$location] as $index => $error){
                if ($table){
                    echo "<tr><td colspan='5'><span class='error'>$error</span></td></tr>";
                }
                else {
                    echo "<span class='error'>$error</span><br />";
                }
//                unset($_SESSION['specificErrors'][$location][$index]);
            }
        }
    }
// Adds an error....
    function add_error($error) {
        $_SESSION['errors'][] = "<span class='error'>$error </span>";
    }
    // Adds a notice....
    function add_notice($notice) {
        $_SESSION['notices'][] = "<span class='notice'>$notice</span>";
    }

    function add_specific_error($error, $name){
        $_SESSION['specificErrors'][$name][] = $error;
    }

    function table_exists($tableName){
        $CI =& get_instance();

        $result = $CI->db->query('SHOW TABLES');
        $result = $result->result_array();
        foreach ($result as $index => $table){
            foreach ($table as $index => $table_name){
                if ($tableName == $table_name){
                    return true;
                }
            }
        }
    }

    function field_exists($table, $field){
        $CI =& get_instance();

        $result = $CI->db->query('SHOW COLUMNS FROM `'.TABLE_PREFIX."$table`");
        foreach ($result->result() as $row){
            if ($row->Field == $field){
                return true;
            }
        }
    }

//Takes a date of birth (mm/dd/yy or mm/dd/yyyy) and returns the age
function calculate_age ($dob){
    list($month,$day,$year) = explode("/",$dob);
    if ($year < 100){
        $year = $year + 1900;
    }
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
     if ($month_diff < 0) $year_diff--;
    elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
    return $year_diff;
  }

/*
 * Trims characters fromt he end of a string useful in query building
 */
    function trimString($string, $trim = 1){
        $string = trim($string);
        return substr($string, 0, strlen($string) - $trim);
    }

    function createRandomKey($amount){
	$keyset  = "abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$randkey = "";
	for ($i=0; $i<$amount; $i++)
		$randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
	return $randkey;
    }

  function dateCMP($a, $b){
      return strtotime($a['dateText']) - strtotime($b['dateText']);
  }
  
/*
 * To generate a has from a plain text password, don't supply the salt
 *
 * $plainText Plain text password
 * $salt      If checking a password this should be passed as the full hash from the DB
 */
    function generateHash($plainText, $salt = null)
{
    $saltLength = 16;
    if ($salt === null) $salt = substr(sha1(uniqid(rand(), true)), 0, $saltLength);
    else $salt = substr($salt, 0, $saltLength);

    return $salt . sha1($salt . $plainText);
}

function generatePassword($length=6,$level=2){

   list($usec, $sec) = explode(' ', microtime());
   srand((float) $sec + ((float) $usec * 100000));

   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

   $password  = "";
   $counter   = 0;

   while ($counter < $length) {
     $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);

     // All character must be different
     if (!strstr($password, $actChar)) {
        $password .= $actChar;
        $counter++;
     }
   }

   return $password;

}

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

#############################################################################
# int pwd_valid(str pwd [, int minLen [,int minStr [,str $specials = "_-"]]])
#
# inputs:  pwd:      the password to be checked
#          minLen:   minimum length allowed for the password
#          minStr:   minimum number of different character types required
#          specials: special characters allowed in password (non alphanumerics)
#
# returns:  1: password is OK
#      case 1: password contains an invalid character
#      case 2: not enough variety of character types
#      case 3: not long enough
#############################################################################
    function pwd_valid($pwd, $minLen = 8, $minStr = 2, $specials = '_-!@#$%^&*')
{
  $result = 1;   # initialize to OK
  if(strlen($pwd) >= $minLen)
  {
    $specials = preg_replace('/(\W|-)/', "\\\\$1", $specials);
    $invalid = "/[^a-zA-Z0-9$specials]/";

    if(preg_match($invalid, $pwd)) $result = -1;  # password contains an invalid character
    else
    {
      $strength = 0;
      foreach(array("a-z", "A-Z", "0-9", "$specials") as $chars) {
        if(preg_match("/[$chars]/", $pwd)) $strength++;
      }
      if($strength < $minStr) $result = -2;   # not enough variety of character types
    }
  }
  else $result = -3;   # password not long enough

  return($result);
}

/**
 * USED FOR TIMECLOCK INSTALATIONS ONLY
 * Encrypts a user's plain text password using various methods
 * @param $plain_text_password is the plain text password to encrypt
 * @note $plain_text_password must contain a value.
 * @param $encrypted_password is the encrypted password containing the salt to use on $plain_text_password
 * @return the encrypted plain text password, if a method is not available it returns $plain_text_password.
 */
function encrypt_password($plain_text_password, $encrypted_password = '') {
//    global $authentication_method;

    if (empty($plain_text_password)) {
        return $plain_text_password;
    }
        if (empty($encrypted_password)) {
            /*
             * CRYPT_STD_DES - Standard DES-based encryption with a two character salt
             * CRYPT_EXT_DES - Extended DES-based encryption with a nine character salt
             * CRYPT_MD5 - MD5 encryption with a twelve character salt starting with $1$
             * CRYPT_BLOWFISH - Blowfish encryption with a sixteen character salt starting with $2$ or $2a$
             */
            $encrypted_password = crypt($plain_text_password);
        } else {
            $encrypted_password = crypt($plain_text_password, $encrypted_password);
        }
    return $encrypted_password;
}

/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email
address format and the domain exists.
 * http://www.linuxjournal.com/article/9585
*/
    function validEmail($email) {
        if (preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)){
            return true;
        }
        else {
            return false;
        }
//      // First, we check that there's one @ symbol,
//      // and that the lengths are right.
//      if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
//        // Email invalid because wrong number of characters
//        // in one section or wrong number of @ symbols.
//        return false;
//      }
//      // Split it into sections to make life easier
//      $email_array = explode("@", $email);
//      $local_array = explode(".", $email_array[0]);
//      for ($i = 0; $i < sizeof($local_array); $i++) {
//        if
//    (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
//    ?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
//    $local_array[$i])) {
//          return false;
//        }
//      }
//      // Check if domain is IP. If not,
//      // it should be valid domain name
//      if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
//        $domain_array = explode(".", $email_array[1]);
//        if (sizeof($domain_array) < 2) {
//            return false; // Not enough parts to domain
//        }
//        for ($i = 0; $i < sizeof($domain_array); $i++) {
//          if
//    (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
//    ?([A-Za-z0-9]+))$",
//    $domain_array[$i])) {
//            return false;
//          }
//        }
//      }
//      return true;
    }


function isValidURL($url)
{
 return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}


/** Function : dump()
 * Arguments : $data - the variable that must be displayed
 * Prints a array, an object or a scalar variable in an easy to view format.
 */
function dump($data) {
    echo '<br />';
    if(is_array($data)) { //If the given variable is an array, print using the print_r function.
        print "<pre>-----------------------\n";
        print_r($data);
        print "-----------------------</pre>";
    } elseif (is_object($data)) {
        print "<pre>==========================\n";
        var_dump($data);
        print "===========================</pre>";
    } else {
        print "=========&gt; ";
        var_dump($data);
        print " &lt;=========";
    }
}

/*
 * Removes an index from an array  whos value matches passed argument
 * @param $array  Passed by reference
 * @param $value
 *
 */

function remove_from_array(&$array, $value){
    foreach ($array as $index => $val){
        if ($val === $value){
            unset($array[$index]);
        }
    }
}

/*
 * Removes escaping backslashes from supplied string
 */
function remove_slashes($string){
    $string =  preg_replace("/\\\\'/","'", $string);
    $string = preg_replace("/\\\\r\\\\n/","\n", $string); //add_notice($string);
    return $string;
}
/*
 * Redirect via Javascript so users can be redirected if headers have been sent...
 */
function js_header($url){
    echo "<script type='text/javascript'>
            window.location = '$url'
          </script>";
}

function paymentsCmp($a, $b){
    return strcmp($a["date_time"], $b["date_time"]);
}
function transCmp($a, $b){
    return strcmp($a["date"], $b["date"]);
}

function pad($string, $length){
    while (strlen($string) < $length)
        $string .= ' ';
    return $string;
}

//function strl_replace($string, $search, $replace){
//
//}

function do_login($userInfo, $cookieLogin){
//    dump($userInfo);
    $CI =& get_instance();

    $CI->session->set_userdata('userID', $userInfo->id);
    $CI->session->set_userdata('username', $userInfo->username);
    $CI->session->set_userdata('firstName', $userInfo->first_name);
    $CI->session->set_userdata('lastName', $userInfo->last_name);
    $CI->session->set_userdata('sys_admin', $userInfo->sys_admin);

    $hash = sha1(uniqid(rand() . $CI->input->ip_address() . $CI->input->user_agent()));
    $cookieHash = sha1(uniqid(rand() . $CI->input->ip_address() . $CI->input->user_agent()));

    $CI->db->where('id', $CI->session->userdata('userID'));
    $CI->db->update('users', array('cookie_hash' => $cookieHash));

    if (! strlen($CI->Config->item('installKey'))){
        $CI->Config->update_item('installKey', $hash);
    }
    $CI->session->set_userdata('installKey', $CI->Config->item('installKey'));

    if ($cookieLogin OR $CI->input->post('rememberMe')){
        $CI->session->set_userdata('rememberMe', true);
        $CI->session->set_userdata('cookieHash', $cookieHash);
    }
}
/*
 * Called by sanitize
 */
    function cleanInput($input, $stripHTML = true) {
        if ($stripHTML) {
            $search = array(
                '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
                '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments

            );
        }
        else $search = array('@<script[^>]*?>.*?</script>@si');  // Strip out javascript

        $output = preg_replace($search, '', $input);
        return $output;
    }
    function sanitize($input, $stripHTML = true) {
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = sanitize($val);
            }
        }
        else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input  = cleanInput($input, $stripHTML = true);
            $output = mysql_real_escape_string(trim($input));
        }
        return $output;
    }


/**
 * Quick function for running PDO queries
 * @param $query the query to pass
 * @param $params pass as array, $param => $val,
 * @Param $returnInsertID set to true to have the id of the row inserted returned
 *      Binding params required when using binary data, and recommended for security
 *      a bound param is called in query as :param (Ex SELECT * FROM table WHERE field = :param)
 *      If a SELECT COUNT is passed, the return value is the number of rows
 */
function PDO_query($query, $params = null, $returnInsertID = false, $dbCredentials = false, $debug = false) {
    global $dbTime;
    global $totalDBCalls;
    $timeStart = microtime(true);
// Try to connect
    if (is_array($dbCredentials)){
        try {
            extract($dbCredentials);
            $dbh = new PDO(("mysql:host=" . $dbHost . ";dbname=" . $dbName) , $dbUser, $dbPass, array(PDO::ATTR_PERSISTENT => true));
        } catch (Exception $e) {
          echo "Failed: " . $e->getMessage();
          return false;
        }
    }
    else {
        try {
            $dbh = new PDO(("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME) , DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true));
        } catch (Exception $e) {
          echo "Failed: " . $e->getMessage();
          return false;
        }
    }

// Try to run queries
    try {
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      $dbh->beginTransaction();

    // Debugging, if set
      if ($debug) {
          echo '<br>PDO Params<br>';
          dump($params);
          echo '<br>PDO Query<br>';
          echo $query;
      }

      // Query
        $stmt = $dbh->prepare($query);
        if (is_array($params)){
            foreach($params as $param => $val){
//                $foundPos = strpos($query, ":$param");
//                if ($foundPos !== false AND ($foundPos < strlen($query) - strlen($param) OR strpos($query, ":$param "))){
                if (strpos("$query ", ":$param ") !== false OR strpos($query, ":$param\n") !== false
                     OR strpos($query, ":$param\r\n") !== false  OR strpos($query, ":$param\r") !== false
                        OR strpos($query, ":$param,") !== false OR strpos($query, ":$param)") !== false){
                    if (! is_array($val)){
                     // This MUST absoutely stay here, or else PDO will freak out, (it uses pass by referrence).
                        $$val = $val;
                     // End Do NOT Touch
                        $stmt->bindParam($param, $$val);
                        $boundParams[] = $param;
                    }
                    else{
                        add_error('Invalid PDO Parameters (See a webmaster)');
                        echo 'A param passed to PDO_query was an array (must be string or int)';
                    }
                }
            }
        }

   // Commit
        $stmt->execute();
        $lastInsertID = $dbh->lastInsertID();
        $dbh->commit();

        $dbTime += microtime(true) - $timeStart;
        $totalDBCalls++;
   // Return results if select
        if (substr($query, 0, 6) == 'SELECT' OR substr($query, 0, 4) == 'SHOW') return $stmt->fetchAll(PDO::FETCH_ASSOC);
        else if ($returnInsertID == true) return $lastInsertID;
        else return true;

    } catch (Exception $e) {
          $dbh->rollBack();
          echo '<br>Failed: ' . $e->getMessage();
          echo '<br />';
          echo "<br>Query $query<br>";
          dump('PDO Params');
          dump($params);
          dump('Bound Params');
          dump($boundParams);
          foreach($params as $param => $val){
              if (strpos($query, $param) === false) echo $param;
          }
          echo '<br>PDO Failed';
          die();
          return false;
    }

    unset($dbh);
    unset($stmt);
}

?>