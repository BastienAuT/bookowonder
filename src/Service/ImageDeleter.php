<?php

namespace App\Service;

use App\Entity\User;

class ImageDeleter
{
    public function deleteImage($user, $files)
    {
        // get the image from the user asking for delete
        $image = $user->getProfilePic();

        // We check if the image is not the default or empty
        if ($image === "user_default.png") {
            return false;
        }
        
        // If we don't check this one it will delete the entire folder
        if ($image === "") {
            return false;
        }

        // If everything check, we can remove it
        $files->remove($_ENV['IMAGES_FOLDER'] . "/" . $image);

        return true;
    }

    //Use it only when you delete a book, not on edit mode
    public function deleteBookImages($book, $files)
    {
        // get all files from book to delete
        $bookImage = $book->getPicture();
        $bookFrontImage = $book->getFrontPic();
        $bookEpub = $book->getEpub();

        // If we don't check this one it will delete the entire folder
        if ($bookImage === "") {
            return false;
        }
        if ($bookFrontImage === "") {
            return false;
        }
        if ($bookEpub === "") {
            return false;
        }

        // If everything check, we can remove it
        $files->remove($_ENV['IMAGES_BOOK_FOLDER'] . "/" . $bookImage);
        $files->remove($_ENV['IMAGES_BOOKFRONT_FOLDER'] . "/" . $bookFrontImage);
        $files->remove($_ENV['EPUB_FOLDER'] . "/" . $bookEpub);

        return true;
    }
    //delete on edit mode
    public function deleteBookCover($book, $files)
    {
        // get the image from the book asking for delete
        $bookImage = $book->getPicture();
        

        // If we don't check this one it will delete the entire folder
        if ($bookImage === "") {
            return false;
        }
        

        // If everything check, we can remove it
        $files->remove($_ENV['IMAGES_BOOK_FOLDER'] . "/" . $bookImage);
        

        return true;
    }
    //delete on edit mode
    public function deleteBookFrontImage($book, $files)
    {
        // get the image on front page from the book asking for delete
        $bookFrontImage = $book->getFrontPic();
        

        // If we don't check this one it will delete the entire folder
        if ($bookFrontImage === "") {
            return false;
        }
        

        // If everything check, we can remove it
        $files->remove($_ENV['IMAGES_BOOKFRONT_FOLDER'] . "/" . $bookFrontImage);
        

        return true;
    }
    //delete on edit mode
    public function deleteBookEpub($book, $files)
    {
        // get the epub from the book asking for delete
        $bookEpub = $book->getEpub();
        

        // If we don't check this one it will delete the entire folder
        if ($bookEpub === "") {
            return false;
        }
        

        // If everything check, we can remove it
        $files->remove($_ENV['EPUB_FOLDER'] . "/" . $bookEpub);
        

        return true;
    }

    //delete AND edit mode
    public function deleteCategoryImage($category, $files)
    {
        // get the image from the category asking for delete
        $categoryImage = $category->getImage();
        

        // If we don't check this one it will delete the entire folder
        if ($categoryImage === "") {
            return false;
        }
        

        // If everything check, we can remove it
        $files->remove($_ENV['IMAGES_CATEGORY_FOLDER'] . "/" . $categoryImage);
        

        return true;
    }
    //delete AND edit mode
    public function deleteAudioImage($audio, $files)
    {
        // get the image from the category asking for delete
        $audioImage = $audio->getImage();
        

        // If we don't check this one it will delete the entire folder
        if ($audioImage === "") {
            return false;
        }
        

        // If everything check, we can remove it
        $files->remove($_ENV['IMAGES_AUDIO_FOLDER'] . "/" . $audioImage);
        

        return true;
    }
}
