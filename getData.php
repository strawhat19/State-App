<?php 
    $formData = json_decode($_POST['form'], true);
    LocalStorage::getInstance()->commit($formData);
?>