<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\ExaminationRoutine;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExaminationRoutineService
{
    public function createExaminationRoutine(array $data): ExaminationRoutine
    {
        return ExaminationRoutine::create($data);
    }

    public function updateExaminationRoutine(ExaminationRoutine $examinationRoutine, array $data): ExaminationRoutine
    {

        $examinationRoutine->fill($data);
        $examinationRoutine->save();
        return $examinationRoutine;
    }

    /**
     * @throws \Exception
     */
    public function deleteExaminationRoutine(ExaminationRoutine $examinationRoutine): bool
    {
        return $examinationRoutine->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:191',
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getExaminationRoutineLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|ExaminationRoutine $examinationRoutines */
        $examinationRoutines = ExaminationRoutine::select(
            [
                'examination_routines.*',
            ]
        );
        $examinationRoutines->where('examination_routines.institute_id', $authUser->institute_id);
        return DataTables::eloquent($examinationRoutines)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (ExaminationRoutine $examinationRoutine) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $examinationRoutine)) {
                    $str .= '<a href="' . route('course_management::admin.examination-routines.show', $examinationRoutine->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $examinationRoutine)) {
                    $str .= '<a href="' . route('course_management::admin.examination-routines.edit', $examinationRoutine->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $examinationRoutine)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.examination-routines.destroy', $examinationRoutine->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
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
