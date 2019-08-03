<?php

namespace App\Http\Controllers;

trait StoregeDownload {
    public function getFile($file_path) {

    }
}

class FileController {
    use StoregeDownload;

    public function view($id){
        return $this->getFile();
    }
}