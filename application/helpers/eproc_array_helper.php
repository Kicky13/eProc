<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('search_in')) {
	function search_in($needle, $haystack, $key_search=FALSE) {
		foreach ($haystack as $key => $subhaystack) {
			if (is_array($subhaystack)) {
				search_in($needle, $subhaystack, $key_search);
			}
			else {
				if ($subhaystack == $needle) {
					echo $haystack[$key_search];
				}
			}
		}
	}
}

if ( ! function_exists('create_standard')) {
	function create_standard($array,$default_value=FALSE) {
		if ($default_value) {
			$res['" disabled=""disabled" selected="selected'] = $default_value;
		}
		foreach ((array)$array as $key => $subarray) {
			$iter = 0;
			$res_index = '';
			$res_value = '';
			foreach ((array)$subarray as $key2 => $value) {
				if ($iter == 0) {
					$res_index = $value;
				}
				elseif ($iter == 1) {
					$res_value = $value;
				}
				$iter++;
			}
			$res[$res_index] = $res_value;
		}
		return $res;
	}
}

/**
 * Ngubah 09-OCT-12 03.19.59.000000000 PM jadi
 * time integer biar bisa diubah ubah sesukahati
 */
if ( ! function_exists('oraclestrtotime')) {
	function oraclestrtotime($string) {
		$shit = substr($string, -13, 10);
		$return = str_replace($shit, '', $string);
		return strtotime($return);
	}
}

if ( ! function_exists('timeformat')) {
	function timeformat(){return 'd-M-y g.i.s A';}
}

if ( ! function_exists('bettertimeformat')) {
	function bettertimeformat(){return 'd-M-y G:i:s';}
}

/**
 * Ngubah time jadi format yang bisa dibaca sama oracle
 * dan bagus juga
 */
if ( ! function_exists('oracledate')) {
	function oracledate($time) {
		return date(timeformat(), $time);
	}
}

/**
 * Ngubah time jadi format yang bisa dibaca user
 */
if ( ! function_exists('betteroracledate')) {
	function betteroracledate($time) {
		return date(bettertimeformat(), $time);
	}
}

/**
 * Ngubah time jadi format yang bisa dibaca user
 */
if ( ! function_exists('saptotime')) {
	function saptotime($sap_time) {
		if (intval($sap_time) == 0) {
			return null;
		}
		list($y, $m, $d) = sscanf($sap_time, '%04d%02d%02d');
		$newdate = strtotime($d .'-'.$m .'-'.$y);
		return $newdate;
	}
}

/**
 * Ngitung selisih hari, ignore waktu
 * @param int time()
 * @param int time()
 * @param boolean return absolute days
 *
 * @return int day differences
 */
if ( ! function_exists('day_difference')) {
	function day_difference($time1, $time2, $must_absolute = true) {
		$time1 = strtotime(date('d-m-Y', $time1));
		$time2 = strtotime(date('d-m-Y', $time2));

		// 60 seconds, 60 minutes, 24 hours
		$difference = $time1 - $time2;
		if ($must_absolute) {
			$difference = abs($difference);
		}
		return ($difference / 60 / 60 / 24);
	}
}

/**
 * Ngubah jadi x angka di belakang koma
 */
if ( ! function_exists('decimal')) {
	function decimal($angka,$decimals = 2) {
		return number_format((float)$angka, $decimals, '.', '');
	}
}

/**
 * Ngubah ke date nya oracle
 */
if ( ! function_exists('vendortodate')) {
	function vendortodate($oldformat) {
		return strtoupper(date("d-M-y",strtotime($oldformat)));
	}
}

/**
 * Ngubah dari date nya oracle
 */
if ( ! function_exists('vendorfromdate')) {
	function vendorfromdate($date) {
		if ($date) {
			$shit = substr($date, 0, 9);
			// $return = str_replace($shit, '', $date);
			return date("d-m-Y",strtotime($shit));
		}
		else {
			return NULL;
		}
	}
}

/**
 * Motong time keluaran dari oracle ke format DD-MM-YYYY
 */
if ( ! function_exists('cleanDateinArray')) {
	function cleanDateinArray($array) {
		if ($array) {
			if (is_array($array)) {
				foreach ($array as $key => $value) {
					if (is_array($value)) {
						foreach ($value as $key2 => $value2) {
							if (!is_array($value2)) {
								if (is_timestamp($value2)) {
									$array[$key][$key2] = vendorfromdate($value2);
								}
							}
						}
					}
				}
			}
			return $array;
		}
		else {
			return NULL;
		}
	}
}

/**
 * Ngecek bodoh sih tapi hehe apa sebuah value itu timestampnya oracle?
 */
if ( ! function_exists('is_timestamp')) {
	function is_timestamp($timestamp)
	{
		if (preg_match('/[0-9]{2}-[A-Z]{3}-[0-9]{2}/', $timestamp))
		{
		 	 return TRUE;
		}
		else {
			return FALSE;
		}
	}
}

/**
 * Generate PORG given PGRP
 */
