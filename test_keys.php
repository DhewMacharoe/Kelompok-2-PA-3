<?php
$model = json_decode(file_get_contents('public/ai_model/hair/model.json'), true);
echo json_encode(array_keys($model));
