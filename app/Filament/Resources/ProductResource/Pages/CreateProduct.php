<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    
    protected function handleRecordCreation(array $data): Model
    {
        // Create the product
        $product = static::getModel()::create($data);
        
        // Handle variants if necessary
        if ($product->has_variants && isset($data['generated_variants'])) {
            $this->createProductVariants($product, $data['generated_variants']);
        }
        
        return $product;
    }
    
    protected function createProductVariants($product, $variants)
    {
        foreach ($variants as $variantData) {
            // Create the product variant
            $variant = new ProductVariant([
                'product_id' => $product->id,
                'price' => $variantData['price'],
                'stock' => $variantData['stock'],
            ]);
            
            $variant->save();
            
            // Create variant attributes
            if (!empty($variantData['attributes'])) {
                foreach ($variantData['attributes'] as $attributeId => $valueId) {
                    VariantAttribute::create([
                        'product_variant_id' => $variant->id,
                        'attribute_value_id' => $valueId,
                    ]);
                }
            }
        }
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
