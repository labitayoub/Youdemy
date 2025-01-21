<?php
namespace App\Controllers;

use App\Models\TagModels;

class TagController {


    public function createTag($tagName) {
        $tagModels = new TagModels();
        return $tagModels->addTag($tagName);
    }

  
    public function deleteTag($tagId) {
        $tagModels = new TagModels();
        return $tagModels->removeTag($tagId);
    }


    public function getAllTags() {
        $tagModels = new TagModels();
        return $tagModels->getAllTags();
    }
}