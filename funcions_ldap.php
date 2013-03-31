<?php
function obteNomComplet($usuari){
$ldapconfig['host'] = _LDAP_SERVER;
		#Només cal indicar el port si es diferent del port per defecte
		$ldapconfig['port'] = _LDAP_PORT;
		$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
		$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		$password=_LDAP_PASSWORD;
		#$dn="cn=admin,".$ldapconfig['basedn'];
		$dn=_LDAP_USER;
		
		
		if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
		
		    //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
		    $filter = "(uid=".$usuari.")";
		
		    if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		      echo("Unable to search ldap server<br>");
		      echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		    } else {
		      $number_returned = ldap_count_entries($ds,$search);
		      $info = ldap_first_entry($ds, $search);
		      $info1= ldap_get_dn($ds, $info);
		      $nom_complet=$info1;
		      return $nom_complet;
		    }
		  } else {
		    echo("Unable to bind anonymously<br>");
		    echo("msg:".ldap_error($ds)."<br>");
		  }
		} else {
		
		  echo("Unable to bind to server.</br>");
		
		  echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
		  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
		  #we can figure out the right pattern by searching the user tree
		  #remember to turn on the anonymous search on the ldap server
		  
		}
		ldap_close($ds);
}

function comprovaBINDusuari($usuari, $contrasenya){
	$nom_complet=obteNomComplet($usuari);
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
	#$dn="cn=admin,".$ldapconfig['basedn'];
	$dn=$nom_complet;
		
		
	if ($bind=ldap_bind($ds, $dn, $contrasenya)) {
		if ($bind=ldap_bind($ds)) {
			return true;
		} else {
		 	return false;
	  }
	} else {
	   return false;
		  
	}
	ldap_close($ds);
}
function cercaGrup($codi_grup){
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = _LDAP_STUDENT_BASE_DN;
		
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
	$password=_LDAP_PASSWORD;
	#$dn="cn=admin,".$ldapconfig['basedn'];
	$dn=_LDAP_USER;
		
		
	if ($bind=ldap_bind($ds, $dn, $password)) {
	if ($bind=ldap_bind($ds)) {
	
	 $filter = "("._LDAP_GROUP."=".$codi_grup.")";

// Debug	 
//	 echo $filter;
//         echo "" .  $ldapconfig['basedn'];
		
	 if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		echo("Unable to search ldap server<br>");
		echo("msg:'".ldap_error($ds)."'</br>");#check the message again
	 } else {
		      $number_returned = ldap_count_entries($ds,$search);
		      $info = ldap_first_entry($ds, $search);
		      $info1 = ldap_get_dn($ds, $info);
		      $grup_complet=$info1;
		      return $grup_complet;
	  }
	 } else {
		 echo("Unable to bind anonymously<br>");
		 echo("msg:".ldap_error($ds)."<br>");
	}
	
	
	
	} else {
		
	 echo("Unable to bind to server.</br>");
		
	 echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
		  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
		  #we can figure out the right pattern by searching the user tree
		  #remember to turn on the anonymous search on the ldap server
		  
	}
	ldap_close($ds);
	
}
function cercagrupAlumne($dne){
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;

	$ldapconfig['basedn'] = $dne;
	
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
	$password=_LDAP_PASSWORD;
	#$dn="cn=admin,".$ldapconfig['basedn'];
	$dn=_LDAP_USER;
		
		
	if ($bind=ldap_bind($ds, $dn, $password)) {
	if ($bind=ldap_bind($ds)) {
	
	$filter = "(objectClass=organizationalUnit)";
		
	 if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		echo("Unable to search ldap server<br>");
		echo("msg:'".ldap_error($ds)."'</br>");#check the message again
	 } else {
		      $number_returned = ldap_count_entries($ds,$search);
		      $info = ldap_first_entry($ds, $search);
		      $info1= ldap_get_values($ds, $info, _LDAP_GROUP);
		      $grup_complet=$info1;
		      return $grup_complet;
	  }
	 } else {
		 echo("Unable to bind anonymously<br>");
		 echo("msg:".ldap_error($ds)."<br>");
	}
	
	
	} else {
		
	 echo("Unable to bind to server.</br>");
		
	 echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
		  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
		  #we can figure out the right pattern by searching the user tree
		  #remember to turn on the anonymous search on the ldap server
		  
	}
	ldap_close($ds);
	
}

