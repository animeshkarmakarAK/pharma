<?php


namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\RequiredIf;
use Module\CourseManagement\App\Models\Institute;
use Yajra\DataTables\Facades\DataTables;


class InstituteService
{
    public function createSSP(array $data): Institute
    {
        $instituteData = Arr::except($data, ['contact_person_password', 'contact_person_password_confirmation']);
        $instituteData['title_en'] = $instituteData['name'];
        $instituteData['slug'] = Str::slug($instituteData['name']);
        $institute = Institute::create($instituteData);

        /* create a institute admin */
        $data = Arr::only($data, ['name', 'email', 'contact_person_password']);
        $data['institute_id'] = $institute->id;
        $data['name_en'] = $data['name'];
        unset($data['name']);
        $data['user_type_id'] = User::USER_TYPE_INSTITUTE_USER_CODE;
        $data['role_id'] = 3;
        $data['password'] = Hash::make($data['contact_person_password']);
        $data['row_status'] = 0;
        unset($data['contact_person_password']);
        User::create($data);
        return $institute;
    }

    public function createInstitute(array $data): Institute
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);

        if (!empty($data['logo'])) {
            $filename = FileHandler::storePhoto($data['logo'], 'institute');
            $data['logo'] = 'institute/' . $filename;
        } else {
            $data['logo'] = Institute::DEFAULT_LOGO;
        }
        return Institute::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'name' => ['required', 'string', 'max:191'],
            'email' => [
                'required',
                'string',
                'regex:/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
                'unique:users'
            ],
            'mobile' => ['required', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:191'],
            'office_head_name' => [
                'required', 'string',
            ],
            'office_head_post' => [
                'required', 'string',
            ],
            'contact_person_name' => [
                'required', 'string',
            ],
            'contact_person_post' => [
                'required', 'string',
            ],
            'contact_person_mobile' => [
                'required', 'string',
            ],
            'contact_person_email' => [
                'required', 'string', 'email',
            ],
            'contact_person_address' => [
                'nullable', 'string',
            ],
            'contact_person_password' => [
                'bail',
                new RequiredIf($id == null),
                'confirmed'
            ],

            /* 'logo' => [
                 new RequiredIf($id == null),
                 'image',
                 'mimes:jpeg,jpg,png,gif',
                 'max:500',
                 //'dimensions:width=370,height=70'
             ],
             'description'=>['nullable', 'string']*/
        ];

        $messages = [
            'logo.dimensions' => 'Please upload 370x70 size of image',
            'logo.max' => 'Please upload maximum 500kb size of image',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);

    }

    public function getListDataForDatatable(\Illuminate\Http\Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Institute $institutes */

        $institutes = Institute::acl()->select([
            'institutes.id as id',
            'institutes.title_en',
            'institutes.code',
            'institutes.address',
            'institutes.domain',
            'institutes.created_at',
            'institutes.updated_at'
        ]);

        return DataTables::eloquent($institutes)
            ->addColumn('action', static function (Institute $institute) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $institute)) {
                    $str .= '<a href="' . route('course_management::admin.institutes.show', $institute->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }

                if ($authUser->can('update', $institute)) {
                    $str .= '<a href="' . route('course_management::admin.institutes.edit', $institute->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $institute)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.institutes.destroy', $institute->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function updateInstitute(Institute $institute, array $data)
    {
        $data['google_map_src'] = $this->parseGoogleMapSrc($data['google_map_src']);

        if ($institute->logo && !$institute->logoIsDefault() && !empty($data['logo'])) {
            FileHandler::deleteFile($institute->logo);
        }

        if (!empty($data['logo'])) {
            $filename = FileHandler::storePhoto($data['logo'], 'institute');
            $data['logo'] = 'institute/' . $filename;

        } else {
            unset($data['logo']);
        }

        if (empty($institute->logo)) {
            $data['logo'] = Institute::DEFAULT_LOGO;
        }

        $institute->update($data);
    }

    public function deleteInstitute(Institute $institute): bool
    {
        return $institute->delete();
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
