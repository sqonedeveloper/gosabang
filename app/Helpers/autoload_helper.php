<?php

function cleanSpace($str) {
	return str_replace($str, '%20', ' ');
}

function tanggalIndonesia($tanggal, $separator = ' ') {
	if (!empty($tanggal)) {
		$content = explode('-', $tanggal);
		$tahun = $content[0];
		$bulan = $content[1];
		$tanggal = $content[2];

		$config_bulan = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];
		
		return $tanggal.$separator.$config_bulan[$bulan].$separator.$tahun;
	} else {
		return '-';
	}
}

function settings($key) {
   $db = \Config\Database::connect();

   $table = $db->table('tb_settings');
   $table->select($key);
   $query = $table->get();
   $data = $query->getRowArray();

   return $data[$key];
}

function hari($content) {
   $hari = date('D', strtotime($content));
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
}

function replaceDotWithEmptyString($str) {
	return str_replace('.', '', $str);
}

function userRoles(string $key) {
	$config = [
		'1' => 'Administrator',
		'2' => 'Usaha',
		'3' => 'Member'
	];
	return $config[$key];
}

function userStatus(string $key) {
	$config = [
		'0' => 'Suspend',
		'1' => 'Active'
	];
	return $config[$key];
}