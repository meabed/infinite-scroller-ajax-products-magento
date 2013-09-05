<?php
class Web_AjaxProducts_Helper_Data extends Mage_Core_Helper_Abstract {
    public function isEnabled()
    {
        return Mage::getStoreConfig('catalog/ajax_products/enabled');
    }
    public function getProductsPerRequest()
    {
        $value =  abs(Mage::getStoreConfig('catalog/ajax_products/products_in_request'));
        if($value == 0){$value = 6;}
        return $value;
    }
    public function getRequestOffset()
    {
        $value =  Mage::getStoreConfig('catalog/ajax_products/request_offset');
        if($value < 10 ){$value = 10;}
        return $value;
    }
    public function getToolbarBlock()
    {
        return Mage::getBlockSingleton('catalog/product_list_toolbar');
    }

    public function getAllIdsSelect($collection,$limit = null, $offset = null)
    {
        $idsSelect = clone $collection->getSelect();
        //$idsSelect->reset(Zend_Db_Select::ORDER);
        //$idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        //$idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        //$idsSelect->reset(Zend_Db_Select::COLUMNS);
        $idsSelect->columns('e.' . $collection->getEntity()->getIdFieldName());
        $idsSelect->limit($limit, $offset);
        return $idsSelect;
    }
    public function getAllIds($collection,$limit = null, $offset = null)
    {
        return $collection->getConnection()->fetchCol($this->getAllIdsSelect($collection,$limit, $offset), array());
    }
    public function getAjaxIds($collection)
    {

        /* @var $ajaxCollection Mage_Catalog_Model_Resource_Product_Collection */

        $ajaxCollection = clone $collection;
        $toolbar = $this->getToolbarBlock();

        //$ajaxCollection->setCurPage($toolbar->getCurrentPage());

        $limit = (int)$toolbar->getLimit();
        $offset = $toolbar->getCurrentPage() * $limit;

        if ($toolbar->getCurrentOrder()) {
            $ajaxCollection->setOrder($toolbar->getCurrentOrder(), $toolbar->getCurrentDirection());
        }
        return $this->getAllIds($ajaxCollection,10000,$offset);
    }
}