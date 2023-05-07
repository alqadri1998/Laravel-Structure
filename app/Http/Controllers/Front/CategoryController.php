<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Traits\GetAttributes;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    use GetAttributes;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSubCategories1($id)
    {
        $subCategory = $this->getSubCategories($id);
        return $subCategory;
    }

    public function subCategories($id)
    {
        $category = Category::where('id', $id)->whereHas('languages')->with('languages')->first();
        $category->translations = $this->translateRelation($category, 'languages');
        $this->breadcrumbTitle = __($category->translations->name);
        $this->breadcrumbs[route('front.sub-categories', $id)] = ['title' => __($category->translations->name)];
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Sub Categories')];
        $subCategory = '';
        $subCategory = Category::whereHas('languages')->with('languages')->where('parent_id', $id)->paginate(12);
        if (count($subCategory) == 0) {
            return redirect(route('front.product.index', ['category' => $id]));
        }
        $this->setTranslations($subCategory);

        return view('front.categories.sub-categories', ['subCategories' => $subCategory]);
    }
}
