<?php

use App\Http\Libraries\ResponseBuilder;
use App\Models\City;
use App\Models\CityLanguage;
use Carbon\Carbon;

function imageUrl($path, $width = NULL, $height = NULL, $quality = NULL, $crop = NULL)
{
    if (!$width && !$height) {
        $url = env('IMAGE_URL') . $path;
    } else {
        $url = url('/') . '/images/timthumb.php?src=' . env('IMAGE_URL') . $path;
        if (isset($width)) {
            $url .= '&w=' . $width;
        }
        if (isset($height) && $height > 0) {
            $url .= '&h=' . $height;
        }
        if (isset($crop)) {
            $url .= "&zc=" . $crop;
        } else {
            $url .= "&zc=1";
        }
        if (isset($quality)) {
            $url .= '&q=' . $quality . '&s=0';
        } else {
            $url .= '&q=95&s=0';
        }
    }
    return $url;
}

function parseAsBlade($template, $params = [])
{
    $languages = [];
    $segments = request()->segments();
    $queryParams = explode('?', request()->fullUrl());
    unset($segments[0]);
    foreach (cache('LANGUAGES') as $lang) {
        $languages[$lang['short_code']] = [
            'title' => $lang['title'],
            'url' => url(implode('/', array_merge([$lang['short_code']], $segments)) . ((count($queryParams) > 1) ? '?' . $queryParams[1] : ''))
        ];
    }
    $data = [
        'locale' => config('app.locale'),
        'title' => config('settings.company_name'),
        'languages' => $languages,
        'currentRouteName' => \Route::current()->getName(),
    ];
    extract($data);
    extract($params);
    $response = "";
    ob_start();
    eval('?>' . \Blade::compileString($template));
    $response = ob_get_contents();
    ob_end_clean();
    return $response;
}

function responseBuilder()
{
    $responseBuilder = new ResponseBuilder();
    return $responseBuilder;
}

function getConversionRate()
{
    if (Cache::has('AED')){
        $rate = Cache::get('AED');
    }
    else{
//        $swapEURToUSD = \Swap::latest('EUR/USD');
//        $swapEURToAED = \Swap::latest('EUR/AED');
//        // rate of 1 USD in EUR
//        $rateUSDToEUR = 1 / $swapEURToUSD->getValue();
//        // rate of 1 AED in EUR
//        $rateAEDToEUR = 1 / $swapEURToAED->getValue();
////                $rate  = round(((1 / $rateUSDToEUR) * $rateAEDToEUR), 2);
        $rate = 3.67;
        Cache::put('AED', $rate, Carbon::now()->addMinutes(60));
    }
    return $rate;

}

function getAEDCoversationRate(){
    $swapEURToUSD = \Swap::latest('EUR/USD');
    $swapEURToAED = \Swap::latest('EUR/AED');
    // rate of 1 USD in EUR
    $rateUSDToEUR = 1 / $swapEURToUSD->getValue();
    // rate of 1 AED in EUR
    $rateAEDToEUR = 1 / $swapEURToAED->getValue();
//                $rate  = round(((1 / $rateUSDToEUR) * $rateAEDToEUR), 2);
    return round(((1 / $rateAEDToEUR) * $rateUSDToEUR), 2);
}

function getUSDCoversationRate(){
    $swapEURToUSD = \Swap::latest('EUR/USD');
    $swapEURToAED = \Swap::latest('EUR/AED');
    // rate of 1 USD in EUR
    $rateUSDToEUR = 1 / $swapEURToUSD->getValue();
    // rate of 1 AED in EUR
    $rateAEDToEUR = 1 / $swapEURToAED->getValue();
    return round(((1 / $rateUSDToEUR) * $rateAEDToEUR), 2);
//    $rate = round(((1 / $rateAEDToEUR) * $rateUSDToEUR), 2);
}

    function trim_text($input) {
        $middle = ceil(strlen($input) / 2);
        $middle_space = strpos($input, " ", $middle - 1);
            $first_half = substr($input, 0, $middle_space);
            $second_half = substr($input, $middle_space);
        return  $first_half.'@'.$second_half;
    }

/**
 * Set session alert / flashdata
 * @param string $type Alert type
 * @param string $message Alert message
 */
function set_alert($type, $message)
{
    session()->flash('alert_type', $type);
    session()->flash('alert_message', $message);
}

function get_user_id()
{
    if (\Auth::check()) {
        return \Auth::user()->id;
    }
    return null;
}


function getUserProfileImage($path)
{
    $img_path = 'img/default_profile.jpg';
    if ($path != null) {
        $img_path = $path;
    }
    return imageUrl($img_path, 500, 500, 100);
}

function getCityDropDown()
{
    $dropDownCities = CityLanguage::whereHas('city')
        ->with(['language_id' => config('app.locales')[config('app.locale')]])
        ->pluck('title', 'city_id');
    return $dropDownCities;
}
function calcualateDistance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    } else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
function getStarRating($value)
{
    $star_rate = $value;
    if ($value > 0  && $value < 0.5)
    {
        $star_rate = 0.5;
    }
    if ($value > 0.5 && $value < 1)
    {
        $star_rate = 1;
    }
    if ($value > 1 && $value < 1.5)
    {
        $star_rate = 1.5;
    }
    if ($value > 1.5 && $value < 2)
    {
        $star_rate = 2;
    }
    if ($value > 2 && $value < 2.5)
    {
        $star_rate = 2.5;
    }
    if ($value > 2.5 && $value < 3)
    {
        $star_rate = 3;
    }
    if ($value > 3 && $value < 3.5)
    {
        $star_rate = 3.5;
    }
    if ($value > 3.5 && $value < 4)
    {
        $star_rate = 4;
    }
    if ($value > 4 && $value < 4.5)
    {
        $star_rate = 4.5;
    }
    if ($value > 5)
    {
        $star_rate = 5;
    }
    return $star_rate;
}

function pluckPackagesValue($availablePackages)
{
    $packges = [];
    foreach ($availablePackages as $key => $availablePackage) {
        $packges[$availablePackage->id] = $availablePackage->package->translation->title . ' ( views ' .$availablePackage->package->views . ' )' ;
    }
    return $packges;
}

function getConvertedPrice($currency_id , $price){
    $conversionRates = cache('CONVERSION_RATES');
    $currencyId = session('CURRENCY_ID', config('app.currencies.AED'));
//    Log::info('currency_id '.$currency_id.' CurrencyId session '.$currencyId);
    if($currency_id == 1 && $currencyId == 1){
        $price = round($price,2);
    }
    if ($currency_id == 1 && $currencyId == 2){
        $price =  round($price / 3.67,2);
    }
    if ($currency_id == 2 && $currencyId == 2){
        $price = 0;
    }
    if ($currency_id == 2 && $currencyId == 1){
        $price =  0;
    }

    return $price;
}
function getUsdAedPrice($price){
    $conversionRates = cache('CONVERSION_RATES');
    $price = round($price * $conversionRates['2_to_1']['rate'],2);
    return $price;
}

function showPromotionSlider($setting){
    if($setting == '1'){
        return true;
    }else{
        return false;
    }
}