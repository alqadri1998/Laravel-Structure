<?php

namespace App\Traits;

use App\Models\Admin;
use App\Http\Libraries\Uploader;

trait Administrators {

    /*
     * PIRVATE FUNCTION TO SAVE ADMIN DATA
     */
    private function save($request, $id = 0, $active = false) {

        $data = $request->only(['role_id', 'full_name', 'user_name', 'email', 'is_active','address','latitude','longitude']);

        if($id>0) {

            if ($request->old_credit_limit > $request->total_credit_limit) {

                $data['credit_limit'] =abs($request->credit_limit - (abs($request->old_credit_limit - $request->total_credit_limit)));
//
                $data['total_credit_limit'] = $request->total_credit_limit;
            }
            elseif($request->old_credit_limit < $request->total_credit_limit) {

                $data['credit_limit'] = abs((abs($request->total_credit_limit-$request->old_credit_limit)) + $request->credit_limit);
                $data['total_credit_limit'] = $request->total_credit_limit;
            }
            else {
                $data['total_credit_limit']=$request->total_credit_limit;
                $data['credit_limit']=$request->credit_limit;
            }
        }
        else
        {
            $data['total_credit_limit']=$request->total_credit_limit;
            $data['credit_limit']=$request->total_credit_limit;
        }
        if ($data['role_id']== Admin::superSystemAdminId) {
            return redirect()->back()->with('err', 'You cannot add super admin')->withInput();
        }

       if($id>0 && !empty($request->get('image'))) {
                   $data['profile_pic'] = $request->get('image');
       }
       if($id==0)
       {

           $data['profile_pic'] = $request->get('image');
       }
       if (!empty($request->get('password'))) {

            $data['password'] = bcrypt($request->get('password'));
        }
        if ($active) {
            unset($data['role_id']);
            unset($data['is_active']);
            $admin = Admin::find($id);
            $admin->update($data);
            session()->put('ADMIN_DATA', $admin->toArray());
        }
        else {
            Admin::updateOrCreate(['id' => $id], $data);
        }
    }

}