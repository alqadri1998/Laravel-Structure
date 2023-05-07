<?php

namespace App\Http\Controllers\Front;

use App\Models\Event;
use App\Traits\GetAttributes;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[route('front.events.index')] = ['title' => __('Events')];
    }

    public function index()
    {
        $this->breadcrumbTitle = __('Events');
        $events = Event::whereHas('languages')->with('languages')->orderBy('created_at', 'DESC')->get();
        $this->setTranslations($events);
        return view('front.events.list', ['events' => $events]);

    }

    public function detail($slug)
    {
        $this->breadcrumbTitle = __('Detail');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Detail')];
        $event = Event::whereHas('languages')->with('languages')->where('slug', $slug)->firstOrFail();
        $event->translation = $this->translateRelation($event);
        $this->breadcrumbTitle = __($event->translation->title);

        return view('front.events.detail', ['event' => $event]);
    }

    public function eventDirection($slug)
    {
        $event = Event::whereHas('languages')->with('languages')->where('slug', $slug)->firstOrFail();
        $event->translation = $this->translateRelation($event);
        unset($event->languages);
        $this->breadcrumbTitle = __($event->translation->title);
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Directions')];


        return view('front.events.getDirections', ['event' => $event]);
    }
}
