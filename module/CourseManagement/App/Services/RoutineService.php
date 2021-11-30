<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Routine;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoutineService
{
    public function createRoutine(array $data): Routine
    {
        //$data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);
        return Routine::create($data);
    }

    public function updateRoutine(Routine $routine, array $data): Routine
    {
        //dd($data);
        //$data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);
        $routine->fill($data);
        $routine->save();
        return $routine;
    }

    /**
     * @throws \Exception
     */
    public function deleteRoutine(Routine $routine): bool
    {
        return $routine->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'batch_id' => [
                'required',
                'int',
            ],

            'training_center_id' => [
                'required',
                'int',
            ],
            'day' => ['required']
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getRoutineLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Routine $routines */
        $routines = Routine::with('Batch','trainingCenter')->select(
            [
                'routines.*'
            ]
        );

        $routines->where('routines.institute_id', '=', $authUser->institute_id);

        return DataTables::eloquent($routines)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Routine $routine) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $routine)) {
                    $str .= '<a href="' . route('course_management::admin.routines.show', $routine->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $routine)) {
                    $str .= '<a href="' . route('course_management::admin.routines.edit', $routine->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $routine)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.routines.destroy', $routine->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * @param string|null $googleMapSrc
     * @return string
     */
    public function parseGoogleMapSrc(?string $googleMapSrc): ?string
    {
        if (!empty($googleMapSrc) && preg_match('/src="([^"]+)"/', $googleMapSrc, $match)) {
            $googleMapSrc = $match[1];
        }

        return $googleMapSrc;
    }
}
