<?php
function forwardChaining($conn, $gejala_input) {

    $query = "
        SELECT r.id_rule, r.kode_penyakit, p.tingkat_risiko
        FROM rules r
        JOIN penyakit p ON r.kode_penyakit = p.kode_penyakit
        ORDER BY FIELD(p.tingkat_risiko,'Tinggi','Sedang','Rendah')
    ";

    $rules = mysqli_query($conn, $query);

    while ($rule = mysqli_fetch_assoc($rules)) {

        $id_rule = $rule['id_rule'];

        $detail = mysqli_query($conn,
            "SELECT kode_gejala FROM rule_detail WHERE id_rule = $id_rule"
        );

        $cocok = true;

        while ($d = mysqli_fetch_assoc($detail)) {
            if (!in_array($d['kode_gejala'], $gejala_input)) {
                $cocok = false;
                break;
            }
        }

        if ($cocok) {
            return [
                'kode'   => $rule['kode_penyakit'],
                'risiko' => $rule['tingkat_risiko']
            ];
        }
    }

    // Default jika tidak ada rule cocok
    return [
        'kode'   => null, 
        'risiko' => 'Tidak Terdeteksi'
    ];
}
