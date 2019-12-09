<?php
namespace App\Services;
use App\Models\Category;
class CategoryService
{
    public function add(array $data)
    {
        //添加商品
        $category = new Category();
        $category->name = $data['name'];
        $category->property = $data['property'];
        $category->sort = $data['sort'];
        $category->status = $data['status'];

        if (!$category->save()) {
            return null;
        }


        // 添加 SKU

        return $category;

    }
}
