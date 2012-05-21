<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @copyright  Copyright (c) 2009 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('flagbit_faq/faq')}`
    ADD COLUMN `popularity` int(10) NOT NULL DEFAULT '0'

");

$installer->endSetup();
