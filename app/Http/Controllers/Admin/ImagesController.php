<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use App\Traits\DataFormController;

class ImagesController extends Controller
{
    use DataFormController;
    public function uploadeImg(Request $request) {
        $validator = Validator::make($request->all(), [
            'img' => ['required', 'image'], // Ensure the uploaded file is an image
        ], [
            'img.required' => 'Please upload a valid image',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Upload failed', [$validator->errors()->first()], []);
        }

        // Use the storePhoto method to save the image
        $imagePath = $this->storePhoto($request->file('img'));
        if ($imagePath) {
            $uploadImage = Image::create([
                'path' => $imagePath,
            ]);

            if ($uploadImage) {
                return $this->jsondata(true, true, 'Image has been uploaded successfully', [], []);
            }
        }

        return $this->jsondata(false, true, 'Upload failed', ['Please upload a valid image'], []);
    }

    public function search(Request $request) {
        $images = Image::where('path', 'like', '%' . $request->search_words . '%')
                       ->orderBy('id', 'desc')
                       ->paginate(10);

        return $this->jsondata(true, true, '', [], $images);
    }

    public function getImages() {
        $getImages = Image::orderBy('id', 'desc')->paginate(10);

        if ($getImages) {
            return $this->jsondata(true, true, '', [], $getImages);
        }

        return $this->jsondata(false, true, 'There are no images yet', ['Please upload images'], []);
    }

    public function putSEO(Request $request) {
        $validator = Validator::make($request->all(), [
            'img_id' => ['required'],
        ], [
            'alt.required' => 'Please enter image alt',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Upload failed', [$validator->errors()->first()], []);
        }

        $image = Image::find($request->img_id);
        if ($image) {
            $image->title = $request->title;
            $image->save();

            return $this->jsondata(true, true, 'Image updated successfully', [], []);
        }

        return $this->jsondata(false, true, 'Image not found', ['Invalid image ID'], []);
    }

    protected function storePhoto($photo)
    {
        $path = $photo->store('photos', 'public'); // Store the photo in the 'storage/app/public/photos' directory
        return $path;
    }
}
