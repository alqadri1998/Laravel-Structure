<?phpnamespace App\Traits;use App\Models\Category;use App\Models\Manufacturer;use App\Models\ProductImage;trait Products{    public function getCategories()    {        $categoriesData = Category::with('languages')->where('parent_id', '=', null)->get();        $this->setTranslations($categoriesData);        foreach ($categoriesData as $key => $category) {            $categories[$category->id] = $category->translation->title;        }        return $categories;    }    public function getSubCategories($categoryID)    {        $subCategoryData = Category::with('subCategories.languages')->findOrFail($categoryID);        $this->setTranslations($subCategoryData['subCategories']);        if ($subCategoryData['subCategories']) {            foreach ($subCategoryData['subCategories'] as $key => $subCategory) {                $subCategories[$subCategory->id] = $subCategory->translation->title;            }        }        return $subCategories;    }    public function manufacturesWithModels()    {        $manufacturers = Manufacturer::with(['languages', 'models.languages'])->whereHas('languages')->orderBy('id', 'desc')->get();        $this->setTranslations($manufacturers, 'languages', ['models' => 'languages']);        return $manufacturers;    }    public function categoriesWithSubCategories()    {        $categories = Category::with(['languages', 'subCategories.languages'])            ->whereHas('languages')            ->where('parent_id', '=', null)            ->orderBy('id', 'desc')            ->get();        $this->setTranslations($categories, 'languages', ['subCategories' => 'languages']);        return $categories;    }    public function productsData($product)    {        $productData = $product->toArray();        foreach ($productData as $key => $value) {            if (is_null($value)) {                $productData[$key] = '';            }        }        return $productData;    }    public function getImages($productId)    {        $imageData = [];        $images = ProductImage::select('image')->where('product_id', $productId)->get();        foreach ($images as $key => $image) {            $imageData[$key] = $image->getOriginal('image');        }        return $imageData;    }    public function gettrashedModel()    {        $trashed_model = function ($category) {            $category->withTrashed();            $category->with('languages');        };        return $trashed_model;    }    public function getTrashedManufacturer()    {        $trashed_manufacture = function ($category) {            $category->withTrashed();            $category->with('languages');        };        return $trashed_manufacture;    }    public function getTrashedCategory()    {        $trashed_category = function ($category) {            $category->withTrashed();            $category->with('languages');        };        return $trashed_category;    }    public function getTrashedSubCategories()    {        $trashed_subcategory = function ($category) {            $category->withTrashed();            $category->with('languages');        };        return $trashed_subcategory;    }}