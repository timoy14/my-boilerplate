<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryFileUpload
{
    protected $config;
    protected $private_key;

    public function __construct()
    {
        $this->config = Configuration::instance();
        $this->config->cloud->cloudName = env('CLOUDINARY_NAME');
        $this->config->cloud->apiKey = env('CLOUDINARY_KEY');
        $this->config->cloud->apiSecret = env('CLOUDINARY_SK');
        $this->config->url->secure = true;
    }

    public function file_upload($file,$bucket) {

        $filename = $file->getClientOriginalName();
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        $filename = str_replace(" ","_",$filename);
        $stringtime = strtotime(date("Y-m-d H:i:s"));
        if ($cldrResult = (new UploadApi())->upload($file->getRealPath(),['public_id' => $bucket.'/'.$filename."_".$stringtime])) {
            return $cldrResult["secure_url"];
        }

        return false;
    }

}