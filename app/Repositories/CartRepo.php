<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepo{
    public function get() : collection;
    public function add(Product $product,$quantity);
    public function delete($id);
    public function update($id ,$quantity);
    public function total();
    public function empty();
}
