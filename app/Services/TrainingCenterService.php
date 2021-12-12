<?php

namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\BaseModel;
use App\Models\TrainingCenter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TrainingCenterService
{
    public function createTrainingCenter(array $data): TrainingCenter
    {
        if (!empty($data['course_coordinator_signature'])) {
            $filename = FileHandler::storePhoto($data['course_coordinator_signature'], 'training-center/signature/course-coordinator');
            $data['course_coordinator_signature'] = 'training-center/signature/course-coordinator/' . $filename;
        }

        if (!empty($data['course_director_signature'])) {
            $filename = FileHandler::storePhoto($data['course_director_signature'], 'training-center/signature/course-director');
            $data['course_director_signature'] = 'training-center/signature/course-director/' .  $filename;
        }
        return TrainingCenter::create($data);
    }

    public function updateTrainingCenter(TrainingCenter $trainingCenter, array $data): TrainingCenter
    {
        if ($trainingCenter->course_coordinator_signature && !empty($data['course_coordinator_signature'])) {
            FileHandler::deleteFile($trainingCenter->course_coordinator_signature);
        }

        if (!empty($data['course_coordinator_signature'])) {
            $filename = FileHandler::storePhoto($data['course_coordinator_signature'], 'training-center/signature/course-coordinator');
            $data['course_coordinator_signature'] = 'training-center/signature/course-coordinator/' . $filename;
        }

        if ($trainingCenter->course_director_signature && !empty($data['course_director_signature'])) {
            FileHandler::deleteFile($trainingCenter->course_director_signature);
        }

        if (!empty($data['course_director_signature'])) {
            $filename = FileHandler::storePhoto($data['course_director_signature'], 'training-center/signature/course-director');
            $data['course_director_signature'] = 'training-center/signature/course-director/' .  $filename;
        }


        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);

        if (!isset($data['branch_id'])) {
            $data['branch_id'] = null;
        }

        $trainingCenter->fill($data);
        $trainingCenter->save();
        return $trainingCenter;
    }

    public function deleteTrainingCenter(TrainingCenter $trainingCenter): void
    {
        $trainingCenter->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => 'required|string|max: 191',
            'institute_id' => 'required|int',
            'branch_id' => 'nullable|int',
            'address' => ['nullable', 'string', 'max:191'],
            "mobile" => [
                "required",
                BaseModel::MOBILE_REGEX
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(\Illuminate\Http\Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|TrainingCenter $trainingCenters */
        $trainingCenters = TrainingCenter::acl()->select([
            'training_centers.id as id',
            'training_centers.title_en',
            'institutes.title as institute_title',
            'branches.title_en as branch_name',
            'users.name_en as training_center_created_by',
            'training_centers.created_at',
            'training_centers.updated_at'
        ]);
        $trainingCenters->join('institutes', 'training_centers.institute_id', '=', 'institutes.id')
            ->leftJoin('branches', 'training_centers.branch_id', '=', 'branches.id')
            ->leftJoin('users', 'training_centers.created_by', '=', 'users.id');

        return DataTables::eloquent($trainingCenters)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (TrainingCenter $trainingCenter) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $trainingCenter)) {
                    $str .= '<a href="' . route('admin.training-centers.show', $trainingCenter->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $trainingCenter)) {
                    $str .= '<a href="' . route('admin.training-centers.edit', $trainingCenter->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $trainingCenter)) {
                    $str .= '<a href="#" data-action="' . route('admin.training-centers.destroy', $trainingCenter->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->editColumn('created_at', function (TrainingCenter $trainingCenter) {
                return Date('d M, Y h:i A', strtotime($trainingCenter['created_at']));
            })
            ->editColumn('updated_at', function (TrainingCenter $trainingCenter) {
                return Date('d M, Y h:i A', strtotime($trainingCenter['updated_at']));
            })
            ->rawColumns(['action', 'created_at', 'updated_at'])
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
