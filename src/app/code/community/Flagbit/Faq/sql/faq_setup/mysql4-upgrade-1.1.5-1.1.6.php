<?php
$installer = $this;
$installer->startSetup();

$table = $this->getTable('plopcom_slider/slide');

$path = Mage::getBaseDir('media') . DS . 'Flagbit' . DS . 'FAQ';

function mkdir_r($dirName, $rights=0777){
    $dirs = explode(DS, $dirName);
    $dir='';
    foreach ($dirs as $part) {
        $dir.=$part.DS;
        if (!is_dir($dir) && strlen($dir)>0)
            mkdir($dir, $rights);
    }
}
try{
    mkdir_r($path);
}catch (Exception $exception){

}

$installer->endSetup();
