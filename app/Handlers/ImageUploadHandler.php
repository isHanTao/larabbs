<?php

namespace App\Handlers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    public function save(UploadedFile $file, $folder, $file_prefix, $max_width = false)
    {
        $res = [
            'size' => $file->getSize(),
            'name'=>$file->getClientOriginalName()
        ];

        // 文件夹路径
        $folder_name = "/uploads/images/$folder/" . date("Ym/d", time()).'/';

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // 如果上传的不是图片将终止操作
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {
            $file = $this->reduceSize($file->getContent(), $max_width);
        }

        // 如果是本地就需要建文件夹
//        if (!is_dir(storage_path($folder_name))){
//            mkdir(storage_path($folder_name),0777,true);
//        }
        Storage::put($folder_name.$filename, $file);

        $res['path'] = $folder_name.$filename;


        return $res;
    }

    public function reduceSize($file, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        return $image->stream()->getContents();
    }
}
