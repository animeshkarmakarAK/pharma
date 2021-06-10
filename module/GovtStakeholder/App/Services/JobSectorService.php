<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\JobSector;
use Yajra\DataTables\Facades\DataTables;

class JobSectorService
{
    public function createJobSector(array $data): JobSector
    {
        return JobSector::create($data);
    }

    public function updateJobSector(JobSector $jobSector, array $data): JobSector
    {
        $jobSector->fill($data);
        $jobSector->save();

        return $jobSector;
    }

    public function deleteJobSector(JobSector $jobSector): bool
    {
        return $jobSector->delete();
    }

    public function validator(Request $request, $id = null): Validator
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
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                \Illuminate\Validation\Rule::in([JobSector::ROW_STATUS_ACTIVE, JobSector::ROW_STATUS_INACTIVE]),
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getServiceLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|JobSector $jobSectors */
        $jobSectors = JobSector::select(
            [
                'job_sectors.id',
                'job_sectors.title_en',
                'job_sectors.title_bn',
                'job_sectors.row_status',
            ]
        );

        return DataTables::eloquent($jobSectors)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (JobSector $jobSector) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $jobSector)) {
                    $str .= '<a href="' . route('admin.job-sectors.show', $jobSector->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $jobSector)) {
                    $str .= '<a href="' . route('admin.job-sectors.edit', $jobSector->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $jobSector)) {
                    $str .= '<a href="#" data-action="' . route('admin.job-sectors.destroy', $jobSector->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->editColumn('row_status', function (JobSector $jobSector) {
                return $jobSector->row_status == JobSector::ROW_STATUS_ACTIVE ? '<a href="#" class="badge badge-success">Active</a>' : '<a href="#" class="badge badge-danger">Inactive</a>';
            })
            ->rawColumns(['action', 'row_status'])
            ->toJson();
    }


}
