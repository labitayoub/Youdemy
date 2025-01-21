<?php
namespace App\Controllers;

use App\Models\CategorieModels;

class CategorieController {


    public function createCategory($categoryName) {
        $categorieModels = new CategorieModels();
        return $categorieModels->addCategory($categoryName);
    }

  
    public function deleteCategory($categoryId) {
        $categorieModels = new CategorieModels();
        return $categorieModels->removeCategory($categoryId);
    }


    public function updateCategory($categoryId, $newCategoryName) {
        $categorieModels = new CategorieModels();
        return $categorieModels->editCategory($categoryId, $newCategoryName);
    }

 
    public function getAllCategories() {
        $categorieModels = new CategorieModels();
        return $categorieModels->getAllCategories();
    }

  
    public function getCategoryById($categoryId) {
        $categorieModels = new CategorieModels();
        return $categorieModels->getCategoryById($categoryId);
    }
}