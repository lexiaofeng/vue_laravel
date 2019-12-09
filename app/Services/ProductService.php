<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;

class ProductService
{
    public function add(array $data)
    {
        //添加商品
        $product = new Product();
        $product->category_id = $data['product']['category_id'];
        $product->name = $data['product']['name'];
        $product->sale_num = $data['product']['sale_num'];
        $product->content = $data['product']['content'];
        $product->sort = $data['product']['sort'];
        $product->status = $data['product']['status'];
        if (!$product->save()) {
            return null;
        }

        //添加标签
        $tags = $data['tag'];
        if($tags!=null){
            $insertTags = [];
            foreach ($tags as $ind => $record) {
                $insertTags[$ind]['tag_id'] = $record['tag_id'];
                $insertTags[$ind]['value'] = $record['value'];
                $insertTags[$ind]['status'] = $record['status'];
                $insertTags[$ind]['product_id'] = $product['id'];
            }
            $bool = DB::table('pre_product_tag')->insert($insertTags);
            if (!$bool) {
                return null;
            }
        }


        //添加sku
        $skus = $data['sku'];
        if ($skus!=null){
            $insertSkus = [];
            foreach ($skus as $ind => $record) {
                $insertSkus[$ind]['product_id'] = $product['id'];
                $insertSkus[$ind]['original_price'] = $record['original_price'];
                $insertSkus[$ind]['price'] = $record['price'];
                $insertSkus[$ind]['attr1'] = json_encode($record['attr1']);
                $insertSkus[$ind]['attr2'] = json_encode($record['attr2']);
                $insertSkus[$ind]['quantity'] = $record['quantity'];
                $insertSkus[$ind]['sort'] = $record['sort'];
                $insertSkus[$ind]['status'] = $record['status'];
            }
            $bool1 =  DB::table('pre_sku')->insert($insertSkus);
            if (!$bool1){
                return null;
            }
        }


        return $product;


    }
}
