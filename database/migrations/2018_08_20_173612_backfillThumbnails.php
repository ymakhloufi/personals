<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Personals\Ad\Picture;

class BackfillThumbnails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Picture::whereNull('thumbnail_url')->where('url', 'like', 'https://cdn%')->get() as $pic) {
            /** @var Picture $pic */
            $fileName = explode("/", $pic->url);
            $fileName = str_replace(".", "_thumb.", end($fileName));

            $extension = explode(".", $fileName);
            $extension = end($extension);

            $path = "/tmp/" . $fileName;

            file_put_contents($path, file_get_contents($pic->url));
            $image = (new ImageManager())->make($path);

            $constraints = function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            };

            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(100, null, $constraints);
            } elseif ($image->getHeight() > $image->getWidth()) {
                $image->resize(null, 100, $constraints);
            }

            $image->save();

            $uFile = new UploadedFile($path, $fileName, $extension);
            \Storage::putFileAs('images/' . $pic->ad_id, $uFile, $fileName);
            $pic->thumbnail_url = \Storage::url('images/' . $pic->ad_id . "/" . $fileName);
            $pic->save();
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
