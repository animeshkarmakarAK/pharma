<?php


namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use Module\CourseManagement\App\Models\Institute;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;
use Yajra\DataTables\Facades\DataTables;


class InstituteService
{
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
            'title_en' => ['required', 'string', 'max:191'],
            'title_bn' => ['required', 'string', 'max:191'],
            'code' => ['required', 'string', 'max:191', 'unique:institutes,code,' . $id],
            'domain' => [
                'required',
                'string',
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/',
                'max:191',
                'unique:institutes,domain,' . $id
            ],
            'address' => ['nullable', 'string', 'max:191'],
            'google_map_src' => ['nullable', 'string'],
            'primary_phone' => [
                'nullable',
                'regex:/^[0-9]*$/'
            ],
            'phone_numbers' => ['array'],
            'phone_numbers.*' => ['nullable', 'string', 'regex:/^[0-9]*$/'],
            'primary_mobile' => ['required', 'string', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
            'mobile_numbers' => ['array'],
            'mobile_numbers.*' => ['nullable', 'string', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
            'logo' => [
                new RequiredIf($id == null),
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:500',
                //'dimensions:width=80,height=80'
            ]
        ];

        $messages = [
            'logo.dimensions' => 'Please upload 80x80 size of image',
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
            'institutes.title_bn',
            'institutes.code',
            'institutes.address',
            'institutes.domain',
            'institutes.created_at',
            'institutes.updated_at'
        ]);
        $institutes->acl();

        return DataTables::eloquent($institutes)
            ->addColumn('action', static function (Institute $institute) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $institute)) {
                    $str .= '<a href="' . route('admin.institutes.show', $institute->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }

                if ($authUser->can('update', $institute)) {
                    $str .= '<a href="' . route('admin.institutes.edit', $institute->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $institute)) {
                    $str .= '<a href="#" data-action="' . route('admin.institutes.destroy', $institute->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
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
