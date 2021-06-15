<?php

namespace App\Http\Controllers\GeoLocations;

use App\Helpers\Classes\DatatableHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocDistrict;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class LocDistrictController extends BaseController
{
    private const VIEW_PATH = 'backend.geo-locations.loc-districts.';

    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $locDistrict = new LocDistrict();

        return view(self::VIEW_PATH . 'ajax.edit-add', compact('locDistrict'));
    }

    public function store(Request $request): JsonResponse
    {
        $this->validator($request)->validate();

        $data = $request->all();

        try {
            LocDistrict::create($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'District']), 'alert-type' => 'success']);

    }

    public function show(int $id): View
    {
        $locDistrict = LocDistrict::findOrFail($id);

        return view(self::VIEW_PATH . 'ajax.read', compact('locDistrict'));
    }

    public function edit(int $id): View
    {
        $locDistrict = LocDistrict::findOrFail($id);

        return view(self::VIEW_PATH . 'ajax.edit-add', compact('locDistrict'));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $locDistrict = LocDistrict::findOrFail($id);

        $this->validator($request)->validate();

        $data = $request->all();

        try {
            $locDistrict->update($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_updated_successfully', ['object' => 'District']), 'alert-type' => 'success']);
    }

    public function destroy(int $id): RedirectResponse
    {
        $locDistrict = LocDistrict::findOrFail($id);
        try {
            $locDistrict->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'District']),
            'alert-type' => 'success'
        ]);
    }

    public function validator(Request $request): Validator
    {
        return \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title' => 'required|max:300',
            'title_en' => 'required|max:191',
            'bbs_code' => 'required|max:2',
            'loc_division_id'=> 'required'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        /** @var Builder $locDivisions */
        $locDistricts = LocDistrict::select([
            'loc_districts.id as id',
            'loc_districts.title',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.created_at',
            'loc_districts.updated_at',
            'loc_divisions.title as loc_divisions.title',
        ]);

        /** relations */
        $locDistricts->join('loc_divisions', 'loc_districts.loc_division_id', '=', 'loc_divisions.id');

        return DataTables::eloquent($locDistricts)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (LocDistrict $locDistrict) {
                $str = '';
                $str .= '<a href="#" data-url="' . route('admin.loc-districts.show', $locDistrict->id) . '" class="btn btn-outline-info btn-sm dt-view"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                $str .= '<a href="#" data-url="' . route('admin.loc-districts.edit', $locDistrict->id) . '" class="btn btn-outline-warning btn-sm dt-edit"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                $str .= '<a href="#" data-action="' . route('admin.loc-districts.destroy', $locDistrict->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
