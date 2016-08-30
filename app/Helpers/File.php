<?php

namespace App\Helpers;

/*
 * Antvel - Files Validations Helper
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Models\UpdateFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{
    /**
     * $default_path
     * It is the folder where all the files will be stored.
     *
     * @var string
     */
    private static $default_path = 'files';

    /**
     * $sections
     * It contains the validation rules which will be used in upload process.
     *
     * @var [type]
     */
    private static $sections =
    [
        'default'          => ['path' => '', 'type' => 'all', 'valid' => '/[\.\/](.+)$/i'],
        'dynamic_attachment' => ['path' => 'company/dynamic/attachment', 'type' => 'all', 'code' => true, 'valid' => '/[\.\/](.+)$/i'],


        'img'              => ['path' => 'img', 'type' => 'img', 'code' => true, 'valid' => '/[\.\/](jpe?g|png)$/i', 'maxwidth' => 2048],
        'category_img'     => ['path' => 'img/categories/image', 'type' => 'img', 'valid' => '/[\.\/](jpe?g|png)$/i', 'maxwidth' => 600, 'square' => true],
        'profile_img'      => ['path' => 'img/profile', 'type' => 'img', 'code' => true, 'valid' => '/[\.\/](jpe?g|png)$/i', 'maxwidth' => 600, 'square' => true],
        'product_img'      => ['path' => 'img/products/image', 'type' => 'img', 'code' => true, 'valid' => '/[\.\/](jpe?g|gif|png)$/i', 'maxwidth' => 600, 'square' => true],
        'product_key'      => ['path' => 'products/key_code', 'type' => 'text', 'code' => true, 'valid' => '/[\.\/](txt)$/i'],
        'product_software' => ['path' => 'products/software', 'type' => 'compact', 'code' => true, 'valid' => '/[\.\/](zip|rar)$/i'],
    ];

    //variables
    private static $full_path = '';
    private $options = [];

    public function __construct($options = [])
    {
        $this->options = $options;

        return $this;
    }


    public static function __callStatic($name, array $arguments)
    {
        if ($name == 'section') {
            $file = new self();

            return $file->callableSection($arguments[0], @$arguments[1]);
        }
    }

    public function __call($name, array $arguments)
    {
        if ($name == 'section') {
            return $this->callableSection($arguments[0], @$arguments[1]);
        }
    }

    private function callableSection($section = '', $clean = false)
    {
        return $this->setting(self::$sections[$section ?: 'img'], $clean);
    }

    public function setting(array $options, $clean = false)
    {
        if (@$clean) {
            $this->options = [];
        }
        $this->options = $this->options + $options;

        return $this;
    }


    /**
     * 上传文件
     * @param $files
     * @return array|string
     */
    public function upload($files)
    {
        //检查是否是一个文件
        if ($files instanceof UploadedFile) {
            $many = false;

        //超过一个文件
        } elseif (is_array($files)) {
            $many = true;

        //不是文件
        } else {
            return '';
        }

        //one file validation
        if (!$many) {
            $files = [$files];
        }

        /**
         * $uploaded
         * It is the array that will contains all the uploaded files information.
         *
         * @var array
         */
        $uploaded = [];
        foreach ($files as $file) {
            $info = (object) pathinfo(strtolower($file->getClientOriginalName()));
            $options = (object) $this->options;

            //setting file path
            $path = [storage_path(), self::$default_path, $options->path];
            if (@$options->code && \Auth::check()) {
                $path[] = \Auth::id();
            }

            //user folder
            if (@$options->subpath) {
                $path[] = $options->subpath;
            }

            //file type validation - if file type or any file type are allowed
            if ((!isset($options->valid) || preg_match($options->valid, '.'.$info->extension)) && $file->isValid()) {
                //subfolder
                $path = implode('/', $path);

                //destiny file
                list($tmp1, $tmp2) = explode(' ', microtime());
                $msec =  (float)sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 1000);
                $file_destiny = md5($msec.mt_rand(0, 10000)).'.'.$info->extension;

                //folder validation - if there is not folder, it will be created
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                //uploading file
                $return = $file->move($path, $file_destiny);

                //normalization of the file sent
                $this->normalice("$path/$file_destiny");

                $recode = new UpdateFile();
                $recode->name = $info->basename;
                $recode->path = substr(explode(self::$default_path, str_replace('\\', '/', $return))[1], 1);
                $recode->ext = $info->extension;
                if(\Auth::user()){
                    $recode->user_id = \Auth::user()->id;
                }else{
                    $recode->user_id = 0;
                }
                $recode->save();

                //keeping the uploaded file path
                $uploaded[] = ['path'=>$recode->path, 'id'=>$recode->id];
            } else {
                $MaxFilesize = self::formatBytes($file->getMaxFilesize());
                $uploaded[] = 'Error: '."文件大小已超过{$MaxFilesize}最大值";
            }
        }

        return $many ? $uploaded : $uploaded[0];
    }

    public static function deleteFile($file)
    {
        $path = explode('/', $file);

        if (\Auth::id() == $path[4]) {
            $file = storage_path().'/'.self::$default_path.$file;
            unlink($file);

            return file_exists($file) ? 0 : 1;
        }

        return 0;
    }

    /**
     * normalice
     * This method controlls files size and shape.
     *
     * @param [object] $file file to evaluated
     *
     * @return [object] $file file normalized
     */
    public function normalice($file)
    {
        $info = (object) pathinfo($file);
        $options = (object) $this->options;

        //images control
        if (@$options->type == 'img') {
            $img = \Image::make($file);
            $maxwidth = @$options->maxwidth ?: null;
            $maxheight = @$options->maxheight ?: null;

            //resizing images
            if (@$options->square) {
                //square picture
                $height = $img->height();
                $width = $img->width();
                $offset = floor(abs($width - $height) / 2);
                if ($height > $width) {
                    $img->crop($width, $width, 0, $offset);
                } else {
                    $img->crop($height, $height, $offset, 0);
                }
            }

            if ($maxwidth || $maxheight) {
                $img->resize($maxwidth, $maxheight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $img->save();
        }

        return $this;
    }

    public static function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'k', 'M', 'G', 'T'];

        return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)];
    }
}