/**
 * FUNCIONS ESPECIFIQUES PER A CANVIAR LA CONTRSENYA D'USUARI
 * @author Ivan Gomez Romero
 * @since 23/09/2010
 * @license GPL
 */
function webfalteschange_password ($dn, $password,$data, $mode=0, $hash= "")
{

    /* Extract used hash */
    // User MD5 by default
    $hash= "md5";
    
    //search a partir del dn
    //attrs=("shadowLastChange", "userPassword", "uid"));
  

  $test = new passwordMethodMd5();
  if($test instanceOf passwordMethod){
    /* Feed password backends with information */
    $test->dn= $dn;
    $test->attrs= $attrs;
   // echo $test->dn." - ";
    $newpass= $test->generate_hash($password);
    // Update shadow timestamp?
    //print_r($data);
   if (isset($data[0]["shadowlastchange"])){
      $shadow= (int)(date("U") / 86400);
    } else {
      $shadow= 0;
    }
    // Write back modified entry
    //$ldap->cd($dn);
    $attrs= array();

    // Not for groups
    if ($mode == 0){
      // Create SMB Password
      $attrs= generate_smb_nt_hash($password);
      if ($shadow != 0){
        $attrs['shadowLastChange']= $shadow;

      }
    }
    $attrs['userPassword']= array();
    $attrs['userPassword']= $newpass;

    //print_r($attrs);
    $ldap = modify($attrs, $data);
	
    /* Read ! if user was deactivated */
    /*if($deactivated){
      $test->lock_account($config,$dn);
    }*/

    /*if (!$ldap->success()) {
      msg_dialog::display(_("LDAP error"), msgPool::ldaperror($ldap->get_error(), $dn, LDAP_MOD, ERROR_DIALOG));
    } else {*/

      /* Run backend method for change/create */
     /* if(!$test->set_password($password)){
        return(FALSE);
      }*/

      /* Find postmodify entries for this class */
     /* $command= $config->search("password", "POSTMODIFY",array('menu'));

      if ($command != ""){*/
        /* Walk through attribute list */
       /* $command= preg_replace("/%userPassword/", $password, $command);
        $command= preg_replace("/%dn/", $dn, $command);

        if (check_command($command)){
          @DEBUG (DEBUG_SHELL, __LINE__, __FUNCTION__, __FILE__, $command, "Execute");
          exec($command);
        } else {
          $message= sprintf(_("Command '%s', specified as POSTMODIFY for plugin '%s' doesn't seem to exist."), $command, "password");
          msg_dialog::display(_("Configuration error"), $message, ERROR_DIALOG);
        }
      }
    }*/
    return($ldap);
  }
}
 function modify($attrs, $data)
  {
  	include_once(_DIR_CONNEXIO."webfaltes_ldap_con.php");
    if(count($attrs) == 0){
      return (0);
    }
   /* if($this->hascon){
      if ($this->reconnect) $this->connect();
      $r = @ldap_modify($this->cid, LDAP::fix($this->basedn), $attrs);
      $this->error = @ldap_error($this->cid);
      if(!$this->success()){
        $this->error.= $this->makeReadableErrors($this->error,$attrs);
      }*/
    $ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = "ou=All,dc=iesebre,dc=com";
	
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
	$password=_LDAP_PASSWORD;
			#$dn="cn=admin,".$ldapconfig['basedn'];
	$dn=_LDAP_USER;
		if ($bind=ldap_bind($ds, $dn, $password)) {
		  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
			$filter = "(&(objectClass=inetOrgPerson)(uid=".$data[0]['user']."))";
			
			if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
			    echo("Unable to search ldap server<br>");
			    $rs = FALSE;
			    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
			} else {
			    $number_returned = ldap_count_entries($ds,$search);
			    ldap_sort($ds, $search, "cn"); 
			    $info = ldap_get_entries($ds, $search);
			    for ($i=0; $i<$info["count"];$i++) {
			    	$rs = ldap_modify($ds, $info[0]["dn"], $attrs);
					$j=$j+1;
	     		}
		}	    
	} else {
		echo("Unable to bind to server.</br>");
		$rs = FALSE;	
		echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
			  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
			  #we can figure out the right pattern by searching the user tree
			  #remember to turn on the anonymous search on the ldap server		  
	}
			// Usuari i contrasenya vàlids (Control seguretat 1)
	ldap_close($ds);
    return($rs);
  }
  
  function cd($dir)
  {
    if ($dir == ".."){
      $this->basedn = $this->getParentDir();
    } else {
      $this->basedn = LDAP::convert($dir);
    }
  }

