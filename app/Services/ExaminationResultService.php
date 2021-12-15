<?php

namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\ExaminationResult;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExaminationResultService
{
    public function createExaminationResult(array $data): ExaminationResult
    {
        return ExaminationResult::create($data);
    }

    public function updateExaminationResult(ExaminationResult $examinationResult, array $data): ExaminationResult
    {

        $examinationResult->fill($data);
        $examinationResult->save();
        return $examinationResult;
    }

    /**
     * @throws \Exception
     */
    public function deleteExaminationResult(ExaminationResult $examinationResult): bool
    {
        return $examinationResult->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'achieved_marks' => [
                'required'
            ],
            'feedback' => [
                'required',
                'string',
                'max:191',
            ],
            'trainee_id' => [
                'required','int'
            ],
            'examination_id' => [
                'required','int'
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getExaminationResultLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|ExaminationResult $examinationResults */
        $examinationResults = ExaminationResult::with('user','trainee','examination','batch','trainingCenter')->select(
            [
                'examination_results.*'
            ]
        );
        $examinationResults->where('examination_results.institute_id', $authUser->institute_id);
        return DataTables::eloquent($examinationResults)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (ExaminationResult $examinationResult) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $examinationResult)) {
                    $str .= '<a href="' . route('admin.examination-results.show', $examinationResult->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $examinationResult)) {
                    $str .= '<a href="' . route('admin.examination-results.edit', $examinationResult->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $examinationResult)) {
                    $str .= '<a href="#" data-action="' . route('admin.examination-results.destroy', $examinationResult->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
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
