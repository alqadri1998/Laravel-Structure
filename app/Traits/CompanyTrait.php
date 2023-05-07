<?php

namespace App\Traits;

use App\Http\Libraries\Uploader;
use App\Models\Company;
use App\Models\CompanyTiming;
use App\Models\User;
use Carbon\Carbon;

trait CompanyTrait {

    public function saveCompany($request, $companyId = 0)
    {
        $data = $request->only('type', 'user_id', 'address', 'contact_number', 'email', 'latitude', 'longitude');
        $companyTimings = $request->get('timing');
        if ($request->hasFile('image')) {
            $uploader = new Uploader('image');
            if ($uploader->isValidFile()) {
                $uploader->upload('companies', $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $data['image'] = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                return redirect()->back()->with('err', $uploader->getMessage())->withInput();
            }
        }
        $company = Company::updateOrCreate(['id' => $companyId], $data);
        $company->languages()->syncWithoutDetaching([
            $request->get('language_id') => [
                'title' => $request->get('title'),
                'detail' => $request->get('detail'),
            ]
        ]);
        User::where(['id' => $data['user_id']])->update(['account_type' => 'company']);
        CompanyTiming::where(['company_id' => $company->id])->delete();
        foreach ($companyTimings as $key => $timing){
            $timing['company_id'] = $company->id;
            CompanyTiming::create($timing);
        }
        return $company;
    }

}