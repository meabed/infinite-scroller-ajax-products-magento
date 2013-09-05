<?php
class Web_AjaxProducts_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $_helper = Mage::helper('web_ajaxproducts');
        if (!$_helper->isEnabled()) {
            return;
        }
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return;
        }
        $this->getResponse()->clearAllHeaders();
        $ids = $this->getRequest()->getPost('ids');
        if ($ids) {
            $ids = explode(',', $ids);
        }
        if (!is_array($ids) || (count($ids) > $_helper->getProductsPerRequest()) || count($ids) < 1) {
            return;
        }
        $toolbar = Mage::getBlockSingleton('catalog/product_list_toolbar');
        $block = $this->getLayout()->createBlock('catalog/product_list', 'products_' . md5(join(',', $ids)))
            ->setTemplate('catalog/product/list_ajax.phtml')
            ->setMode($toolbar->getCurrentMode())
            ->setIds($ids);
        echo $block->toHtml();
    }
}