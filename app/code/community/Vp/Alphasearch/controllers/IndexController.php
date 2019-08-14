<?php
class Vp_Alphasearch_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() 
    {
        $systemval = Mage::getStoreConfig('alphasearch/alphasearch/alphasearch');
        
        if($systemval == 1)
        {
    	  $this->loadLayout();   
    	  $this->getLayout()->getBlock("head")->setTitle($this->__("Alphasearch"));
    	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
          $breadcrumbs->addCrumb("home", array(
                    "label" => $this->__("Home Page"),
                    "title" => $this->__("Home Page"),
                    "link"  => Mage::getBaseUrl()
    		   ));

          $breadcrumbs->addCrumb("alphasearch", array(
                    "label" => $this->__("Alphasearch"),
                    "title" => $this->__("Alphasearch")
    		   ));

          $this->renderLayout(); 
    	  }
        else
        {
          //$this->_redirectUrl(Mage::getBaseUrl());
          $this->norouteAction();
return;
        }
    }

    public function checkproductAction()
    {
      $alpha = trim($this->getRequest()->getPost('alpha'));
      $alphastr = '%';
      $key = "{$alpha}{$alphastr}";

      $products = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect(array('name', 'product_url'))
                ->addAttributeToFilter('name', array('like' => $key ))
                ->addAttributeToFilter('status', array('eq' => 1))
                ->addUrlRewrite()
                ->load();

         $alphaproducts = array();
        foreach ($products as $value) 
        {      
            $alphaproducts['name'] = $value->getName();
            $alphaproducts['producturl'] = $value->getProductUrl();
            $alphaproducts_data[] = $alphaproducts; 
        }

        echo json_encode($alphaproducts_data);

    }
}