<?php
namespace App\Traits;
require __DIR__.'/../../vendor/autoload.php';
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait SaveFileTrait
{

function savefile($photo, $folder) {
    // Ensure the file has an extension
    $file_extension = $photo->getClientOriginalExtension();

    // If the extension is empty, use a default extension (e.g., 'txt')
    if (empty($file_extension)) {
        $file_extension = 'txt'; // Change this to the default extension you want
    }

    $fileNameWithExtension = $photo->getClientOriginalName();
    $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
    $path = $folder;

    $counter = 1;

    // Check if a file with the same name and extension already exists
    while (file_exists($path . '/' . $fileName . '.' . $file_extension)) {
        $fileName = $fileName . '_' . $counter;
        $counter++;
    }

    // Append the correct file extension
    $fileName = $fileName . '.' . $file_extension;

    // Move the file to the destination folder
    $photo->move($path, $fileName);

    // create image manager with desired driver
    $manager = new ImageManager(new Driver());

    // read image from file system
    $image = $manager->read($folder . $fileName);

    // resize image proportionally to 300px width
    $image->scale(width: 600);

    // save modified image in new format
    $image->save($folder . $fileName);

    // create image manager with desired driver
    $manager2 = new ImageManager(new Driver());

    // read image from file system
    $image2 = $manager->read($folder . $fileName);

    // resize image proportionally to 300px width
    $image2->scale(width: 300);

    // save modified image in new format
    $image2->save($folder . $fileName . '_small.' . $file_extension);

    // Return the final file name (with extension)
    return $fileName;
}
}
