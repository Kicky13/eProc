<?php
class vnd_perf_who_app extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = 'VND_PERF_WHO_APP';
	}
    
    public function show_list_tahap1()
    {
        $sql="SELECT ADM_EMPLOYEE.ID, ADM_EMPLOYEE.FULLNAME FROM
    	ADM_POS INNER JOIN ADM_DEPT ON ADM_POS.DEPT_ID=ADM_DEPT.DEPT_ID INNER JOIN ADM_COMPANY ON ADM_DEPT.DEPT_COMPANY=ADM_COMPANY.COMPANYID
    	LEFT JOIN APP_GRP_MENU ON ADM_POS.GROUP_MENU=APP_GRP_MENU.APP_GRP_ID INNER JOIN ADM_EMPLOYEE ON ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID  
        WHERE APP_GRP_MENU.APP_GRP_ID IN(83,121)";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(!empty($result))
        {
            return $result;
        }
        else
        {
            return array();
        }
    }
    
    public function show_list_tahap2()
    {
        $sql="SELECT ADM_EMPLOYEE.ID, ADM_EMPLOYEE.FULLNAME FROM
    	ADM_POS INNER JOIN ADM_DEPT ON ADM_POS.DEPT_ID=ADM_DEPT.DEPT_ID INNER JOIN ADM_COMPANY ON ADM_DEPT.DEPT_COMPANY=ADM_COMPANY.COMPANYID
    	LEFT JOIN APP_GRP_MENU ON ADM_POS.GROUP_MENU=APP_GRP_MENU.APP_GRP_ID INNER JOIN ADM_EMPLOYEE ON ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID  
        WHERE APP_GRP_MENU.APP_GRP_ID IN(102,81,82)";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(!empty($result))
        {
            return $result;
        }
        else
        {
            return array();
        }
    }
    
    function update_who_app($datawhoapp,$tahap)
    {
        $this->db->update('VND_PERF_WHO_APP', $datawhoapp,array('TAHAP'=>$tahap));
    }
}
?>