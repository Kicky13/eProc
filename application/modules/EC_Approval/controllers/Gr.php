<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gr extends MX_Controller {

    private $USER;

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        // $this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
    }

    public function index() {
        $this->load->library('Authorization');
        $data['title'] = "Approval GR";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('jquery.redirect.js');
        $this->layout->add_js('pages/invoice/EC_common.js');

        $this->layout->add_css('plugins/daterangepicker/daterangepicker.css');
        $this->layout->add_js('plugins/daterangepicker/daterangepicker.js');

        $this->layout->add_js('pages/invoice/Approval_gr.js');

        $listLevel = $this->listLevelAccess();
        $data['levelAcess'] = $listLevel[0];

        $this->layout->render('EC_Approval/gr/list', $data);
    }

    public function detail() {
        $data['title'] = "Detail GR";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/Approval_gr_detail.js');

        $this->load->model('invoice/ec_gr_status', 'egs');

        $listLevel = $this->listLevelAccess();
        $data['levelAcess'] = $listLevel[0];

        $data['gr_year'] = $this->input->post('year');
        $data['po_no'] = $this->input->post('po_no');
        $data['vendor'] = $this->input->post('vendor');
        $data['act'] = $this->input->post('act');
        $data['detail_type'] = $this->input->post('detail_type');
        if ($listLevel[0] == 0 && $data['detail_type'] == 'rr') {
            
            $data['urlsubmit'] = '';
            $data['rr'] = $this->input->post('rr');
            $data['desc'] = $this->input->post('desc');
            $data['jenispo'] = $this->input->post('jenispo');
            
            switch ($data['jenispo']) {
                case 'BAHAN':
                    $data['detail'] = $this->egs->detailGrBahan($data['rr'], $data['po_no']);
//                    echo $this->db->last_query();die();
                    break;
                default:
                    $data['detail'] = $this->egs->detailGrSparepart($data['rr'], $data['po_no']);
//                    echo $this->db->last_query();die();
                    break;
            }
        } else {
            $data['urlsubmit'] = site_url('EC_Approval/Gr/approve');
            $data['lot_number'] = $this->input->post('lot_number');

            $po_rr = $this->egs->as_array()->order_by('GR_NO,GR_ITEM_NO')->get_all(array('LOT_NUMBER' => $data['lot_number']));
            $gr = array();


            $temp_lot = $this->db->select('STATUS,REJECTED_BY,NOTE_REJECT,REJECTED_GR')->where(array('LOT_NUMBER' => $data['lot_number']))->get('EC_GR_LOT')->result_array();

            if ($temp_lot[0]['STATUS'] == 4) {
                $data['reject_by'] = $temp_lot[0]['REJECTED_BY'];
                $data['note_reject'] = $temp_lot[0]['NOTE_REJECT'];

                $po_rr = array();
                $i = 0;
                foreach ($temp_lot as $value) {
                    $temp_1 = explode('-', $value['REJECTED_GR']);
                    foreach ($temp_1 as $val) {
                        $temp_2 = explode('#', $val);
                        $po_rr[$i]['PO_NO'] = $temp_2[0];
                        $po_rr[$i]['PO_ITEM_NO'] = $temp_2[1];
                        $po_rr[$i]['GR_NO'] = $temp_2[2];
                        $po_rr[$i]['GR_YEAR'] = $temp_2[3];
                        $po_rr[$i]['JENISPO'] = $temp_2[4];
                        $i++;
                    }
                }
                //var_dump($po_rr);die();
            }

            foreach ($po_rr as $val) {
                switch ($val['JENISPO']) {
                    case 'BAHAN':
                        $barang = $this->egs->detailGrBahan($val['GR_NO'], $val['PO_NO'], $val['PO_ITEM_NO']);
                        foreach ($barang as $value) {
                            $gr[] = $value;
                        }
                        break;
                    default:
                        $no = $this->db->where(array('LFBNR' => $val['GR_NO'], 'BWART' => '105', 'LFGJA' => $val['GR_YEAR']))->get('EC_GR_SAP')->row_array();

                        $sparepart = $this->egs->detailGrSparepart($no['BELNR'], $val['PO_NO'], $val['PO_ITEM_NO']);

                        foreach ($sparepart as $value) {
                            $gr[] = $value;
                        }
                        break;
                }
            }
            $data['detail'] = $gr;
        }
        $this->layout->render('EC_Approval/gr/form', $data);
    }

    public function cetak() {
        $this->load->library('Authorization');
        $data['title'] = "Report GR dan Lot";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('jquery.redirect.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/Approval_gr_cetak.js');

        $listLevel = $this->listLevelAccess();
        $data['levelAcess'] = $listLevel[0];
        $this->layout->render('EC_Approval/gr/listCetak', $data);
    }

    public function listGR() {
        $this->load->model('invoice/ec_gr_status', 'egs');
        $gr = $this->input->post('data');

        /* Get Data GR */
        $data['detail'] = array();
        $data['gr'] = implode('#', $gr);

        foreach ($gr as $val) {
            $temp = explode(';', $val);
            //var_dump($temp);die();
            switch ($temp[3]) {
                case 'BAHAN':
                    $data['detail'][$temp[1]] = $this->egs->detailGrBahan($temp[1], $temp[0]); // RR,PO
                    break;
                default:
                    $data['detail'][$temp[1]] = $this->egs->detailGrSparepart($temp[1], $temp[0]);
                    break;
            }
            $count++;
        }
        $data['count'] = $count;
        $this->load->view('gr/detailGR', $data);
    }

    public function createLot() {
        $this->load->model('invoice/ec_gr_lot', 'egl');
        $this->load->model('invoice/ec_gr_status', 'egs');

        $stringGR = $this->input->post('data');
        $print_type = $this->input->post('print_type');

        //var_dump($this->input->post());die();

        $lot_item = explode('#', $stringGR);

        $data = array('CREATED_BY' => $this->session->userdata('FULLNAME'), 'PRINT_TYPE' => $print_type);

        $this->db->trans_begin();

        $lot_number = $this->egl->insert($data);
        $no_gr = array();
        $gr_no = array();

        $index = 0;
        foreach ($lot_item as $val) {
            $detail_item = explode(';', $val);
            $temp = $this->db->where(array('BELNR' => $detail_item[1]))->get('EC_GR_SAP')->result_array();
            foreach ($temp as $key => $value) {
                $gr_no[] = $value['LFBNR'];
                $no_gr[$index]['GR_NO'] = $value['LFBNR'];
                $no_gr[$index]['GR_YEAR'] = $value['LFGJA'];
                $index++;
            }
        }

        $data_update = array(
            'LOT_NUMBER' => $lot_number,
            'STATUS' => 1
        );

        foreach ($no_gr as $value) {
            $this->egs->update_item($value, $data_update);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $pesan = 'Loting GR Number : {' . implode(',', array_unique($gr_no)) . '} GAGAL';
            $this->session->set_flashdata('message', $pesan);
        } else {
            $this->db->trans_commit();

            /* SEND MESSAGE TO APPROVAL 2 */
            $data_GR = $this->db->where(array('LOT_NUMBER' => $lot_number))->get('EC_GR_STATUS')->result_array();
            $this->notifikasiApproveGRLevel($data_GR);

            /* SUCESS NOTIFICATION */
            $pesan = 'Lot No. ' . $lot_number . ' Created. Loting GR Number : {' . implode(',', array_unique($gr_no)) . '} BERHASIL';
            $this->session->set_flashdata('message', $pesan);
        }
        redirect('EC_Approval/Gr');
    }

    public function approve() {
        $this->load->model('invoice/ec_gr_lot', 'egl');
        $this->load->model('invoice/ec_gr_status', 'egs');

        $lot_number = $this->input->post('LOT_NUMBER');
        $status = $this->input->post('status');

        $this->db->trans_begin();

        if ($status) {
//
//            /* cari statusnya dulu di database */
            $lot = $this->db->where(array('LOT_NUMBER' => $lot_number))->get('EC_GR_LOT')->row_array();            

            $nextStatus = $lot['STATUS'] + 1;
            $_updateData = array('STATUS' => $nextStatus);

            if ($nextStatus == 2) {
                $_updateData['APPROVED1_BY'] = $this->session->userdata('FULLNAME');
            }else if($nextStatus == 3) {
                $_updateData['APPROVED2_BY'] = $this->session->userdata('FULLNAME');
            }
//            var_dump($_updateData);die();  
        } else {
            $listGR = $this->db->select('GR_NO,PO_ITEM_NO,PO_NO,GR_YEAR,JENISPO')->where(array('LOT_NUMBER' => $lot_number))->group_by('GR_NO,PO_ITEM_NO,PO_NO,GR_YEAR,JENISPO')->get('EC_GR_STATUS')->result_array();
            $gr = array();
            foreach ($listGR as $value) {
                $gr[] = $value['PO_NO'] . '#' . $value['PO_ITEM_NO'] . '#' . $value['GR_NO'] . '#' . $value['GR_YEAR'] . '#' . $value['JENISPO'];
            }
            $nextStatus = 4; // Reject
            $_updateData = array('STATUS' => $nextStatus);
            $_updateData['REJECTED_BY'] = $this->session->userdata('FULLNAME');
            $_updateData['NOTE_REJECT'] = $this->input->post('msg');
            $_updateData['REJECTED_GR'] = implode('-', $gr);
            $_updateData['APPROVED1_BY'] = '';
            $_updateData['APPROVED1_AT'] = '';
            $_updateData['APPROVED2_BY'] = '';
            $_updateData['APPROVED2_AT'] = '';
        }
//
        $whereData = array('LOT_NUMBER' => $lot_number);
        $this->egl->update($_updateData, $whereData);
        $this->egs->update(array('STATUS' => $nextStatus), $whereData);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $pesan = 'Approval LOT nomer ' . $lot_number . ' gagal dilakukan';
            $this->session->set_flashdata('message', $pesan);
        } else {              
            $this->db->trans_commit(); 
            if ($nextStatus == 2) {
                $data_GR = $this->db->where(array('LOT_NUMBER' => $lot_number))->get('EC_GR_STATUS')->result_array();
                $jumlahGR=count($data_GR);
                for($i=0;$i<$jumlahGR;$i++){
                   $BA[$i]=$this->db->select('PRUEFLOS as BA')->where(array('BELNR'=>$data_GR[$i]['GR_NO']))->get('EC_GR_SAP')->row_array();                                  
                   if($BA[$i]['BA']!=NULL and $BA[$i]['BA']!="0"){
                       $BAH[$i]=$this->db->select('EC_POMUT_DETAIL_SAP.NO_BA, EC_POMUT_HEADER_SAP.STATUS')->from('EC_POMUT_DETAIL_SAP')->join('EC_POMUT_HEADER_SAP', 'EC_POMUT_DETAIL_SAP.NO_BA = EC_POMUT_HEADER_SAP.NO_BA')->where('EC_POMUT_DETAIL_SAP.PRUEFLOS',$BA[$i]['BA'])->get()->row_array();
                       if($BAH[$i]['STATUS']==0){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Belum Dibuat';
                       }else if($BAH[$i]['STATUS']==1){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Sudah Dibuat';
                       }else if($BAH[$i]['STATUS']==2){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Sudah Diapprove oleh Kasi Pengadaan Bahan';
                       }else if($BAH[$i]['STATUS']==3){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Sudah Diapprove oleh Vendor';
                       }
                       $data_GR[$i]['NO_BA']=$BAH[$i]['NO_BA'];                       
                   }else{
                       $data_GR[$i]['NO_BA']="Tidak Membutuhkan BA Analisa Mutu";
                       $data_GR[$i]['POSISI']='-';
                   } 
                }                 
//                var_dump($data_GR);die();
                $this->notifikasiApproveGRLevel($data_GR);
            }
            else if($nextStatus == 3) {
                $data_GR = $this->db->where(array('LOT_NUMBER' => $lot_number))->get('EC_GR_STATUS')->result_array();
                $jumlahGR=count($data_GR);
                for($i=0;$i<$jumlahGR;$i++){
                   $BA[$i]=$this->db->select('PRUEFLOS as BA')->where(array('BELNR'=>$data_GR[$i]['GR_NO']))->get('EC_GR_SAP')->row_array();                                  
                   if($BA[$i]['BA']!=NULL and $BA[$i]['BA']!="0"){
                       $BAH[$i]=$this->db->select('EC_POMUT_DETAIL_SAP.NO_BA, EC_POMUT_HEADER_SAP.STATUS')->from('EC_POMUT_DETAIL_SAP')->join('EC_POMUT_HEADER_SAP', 'EC_POMUT_DETAIL_SAP.NO_BA = EC_POMUT_HEADER_SAP.NO_BA')->where('EC_POMUT_DETAIL_SAP.PRUEFLOS',$BA[$i]['BA'])->get()->row_array();
                       if($BAH[$i]['STATUS']==0){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Belum Dibuat';
                       }else if($BAH[$i]['STATUS']==1){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Sudah Dibuat';
                       }else if($BAH[$i]['STATUS']==2){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Sudah Diapprove oleh Kasi Pengadaan Bahan';                       
                       }else if($BAH[$i]['STATUS']==3){
                           $data_GR[$i]['POSISI']='BA Analisa Mutu Sudah Diapprove oleh Vendor';
                       }
                       $data_GR[$i]['NO_BA']=$BAH[$i]['NO_BA'];                       
                   }else{
                       $data_GR[$i]['NO_BA']="Tidak Membutuhkan BA Analisa Mutu";
                       $data_GR[$i]['POSISI']='-';
                   } 
                }  
//                var_dump($data_GR);die();
                $this->notifikasiApproveGR($data_GR);
            }
            $temp = $status ? 'Approval' : 'Reject';
            $pesan = $temp . ' LOT nomer ' . $lot_number . ' berhasil dilakukan';
            $this->session->set_flashdata('message', $pesan);
        }
        redirect('EC_Approval/Gr');
    }

    public function data($check = null) {
        $tmp = $this->_data($check);
//        print_r($tmp);die()                ;
        //echo $this->db->last_query();die();
        $result = array();
        $_result = array();
        /* grouping berdasarkan no_rr */
        if (!empty($tmp)) {
            foreach ($tmp as $k => $v) {
                $rr = $v['NO_RR'];
                if (!isset($result[$rr])) {
                    $_result[$rr] = array();
                }
                array_push($_result[$rr], $v);
            }
        }
        if (!empty($_result)) {
            foreach ($_result as $_r) {
                $_tmp = array();
                foreach ($_r as $_s) {
                    array_push($_tmp, array('GR_NO' => $_s['GR_NO'], 'GR_ITEM_NO' => $_s['GR_ITEM_NO'], 'GR_YEAR' => $_s['GR_YEAR']));
                }
                $_r[0]['DATA_ITEM'] = json_encode($_tmp);
                array_push($result, $_r[0]);
            }
        }
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('data' => $result)));
    }

    public function getGrQuery($status = null) {
        $listPlant = $this->listPlantAccess();
        $listLevel = $this->listLevelAccess();
        $_lp = implode('\',\'', $listPlant);
        $_ll = implode('\',\'', $listLevel);

        if ($status == 1) {  // Report tab Request
            $_ll = "1','2";
        } else if ($status == 3) { // Report tab Approved
            $_ll = "3";
        } else if ($status == 4) { // Report tab Reject
            $_ll = "4";
        } else if ($status == 14) { // Report tab Reject
            $_ll = "0','4";
        }

        $sql = <<<SQL
		select EGS.PO_NO
			,EGS.PO_ITEM_NO
			,EGS.GR_NO
			,EGS.GR_ITEM_NO
			,EGS.GR_YEAR
			,EGS.JENISPO
			,EG.TXZ01
			,EG.NAME1
			,EG.BUDAT DOC_DATE
			,EG.LFBNR NO_RR
			,EGS.LOT_NUMBER
			,EG.ERNAM,
                        EG.BSART
			--,EGS.GR_NO
			--,EGS.JENISPO
			from EC_GR_STATUS EGS
			join EC_GR_SAP EG
			on EG.EBELN = EGS.PO_NO
			   AND EG.EBELP = EGS.PO_ITEM_NO
			   AND EG.BELNR = EGS.GR_NO
			   AND EG.BUZEI = EGS.GR_ITEM_NO
			   AND EG.GJAHR = EGS.GR_YEAR
			where EGS.JENISPO = 'BAHAN' and EGS.PLANT in ('{$_lp}') and EGS.STATUS in ('{$_ll}')
			union
			select EGS.PO_NO
				,EGS.PO_ITEM_NO
				,EGS.GR_NO
				,EGS.GR_ITEM_NO
				,EGS.GR_YEAR
				,EGS.JENISPO
				,EG.TXZ01
				,EG.NAME1
				,EG.BUDAT DOC_DATE
				,(select max(BELNR) from EC_GR_SAP where LFBNR = EGS.GR_NO and LFPOS = EGS.GR_ITEM_NO and LFGJA = EGS.GR_YEAR AND BWART = 105) NO_RR
				,EGS.LOT_NUMBER
				,EG.ERNAM,
                                EG.BSART
				--,EGS.JENISPO
				--,EGS.GR_NO
			from EC_GR_STATUS EGS
			join EC_GR_SAP EG
			on EG.EBELN = EGS.PO_NO
			   AND EG.EBELP = EGS.PO_ITEM_NO
			   AND EG.BELNR = EGS.GR_NO
			   AND EG.BUZEI = EGS.GR_ITEM_NO
			   AND EG.GJAHR = EGS.GR_YEAR
			where EGS.JENISPO = 'SPARE_PART' and EGS.PLANT in ('{$_lp}') and EGS.STATUS in ('{$_ll}')
SQL;
        
        return $sql;
    }

    /* ambil semua gr bahan / spare part yang belum diapprove */

    public function _data($status = null) {
        $ROLE_GR = $this->getRoleApprovalGR();

        $sql = 'SELECT * FROM(';
        $sql .= $this->getGrQuery($status);
        $sql .= ")A ";
        $sql .= empty($ROLE_GR) ? "" : "WHERE A.ERNAM IN ('$ROLE_GR')";
        //echo $sql;die();
        return $this->db->query($sql, false)->result_array();
    }

    public function data_loted($status = null) {
        $data = $this->_data_loted($status);
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('data' => $data)));
    }

    private function _data_loted($status = null) {
        $sql = "
			SELECT DISTINCT EGL.LOT_NUMBER
				,STATUS
				,TO_CHAR(CREATED_AT,'dd/mm/yyyy') AS CREATE_DATE
				,CREATED_BY
				,TO_CHAR(APPROVED1_AT,'dd/mm/yyyy') AS APPR1_DATE
				,APPROVED1_BY
				,TO_CHAR(APPROVED2_AT,'dd/mm/yyyy') AS APPR2_DATE
				,APPROVED2_BY
				,PO_NO
				,GR_YEAR
				,NAME1 AS VENDOR
				,GR.JENISPO
				,REJECTED_BY
				,PRINT_TYPE, BSART
			FROM EC_GR_LOT EGL
			JOIN (
			SELECT * FROM (";
        $sql .= $this->getGrQuery($status);
        $sql .= '
				)
			)GR ON EGL.LOT_NUMBER = GR.LOT_NUMBER';

        //echo $sql;die;
        return $this->db->query($sql)->result_array();
    }

    private function listPlantAccess() {
        $this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
        /* dapatkan role untuk fitur verifikasi ini */
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->user_email);
        $plant = array();
        $_tmp = $this->db->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->like('ROLE_AS', 'GUDANG', 'after')->get('EC_ROLE_USER')->result_array();
        $role = array();
        if (!empty($_tmp)) {
            foreach ($_tmp as $_t) {
                array_push($role, $_t['ROLE_AS']);
            }
            $this->load->model('invoice/ec_role_access', 'era');
            $era = $this->db->where('OBJECT_AS = \'PLANT\' AND ROLE_AS in (\'' . implode('\',\'', $role) . '\')')->get('EC_ROLE_ACCESS')->result_array();
            if (!empty($era)) {
                foreach ($era as $_p) {
                    $plant = array_merge($plant, explode(',', $_p['VALUE']));
                }
            }
        }
        /* cari plant untuk role yang dimiliki */
        return array_unique($plant);
    }

    private function listLevelAccess() {
        $this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
        /* dapatkan role untuk fitur verifikasi ini */
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->user_email);
        $level = array();
        $_tmp = $this->db->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->like('ROLE_AS', 'APPROVAL GR', 'after')->get('EC_ROLE_USER')->result_array();

        $role = array();
        if (!empty($_tmp)) {
            foreach ($_tmp as $_t) {
                array_push($role, $_t['ROLE_AS']);
            }
            $this->load->model('invoice/ec_role_access', 'era');
            $era = $this->db->where('OBJECT_AS = \'LEVEL\' AND ROLE_AS in (\'' . implode('\',\'', $role) . '\')')->get('EC_ROLE_ACCESS')->result_array();
            if (!empty($era)) {
                foreach ($era as $_p) {
                    /* kurangkan 1 supaya menghasilkan level dibawahnya, level 1 itu menjadikan status gr menjadi 1, jadi status sebelumnya 0 ( level - 1 ) */
                    $level = array_merge($level, explode(',', $_p['VALUE'] - 1));
                }
            }
        }
        /* cari plant untuk role yang dimiliki */
        return array_unique($level);
    }

    public function getRoleApprovalGR() {
        $this->user_email = $this->session->userdata('EMAIL');
        $email_login = explode('@', $this->user_email);
        $temp = $this->db->select('ACCESS')->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->get('EC_M_ROLE_APPROVAL_GR')->result_array();
        $ret = array();

        foreach ($temp as $value) {
            $ret[] = $value['ACCESS'];
        }
        return implode("','", $ret);
    }

    public function notifikasiApproveGR($data_GR) {
        $this->load->model('invoice/ec_gr_sap', 'gr_sap');
                
        $_data = array();
        foreach ($data_GR as $val) {
            $temp = $this->gr_sap->as_array()->get_all(array('BELNR' => $val['GR_NO'], 'GJAHR' => $val['GR_YEAR']));
            foreach ($temp as $a => $value) {
                $_data[] = $value;
            }
        }

        $table = '';
        $tableBA='';
        $keteranganBA='';
        if (!empty($_data)) {
            $table = $this->buildTable($_data);
            $keteranganBA='<h2 style="text-align:center;">Detail Status BA Analisa Mutu</h2>';
            $tableBA = $this->buildTableBA($data_GR); 
        }

        $this->load->model(array('vnd_header'));
        $data_vendor = $this->vnd_header->get(array('VENDOR_NO' => $_data['LIFNR']));

        //var_dump($data_GR);die();

        $note = 'Note : <div>Faktur pajak dengan kode 030 agar diproses ke dalam E-Invoice paling lambat tanggal 5 bulan berikutnya setelah masa <br>
						Kode Faktur Pajak selain 030 agar diproses kedalam E-Invoice paling lambat 3 bulan setelah masa Faktur Pajak dibuat<br>
						Apabila terlambat potensi denda ditanggung rekanan</div>';
        $data = array(
            'content' => '
					List Dokumen RR Approved on ' . date('d M Y H:i:s') . '<br>
					' . $table . '<br/>'.$keteranganBA.$tableBA.'<br>
					<br><br><hr><br>' . $note,
            'title' => 'Dokumen RR ' . $_data[0]['BELNR'] . ' Approved',
            'title_header' => 'Dokumen RR ' . $_data[0]['BELNR'] . ' Approved',
        );
//        $message = $this->load->view('EC_Notifikasi/approveInvoice', $data);
        $message = $this->load->view('EC_Notifikasi/approveInvoice', $data, TRUE);
        $_to = $data_vendor['EMAIL_ADDRESS'];
//        var_dump($_to);die(); 
//        $_to = 'yuwaka33@gmail.com';
        $subject = 'Dokumen RR ' . $_data[0]['BELNR'] . ' Approved [E-Invoice Semen Indonesia]';
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
    }

    public function notifikasiApproveGRLevel($data_GR) {
        /* $data_GR[0]['GR_NO'] = '5000001629';
          $data_GR[0]['GR_YEAR'] = '2017';
          $data_GR[0]['LOT_NUMBER'] = '1';
          $data_GR[0]['PLANT'] = '7702'; */

        $this->load->model('invoice/ec_gr_sap', 'gr_sap');
        $_data = array();
        foreach ($data_GR as $val) {
            $temp = $this->gr_sap->as_array()->get_all(array('BELNR' => $val['GR_NO'], 'GJAHR' => $val['GR_YEAR']));
            foreach ($temp as $a => $value) {
                $_data[] = $value;
            }
        }
//        var_dump($data_GR);die();
        $table = '';
        $tableBA='';
        $keteranganBA='';
        if (!empty($_data)) {
            $table = $this->buildTable($_data);            
            $keteranganBA='<h2 style="text-align:center;">Detail Status BA Analisa Mutu</h2>';
            $tableBA = $this->buildTableBA($data_GR);            
        }

        $plant = $data_GR[0]['PLANT'];
        $level = $data_GR[0]['STATUS'] + 1;

        // cari user yang akan menerima email berdasarkan plant GR 
        $sql = <<<SQL
		SELECT USERNAME FROM EC_ROLE_USER ERU
			JOIN EC_ROLE_ACCESS ERA ON ERA.ROLE_AS = ERU.ROLE_AS AND ERA.ROLE_AS LIKE 'GUDANG%' AND ERA.OBJECT_AS = 'PLANT' AND ERA.VALUE LIKE '%{$plant}%'
			WHERE ERU.USERNAME IN (
			SELECT USERNAME
			FROM EC_ROLE_USER ERU
			WHERE ERU.ROLE_AS = 'APPROVAL GR LVL {$level}' AND ERU.STATUS = 1
			)
SQL;
        $listEmail = $this->db->query($sql)->result_array();
//        var_dump($listEmail);die();
        if (!empty($listEmail)) {
            $emailnya = array();
            foreach ($listEmail as $_email) {
                array_push($emailnya, $_email['USERNAME'] . '@SEMENINDONESIA.COM');
            }
            $data = array(
                'content' => '
						LOT No. ' . $data_GR[0]['LOT_NUMBER'] . ' telah dibuat dan membutuhkan approval. <br>
						Berikut list GR pada LOT No. ' . $data_GR[0]['LOT_NUMBER'] . ' : <br>'
                . $table.'<br/>'.$keteranganBA.$tableBA,
                'title' => 'LOT No. ' . $data_GR[0]['LOT_NUMBER'] . ' Mohon Diapprove',
                'title_header' => 'LOT No. ' . $data_GR[0]['LOT_NUMBER'] . ' Mohon Diapprove',
                'url' => site_url('Login')
            ); 
//              $message = $this->load->view('EC_Notifikasi/approveInvoice', $data);
            $message = $this->load->view('EC_Notifikasi/approveInvoice', $data, TRUE);
            $_to = $emailnya;
//            var_dump($_to);die(); 
//            $_to = 'yuwaka33@gmail.com';
            $subject = 'LOT No. ' . $data_GR[0]['LOT_NUMBER'] . ' Mohon Diapprove [E-Invoice Semen Indonesia]';
            Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
        }
    }

    private function buildTable($listGR) {
        $tableGR = array(
            '<table border=1 width="650" style="font-size:10px">'
        );
        $thead = '<thead>
                                <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">PO NO</th>
                                                <th class="text-center">PO ITEM NO</th>
                                                <th class="text-center">NO GR</th>
                                                <th class="text-center">GR YEAR</th>
                                                <th class="text-center">MATERIAL</th>
                                                <th class="text-center">VENDOR</th>
                                </tr>
                </thead>
				';
        $tbody = array();
        $no = 1;
        foreach ($listGR as $gr) {
            $_tr = '<tr>
					<td>' . $no++ . '</td>
					<td>' . $gr['EBELN'] . '</td>
					<td>' . $gr['EBELP'] . '</td>
					<td>' . $gr['BELNR'] . '</td>
					<td>' . $gr['LFGJA'] . '</td>
					<td>' . $gr['TXZ01'] . '</td>
					<td>' . $gr['NAME1'] . '</td>
			</tr>';
            array_push($tbody, $_tr);
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }
    
    private function buildTableBA($listGR) {
        $tableGR = array(
            '<table border=1 width="650" style="font-size:10px">'
        );
        $thead = '<thead>
                                <tr>
                                                <th class="text-center">NO</th>                                                
                                                <th class="text-center">NO GR</th>
                                                <th class="text-center">NO BA</th>
                                                <th class="text-center">STATUS BA</th>                                                
                                </tr>
                </thead>
				';
        $tbody = array();
        $no = 1;
        foreach ($listGR as $gr) {
            $_tr = '<tr>
					<td>' . $no++ . '</td>
					<td>' . $gr['GR_NO'] . '</td>
					<td>' . $gr['NO_BA'] . '</td>
					<td>' . $gr['POSISI'] . '</td>					
			</tr>';
            array_push($tbody, $_tr);
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }

    public function showData() {
        //$sql = "SELECT * FROM EC_GR_LOT WHERE LOT_NUMBER = 75";
        //$sql = "SELECT * FROM EC_GR_STATUS WHERE LOT_NUMBER = 66";
        //$sql = "UPDATE EC_GR_STATUS SET STATUS=1 WHERE STATUS = 4";
        //$sql = "UPDATE EC_GR_LOT SET STATUS=1 WHERE STATUS = 4";
        //$data = $this->db->query($sql);

        $sql = "SELECT * FROM EC_ROLE_ACCESS WHERE ROLE_AS = 'APPROVAL GR LVL 1' AND OBJECT_AS = 'LEVEL'";
        //$sql = "UPDATE EC_ROLE_ACCESS SET VALUE='1,4' WHERE ROLE_AS = 'APPROVAL GR LVL 1' AND OBJECT_AS = 'LEVEL'";
        $data = $this->db->query($sql)->result_array();
        var_dump($data);
    }

    public function Test() {
        $gr = '6010005315' . ';' . '5001187963' . ';' . '2017' . ';' . 'SPARE_PART';
        $this->load->model('invoice/ec_gr_status', 'egs');
        //$gr = $this->input->post('data');

        /* Get Data GR */
        $data['detail'] = array();
        $data['gr'] = implode('#', $gr);

        $count = 0;

        foreach ($gr as $val) {
            $temp = explode(';', $val);
            //var_dump($temp);die();
            switch ($temp[3]) {
                case 'BAHAN':
                    $data['detail'][$temp[1]] = $this->egs->detailGrBahan($temp[1], $temp[0]); // RR,PO
                    break;
                default:
                    $data['detail'][$temp[1]] = $this->egs->detailGrSparepart($temp[1], $temp[0]);
                    break;
            }
            $count++;
        }
        $data['count'] = $count;
        //echo '<pre>';
        //var_dump($data);
        $this->load->view('gr/detailGR', $data);
    }

}
