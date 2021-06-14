<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Branch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchService
{
    public function createBranch(array $data): Branch
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);
        return Branch::create($data);
    }

    public function updateBranch(Branch $branch, array $data): Branch
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);
        $branch->fill($data);
        $branch->save();
        return $branch;
    }

    /**
     * @throws \Exception
     */
    public function deleteBranch(Branch $branch): bool
    {
        return $branch->delete();
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

    public function getBranchLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Branch $branches */
        $branches = Branch::select(
            [
                'branches.id as id',
                'branches.title_en',
                'branches.title_bn',
                'institutes.title_en as institute_title_en',
                'branches.row_status',
                'branches.created_at',
                'branches.updated_at',
            ]
        );
        $branches->leftJoin('institutes', 'branches.institute_id', '=', 'institutes.id');
        $branches->acl();

        return DataTables::eloquent($branches)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Branch $branch) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $branch)) {
                    $str .= '<a href="' . route('course_management::admin.branches.show', $branch->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $branch)) {
                    $str .= '<a href="' . route('course_management::admin.branches.edit', $branch->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $branch)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.branches.destroy', $branch->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
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
