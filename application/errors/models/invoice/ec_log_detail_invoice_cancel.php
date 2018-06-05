<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_log_detail_invoice_cancel extends MY_Model {
        public $table = 'EC_LOG_DETAIL_INVOICE_CANCEL';
        public $primary_key = 'DOCUMENT_ID';
        public $increments = FALSE;
        protected $timestamps = FALSE;
}
