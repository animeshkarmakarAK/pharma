<?php


namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\ApplicationFormType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ApplicationFormTypeService
{
    /**
     * @param array $data
     * @return ApplicationFormType
     */
    public function createApplicationFormType(array $data): ApplicationFormType
    {
        if($data['masters']==1){
            $data['ssc']=1;
            $data['hsc']=1;
            $data['honors']=1;
        }
        if($data['honors']==1){
            $data['ssc']=1;
            $data['hsc']=1;
        }

        if($data['hsc']==1){
            $data['ssc']=1;
        }
        return ApplicationFormType::create($data);
    }


    /**
     * @param ApplicationFormType $applicationFormType
     * @param Request $request
     */
    public function updateApplicationFormType(ApplicationFormType $applicationFormType, Request $request): ApplicationFormType
    {
        //dd($request->all());
        $data = [];
        $data['title_en'] = $request->title_en;
        $data['title_bn'] = $request->title_bn;
        $data['institute_id'] = $request->institute_id;
        $data['ssc'] = $request->ssc;
        $data['hsc'] = $request->hsc;
        $data['honors'] = $request->honors;
        $data['masters'] = $request->masters;

        $data['disable_status'] = $request->disable_status;
        $data['occupation'] = $request->occupation;
        $data['ethnic'] = $request->ethnic;
        $data['freedom_fighter'] = $request->freedom_fighter;
        $data['guardian'] = $request->guardian;


        if($data['masters']==1){
            $data['ssc']=1;
            $data['hsc']=1;
            $data['honors']=1;
        }

        if($data['honors']==1){
            $data['ssc']=1;
            $data['hsc']=1;
        }
        if($data['hsc']==1){
            $data['ssc']=1;
        }

        $applicationFormType->update($data);
        return $applicationFormType;
    }

    /**
     * @param ApplicationFormType $applicationFormType
     * @return bool|null
     */
    public function deleteApplicationFormType(ApplicationFormType $applicationFormType): ?bool
    {
        return $applicationFormType->delete();
    }

    /**
     * @param Request $request
     * @param null $id
     * @return Validator
     */
    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => ['required', 'string', 'max:191'],
            'title_bn' => ['required', 'string', 'max:191'],
            'institute_id' => 'required',
            'ethnic' => 'boolean',
            'freedom_fighter' => 'boolean',
            'disable_status' => 'Boolean',
            'ssc' => 'boolean',
            'hsc' => 'boolean',
            'honors' => 'boolean',
            'masters' => 'boolean',
            'occupation' => 'boolean',
            'guardian' => 'boolean',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getListDataForDatatable(Request $request): JsonResponse
    {
        /** @var Builder|ApplicationFormType $applicationFromType */
        $applicationFromType = ApplicationFormType::select([
            'application_form_types.id as id',
            'application_form_types.title_en',
            'application_form_types.title_bn',
            'row_status.title as row_status',
            'application_form_types.created_at',
            'application_form_types.updated_at',
            'institutes.title_en as institute_title'
        ]);
        $applicationFromType->join('row_status', 'application_form_types.row_status', 'row_status.code');
        $applicationFromType->join('institutes', 'application_form_types.institute_id', '=', 'institutes.id');
        $applicationFromType->acl();

        return DataTables::eloquent($applicationFromType)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (ApplicationFormType $applicationFromType) {
                $str = '';
                $str .= '<a href="' . route('course_management::admin.application-form-types.show', $applicationFromType->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                $str .= '<a href="' . route('course_management::admin.application-form-types.edit', $applicationFromType->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                $str .= '<a href="#" data-action="' . route('course_management::admin.application-form-types.destroy', $applicationFromType->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
