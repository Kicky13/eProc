<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reservation_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function resume($_rwerks){
      $rwerks = array();
			foreach($_rwerks as $_r){
				array_push($rwerks,
						array(
						'SIGN' => 'I',
						'OPTION' => 'EQ',
						'LOW' => $_r
					)
				);
			}
			$rbwart = array();
			$_rbwart = array(961);
			foreach($_rbwart as $_r){
				array_push($rbwart,
						array(
						'SIGN' => 'I',
						'OPTION' => 'EQ',
						'LOW' => $_r
					)
				);
			}
			$hariIni = date('Ymd');
			$rbdter = array();
			$_rbdter = array($hariIni);
			foreach($_rbdter as $_r){
				array_push($rbdter,
						array(
						'SIGN' => 'I',
						'OPTION' => 'EQ',
						'LOW' => $_r
					)
				);
			}
			$input = array(
				'EXPORT_PARAM_SINGLE' => array(),
        'EXPORT_PARAM_TABLE' => array(),
      );
			/* default untuk resume */
      $rxwaok = array();
			$_rxwaok = array('X');
			foreach($_rxwaok as $_r){
				array_push($rxwaok,
						array(
						'SIGN' => 'I',
						'OPTION' => 'EQ',
						'LOW' => $_r
					)
				);
			}

			if(!empty($rbwart)){
				$input['EXPORT_PARAM_TABLE']['R_BWART'] = $rbwart;
			}
			if(!empty($rwerks)){
				$input['EXPORT_PARAM_TABLE']['R_WERKS'] = $rwerks;
			}
			if(!empty($rbdter)){
				$input['EXPORT_PARAM_TABLE']['R_BDTER'] = $rbdter;
			}
      if(!empty($rxwaok)){
				$input['EXPORT_PARAM_TABLE']['R_XWAOK'] = $rxwaok;
			}
      $t = $this->data($input);
      $hasilGrouping = $this->_groupingReservasiData($t['EXPORT_PARAM_TABLE']['T_DATA'],'RSNUM');
      return $hasilGrouping;
    }

    function detailData($input = array()){
      $rsnum_p = isset($input['rsnum_p']) ? $input['rsnum_p'] : array();
      $rwerks_p = isset($input['rwerks_p']) ? $input['rwerks_p'] : array();
      $rmatnr_p = isset($input['rmatnr_p']) ? $input['rmatnr_p'] : array();
      $rbwart_p = isset($input['rbwart_p']) ? $input['rbwart_p'] : array();
      $rlgort_p = isset($input['rlgort_p']) ? $input['rlgort_p'] : array();
      $mvtind_p = isset($input['mvtind_p']) ? ( !empty($input['mvtind_p']) ? array($input['mvtind_p']) : array() ) : array();
      $final_p = isset($input['final_p']) ? ( !empty($input['final_p']) ? array($input['final_p']) : array() ) : array();
      $delete_p = isset($input['delete_p']) ? ( !empty($input['delete_p']) ? array($input['delete_p']) : array() )  : array();
      $bdter_awal = isset($input['bdter_awal']) ? $input['bdter_awal'] : array();
      $bdter_akhir = isset($input['bdter_akhir']) ? $input['bdter_akhir'] : array();
      $detail = isset($input['detail']) ? $input['detail'] : array();
      $includeUnapprove = isset($input['includeUnapprove']) ? $input['includeUnapprove'] : 0;
      if($includeUnapprove){
        array_push($mvtind_p,' ');
      }

      $showDetail = 0;
      if(!empty($detail)){
				$showDetail = $detail;
			}
			$rsnum = array();
			$rwerks = array();
			$rmatnr = array();
			$rbwart = array();
      $rlgort = array();
			$rbdter = array();
			$mvtind = array();
      $final = array();
      $delete = array();

			if(!empty($rsnum_p)){
				foreach($rsnum_p as $_rp){
					array_push($rsnum,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

			if(!empty($rwerks_p)){
				foreach($rwerks_p as $_rp){
					array_push($rwerks,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

			if(!empty($rmatnr_p)){
				foreach($rmatnr_p as $_rp){
					array_push($rmatnr,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

		if(!empty($rbwart_p)){
			foreach($rbwart_p as $_r){
				array_push($rbwart,
						array(
						'SIGN' => 'I',
						'OPTION' => 'EQ',
						'LOW' => $_r
					)
				);
			}
		}

		if(!empty($rlgort_p)){
			foreach($rlgort_p as $_r){
				array_push($rlgort,
						array(
						'SIGN' => 'I',
						'OPTION' => 'EQ',
						'LOW' => $_r
					)
				);
			}
		}

		$separator = 'EQ';
		if(!empty($bdter_awal)){
				$tgl_akhir = $bdter_awal;
				if(!empty($bdter_akhir)){
					$separator = 'BT';
					$tgl_akhir = $bdter_akhir;
				}
			$rbdter =	array(
						array(
						'SIGN' => 'I',
						'OPTION' => $separator,
						'LOW' => $bdter_awal,
						'HIGH' => $tgl_akhir
					)
				);

		}else if(!empty($bdter_akhir)){
			$rbdter = array(
				array(
					'SIGN' => 'I',
					'OPTION' => $separator,
					'LOW' => $bdter_akhir
				)
			);
		}

		if(!empty($mvtind_p)){
		  foreach($mvtind_p as $_rp){
			array_push($mvtind,array(
				'SIGN' => 'I',
				'OPTION' => 'EQ',
				'LOW' => $_rp
			  )
			);
		  }
		}

		if(!empty($final_p)){
		  foreach($final_p as $_rp){
			array_push($final,array(
				'SIGN' => 'I',
				'OPTION' => 'EQ',
				'LOW' => $_rp
			  )
			);
		  }
		}

		if(!empty($delete_p)){
		  foreach($delete_p as $_rp){
			array_push($delete,array(
				'SIGN' => 'I',
				'OPTION' => 'EQ',
				'LOW' => $_rp
			  )
			);
		  }
		}

		$input = array(
			'EXPORT_PARAM_SINGLE' => array(),
			'EXPORT_PARAM_TABLE' => array(),
		);
      //print_r($final_p);

			if(!empty($rsnum)){
				$input['EXPORT_PARAM_TABLE']['R_RSNUM'] = $rsnum;
			}
			if(!empty($rwerks)){
				$input['EXPORT_PARAM_TABLE']['R_WERKS'] = $rwerks;
			}
			if(!empty($rmatnr)){
				$input['EXPORT_PARAM_TABLE']['R_MATNR'] = $rmatnr;
			}
			if(!empty($rbdter)){
				$input['EXPORT_PARAM_TABLE']['R_BDTER'] = $rbdter;
			}
			if(!empty($rbwart)){
				$input['EXPORT_PARAM_TABLE']['R_BWART'] = $rbwart;
			}
      if(!empty($rlgort)){
				$input['EXPORT_PARAM_TABLE']['R_LGORT'] = $rlgort;
			}
			if(!empty($mvtind)){
				$input['EXPORT_PARAM_TABLE']['R_XWAOK'] = $mvtind;
			}
			if(!empty($final)){
				$input['EXPORT_PARAM_TABLE']['R_KZEAR'] = $final;
			}
			if(!empty($delete)){
				$input['EXPORT_PARAM_TABLE']['R_XLOEK'] = $delete;
			}
      //print_r($input);
      $t = $this->data($input);
			if($showDetail){
				$hasilGrouping = $t['EXPORT_PARAM_TABLE']['T_DATA'];
			}else{
				$hasilGrouping = $this->_groupingReservasiData($t['EXPORT_PARAM_TABLE']['T_DATA'],'RSNUM');
			}
      return $hasilGrouping;
    }

    function data($input){
      $output = array(
        'EXPORT_PARAM_TABLE' => array('T_DATA')
      );
			$t = $this->sap_invoice->callFunction('ZCMM_GET_RESERVASI',$input,$output);
			return $t;
    }

    function listBonSementara($inputData){
      $werks = array();
      $sortf = array();
      if(!empty($inputData['werks'])){
        foreach($inputData['werks'] as $_rp){
          array_push($werks,array(
              'SIGN' => 'I',
              'OPTION' => 'EQ',
              'LOW' => $_rp
            )
          );
        }
      }
      if(!empty($inputData['sortf'])){
        foreach($inputData['sortf'] as $_rp){
          array_push($sortf,array(
              'SIGN' => 'I',
              'OPTION' => 'CP',
              'LOW' => $_rp
            )
          );
        }
      }
      $input = array(
        'EXPORT_PARAM_TABLE' => array()
      );
      if(!empty($werks)){
        $input['EXPORT_PARAM_TABLE']['R_WERKS'] = $werks;
      }
      if(!empty($sortf)){
        $input['EXPORT_PARAM_TABLE']['R_SORTF'] = $sortf;
      }
      return $this->data($input);
    }

    function _groupingReservasiData($t,$group_by = NULL){
			$result = array();
      $sementara = array();
			if(!empty($t)){
				if(!empty($group_by)){
					foreach($t as $_t){
						$param = $_t[$group_by];
						if(!isset($sementara[$param])){
              $sementara[$param] = 1;
              $result[] = $_t;
						}
					}
				}else{
					$result = $t;
				}
			}else{
				$result = $t;
			}
			return $result;
		}

    function detailByReservationNumber($resno){
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
          'RESERVATION' => $resno
        ),
      );

      $output = array(
        'EXPORT_PARAM_ARRAY' => array('RESERVATION_HEADER'),
        'EXPORT_PARAM_TABLE' => array('RESERVATION_ITEMS')
      );

      $t = $this->sap_invoice->callFunction('BAPI_RESERVATION_GETDETAIL',$input,$output);
      return $t;
    }

    function getItems($resno,$material,$plant,$req_date,$store_loc){
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
          'OPEN_ITEMS' => 'X'
        ),
        'EXPORT_PARAM_TABLE' => array(
        )
      );
      if(!empty($resno)){
        $input['EXPORT_PARAM_TABLE']['R_RES_NO'] = array();
        foreach($resno as $r){
          array_push($input['EXPORT_PARAM_TABLE']['R_RES_NO'],array('SIGN' => 'I', 'OPTION' => 'EQ', 'LOW' => $r));
        }
      }
      if(!empty($material)){
        $input['EXPORT_PARAM_TABLE']['R_MATERIAL'] = array();
        foreach($material as $r){
          array_push($input['EXPORT_PARAM_TABLE']['R_MATERIAL'],array('SIGN' => 'I', 'OPTION' => 'EQ', 'LOW' => $r));
        }
      }
      if(!empty($plant)){
        $input['EXPORT_PARAM_TABLE']['R_PLANT'] = array();
        foreach($plant as $r){
          array_push($input['EXPORT_PARAM_TABLE']['R_PLANT'],array('SIGN' => 'I', 'OPTION' => 'EQ', 'LOW' => $r));
        }
      }
      if(!empty($req_date)){
        $input['EXPORT_PARAM_TABLE']['R_REQ_DATE'] = array();
        foreach($req_date as $r){
          array_push($input['EXPORT_PARAM_TABLE']['R_REQ_DATE'],array('SIGN' => 'I', 'OPTION' => 'GE', 'LOW' => $r));
        }
      }

      $output = array(
        'EXPORT_PARAM_TABLE' => array('RESERVATION_ITEMS')
      );

      $t = $this->sap_invoice->callFunction('Z_ZCMM_RESERVATION_GETITEMS',$input,$output);
      return $t['EXPORT_PARAM_TABLE']['RESERVATION_ITEMS'];
    }

    function flagBonSementara($inputData){
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(),
        'EXPORT_PARAM_TABLE' => array()
      );

      if(!empty($inputData['P_FLAG'])){
        $input['EXPORT_PARAM_SINGLE']['P_FLAG'] = $inputData['P_FLAG'];
      }
      if(!empty($inputData['R_INPUT'])){
        $input['EXPORT_PARAM_TABLE']['R_INPUT'] = $inputData['R_INPUT'];
      }
      /*
      foreach($inputData as $_k => $_v){
        $input['EXPORT_PARAM_SINGLE'][$_k] = $_v;
      }*/

      $output = array(
        'EXPORT_PARAM_TABLE' => array('T_MESSAGE')
      );

      $t = $this->sap_invoice->callFunction('ZCPM_FLAGUNFLAG_RESERVASI',$input,$output);
      return $t['EXPORT_PARAM_TABLE']['T_MESSAGE'];
    }

    function goodIssue($inputData){
      $input = array(
        'EXPORT_PARAM_ARRAY' => array(
          'GOODSMVT_CODE' => array('GM_CODE' => '03')
        ),
        'EXPORT_PARAM_TABLE' => array()
      );
      if(isset($inputData['GOODSMVT_HEADER'])){
         $input['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADER'] = $inputData['GOODSMVT_HEADER'];
      }
      if(isset($inputData['GOODSMVT_ITEM'])){
         $input['EXPORT_PARAM_TABLE']['GOODSMVT_ITEM'] = $inputData['GOODSMVT_ITEM'];
      }
      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN'),
        'EXPORT_PARAM_ARRAY' => array('GOODSMVT_HEADRET')
      );
      $commit = 1;
      $t = $this->sap_invoice->callFunction('BAPI_GOODSMVT_CREATE',$input,$output,$commit);
      return array('error' => $t['EXPORT_PARAM_TABLE']['RETURN'], 'success' => $t['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADRET']);
    }

    function transfer($inputData){
      $input = array(
        'EXPORT_PARAM_ARRAY' => array(),
        'EXPORT_PARAM_TABLE' => array()
      );
      if(isset($inputData['GOODSMVT_HEADER'])){
         $input['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADER'] = $inputData['GOODSMVT_HEADER'];
      }
      if(isset($inputData['GOODSMVT_CODE'])){
         $input['EXPORT_PARAM_ARRAY']['GOODSMVT_CODE'] = $inputData['GOODSMVT_CODE'];
      }
      if(isset($inputData['GOODSMVT_ITEM'])){
         $input['EXPORT_PARAM_TABLE']['GOODSMVT_ITEM'] = $inputData['GOODSMVT_ITEM'];
      }
      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN'),
        'EXPORT_PARAM_ARRAY' => array('GOODSMVT_HEADRET')
      );
      $commit = 1;
      $t = $this->sap_invoice->callFunction('BAPI_GOODSMVT_CREATE',$input,$output,$commit);
      return array('error' => $t['EXPORT_PARAM_TABLE']['RETURN'], 'success' => $t['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADRET']);
    }
}