function webfaltesgenerate_smb_nt_hash($password)
{
 // global $config;

  # Try to use gosa-si?
  /*if ($config->get_cfg_value("gosaSupportURI") != ""){
  	$res= gosaSupportDaemon::send("gosa_gen_smb_hash", "GOSA", array("password" => $password), TRUE);
    if (isset($res['XML']['HASH'])){
    	$hash= $res['XML']['HASH'];
    } else {
      $hash= "";
    }

    if ($hash == "") {
      msg_dialog::display(_("Configuration error"), _("Cannot generate samba hash!"), ERROR_DIALOG);
      return ("");
    }
  } else {
	  $tmp= $config->get_cfg_value('sambaHashHook')." ".escapeshellarg($password);
	  @DEBUG (DEBUG_LDAP, __LINE__, __FUNCTION__, __FILE__, $tmp, "Execute");
*/
	  $comanda = "perl -MCrypt::SmbHash -e \"print join(q[:], ntlmgen ".$password."), \$/;\"";
	  exec($comanda, $resu);
	 // reset($ar);
	  //$hash= current($ar);

   /* if ($hash == "") {
      msg_dialog::display(_("Configuration error"), sprintf(_("Cannot generate samba hash: running '%s' failed, check the 'sambaHashHook'!"),$config->get_cfg_value('sambaHashHook')), ERROR_DIALOG);
      return ("");
    }
  }
*/
  list($lm,$nt)= explode(":", trim($resu[0]));

  $attrs['sambaLMPassword']= $lm;
  $attrs['sambaNTPassword']= $nt;
  $attrs['sambaPwdLastSet']= date('U');
  $attrs['sambaBadPasswordCount']= "0";
  $attrs['sambaBadPasswordTime']= "0";
  return($attrs);
}
  
function set_password($password)
  {
    return(TRUE);
  }
  
 
  function makeReadableErrors($error,$attrs)
  { 
    global $config;

    if($this->success()) return("");

    $str = "";
    if(preg_match("/^objectClass: value #([0-9]*) invalid per syntax$/", $this->get_additional_error())){
      $oc = preg_replace("/^objectClass: value #([0-9]*) invalid per syntax$/","\\1", $this->get_additional_error());
      if(isset($attrs['objectClass'][$oc])){
        $str.= " - <b>objectClass: ".$attrs['objectClass'][$oc]."</b>";
      }
    }
    if($error == "Undefined attribute type"){
      $str = " - <b>attribute: ".preg_replace("/:.*$/","",$this->get_additional_error())."</b>";
    } 

    @DEBUG(DEBUG_LDAP,__LINE__,__FUNCTION__,__FILE__,$attrs,"Erroneous data");

    return($str);
  }

  function getParentDir($basedn = "")
  {
    if ($basedn==""){
      $basedn = $this->basedn;
    } else {
      $basedn = LDAP::convert($basedn);
    }
    return(preg_replace("/[^,]*[,]*[ ]*(.*)/", "$1", $basedn));
  }
  
   function get_cfg_value($name, $default= "") {
    $name= strtoupper($name);

    /* Check if we have a current value for $name */
    if (isset($this->current[$name])){
      return ($this->current[$name]);
    }

    /* Check if we have a global value for $name */
    if (isset($this->data["MAIN"][$name])){
      return ($this->data["MAIN"][$name]);
    }

    return ($default);
  }
  
 function get_ldap_link($sizelimit= FALSE)
  {
    if($this->ldap === NULL || !is_resource($this->ldap->cid)){

      /* Build new connection */
      $this->ldap= ldap_init ($this->current['SERVER'], $this->current['BASE'],
          $this->current['ADMINDN'], $this->get_credentials($this->current['ADMINPASSWORD']));

      /* Check for connection */
      if (is_null($this->ldap) || (is_int($this->ldap) && $this->ldap == 0)){
        $smarty= get_smarty();
        msg_dialog::display(_("LDAP error"), _("Cannot bind to LDAP. Please contact the system administrator."), FATAL_ERROR_DIALOG);
        exit();
      }

      /* Move referrals */
      if (!isset($this->current['REFERRAL'])){
        $this->ldap->referrals= array();
      } else {
        $this->ldap->referrals= $this->current['REFERRAL'];
      }

      if (!session::global_is_set('size_limit')){
        session::global_set('size_limit',$this->current['LDAPSIZELIMIT']);
        session::global_set('size_ignore',$this->current['LDAPSIZEIGNORE']);
      }
    }

    $obj  = new ldapMultiplexer($this->ldap);
    if ($sizelimit){
      $obj->set_size_limit(session::global_get('size_limit'));
    } else {
      $obj->set_size_limit(0);
    }
    return($obj);
  }
  
