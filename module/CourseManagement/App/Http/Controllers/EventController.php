<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Branch;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Event;
use Module\CourseManagement\App\Services\EventService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    const VIEW_PATH = 'course_management::backend.events.';
    public EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
        $this->authorizeResource(Event::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): view
    {
        $institutes = Institute::active()->get();
        $branches = Branch::active()->get();

        $event = new Event();
        return view(self::VIEW_PATH . 'edit-add', compact('event', 'institutes', 'branches'));

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->eventService->validator($request)->validate();
        try {
            $this->eventService->createEvent($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.events.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Event']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Event $event
     * @return View
     */
    public function show(Event $event): View
    {
        return view(self::VIEW_PATH . 'read', compact('event'));
    }

    /**
     * @param Event $event
     * @return View
     */
    public function edit(Event $event): View
    {
        $institutes = Institute::active()->get();
        $branches = Branch::where(['institute_id' => $event->institute_id])->get();
        //dd($branches);

        return view(self::VIEW_PATH . 'edit-add', compact('event', 'institutes', 'branches'));
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function update(Request $request, Event $event)
    {
        $validateData = $this->eventService->validator($request, $event->id)->validate();

        try {
            $this->eventService->updateEvent($event, $validateData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.training-centers.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Training Center']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Event $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        try {
            $this->eventService->deleteEvent($event);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Training center']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->eventService->getListDataForDatatable($request);
    }
}

