<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\VisitorFeedback;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitorFeedbackService
{
    public function createVisitorFeedback(array $data): VisitorFeedback
    {
        return VisitorFeedback::create($data);
    }

    public function deleteVisitorFeedback(VisitorFeedback $visitorFeedback): void
    {
        $visitorFeedback->delete();
    }

    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'institute_id' => [
                'required',
                'exists:institutes,id',
            ],
            'form_type' => [
                'required',
                \Illuminate\Validation\Rule::in([VisitorFeedback::FORM_TYPE_FEEDBACK, VisitorFeedback::FORM_TYPE_CONTACT]),
            ],
            'name' => [
                'required',
                'string',
                'max:191',
            ],
            'mobile' => ['required', 'string', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
            'email' => [
                'required',
                'email',
            ],
            'address' => [
                'nullable',
                'string',
                'max:2000'
            ],
            'comment' => [
                'required',
                'string',
                'max:2000'
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getVisitorFeedbackLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|VisitorFeedback $visitorFeedbacks */
        $visitorFeedback = VisitorFeedback::select(
            [
                'visitor_feedback.id as id',
                'institutes.title_en as institute_name',
                'visitor_feedback.name',
                'visitor_feedback.mobile',
                'visitor_feedback.email',
                'visitor_feedback.form_type',
                'visitor_feedback.read_at',
                'visitor_feedback.row_status',
            ]
        );
        $visitorFeedback->join('institutes', 'visitor_feedback.institute_id', '=', 'institutes.id');

        $formType = $request->input('form_type');
        if (!empty($formType)) {
            $visitorFeedback->where('visitor_feedback.form_type', '=', $formType);
        }

        return DataTables::eloquent($visitorFeedback)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (VisitorFeedback $visitorFeedback) use ($authUser){
                $str = '';
                if ($authUser->can('view', $visitorFeedback)) {
                    $str .= '<a href="' . route('admin.visitor-feedback.show', $visitorFeedback->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }

                if ($authUser->can('delete', $visitorFeedback)) {
                    $str .= '<a href="#" data-action="' . route('admin.visitor-feedback.destroy', $visitorFeedback->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->editColumn('read_at', function (VisitorFeedback $visitorFeedback) {
                $str = '';
                $str .= '<a href="#" data-action="' . route('admin.branches.destroy', $visitorFeedback->id) . '" class="badge badge-' . ($visitorFeedback->read_at ? 'success' : 'danger') . '">' . ($visitorFeedback->read_at ? 'Read' : 'Unread') . '</a>';
                return $str;
            })
            ->editColumn('form_type', function (VisitorFeedback $visitorFeedback) {
                return $visitorFeedback->form_type == VisitorFeedback::FORM_TYPE_FEEDBACK ? 'Feedback' : 'Contact';
            })
            ->rawColumns(['action', 'read_at', 'form_type'])
            ->toJson();
    }
}
