<?php

class Schroeder_ConfigViewer_Model_Observer {

    const FLAG_SHOW_CONFIG = "showConfig";
    const FLAG_SHOW_LAYOUT = "showLayout";
    const FLAG_SHOW_CONFIG_FORMAT = "showConfigFormat";

    private $request;

    public function checkShowConfigRequest($observer) {

        $this->request = $observer->getEvent()->getData('front')->getRequest();

        if($this->request->{self::FLAG_SHOW_CONFIG} === 'true') {
            $this->setHeader();
            $this->outputConfig();
        }
    }

    public function checkShowLayoutRequest($observer) {

        $this->request = Mage::app()->getRequest();

        if($this->request->{self::FLAG_SHOW_LAYOUT} === 'true') {
            $this->setHeader();
            $this->outputLayout();
        }
    }

    private function setHeader() {

        if(isset($this->request->{self::FLAG_SHOW_CONFIG_FORMAT})) {
            $format = $this->request->{self::FLAG_SHOW_CONFIG_FORMAT};
        } else {
            $format = 'xml';
        }

        switch($format) {
            case 'text':
                header('Content-Type: text/plain');
                break;
            default:
                header('Content-Type: text/xml');
        }
    }

    private function outputConfig() {

        die(Mage::app()->getConfig()->getNode()->asXML());
    }

    private function outputLayout() {

        die(Mage::app()->getLayout()->getXmlString());
    }

}
