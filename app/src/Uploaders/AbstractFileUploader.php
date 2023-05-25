<?php

namespace App\Uploaders;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractFileUploader {

    private string $directory;
    private array $acceptedExtensions;
    
    protected function __construct(string $directory, array $acceptedExtensions = []){
        $this->directory = $directory;
        $this->acceptedExtensions = $acceptedExtensions;
    }

    public function upload(UploadedFile $file) : string {
        if($this->isExtensionAccepted($file)){
            return $this->saveFile($file);
        }
        else{
            $errorMessage = 'Wrong file, only: ';
            foreach($this->acceptedExtensions as $ext){
                $errorMessage .= $ext . ' ';
            }
            $errorMessage .= 'accepted.';
            throw new Exception($errorMessage, 500);
        }
    }

    private function isExtensionAccepted(UploadedFile $file) : bool {
        if(count($this->acceptedExtensions) > 0){
            $extension = $file->guessClientExtension();
            if(!in_array($extension, $this->acceptedExtensions)){
                return false;
            }
        }
        return true;
    }

    private function saveFile(UploadedFile $file) : string {
        $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
        $file->move($this->directory, $filename);
        return $this->directory . '/' . $filename;
    }
}