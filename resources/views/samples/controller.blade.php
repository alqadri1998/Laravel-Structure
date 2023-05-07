
namespace App\Http\Controllers\Admin;

use App\Models\{!! $model !!};
use App\Http\Requests\{!! $request !!};
use App\Http\Libraries\Uploader;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;

class {!! $controller !!} extends Controller {

    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->middleware('admin.role:crud', ['only' => ['index']]);
        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
        $this->middleware('admin.role:read', ['only' => ['show']]);
        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage {!! $model !!}'];
        return view('admin.{!! $view !!}.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
        ];
        DataTable::init(new {!! $model !!}, $columns);
        DataTable::with('languages');
        ${!! $variable !!} = DataTable::get();
        if (sizeof(${!! $variable !!}['data']) > 0) {
            foreach (${!! $variable !!}['data'] as $key => $data) {
                    ${!! $variable !!}['data'][$key]['actions'] = '<a href="'.route('admin.{!! $view !!}.edit', ['{!! $view !!}' => $data['id']]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="'. route('admin.{!! $view !!}.destroy', ['{!! $view !!}' => $data['id']]).'" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

                }
        }
        return response(${!! $variable !!});
    }

    private function save($request, $id = 0) {
        @php
        $length = count($formFields);
        $length = $length - 1;
        @endphp
        $data = $request->only(@foreach($formFields as $key=>$fields) @if(!in_array('+', $fields) && $fields[1] != 'file') '{!! $fields[0] !!}' @if($key != $length) , @endif @endif @endforeach );
        @foreach($formFields as $key=>$fields)
            @if($fields[1] == 'file')
                if ($request->hasFile('{!! $fields[0] !!}')) {
                $uploader = new Uploader('{!! $fields[0] !!}');
                if ($uploader->isValidFile()) {
                $uploader->upload('pages', $uploader->fileName);
                if ($uploader->isUploaded()) {
                $data['{!! $fields[0] !!}'] = $uploader->getUploadedPath();
                }
                }
                if (!$uploader->isUploaded()) {
                return redirect()->back()->with('err', $uploader->getMessage())->withInput();
                }
                }
            @endif
        @endforeach
        ${!! $variable !!} = {!! $model !!}::updateOrCreate(['id' => $id], $data);
        ${!! $variable !!}->languages()->syncWithoutDetaching([
            $request->get('language_id') => [
                @foreach($formFields as $key=>$fields)
                    @if(in_array('*', $fields))
                        '{!! $fields[0] !!}' => $request->get('{!! $fields[0] !!}'),
                    @endif
                @endforeach
                ]
        ]);

        return;
    }

    public function edit($id) {
        $heading = (($id > 0) ? 'Edit {!! $model !!}':'Add {!! $model !!}');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.{!! $view !!}.edit', [
            'method' => 'PUT',
            '{!! $variable !!}Id' => $id,
            'action' => route('admin.{!! $view !!}.update', $id),
            'heading' => $heading,
            '{!! $variable !!}' => $this->getViewParams($id)
        ]);
    }

    public function update({!! $request !!} $request, $id) {
        $err = $this->save($request, $id);
        return ($err) ? $err:redirect(route('admin.{!! $view !!}.index'))->with('status', '{!! $model !!} updated');
    }

    private function getViewParams($id = 0) {
        $locales = config('app.locales');
        ${!! $variable !!} = new {!! $model !!}();
        $translations = [];
        foreach ($locales as $shortCode=>$languageId){
            @foreach($formFields as $key=>$fields)
                @if(in_array('*', $fields))
            $translations[$languageId]['{!! $fields[0] !!}'] = '';
            @endif
            @endforeach
        }
        if ($id > 0) {
            ${!! $variable !!} = {!! $model !!}::with(['languages'])->findOrFail($id);
            foreach ($locales as $shortCode=>$languageId){
                foreach (${!! $variable !!}->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        @foreach($formFields as $key=>$fields)
                            @if(in_array('*', $fields))
                                $translations[$languageId]['{!! $fields[0] !!}'] = $language->pivot->{!! $fields[0] !!};
                            @endif
                        @endforeach
                    }
                }
            }
            unset(${!! $variable !!}->languages);
        }
        ${!! $variable !!}->translations = $translations;
        return ${!! $variable !!};
    }

    public function destroy($id) {
        {!! $model !!}::destroy($id);
        return response(['msg' => '{!! $model !!} deleted']);
    }

}
