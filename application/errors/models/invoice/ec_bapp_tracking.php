<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_bapp_tracking extends MY_Model {
    public $table = 'EC_BAPP_TRACKING';
    protected $timestamps = FALSE;
    public $increments = FALSE;
    public $primary_key = 'ID_BAPP';

    public function history($id){
      $sql = 'select t.*,
          TO_CHAR (t.UPDATE_AT,\'DD Mon YYYY hh24:mi:ss \') AS UPDATED,
          case t.STATUS
            when \'1\' then \'Draft\'
            when \'2\' then \'Submit\'
            when \'3\' then \'Approve\'
            when \'4\' then \'Reject\'
            else \'Not defined\'
          end STATUS_BAPP
          from '.$this->table.' t where t.ID_BAPP = '.$id.'
          order by t.UPDATE_AT desc
      ';
      return $this->db->query($sql)->result_array();
    }
}
