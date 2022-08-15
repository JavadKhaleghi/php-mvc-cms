<?php

namespace App\Models;

class Upload
{
    public $file;
    public $field;
    public $errors = [];
    public $size;
    public $temp;
    public $extension;
    public $maxSize = 2000000;
    public $fileTypes = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    ];
    public $required = true;
    
    public function __construct($field)
    {
        $this->field = $field;
        $this->checkError();
        $this->file = $_FILES[$field];
        $this->size = $this->file['size'];
        $this->temp = $this->file['tmp_name'];
        $this->extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }
    
    private function checkError()
    {
        if (! isset($_FILES[$this->field]) || is_array($_FILES[$this->field]['error'])) {
            throw new \RuntimeException('Something went wrong with the file uploading.');
        }
    }
    
    public function validate()
    {
        $this->errors = [];
        
        if (empty($this->temp) && $this->required) {
            $this->errors[$this->field] = 'Cover image is required.';
        }
        
        // check file size
        if ($this->size > $this->maxSize) {
            $this->errors[$this->field] = 'File size cannot be greater than ' . $this->formatBytes($this->maxSize);
        }
        
        // check allowed file type
        if (empty($this->errors) && !empty($this->tmp)) {
            $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
            $fileType = $fileInfo->file($this->temp);
    
            if (array_search($fileType, $this->fileTypes) === false) {
                $this->errors[$this->field] = 'File type must be: ' . implode(',', array_keys($this->fileTypes));
            }
        }
        
        return $this->errors;
    }
    
    public function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $power = floor(($bytes ? log($bytes) : 0) / log(1024));
        $power = min($power, count($units) - 1);
        
        return round($bytes, $precision) . ' ' . $units[$power];
    }
    
    public function upload($fileName)
    {
        return move_uploaded_file($this->temp, $fileName);
    }
}
