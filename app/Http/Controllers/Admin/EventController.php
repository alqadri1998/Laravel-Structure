<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FromValidation;
use App\Models\Event;
use App\Traits\GetAttributes;
use Illuminate\Http\Request;
use App\Http\Libraries\DataTable;
use Carbon\Carbon;

class EventController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index()
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage events'];
        return view('admin.events.index');
    }

    public function all()
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'start_date', 'dt' => 'start_date'],
            ['db' => 'end_date', 'dt' => 'end_date'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Event(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $event = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($event['data']) > 0) {
            foreach ($event['data'] as $key => $data) {
                $count = $count + 1;
                $event['data'][$key]['id'] = $count + $perPage;
                $event['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $event['data'][$key]['date'] = Carbon::createFromTimestamp($data['start_date'])->format($dateFormat) . ' - ' . Carbon::createFromTimestamp($data['end_date'])->format($dateFormat);
                $event['data'][$key]['title'] = '';
                $event['data'][$key]['description'] = '';
                if (count($data['languages']) > 0) {
                    $event['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                    $event['data'][$key]['description'] = $data['languages'][0]->pivot->description;
                }
                unset($event['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $event['data'][$key]['actions'] = '<a href="' . route('admin.event.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $event['data'][$key]['actions'] = '<a href="' . route('admin.event.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.events.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($event);
    }

    public function store(FromValidation $request, $id)
    {
        $data = $request->only('start_date', 'end_date', 'event_location', 'latitude', 'longitude');
        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
        }
        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Event::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', 'Event  With Same Name Already Exist');
        }
        $data['start_date'] = Carbon::parse($data['start_date'])->timestamp;
        $data['end_date'] = Carbon::parse($data['end_date'])->timestamp;
        $event = Event::updateOrCreate(['id' => $id], $data);
        $event->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
            'description' => $request->description
        ]]);
        return redirect(route('admin.event.index'))->with('status', 'Event  ADDED');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Event' : 'Add Event');
        $this->breadcrumbs[route('admin.event.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Events'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.events.edit', [
            'event' => $this->getViewParams($id),
            'action' => route('admin.event.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $event = Event::where('id', '=', $id)->firstOrFail();
        $event->languages()->detach();
        $event::destroy($id);
        return response(['msg' => 'Event Deleted']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $event = new Event();
        $event->start_date = Carbon::now()->timestamp;
        $event->end_date = Carbon::now()->timestamp;
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
            $translations[$languageId]['description'] = '';
        }
        if ($id > 0) {
            $event = Event::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($event->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                        $translations[$languageId]['description'] = $language->pivot->description;
                    }
                }
            }
            unset($event->languages);
        }
        $event['translations'] = $translations;
        return $event;
    }

}
