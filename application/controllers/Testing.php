<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	function index() {
		// $this->load->model('vnd_reg_announcement');
		// $TES = $this->vnd_reg_announcement->with('company')->as_array()->get_all();
		// var_dump(vendortodate('29-02-16'));

		$this->load->model('hist_vnd_header');
		$vendor = $this->hist_vnd_header
							->with_address('where:VND_TRAIL_ID=\'2\'')
							->get(array("VENDOR_ID" => 13, "VND_TRAIL_ID" => 2));
		var_dump($vendor);

		// var_dump($this->db->last_query());

		// $this->tmp_vnd_reg_progress->get(1);
		// $this->tmp_vnd_reg_progress->get_by('title', 'Pigs CAN Fly!');
		// $this->tmp_vnd_reg_progress->get_many_by('status', 'open');

		// $this->tmp_vnd_reg_progress->insert(array(
		// 	'status' => 'open',
		// 	'title' => "I'm too sexy for my shirt"
		// 	));

		// $this->tmp_vnd_reg_progress->update(1, array( 'status' => 'closed' ));

		// $this->tmp_vnd_reg_progress->delete(1);
	}

	public function ngambil() {
		$nama = array(
			"6495002" => "ASHARI", "6487006" => "JULAIKAH", "7191083" => "KARNO", "6284022" => "MUSTAHA", "7796185" => "MUZAMIL", "6081018" => "NURTONO", "7595077" => "PARNO", "7809002" => "SHOLIHIN", "6179235" => "SUDARMINTO", "7291091" => "SUMANTO", "7193029" => "SUNOTO", "7393090" => "SUSANTO", "6990043" => "SUYONO", "7897182" => "ABDI SAPUTRA", "7190080" => "ABDUL CHOLIK", "7896214" => "ABDUL HADI", "7093117" => "ABDUL MUNIF EFENDI", "7196007" => "ABDUL QOHAR", "7696128" => "ABDUR ROZIQ", "7493099" => "ABDURROHMAN", "0006372" => "ACHMAD ALI ASH SHIDIQI", "7697163" => "ACHMAD BAIHAQI", "0001074" => "ACHMAD JUSUF", "7091073" => "ACHMAD NURIL", "8208019" => "ACHMAD RUSDIYANTO", "7493060" => "ACHMAD TOHARI", "7595080" => "ADAM SONDI CANDRA BUMI", "7695053" => "ADI KUSETIYAWAN", "8309006" => "ADI NUGROHO", "8309005" => "ADI SUPRAYONO", "8208022" => "AFRI DHARMA YANDI", "0001675" => "AGUNG ABDILLAH", "6991017" => "AGUNG TRI UTOMO", "0001143" => "AGUS ADI SUBEKTI", "5980018" => "AGUS AFANDI", "8508152" => "AGUS HIZBULLAH HUDA", "7196225" => "AGUS KUNTORO", "7395062" => "AGUS MARIANTO", "8408054" => "AGUS SETYO BUDI", "7091021" => "AGUS SOEHARTONO", "7295058" => "AGUS SUPARYANTO SEMBIRING", "0001797" => "AGUS WIDADI", "0007080" => "AHDA ZULKARNAIN", "6995006" => "AHMAD FAISOL", "6994015" => "AHMAD NURIL HUDA", "7090069" => "AHMAD SHODIQIN", "8008081" => "AHMAD ZULAIHAN", "7093126" => "AKHMAD BASUNI", "7494067" => "AKHMAD GHUFRON", "6894012" => "ALI IMRON", "7596067" => "ALI SODIKIN", "8008005" => "AMIN BUDI HARTANTO", "7193133" => "ANDHIKA FIRMANSYAH", "6896224" => "ANDRIE ZEINALDIE", "8408045" => "ANITA SUSANTI", "8508064" => "ARI DWI RACHMA RINI", "7095032" => "ARI YUANANTO", "0005818" => "ARIEF HERMAWAN", "7494069" => "ARIEF SUKMONO", "7597006" => "ARIEF SUSANTO", "6893113" => "ARIF PURWANTO", "6591042" => "ARNOLDUS GEMBO", "6994102" => "AWAN NUGROHO", "8108013" => "BANGKIT PRIAMBODO", "8508060" => "BAYU PUTRA", "7195056" => "BUDI SN", "7595083" => "CHOIRUL AGUSTIAN", "7091023" => "CHOIRUL ANAFI", "7397201" => "CHOIRUL FUAD", "7494134" => "CHOIRUL INSAN", "7696072" => "CHOLIQ SAIFULLAH", "7797131" => "CHUSNUL CHULUQ", "7796176" => "CONDRO HADI PURWITO", "0006311" => "DANICA JOHANNA SILAHOOY", "7291092" => "DEDI JUNANTO", "8108090" => "DEDY ERMAWANTO", "8208023" => "DENO MANDRIAL", "8508069" => "DEWI ANGGRAENI", "7391107" => "DIDIK SUWARYANTA", "8308126" => "DIDIT SUSILO", "8108009" => "DOBY YUNIARDI", "8508063" => "DODDY ISKANDAR WIJAYA", "7396231" => "DODI SANCOKO", "7394113" => "DONNY KUSBIANTORO", "7596027" => "DWI AGUS WIDODO", "6891012" => "DWI ARIS GUNAWAN", "8208108" => "DWI ARVIANTO", "6994017" => "DWI BHEKTI A", "0006289" => "DWI BOEDI SETIAWAN", "8508151" => "DWI SANJAYA", "8408048" => "DWI WICAKSONO", "8309004" => "DWIHANY APRILIYANTIE", "7193031" => "EDI SUSMIANTO", "8909029" => "EKA AGUS KHABIBULLAH", "8108014" => "EKA NINGRUM", "7896216" => "EKO CAHYONO", "7896217" => "EKO PRIYANTO", "8308119" => "EKO SETIAWAN", "7493148" => "EKO SUTRISNO", "7391106" => "FACHRUR RIDLO", "8408141" => "FAJAR RAHAYU", "7293016" => "FAJAR SOLEH FAGI EFFENDI", "0000732" => "FIRDIANSYAH OKTARIZKY", "8208100" => "FREDY AGUNG PRABOWO", "7291088" => "GATHOT SUWARNO", "8008085" => "GINANJAR RAHARJO", "7294003" => "HARDIYANTA S.E.", "0001165" => "HARI PURWANTO", "5979096" => "HARI SUGIANTONO", "7195033" => "HARI SUSILO", "7493097" => "HARI SUWARTONO", "7495067" => "HARIADI", "6990039" => "HARIADI WURDIANTO", "8308124" => "HASAN MUJAHID", "7796190" => "HAVI MALANDI", "7695142" => "HERI PURNOMO", "8208030" => "HERU SETIAWAN", "8408055" => "HUDDY TRI PRASETYO", "7803001" => "IBNU PRASETYO", "8208032" => "IFFI NI'MAH K.", "6895029" => "IMAM SUWANDI", "8208028" => "INDAH LUKMAWATI", "7396096" => "INDRA DARMAWAN", "8008084" => "INDRA KURNIAWAN", "8208015" => "INDRA YUDHI KURNIAWAN", "0001755" => "IRFAN ZUCHRUFUDIN", "0001758" => "IRWAN SATTU", "7896218" => "ISBAKHUS SURUR", "7197160" => "ISUSILONINGTYAS", "7696161" => "ISWOYO", "0000926" => "IVAN SETYABUDIE", "7493101" => "IWAN PRASTYO UTOMO", "7194125" => "JATMIKO", "0001046" => "JOKO SURASA", "7090064" => "JUNI WAHJU WIDODO", "0000919" => "JUNIARDI KRISTANTO", "7393142" => "KANTI PULUH H.", "7596124" => "KASIYAN", "7393043" => "KHOIRON YASIR", "8208101" => "KHOIRUL ANWAR", "7394035" => "KUSIYADI", "6790019" => "KUSMAN", "7093012" => "KUSWANDI", "7494006" => "LAURENSIUS SLAMET MARTONO", "7797149" => "LISTIYONO", "7493093" => "LULUS PRIYONO", "6997197" => "M. ARIS SYUKRIYANTO", "7193132" => "M. FATCHUR RACHMAN", "8208095" => "M. IMRON ZAINAL ARIFIN", "6994082" => "M. TEGUH WIDODO", "8408136" => "MASKHUN HERMAWAN", "5980080" => "MOCH SODIQ", "7193130" => "MOCH. FACHRUDIN", "7696034" => "MOCH. MUNIF", "7293139" => "MOCH. SOEBCHAN", "7908075" => "MOCHAMMAD FARID", "6993116" => "MOCHAMMAD RAAFI'UD", "7595050" => "MOCHAMMAD SANI YUWONO", "7396110" => "MOH. KHOLIL", "7597111" => "MOH. MUHLIS ZAINUDDIN", "7293085" => "MOH. SODIG", "6797213" => "MOHAMAD ZAINUDIN", "7497203" => "MOHAMMAD IRCHAM", "8408135" => "MUBAROK", "7293034" => "MUCHAMAD MAKSUM", "7295038" => "MUCHAMAD RIZAL", "6282065" => "MUH FAIQ NIYAZI", "5980111" => "MUH. FAISHOL", "6990050" => "MUHAMAD MUJIB", "0000384" => "MUHAMMAD ARIFIN", "7493067" => "MUHAMMAD HASAN ZAHIDI", "7796084" => "MUHAMMAD IMAM BASUKI", "0000917" => "MUHAMMAD INDRAYONO", "8409052" => "MUHAMMAD SHIDDIQ", "7197215" => "MUSIRAN S.T", "0000738" => "NADYA KARNINA", "8811079" => "NALENDRA PERMANA", "7697125" => "NANANG SUDRAJAT", "6893022" => "NGUDI CATUR PRIYANTO", "7393040" => "NGUDIJONO", "6185009" => "NINIK HERRY", "0006332" => "NOVA KURNIAWAN", "7496117" => "NOVITA KARTININGRUM S.", "7797141" => "NUR ANAS QOMARI", "7393145" => "NUR HASYIM", "8408138" => "NURINA PRATIWI SASMITA", "7494040" => "NYIMAS NURHANISAH", "8308125" => "OKTORIA MASNIARI M.", "8308039" => "ONNI AGUSTYA RAHMAN", "0000721" => "PARNO", "7897075" => "PUDJI ISKANDAR", "7596061" => "PURWANTO", "8308118" => "QUNTO TRI WARDOYO", "7094019" => "R. DODY SUPRIYODI", "0006291" => "RADITYO WIDINUGROHO", "7191030" => "RAHMAT ARDHIANSJAH", "0007092" => "RANDI WIYARAGA", "8208094" => "RENDRA SANJAYA", "8611077" => "RIDUWAN MALIKI", "7397108" => "ROIKHANATIN", "9010017" => "RONNA GUSTIAN", "6695027" => "ROY SUKARNO P", "8008004" => "RURI ADAM", "7696173" => "RUSDI", "7896211" => "SAID EFFENDI", "7493063" => "SAIFUL BASRI", "7197198" => "SAIFUL MAS'AN", "6284023" => "SAMSUL ARIF", "7497217" => "SAMSURI", "7397200" => "SETIYONO", "7897189" => "SETYAWAN ADI SISWANTO", "7194056" => "SETYO KARNO", "8408049" => "SIGIT WAHONO", "7396232" => "SINGGIH WIDAYAT", "7797039" => "SISWANTOSISWANTO", "8208020" => "SLAMET BUDIONO", "0000864" => "SLAMET HARIADI", "7093017" => "SLAMET MURSIDIARSO", "7495068" => "SOEGENG TRIYATNO", "7396106" => "SOENOE DIHARDJO", "7194087" => "SRI HARTATIK RESMININGSIH", "7394033" => "SRI WACHYUNINGSIH", "6790023" => "SUCIPTO", "7091020" => "SUDARNO", "7396109" => "SUDIRO", "0000684" => "SUGENG HERMANTO", "7494144" => "SUHARKO", "6995020" => "SUHARYANTO", "6890031" => "SUJIANTO", "7595049" => "SUKAMTO", "7797165" => "SULAIMAN", "5980055" => "SULAWISNO", "8208026" => "SUMIATI SUTATIK NINGSIH", "7294002" => "SUPRIYADI", "0006462" => "SURATIN BUDI WAHYONO", "7796137" => "SURATMAN.", "6890034" => "SUWOKO", "7796085" => "SUYANTO", "7090061" => "SYAIFUL ARIF", "6790020" => "SYAMSUL MA'ARIF", "7291098" => "TARWOKO", "7396005" => "TAUFIK SUSANTO", "0001621" => "TEGUH HARIONO ST", "7194106" => "TEGUH IMAM SANTOSO", "6995098" => "TEGUH IRIANTO", "7494070" => "TEGUH SUNARYO", "7596120" => "TITTO SISWANDI", "7397202" => "TONY GUNAWAN", "6693075" => "TRI PRASTYA YUNIANTO", "6791051" => "TUBAGUS DHARURY", "7493149" => "UMU KHOIRIYAH", "0006328" => "WACHID DANU", "6991068" => "WAHYU DARMAWAN", "8008078" => "WAHYU NUGROHO", "7494041" => "WASITO EDI", "7193032" => "WIDI SUGIANTORO", "7096002" => "WIWIED BHAKTI ISWIDONO", "0006367" => "YAHYA UBAID KHOIR", "7197159" => "YUDI SANTOSO", "7597204" => "YUNUS YANUAR", "0001698" => "YUSUF CAHYADI", "7896220" => "ZAENAL ARIFIN", "7093125" => "ZAENAL CHOIRI",
			);
		$this->db = $this->load->database('default', TRUE);
		?>
		<table border="1">
		<?php
		foreach ($nama as $key => $val) {
			$q = $this->db->query("SELECT ID, FULLNAME, EM_COMPANY, EM_PLANT from ADM_EMPLOYEE where FULLNAME like '%".$val."' or FULLNAME like '%".$val."%' or fullname like '".$val."%'");
			// var_dump($q->result_array());
			$h = $q->result_array();
			?>
			<tr>
			<?php if (count($h) == 1): ?>
				<td><?php echo $h[0]['ID'] ?></td>
			<?php elseif (count($h) == 0): ?>
				<td>Kosong</td>
			<?php else: ?>
				<!-- <td><pre><?php var_dump($h) ?></pre></td> -->
				<td>MANCAAAPAPAPAPAP</td>
			<?php endif ?>
				<td><?php echo $val ?></td>
				<td><?php echo $key ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}

	public function email()
	{
		$this->load->library('email');
		$this->load->model('adm_company');
		$this->config->load('email');
		$semenindonesia = $this->config->item('semenindonesia');
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to('achmads123@gmail.com');
		$this->email->subject("Registration Confirmation for eProcurement PT. Semen Gresik (Persero) Tbk.");
		$data['selected_company'] = '2000';
		$data['company'] = $this->adm_company->get(array('ISACTIVE' => 1));
		$data['session_id'] = "asdasdasdasd";
		$content = $this->load->view('email/success_regist_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();
		var_dump("nice");
	}

	public function vnd_header()
	{
		$this->load->model('vnd_header');
		$a = $this->vnd_header->get(array('VENDOR_ID' =>($this->session->userdata('VENDOR_ID'))));
		var_dump($a);
	}

	public function emp()
	{
		$this->load->model('adm_employee');
		$emp = $this->adm_employee->get(array('ID' =>$this->session->userdata('ID')));
		var_dump($emp);
	}

	function session() {
		var_dump($this->session->all_userdata());
	}

	function cobak() {
		$this->load->helper('eproc_array_helper');
		$fckngdate = '09-OCT-12 03.19.59.000000000 PM';
		$str = oraclestrtotime($fckngdate);
		// echo $str;
		echo date('d M y', $str);

		$time = explode(" ", microtime());
		$time = $time[0] + $time[1];
		var_dump(round($time * 1000) . '');
	}

	public function hitung_nilai_total($ptm, $update = true) {
		$this->load->model('v_vnd_perf_total');
		var_dump($this->v_vnd_perf_total->get());
	}

	public function get_atasan() {
		$this->load->library('authorization');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$id_nganu = $this->authorization->getEmployeeId();
		$hasil = array();
		do {
			$emp = $this->adm_employee->get(array('ID' => $id_nganu));
			$nopeg = $emp[0]['NO_PEG'];

			$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
			$level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

			$ans = $this->adm_employee->atasan($id_nganu);
			$id_atasan = $ans[0]['ID']; // get atasan
			$nama_atasan = $ans[0]['FULLNAME']; // get atasan
			$hasil[] = compact('id_atasan', 'nama_atasan', 'level');

			$id_nganu = $id_atasan;
		} while ($level != 'DIR');

		var_dump($hasil);
	}

	public function masukan_kewenangan() {
		exit();
		$this->load->model('adm_approve_kewenangan');
		$pgrp = array('G01', 'G02', 'G03', 'G04', 'G05', 'G06', 'G07', 'G9A', 'G9B', 'K01', 'K02', 'K03', 'K04', 'K05', 'K06', 'K07', 'K08', 'K09', 'K10', 'K11', 'K12', 'K13', 'K14', 'K15', 'K16', 'K17', 'K18', 'K19', 'K20', 'K21', 'K22', 'K23', 'K24', 'K25', 'K26', 'K27', 'K55', 'K56');
		foreach ($pgrp as $val) {
			$batas = array(0, 0, 100000000, 2000000000, 5000000000);
			foreach ($batas as $urutan => $var) {
				$data['PERSETUJUAN_ID'] = $this->adm_approve_kewenangan->get_id();
				$data['KEL_OPCO'] = 2;
				$data['BATAS_HARGA'] = $var;
				$data['PGRP'] = $val;
				$data['EMP_ID'] = 1082;
				$data['URUTAN'] = $urutan + 1;

				$this->adm_approve_kewenangan->insert($data);
			}
		}
	}

	public function test_hris() {
		$this->load->model('m_hris');
		$q = $this->m_hris->db->query('select * from v_karyawan where company = 2000');
		var_dump($q->result_array());
	}

	public function g(){
		echo file_get_contents('http://google.com');
	}
	public function info(){
		phpinfo();
	}
}
