<?php
$model = json_decode(file_get_contents('public/ai_model/hair/model.json'), true);
$layers = $model['modelTopology']['model_config']['config']['layers'];
foreach ($layers as $layer) {
    if ($layer['class_name'] == 'Dense') {
        echo "Dense layer units: " . $layer['config']['units'] . "\n";
    }
}
