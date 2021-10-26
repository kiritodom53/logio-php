<?php


namespace App\Controller;

use App\Conf\Consts;

class ProductController extends BaseController
{
    /**
     * @param string $id Product ID
     * @return string Product in JSON format
     */
    public function detail(string $id): string
    {
        header('Content-type: application/json');
        $product = $this->getCacheProduct($id);
        if (empty($product)) {
            $result = static::getDB()->findProduct($id);
            if (empty($result)){
                return json_encode([
                    'message' => '0 result'
                ]);
            }
            $this->addProductToCache($result[0]);
            return json_encode($result[0]);
        }
        return json_encode($product);
    }

    /**
     * Add product to cache file
     *
     * @param object $p
     * @return void
     */
    private function addProductToCache(object $p): void
    {
        $cacheProducts = $this->loadCacheFile(Consts::CACHE_PRODUCT_FILE_PATH);
        $cacheProducts['product'][] = ["id" => $p['id'],
            "name" => $p['name'],
            "count" => $p['count']];
        $this->saveCacheFile(Consts::CACHE_PRODUCT_FILE_PATH, $cacheProducts);
    }

    /**
     * Get product from cache
     *
     * @param string $id
     * @return array
     */
    private function getCacheProduct(string $id): array
    {
        $data = $this->loadCacheFile(Consts::CACHE_PRODUCT_FILE_PATH);

        $results = array_filter($data['product'], fn($p) => $p['id'] = $id);

        if (sizeof($results) == 0)
            return [];

        $this->incrementProductQueries($data, $id);
        return $results;
    }

    /**
     * Increase the number of product queries by 1
     *
     * @param array $data Products
     * @param string $id Product ID
     * @return void
     */
    private function incrementProductQueries(array $data, string $id)
    {
        $data['product'][$id]['count']++;
        $this->saveCacheFile(Consts::CACHE_PRODUCT_FILE_PATH, $data);
    }
}