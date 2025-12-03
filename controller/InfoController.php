<?php

class InfoController {
    
    public function faq() {
        include 'view/info/faq.php';
    }

    public function help() {
        include 'view/info/help.php';
    }

    public function privacy() {
        include 'view/info/privacy.php';
    }

    public function terms() {
        include 'view/info/terms.php';
    }

    public function corporate() {
        include 'view/info/corporate.php';
    }
}
