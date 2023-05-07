<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Coupons';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage coupons'];
        return view('admin.coupon.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Coupon' : 'Add Coupon');
        $this->breadcrumbs[route('admin.coupons.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Coupons'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        if ($id == 0) {
            $code = $this->generateRandomString(6);
        } else {
            $code = Coupon::find($id)->code;
        }
        return view('admin.coupon.edit', [
            'code' => $code,
            'coupon' => $this->getViewParams($id),
            'action' => route('admin.coupons.update', $id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->percent >= 100) {
            return redirect()->back()->with('err', 'You cannot add 100% discount!');
        }
        $data = $request->only('code', 'percent', 'end_date');
        $data['end_date'] = Carbon::parse($data['end_date'])->timestamp;
        $coupon = Coupon::updateOrCreate(['id' => $id], $data);
        return redirect(route('admin.coupons.index'))->with('status', 'Coupon added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Coupon::where('id', '=', $id)->firstOrFail();
        $event::destroy($id);
        return response(['msg' => 'Coupon deleted successfully.']);
    }

    public function all()
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'code', 'dt' => 'code'],
            ['db' => 'percent', 'dt' => 'percent'],
            ['db' => 'is_used', 'dt' => 'is_used'],
            ['db' => 'end_date', 'dt' => 'end_date'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        $count = 0;
        DataTable::init(new Coupon, $columns);
        $dateFormat = config('settings.date-format');
        $event = DataTable::get();
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($event['data']) > 0) {
            foreach ($event['data'] as $key => $data) {
                $count = $count + 1;
                $event['data'][$key]['id'] = $count + $perPage;
                $event['data'][$key]['is_used'] = $this->checkExpiry($data['end_date'], $data['is_used']);
                $event['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $event['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $event['data'][$key]['end_date'] = Carbon::createFromTimestamp($data['end_date'])->format($dateFormat);
//                dd('yolo');
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $event['data'][$key]['actions'] = '<a href="' . route('admin.coupons.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $event['data'][$key]['actions'] = '<a href="' . route('admin.coupons.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.coupons.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($event);
    }

    private function getViewParams($id = 0)
    {
        $coupon = new Coupon();
        if ($id > 0) {
            $coupon = Coupon::findOrFail($id);
        }

        return $coupon;
    }

    function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($this->couponCodeExists($randomString)) {
            return $this->generateRandomString();
        }
        return $randomString;
    }

    function couponCodeExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return Coupon::where('code', $number)->exists();
    }

    function checkExpiry($end_date,$used){
        $copounExpirytime = $end_date - Carbon::today()->timestamp;
        if ($copounExpirytime < 0) {
            return 'expired';
        }else{
            return $used;
        }
    }


}
