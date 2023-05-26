<?php

namespace App\Uploaders;

class ArticleImageUpoader extends AbstractFileUploader {

    public function __construct(string $projectDir) {
        $dir = $projectDir . '/public/images/articles';
        parent::__construct($dir, ['png', 'jpg', 'jpeg']);
    }
}