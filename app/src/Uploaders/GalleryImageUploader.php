<?php

namespace App\Uploaders;

class GalleryImageUpoader extends AbstractFileUploader {

    public function __construct(string $projectDir) {
        $dir = $projectDir . '/public/images/gallery';
        parent::__construct($dir, ['png', 'jpg', 'jpeg']);
    }
}