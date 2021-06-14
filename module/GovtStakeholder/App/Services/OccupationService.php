<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Module\GovtStakeholder\App\Models\Occupation;
use Yajra\DataTables\Facades\DataTables;


class OccupationService
{
    public function createOccupation(array $data): Occupation
    {
        return Occupation::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => [
                'max:191',
                'required',
                'string'
            ],
            'title_bn' => [
                'required',
                'string',
                'max:191',
            ],

            'job_sector_id' => [
                'required',
                'exists:job_sectors,id'
            ],
            'row_status' => [
                Rule::requiredIf(function () use ($id) {
                    return !empty($id);
                }),
                'int',
                'exists:row_status,code',
            ],
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function updateOccupation(Occupation $occupation, array $data): Occupation
    {
        $occupation->update($data);
        return $occupation;
    }


    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|Occupation $occupation */
        $occupation = Occupation::select([
            'occupations.id',
            'occupations.title_en',
            'occupations.title_bn',
            'job_sectors.title_en as job_sectors_title',
        ]);
        $occupation->join('job_sectors', 'occupations.job_sector_id', '=', 'job_sectors.id');


        return DataTables::eloquent($occupation)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Occupation $occupation) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $occupation)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.occupations.show', $occupation->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $occupation)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.occupations.edit', $occupation->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $occupation)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.occupations.destroy', $occupation->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();

    }


    public function deleteOccupation(Occupation $occupation): bool
    {
        return $occupation->delete();
    }


}
