<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Module\CourseManagement\App\Models\Event;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\TrainingCenter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventService
{
    public function createEvent(array $data): Event
    {
        if (!empty($data['image'])) {
            $filename = FileHandler::storePhoto($data['image'], 'event');
            $data['image'] = 'event/' . $filename;
        } else {
            $data['image'] = Event::DEFAULT_IMAGE;
        }

        return Event::create($data);
    }

    public function updateTrainingCenter(TrainingCenter $trainingCenter, array $data): TrainingCenter
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);

        if (!isset($data['branch_id'])) {
            $data['branch_id'] = null;
        }

        $trainingCenter->fill($data);
        if (!$trainingCenter->save()) {
            throw new \Exception();
        }
        return $trainingCenter;
    }

    public function deleteTrainingCenter(TrainingCenter $trainingCenter): void
    {
        $trainingCenter->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'institute_id' => [
                'required',
                'int',
                'exists:institutes,id',
            ],
            'caption' => 'nullable|string',
            'date' => 'required | date_format:"Y-m-d H:i"|after:' . Carbon::now(),
            'details' => ['nullable', 'string'],
            'image' => [
                new RequiredIf($id == null),
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:500',
            ],
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
            'training_centers.title_bn',
            'institutes.title_en as institute_name',
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
                    $str .= '<a href="' . route('course_management::admin.training-centers.show', $trainingCenter->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $trainingCenter)) {
                    $str .= '<a href="' . route('course_management::admin.training-centers.edit', $trainingCenter->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $trainingCenter)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.training-centers.destroy', $trainingCenter->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
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
