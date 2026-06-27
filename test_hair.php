<?php
$json = json_decode(file_get_contents('public/ai_model/rekomendasi_rules.json'), true);
$hairTypes = [];
foreach ($json as $gender => $ageData) {
    foreach ($ageData as $age => $faceData) {
        foreach ($faceData as $face => $hairData) {
            foreach (array_keys($hairData) as $hair) {
                $hairTypes[$hair] = true;
            }
        }
    }
}
print_r(array_keys($hairTypes));
