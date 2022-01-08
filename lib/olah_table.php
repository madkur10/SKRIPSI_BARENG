<?php
if (!function_exists("insert_tabel")) {
    function insert_tabel($nama_tabel="", $array_field=array()) {
        global $conn;
        $no = 0;
        $jumlah_array = count($array_field) - 1;
        $field = implode(", ",array_keys($array_field));
        $place_holder = str_repeat("?, ", $jumlah_array)."?";
        $query = "INSERT INTO $nama_tabel ($field) VALUES ($place_holder)";
        $resquery = $conn->prepare($query);
        foreach ($array_field as $key => $value) {
            $no++;
            $resquery->bindValue($no, $value);
        }
        $resquery->execute();
        return $resquery;
    }
}

if (!function_exists("select_tabel")) {
    function select_tabel($nama_tabel="", $nama_field="", $kondisi="", $nilai_kondisi=array()) {
        global $conn;
        $no = 0;
        $query = "SELECT $nama_field AS hasil_select_tabel FROM $nama_tabel $kondisi LIMIT 1";
        $resquery = $conn->prepare($query);
        if ($kondisi != "") {
            $jumlah_paceholder = substr_count($kondisi, '?');
            $jumlah_array = count($nilai_kondisi);
            if ($jumlah_paceholder == $jumlah_array) {
                foreach ($nilai_kondisi as $key) {
                    $no++;
                    $resquery->bindValue($no, $key);
                }
            }
        }
        $resquery->execute();
        $result = $resquery->fetch();
        $hasil_select_tabel = $result["hasil_select_tabel"];
        return $hasil_select_tabel;
    }
}

if (!function_exists("update_tabel")) {
    function update_tabel($nama_tabel="", $array_field=array(), $kondisi="", $nilai_kondisi=array()) {
        global $conn;
        $no = 0;
        $jumlah_array = count($array_field) - 1;
        $field = implode(" = ?, ",array_keys($array_field))." = ?";
        $query = "UPDATE $nama_tabel SET $field $kondisi";
        $resquery = $conn->prepare($query);
        foreach ($array_field as $key => $value) {
            $no++;
            $resquery->bindValue($no, $value);
        }
        foreach ($nilai_kondisi as $key => $value) {
            $no++;
            $resquery->bindValue($no, $value);
        }
        $resquery->execute();
        return $resquery;
    }
}

if (!function_exists("delete_tabel")) { 
    function delete_tabel($nama_tabel="", $kondisi="", $nilai_kondisi=array()) {
        global $conn;
        $no = 0;
        $query = "DELETE FROM $nama_tabel $kondisi";
        $resquery = $conn->prepare($query);
        if ($kondisi != "") {
            $jumlah_paceholder = substr_count($kondisi, '?');
            $jumlah_array = count($nilai_kondisi);
            if ($jumlah_paceholder == $jumlah_array) {
                foreach ($nilai_kondisi as $key) {
                    $no++;
                    $resquery->bindValue($no, $key);
                }
            }
        }
        $resquery->execute();
        return $resquery;
    }
}

if (!function_exists("generate_max")) {
    function generate_max($tabel="", $nama_field="", $kondisi="", $nilai_kondisi=array()) {
        global $conn;
        $no = 0;
        $query = "SELECT MAX($nama_field) AS hasil_generate_max FROM $tabel $kondisi";
        $resquery = $conn->prepare($query);
        if ($kondisi != "") {
            $jumlah_paceholder = substr_count($kondisi, '?');
            $jumlah_array = count($nilai_kondisi);
            if ($jumlah_paceholder == $jumlah_array) {
                foreach ($nilai_kondisi as $key => $value) {
                    $noo = $no += 1;
                    $resquery->bindValue($noo, $value);
                }
            }
        }
        $resquery->execute();
        $result = $resquery->fetch();
        if(empty($result["hasil_generate_max"]) or $result["hasil_generate_max"]==''){
            $result["hasil_generate_max"]   = 1;
        }else{
            $result["hasil_generate_max"]   = $result["hasil_generate_max"] + 1;
        }
        
        return $result["hasil_generate_max"];
    }
}


if (!function_exists("varcharmax")) {
    function varcharmax($tabel="", $nama_field="", $kondisi="", $nilai_kondisi=array()) {
        global $conn;
        $no = 0;
        $query = "SELECT MAX(CAST($nama_field AS Int)) AS hasil_varcharmax FROM $tabel $kondisi";
        $resquery = $conn->prepare($query);
        if ($kondisi != "") {
            $jumlah_paceholder = substr_count($kondisi, '?');
            $jumlah_array = count($nilai_kondisi);
            if ($jumlah_paceholder == $jumlah_array) {
                foreach ($nilai_kondisi as $key => $value) {
                    $noo = $no += 1;
                    $resquery->bindValue($noo, $value);
                }
            }
        }
        $resquery->execute();
        $result = $resquery->fetch();
        if(empty($result["hasil_varcharmax"]) or $result["hasil_varcharmax"]==''){
            $result["hasil_varcharmax"]   = 1;
        }else{
            $result["hasil_varcharmax"]   = $result["hasil_varcharmax"] + 1;
        }
        
        return $result["hasil_varcharmax"];
    }
}

if (!function_exists("_paddingNol")) {
    function _paddingNol($angka,$jumlah)
    {
        $jumlah_nol = strlen($angka);
        $angka_nol = $jumlah - $jumlah_nol;
        $nol = "";
        for($i=1;$i<=$angka_nol;$i++)
        {
            $nol .= '0';
        }
        return $nol.$angka;
    }
}

if (!function_exists("hari")) {
    function hari($nilai_hari)
    {
        if ($nilai_hari = 1) {
            $hari = "Senin";
        }elseif($nilai_hari = 2){
            $hari = "Selasa";
        }elseif($nilai_hari = 3){
            $hari = "Rabu";
        }elseif($nilai_hari = 4){
            $hari = "Kamis";
        }elseif($nilai_hari = 5){
            $hari = "Jumat";
        }elseif($nilai_hari = 6){
            $hari = "Sabtu";
        }elseif($nilai_hari = 7){
            $hari = "Minggu";
        }
        return $hari;
    }
}

if (!function_exists("jam_slot")) {
    function jam_slot()
    {
        return array(
            '1' => '08:00-09:00',
            '2' => '09:00-10:00',
            '3' => '10:00-11:00',
            '4' => '11:00-12:00',
            '5' => '12:00-13:00',
            '6' => '13:00-14:00',
            '7' => '14:00-15:00'
        );
    }
}
?>