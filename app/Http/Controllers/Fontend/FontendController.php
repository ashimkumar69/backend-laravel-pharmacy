<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use App\Http\Resources\Banner as BannerResource;
use App\Footer;
use App\Http\Resources\Footer as FooterResource;
use App\Product;
use App\Http\Resources\Product as ProductResource;
use App\Blog;
use App\Http\Resources\Blog as BlogResource;

class FontendController extends Controller
{
    public function bannerIndex()
    {
        return  BannerResource::collection(Banner::all());
    }

    public function footerIndex()
    {
        return new FooterResource(Footer::first());
    }

    public function productIndex()
    {
        return  ProductResource::collection(Product::all());
    }

    public function blogIndex()
    {
        return  BlogResource::collection(Blog::published()->paginate(4));
    }

    public function showBlog($slug, Blog $blog)
    {
        return new BlogResource($blog->whereSlug($slug)->first());
    }
}
