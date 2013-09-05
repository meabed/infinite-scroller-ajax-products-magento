<?php
class Web_AjaxProducts_Block_Js extends Mage_Core_Block_Template
{
    public function getLoadedProductCollection()
    {
        $block = Mage::getBlockSingleton('catalog/product_list');
        return $block->getLoadedProductCollection();
    }
}