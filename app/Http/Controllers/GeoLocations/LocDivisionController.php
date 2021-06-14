<?php

namespace App\Http\Controllers\GeoLocations;

use App\Helpers\Classes\DatatableHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocDivision;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class LocDivisionController extends BaseController
{
    private const VIEW_PATH = 'backend.geo-locations.loc-divisions.';

    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $locDivision = new LocDivision();

        return view(self::VIEW_PATH . 'ajax.edit-add',compact('locDivision'));
    }

    public function store(Request $request): JsonResponse
    {
//        $this->authorize('add');

        $this->validator($request)->validate();

        $data = $request->all();

        try {
            LocDivision::create($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'Division']), 'alert-type' => 'success']);

    }

    public function show(int $id): View
    {
        $locDivision = LocDivision::findOrFail($id);

        return view(self::VIEW_PATH . 'read', compact('locDivision'));
    }

    public function edit(int $id): View
    {
        $locDivision = LocDivision::findOrFail($id);

        return view(self::VIEW_PATH . 'ajax.edit-add', compact('locDivision'));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $locDivision = LocDivision::findOrFail($id);

        $this->validator($request)->validate();

        $data = $request->all();

        try {
            $locDivision->update($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_updated_successfully', ['object' => 'Division']), 'alert-type' => 'success']);
    }

    public function destroy(int $id): RedirectResponse
    {
        $locDivision = LocDivision::findOrFail($id);
        try {
            $locDivision->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Division']),
            'alert-type' => 'success'
        ]);
    }

    public function validator(Request $request): Validator
    {
        return \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title' => 'required|max:300',
            'title_en' => 'required|max:191',
            'bbs_code' => 'required|max:2'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        /** @var Builder $locDivisions */
        $locDivisions = LocDivision::select([
            'loc_divisions.id as id',
            'loc_divisions.title',
            'loc_divisions.title_en',
            'loc_divisions.bbs_code',
            'loc_divisions.created_at',
            'loc_divisions.updated_at'
        ]);

        return DataTables::eloquent($locDivisions)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (LocDivision $locDivision) {
                $str = '';
                $str .= '<a href="#" data-url="' . route('admin.loc-divisions.show', $locDivision->id) . '" class="btn btn-outline-info btn-sm dt-view"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                $str .= '<a href="#" data-url="' . route('admin.loc-divisions.edit', $locDivision->id) . '" class="btn btn-outline-warning btn-sm dt-edit"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                $str .= '<a href="#" data-action="' . route('admin.loc-divisions.destroy', $locDivision->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
