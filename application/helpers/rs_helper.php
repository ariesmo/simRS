<?php

function getInfoRS($field){
	$ci = get_instance();
	$ci->db->where('id', 1);
	$rs = $ci->db->get('tbl_profil_rumah_sakit')->row_array();
	return $rs["$field"];

}