<?php
class exchange_rate_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "SELECT b.EXCHANGE_RATE_ID, b.CURRENCY_DATE, b.CURRENCY_VALUE, a.CURRENCY_CODE as CC1, c.CURRENCY_CODE as CC2,
				a.CURRENCY_ID as CI1, c.CURRENCY_ID as CI2
				from M_ADM_EXCHANGE_RATE b
				JOIN M_ADM_CURRENCY a ON b.CURRENCY_FROM=a.CURRENCY_ID
				JOIN M_ADM_CURRENCY c ON b.CURRENCY_TO=c.CURRENCY_ID order by b.CURRENCY_FROM asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($currency_from,$currency_to,$currency_date,$currency_value)
	{
		$this->db->query("insert into M_ADM_EXCHANGE_RATE (EXCHANGE_RATE_ID,CURRENCY_FROM,CURRENCY_TO,CURRENCY_DATE,CURRENCY_VALUE)values (SEQ_EXCHANGE_RATE.nextval,".$currency_from.",".$currency_to.",to_date('".$currency_date."','YYYY/MM/DD'),".$currency_value.")");
	}

	public function edit($exchange_rate_id,$currency_from,$currency_to,$currency_date,$currency_value)
	{
		$this->db->query("update M_ADM_EXCHANGE_RATE set CURRENCY_FROM=".$currency_from.", CURRENCY_TO=".$currency_to.", CURRENCY_DATE=to_date('".$currency_date."','YYYY/MM/DD'), CURRENCY_VALUE=".$currency_value." where EXCHANGE_RATE_ID=".$exchange_rate_id."");
	}

	public function delete($exchange_rate_id)
	{
		$this->db->query("delete from M_ADM_EXCHANGE_RATE where EXCHANGE_RATE_ID='$exchange_rate_id'");
	}

}
?>
