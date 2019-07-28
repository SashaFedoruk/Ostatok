<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class XlUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $xlFile;

    public function rules()
    {
        return [
            [['xlFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xl, xls, xls', 'checkExtensionByMimeType' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->xlFile->saveAs('uploads/' . $this->xlFile->baseName . '.' . $this->xlFile->extension);
            return ('uploads/' . $this->xlFile->baseName . '.' . $this->xlFile->extension);
        } else {
            return false;
        }
    }
}
