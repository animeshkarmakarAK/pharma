<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\LocDivision;
use App\Models\Theme;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ThemesController extends BaseController
{
    private const VIEW_PATH = 'backend.themes.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $theme = new Theme();

        return view(self::VIEW_PATH . 'ajax.edit-add', compact('theme'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $validateData = $this->validator($request)->validate();

        try {
            Theme::create($validateData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'Theme']), 'alert-type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Theme $themes
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $themes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Theme $themes
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $themes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Theme $themes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme $themes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Theme $themes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $themes)
    {
        //
    }

    public function getDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder $themes */
        $themes = Theme::select([
            'themes.id',
            'themes.key',
            'themes.name',
            'themes.created_at',
            'themes.updated_at'
        ]);

        return DataTables::eloquent($themes)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Theme $theme) use ($authUser) {
                $str = '';

                if ($authUser->can('view', $theme)) {
                    $str .= '<a href="#" data-url="' . route('admin.themes.show', $theme->id) . '" class="btn btn-outline-info btn-sm dt-view"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $theme)) {
                    $str .= '<a href="#" data-url="' . route('admin.themes.edit', $theme->id) . '" class="btn btn-outline-warning btn-sm dt-edit"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $theme)) {
                    $str .= '<a href="#" data-action="' . route('admin.themes.destroy', $theme->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function validator(Request $request): Validator
    {
        return \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|max:300',
            'key' => 'required|max:191',
            'created_by' => 'nullable',
            'updated_by' => 'nullable'
        ]);
    }

    public function changeThemeList(): View
    {
        $themes = Theme::all();
        $userThemeId = AuthHelper::getAuthUser()->theme->id;
        return view(self::VIEW_PATH . 'change-theme',compact('themes','userThemeId'));
    }

    public function applyTheme(Request $request): JsonResponse
    {
        try {
            $themeId = $request->themeId;
            $authUser = AuthHelper::getAuthUser();
            $authUser->theme_id = $themeId;
            $authUser->save();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'Theme']), 'alert-type' => 'success']);

    }
}
