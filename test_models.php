<?php
$model1 = json_decode(file_get_contents('public/ai_model/model.json'), true);
$model2 = json_decode(file_get_contents('public/ai_model/hair/model.json'), true);

function getClasses($model) {
    $layers = $model['modelTopology']['model_config']['config']['layers'];
    $lastLayer = end($layers);
    if ($lastLayer['class_name'] == 'Dense') {
        return $lastLayer['config']['units'];
    }
    return null;
}

echo "Main model classes: " . getClasses($model1) . "\n";
echo "Hair model classes: " . getClasses($model2) . "\n";
