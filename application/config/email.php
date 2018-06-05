<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['yahoo']['conf']['protocol'] = 'smtp';
$config['yahoo']['conf']['smtp_host'] = 'ssl://smtp.mail.yahoo.com';
$config['yahoo']['conf']['smtp_port'] = '465';
$config['yahoo']['conf']['smtp_user'] = 'eproc.development@yahoo.com';
$config['yahoo']['conf']['smtp_pass'] = 'Dev3proc.';
$config['yahoo']['conf']['mailtype'] = 'html';
$config['yahoo']['conf']['wordwrap'] = TRUE;
$config['yahoo']['conf']['charset'] = 'iso-8859-1';
$config['yahoo']['conf']['newline'] = "\r\n";
$config['yahoo']['credential'] = array('eproc.development@yahoo.com', 'Development eProc Semen');

$config['gmail']['conf']['protocol'] = 'smtp';
$config['gmail']['conf']['smtp_host'] = 'smtp.gmail.com';
$config['gmail']['conf']['smtp_port'] = '587';
$config['gmail']['conf']['smtp_user'] = 'kicky120@gmail.com';
$config['gmail']['conf']['smtp_pass'] = 'kicky02031995';
$config['gmail']['conf']['smtp_crypto'] = 'tls';
$config['gmail']['conf']['mailtype'] = 'html';
$config['gmail']['conf']['wordwrap'] = TRUE;
$config['gmail']['conf']['charset'] = 'iso-8859-1';
$config['gmail']['conf']['newline'] = "\r\n";
$config['gmail']['credential'] = array('kicky120@gmail', 'Development eProc Semen');


// $config['semenindonesia']['conf']['protocol'] = 'smtp';
// $config['semenindonesia']['conf']['smtp_host'] = 'ssl://smtp.semenindonesia.com';
// $config['semenindonesia']['conf']['smtp_port'] = '465';
// $config['semenindonesia']['conf']['smtp_user'] = 'isak.setiawan@semenindonesia.com';
// $config['semenindonesia']['conf']['smtp_pass'] = 'khilafah';
// $config['semenindonesia']['conf']['mailtype'] = 'html';
// $config['semenindonesia']['conf']['wordwrap'] = TRUE;
// $config['semenindonesia']['conf']['charset'] = 'iso-8859-1';
// $config['semenindonesia']['conf']['newline'] = "\r\n";
// // $config['semenindonesia']['credential'] = array('Semen Indonesia ', 'Eprocurement Semen Indonesia');
// $config['semenindonesia']['credential'] = array('eproc@semenindonesia.com', 'Eprocurement Semen Indonesia');
// // $config['semenindonesia']['credential'] = array('Semen Indonesia ', 'Development eProc Semen');

$config['semenindonesia']['conf']['mailtype'] = 'html';
$config['semenindonesia']['conf']['wordwrap'] = TRUE;
$config['semenindonesia']['conf']['charset'] = 'iso-8859-1';
$config['semenindonesia']['conf']['newline'] = "\r\n";
$config['semenindonesia']['credential'] = array('eproc@semenindonesia.com', 'Eprocurement Semen Indonesia');
/* End of file email.php */
/* Location: ./application/config/email.php */
