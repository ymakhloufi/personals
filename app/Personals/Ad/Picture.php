<?php

namespace Personals\Ad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

/**
 * Personals\User\User
 *
 * @property integer $id
 * @property integer $ad_id
 * @property string  $url
 * @property string  $thumbnail_url
 * @property-read Ad $ad
 * @mixin \Eloquent
 */
class Picture extends Model
{
    const IMAGE_MAX_WIDTH  = 100;
    const IMAGE_MAX_HEIGHT = 100;

    protected $guarded    = ['id'];
    public    $timestamps = false;


    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }


    public static function makeThumbnail(UploadedFile $file, Ad $ad, string $fileName)
    {
        $deleteAfterUpload = false;

        // makes sure that the image is not up-scaled and keeps the aspect ratio.
        $constraints = function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        };

        // resize image if it is not a vector graphics file (SVG)
        // overwrites original file!!
        if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
            $image = (new ImageManager())->make($file->getRealPath());

            if ($image->getWidth() >= $image->getHeight()) {
                $image->resize(static::IMAGE_MAX_WIDTH, null, $constraints);
            } else {
                $image->resize(null, static::IMAGE_MAX_HEIGHT, $constraints);
            }

            $deleteAfterUpload = true;
            $image->save($path = tempnam("/tmp", "img"));

            $file = new UploadedFile($path, $file->getClientOriginalName(), $file->getClientOriginalExtension());
        }

        $fileName = $fileName . "_thumb." . $file->getClientOriginalExtension();
        \Storage::putFileAs('images/' . $ad->id, $file, $fileName);
        if ($deleteAfterUpload) {
            File::delete($file->getRealPath());
        }

        return $fileName;

    }
}
