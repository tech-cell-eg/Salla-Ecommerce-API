<?php

namespace App\Filament\Widgets;

use App\Models\Tag;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Slider;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductVariant;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EcommerceStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Stat::make('Total Variants', ProductVariant::count())
                ->icon('heroicon-o-squares-2x2')
                ->color('primary'),

            Stat::make('Total Attributes', Attribute::count())
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('primary'),

            Stat::make('Total Brands', Brand::count())
                ->icon('heroicon-o-tag')
                ->color('primary'),

            Stat::make('Total Categories', Category::count())
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary'),

            Stat::make('Total Coupons', Coupon::count())
                ->icon('heroicon-o-ticket')
                ->color('primary'),

            Stat::make('Total Orders', Order::count())
                ->icon('heroicon-o-shopping-cart')
                ->color('primary'),

            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-user')
                ->color('primary'),

            
            Stat::make('Total Features', Feature::count())
                ->icon('heroicon-o-sparkles')
                ->color('primary'),
            
            
            Stat::make('Total Sliders', Slider::count())
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary'),

            
            Stat::make('Total Tags', Tag::count())
                ->icon('heroicon-o-hashtag')
                ->color('primary'),
            
            
            
            
        ];
    }
}