if ( ! function_exists('pgrp_to_porg')) {
	function pgrp_to_porg($pgrp)
	{
		$porg = '';
		$pgrp = $pgrp[0];
		switch ($pgrp) {
			case 'G':
				$porg = 'SG01';
				break;
			case 'K':
				$porg = 'KS01';
				break;
			case 'T':
				$porg = 'ST01';
				break;
			case 'P':
				$porg = 'SP01';
				break;
			case 'L':
				$porg = 'TL01';
				break;
			case 'H':
				$porg = 'HC01';
				break;
			default:
				$porg = '';
		}
		return $porg;
	}
}

if ( ! function_exists('url_encode')) {
	function url_encode($str) {
		$CI =& get_instance();
		$CI->load->library('encrypt');
		return rtrim(strtr(base64_encode($CI->encrypt->encode($str)), '+/', '-_'), '=');
	}
}

if ( ! function_exists('url_decode')) {
	function url_decode($str) {
		$CI =& get_instance();
		$CI->load->library('encrypt');
		return $CI->encrypt->decode(base64_decode(str_pad(strtr($str, '-_', '+/'), strlen($str) % 4, '=', STR_PAD_RIGHT)));
	}
}

if ( ! function_exists('array_build_key')) {
	function array_build_key($array, $key, $is_multi = false) {
		$data = array();
		foreach ((array) $array as $val) {
			if ($is_multi) {
				$data[$val[$key]][] = $val;
			} else {
				$data[$val[$key]] = $val;
			}
		}
		return $data;
	}
}

/**
 * Ngubah jadi x angka di belakang koma
 */
if ( ! function_exists('ribuan')) {
	function ribuan($angka,$decimals = 0) {
		return number_format((float)$angka, $decimals, ',', '.');
	}
}

if(! function_exists('clean')){
	function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   return preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.
	}
}

if(! function_exists('accountingFormat')){
	function accountingFormat($number,$sign = 'plus') {
	   return $sign == 'minus' ? '('.ribuan($number).')' : ribuan($number);
	}
}
if(! function_exists('formatPajak')){
	/* contoh 000.000-00.00000306 */
	function formatPajak($str) {
	  return preg_replace('/(\d{3})(\d{3})(\d{2})(\d{8})$/i', '$1.$2-$3.$4', $str);
	}
}

if(! function_exists('stringDate')){
	function stringDate($d){
		/*Change '20170101 to 01-01-2017'*/
        $yyyy = substr($d,0,4);
        $mm = substr($d,4,2);
        $dd = substr($d,6,2);
        $ret = $dd.'-'.$mm.'-'.$yyyy;
        return $ret;
    }
}

if(! function_exists('formatEnofa')){
    function formatEnofa($f){
        $n1 = substr($f,0,3);
        $n2 = substr($f,3,2);
        $n3 = substr($f,5,8);
        $ret = $n1.'-'.$n2.'.'.$n3;
        return $ret;
    }
}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */

if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}

if (!function_exists('setEkspedisiTahun')) {
	function setEkspedisiTahun($ekspedisi,$create_date,$company){
		return $ekspedisi.'#'.$create_date.'#'.$company;
	}
}

if (!function_exists('hariIndonesia')) {
	function hariIndonesia($date){
		$d = new Datetime($date);
		$index = $d->format('N');
		$hari = array(
			'1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis','5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu'
		);
		return $hari[$index];
	}
}
if (!function_exists('kekata')) {
	function kekata($x) {
	    $x = abs($x);
	    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
	    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	    $temp = "";
	    if ($x <12) {
	        $temp = " ". $angka[$x];
	    } else if ($x <20) {
	        $temp = kekata($x - 10). " belas";
	    } else if ($x <100) {
	        $temp = kekata($x/10)." puluh". kekata($x % 10);
	    } else if ($x <200) {
	        $temp = " seratus" . kekata($x - 100);
	    } else if ($x <1000) {
	        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
	    } else if ($x <2000) {
	        $temp = " seribu" . kekata($x - 1000);
	    } else if ($x <1000000) {
	        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	    } else if ($x <1000000000) {
	        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	    } else if ($x <1000000000000) {
	        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	    } else if ($x <1000000000000000) {
	        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	    }
	        return $temp;
	}
}
if (!function_exists('terbilang')) {
	function terbilang($x, $style=4) {
	    if($x<0) {
	        $hasil = "minus ". trim(kekata($x));
	    } else {
	        $hasil = trim(kekata($x));
	    }
	    switch ($style) {
	        case 1:
	            $hasil = strtoupper($hasil);
	            break;
	        case 2:
	            $hasil = strtolower($hasil);
	            break;
	        case 3:
	            $hasil = ucwords($hasil);
	            break;
	        default:
	            $hasil = ucfirst($hasil);
	            break;
	    }
	    return $hasil;
	}
}

if(!function_exists('namaBulan')){
	function namaBulan($index){
		$month_in = array (
				'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
		);
		$_index  = intval($index) - 1;
		return $month_in[$_index];
	}
}