function get_credentials($creds)
  {
    if (isset($_SERVER['HTTP_GOSA_KEY'])){
      if (!session::global_is_set('HTTP_GOSA_KEY_CACHE')){
        session::global_set('HTTP_GOSA_KEY_CACHE',array());
      }
      $cache = session::global_get('HTTP_GOSA_KEY_CACHE');
      if(!isset($cache[$creds])){
        $cache[$creds] = webfaltescred_decrypt($creds, $_SERVER['HTTP_GOSA_KEY']);
        session::global_set('HTTP_GOSA_KEY_CACHE',$cache);
      }
      return ($cache[$creds]);
    }
    return ($creds);
  }
function webfaltescred_decrypt($input,$password) {
  $size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
  $iv = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);

  return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $password, pack("H*", $input), MCRYPT_MODE_ECB, $iv);
}
/**
 * OBJECTES ESPECIFICS PER A CANVIAR LA CONTRSENYA D'USUARI
 * @author Ivan Gomez Romero
 * @since 23/09/2010
 * @license GPL
 */
class passwordMethod
{
  var $config = false;
  var $attrs= array();
  var $display = FALSE;
  var $hash= "";
  var $lockable = TRUE;

  // Konstructor
  function passwordMethod($config, $dn="")
  {
  }

  function create_template_hash($attrs)
  {
    if($this->get_hash_name() == ""){
      return("{crypt}N0T$3T4N0W");
    }else{
      return('{'.$this->get_hash().'}').'N0T$3T4N0W';
    }
  }

  function is_locked($config,$dn = "")
  {
    if(!$this->lockable) return FALSE;

    /* Get current password hash */
    $pwd ="";
    if(!empty($dn)){
      $ldap = $config->get_ldap_link();
      $ldap->cd($config->current['BASE']);
      $ldap->cat($dn);
      $attrs = $ldap->fetch();
      if(isset($attrs['userPassword'][0])){
        $pwd = $attrs['userPassword'][0];
      }
    }elseif(isset($this->attrs['userPassword'][0])){
      $pwd = $this->attrs['userPassword'][0];
    }
    return(preg_match("/^[^\}]*+\}!/",$pwd));
  }


  function lock_account($config,$dn = "")
  {
    if(!$this->lockable) return FALSE;

    /* Get current password hash */
    $pwd ="";
    $ldap = $config->get_ldap_link();
    $ldap->cd($config->current['BASE']);
    if(!empty($dn)){
      $ldap->cat($dn);
      $attrs = $ldap->fetch();
      if(isset($attrs['userPassword'][0])){
        $pwd = $attrs['userPassword'][0];
      }
    }elseif(isset($this->attrs['userPassword'][0])){
      $pwd = $this->attrs['userPassword'][0];
      $dn = $this->attrs['dn'];
    }

    /* We can only lock/unlock non-empty passwords */
    if(!empty($pwd)){

      /* Check if this entry is already locked. */
      if(preg_match("/^[^\}]*+\}!/",$pwd)){
        return(TRUE);
      }     
      
      /* Lock entry */
      $pwd = preg_replace("/(^[^\}]+\})(.*$)/","\\1!\\2",$pwd);
      $ldap->cd($dn);
      $ldap->modify(array("userPassword" => $pwd));
      return($ldap->success());
    }
    return(FALSE);
  }


