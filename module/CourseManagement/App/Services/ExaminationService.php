<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Examination;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExaminationService
{
    public function createExamination(array $data): Examination
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);
        return Examination::create($data);
    }

    public function updateExamination(Examination $examination, array $data): Examination
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);
        $examination->fill($data);
        $examination->save();
        return $examination;
    }

    /**
     * @throws \Exception
     */
    public function deleteExamination(Examination $examination): bool
    {
        return $examination->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
            ],
            'title_bn' => [
                'required',
                'string',
                'max: 191',
            ],
            'institute_id' => [
                'required',
                'int',
                'exists:institutes,id',
            ],
            'address' => ['nullable', 'string', 'max:191'],
            'google_map_src' => ['nullable', 'string'],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getExaminationLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Examination $examinations */
        $examinations = Examination::acl()->select(
            [
                'examinations.id as id',
                'examinations.title_en',
                'examinations.title_bn',
                'institutes.title_en as institute_title_en',
                'examinations.row_status',
                'examinations.created_at',
                'examinations.updated_at',
            ]
        );
        $examinations->leftJoin('institutes', 'examinations.institute_id', '=', 'institutes.id');

        return DataTables::eloquent($examinations)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Examination $examination) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $examination)) {
                    $str .= '<a href="' . route('course_management::admin.examinations.show', $examination->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $examination)) {
                    $str .= '<a href="' . route('course_management::admin.examinations.edit', $examination->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $examination)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.examinations.destroy', $examination->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
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
