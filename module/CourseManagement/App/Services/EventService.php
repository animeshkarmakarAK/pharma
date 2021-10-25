<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Carbon\Carbon;
use Illuminate\Validation\Rules\RequiredIf;
use Module\CourseManagement\App\Models\Event;
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

    public function updateEvent(Event $event, array $data): Event
    {
        if ($event->image && !empty($data['image'])) {
            FileHandler::deleteFile($event->image);
        }
        if (!empty($data['image'])) {
            $filename = FileHandler::storePhoto($data['image'], 'event');
            $data['image'] = 'event/' . $filename;
        }

        $event->fill($data);
        if (!$event->save()) {
            throw new \Exception();
        }
        return $event;
    }

    public function deleteEvent(Event $event): void
    {
        $event->delete();
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

        /** @var Builder|Event $events */
        $events = Event::acl()->select([
            'events.id',
            'events.image',
            'events.caption',
            'events.date',
            'events.details',
            'events.institute_id',
            'institutes.title_en as institute_name_en',
            'users.name_en as user_created_by',
            'events.created_at as event_created_at',
            'events.updated_at as event_updated_at'
        ]);
        $events->join('institutes', 'events.institute_id', '=', 'institutes.id')
            //->leftJoin('branches', 'training_centers.branch_id', '=', 'branches.id')
            ->leftJoin('users', 'events.created_by', '=', 'users.id');

        return DataTables::eloquent($events)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Event $event) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $event)) {
                    $str .= '<a href="' . route('course_management::admin.events.show', $event->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $event)) {
                    $str .= '<a href="' . route('course_management::admin.events.edit', $event->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $event)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.events.destroy', $event->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->editColumn('event_date', function (Event $event) {
                return Date('d M, Y h:i A', strtotime($event['date']));
            })
            ->editColumn('event_created_at', function (Event $event) {
                return Date('d M, Y h:i A', strtotime($event['created_at']));
            })
            ->editColumn('event_updated_at', function (Event $event) {
                return Date('d M, Y h:i A', strtotime($event['updated_at']));
            })
            ->editColumn('event_image', function (Event $event) {
                $str = '';
                $str .= '<img src="' . asset("storage/{$event->image}") . '" height="30px"/>';
                return $str;
            })
            ->rawColumns(['action', 'event_date', 'event_created_at', 'event_updated_at', 'event_image'])
            ->toJson();
    }

}