  function unlock_account($config,$dn = "")
  {
    if(!$this->lockable) return FALSE;

    /* Get current password hash */
    $pwd ="";
    $ldap = $config->get_ldap_link();
    $ldap->cd($config->current['BASE']);
    if(!empty($dn)){
      $ldap->cat($dn);
      $attrs = $ldap->fetch();
      if(isset($attrs['userPassword'][0])){
        $pwd = $attrs['userPassword'][0];
      }
    }elseif(isset($this->attrs['userPassword'][0])){
      $pwd = $this->attrs['userPassword'][0];
      $dn = $this->attrs['dn'];
    }

    /* We can only lock/unlock non-empty passwords */
    if(!empty($pwd)){

      /* Check if this entry is already locked. */
      if(!preg_match("/^[^\}]*+\}!/",$pwd)){
        return (TRUE);
      }     
      
      /* Lock entry */
      $pwd = preg_replace("/(^[^\}]+\})!(.*$)/","\\1\\2",$pwd);
      $ldap->cd($dn);
      $ldap->modify(array("userPassword" => $pwd));
      return($ldap->success());
    }
    return(FALSE);
  }


  // this function returns all loaded classes for password encryption
  static function get_available_methods()
  {
    global $class_mapping, $config;
    $ret =false;
    $i =0;

    /* Only */
    if(!session::is_set("passwordMethod::get_available_methods")){
      foreach($class_mapping as $class => $path) {
        if(preg_match('/passwordMethod/i', $class) && !preg_match("/^passwordMethod$/i", $class)){
          $name = preg_replace ("/passwordMethod/i", "", $class);
          $test = new $class($config, "");
          if($test->is_available()) {
            $plugs= $test->get_hash_name();
            if (!is_array($plugs)){
              $plugs= array($plugs);
            }

            foreach ($plugs as $plugname){

              $cfg = $test->is_configurable();

              $ret['name'][$i]= $plugname;
              $ret['class'][$i]=$class;
              $ret['is_configurable'][$i]= $cfg;
              $ret['object'][$i]= $test;
              $ret['desc'][$i] = $test->get_description();
              $ret[$i]['name']  = $plugname;
              $ret[$i]['class'] = $class;
              $ret[$i]['object']= $test;
              $ret[$i]['is_configurable']= $cfg;
              $ret[$i]['desc'] = $test->get_description();
              $ret[$plugname]=$class;                    
              $i++;
            }
          }
        }
      }
      session::set("passwordMethod::get_available_methods",$ret);
    }
    return(session::get("passwordMethod::get_available_methods"));
  }
  

  function get_description()
  {
    return("");
  }


  // Method to let password backends remove additional information besides
  // the userPassword attribute
  function remove_from_parent()
  {
  }


  // Method to let passwords backends manage additional information
  // besides the userAttribute entry
  function set_password($password)
  {
    return(TRUE);
  }


  // Return true if this password method provides a configuration dialog
  function is_configurable()
  {
    return FALSE;
  }


  // Provide a subdialog to configure a password method
  function configure()
  {
    return "";
  }

  
  // Save information to LDAP
  function save($dn)
  {
  }


  // Try to find out if it's our hash...
  static function get_method($password_hash,$dn = "")
  {
    global $config;

    $methods= passwordMethod::get_available_methods();

    foreach ($methods['class'] as $class){

        $test = new $class($config,$dn);
#        All listed methods are available. 
#        if(!$test->is_available())continue;
        $method= $test->_extract_method($password_hash);
        if ($method != ""){
          $test->set_hash($method);
          return $test;
        }
    }

    msg_dialog::display(_("Error"), _("Cannot find a suitable password method for the current hash!"), ERROR_DIALOG);

    return NULL;
  }


  function _extract_method($password_hash)
  {
    $hash= $this->get_hash_name();
    if (preg_match("/^\{$hash\}/i", $password_hash)){
      return $hash;
    }

    return "";
  }


  static function make_hash($password, $hash)
  {
    global $config;

    $methods= passwordMethod::get_available_methods();
    $tmp= new $methods[$hash]($config);
    $tmp->set_hash($hash);
    return $tmp->generate_hash($password);
  }


  function set_hash($hash)
  {
    $this->hash= $hash;
  }


  function get_hash()
  {
    return $this->hash;
  }

  function adapt_from_template($dn)
  {
    return($this);
  }
}
class passwordMethodMd5 extends passwordMethod
{
	function passwordMethodMd5($config)  
	{
	}


	function is_available()
	{
		if (function_exists('md5')){
			return(true);
		}else{
			return false;
		}
	}


	function generate_hash($pwd)
	{
		return  "{MD5}".base64_encode( pack('H*', md5($pwd)));
	}


  function get_hash_name()
  {
    return "md5";
  }

}
?>