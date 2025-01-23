<?php
namespace App\Controllers;

use App\Models\CategorieModels;

class CategorieController {


    public function createCategory($categoryName) {
        $categorieModels = new CategorieModels();
         $categorieModels->addCategory($categoryName);
    }

  
    public function deleteCategory($categoryId) {
        $categorieModels = new CategorieModels();
        $categorieModels->removeCategory($categoryId);
    }


    public function updateCategory($categoryId, $newCategoryName) {
        $categorieModels = new CategorieModels();
        $categorieModels->editCategory($categoryId, $newCategoryName);
    }

 
    public function getAllCategories() {
        $categorieModels = new CategorieModels();
         $categorieModels->getAllCategories();
    }

  
    public function getCategoryById($categoryId) {
        $categorieModels = new CategorieModels();
         $categorieModels->getCategoryById($categoryId);
    }
}