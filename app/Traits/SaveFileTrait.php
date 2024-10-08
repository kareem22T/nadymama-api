<?php
namespace App\Traits;

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

    // Return the final file name (with extension)
    return $fileName;
}
}
