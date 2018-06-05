<?php

class Active_directory {

    public static function test($auth_user, $auth_pass){
        $auth_user = substr($auth_user,0,strpos($auth_user,'@'));        
        $ldap['host'] = "smig.corp";
        $ldap['port'] = 389;
        $OU = "Semen Indonesia";
        $base_dn = "OU={$OU} ,DC=smig, DC=corp";
        $filter = "(&(objectClass=user)(objectCategory=person)(cn=*)(mailnickname=$auth_user))";
        $ldap['user'] = $auth_user.'@'.$ldap['host'];
        $ldap['pass'] = $auth_pass;
        $ldap['conn'] = @ldap_connect($ldap['host'], $ldap['port'])
                or die("Could not conenct to {$ldap['host']}");
        ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
        $ldap['bind'] = @ldap_bind($ldap['conn'], $ldap['user'], $ldap['pass']);
        if ($ldap['bind']) {
            if (!($search = @ldap_search($ldap['conn'], $base_dn, $filter))) {
                //die("Unable to search ldap server");
                return false;
            } else {
                return true;
            }            
        } else {
            return false;
        }
        
    }

}
