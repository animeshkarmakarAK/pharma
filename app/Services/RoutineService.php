<?php

namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\Routine;
use App\Models\RoutineClass;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoutineService
{
    public function createRoutine(array $data): Routine
    {
        $authUser = AuthHelper::getAuthUser();
        $routine = Routine::create($data);

        foreach($data['daily_routines'] as $dailyRoutine){
            $dailyRoutine['institute_id'] = $authUser->institute_id;
            $dailyRoutine['routine_id'] = $routine->id;
            $routine->routineClass()->create($dailyRoutine);
        }
        return $routine;
    }

    public function updateRoutine(Routine $routine, array $data): Routine
    {
        $routine->fill($data);
        $routine->save();
        $authUser = AuthHelper::getAuthUser();

        foreach($data['daily_routines'] as $dailyRoutine){

            $dailyRoutine['institute_id'] = $authUser->institute_id;
            $dailyRoutine['routine_id'] = $routine->id;

            if (empty($dailyRoutine['id'])) {
                $routine->routineClass()->create($dailyRoutine);
                continue;
            }

            $routineClass = RoutineClass::findOrFail($dailyRoutine['id']);
            if (!empty($dailyRoutine['delete']) && $dailyRoutine['delete'] == 1) {
                $routineClass->delete();
            } else {
                $routineClass->update($dailyRoutine);
            }

        }

        return $routine;
    }

    /**
     * @throws \Exception
     */
    public function deleteRoutine(Routine $routine): bool
    {
        return $routine->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'batch_id' => [
                'required',
                'int',
            ],

            'training_center_id' => [
                'required',
                'int',
            ],
            'day' => ['required'],
            'daily_routines.*.user_id' => ['required'],
            'daily_routines.*.class' => ['required', 'string', 'max:30'],
            'daily_routines.*.start_time' => ['required'],
            'daily_routines.*.end_time' => ['required']
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getRoutineLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Routine $routines */
        $routines = Routine::with('Batch','trainingCenter')->select(
            [
                'routines.*'
            ]
        );

        $routines->where('routines.institute_id', '=', $authUser->institute_id);

        return DataTables::eloquent($routines)

            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Routine $routine) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $routine)) {
                    $str .= '<a href="' . route('admin.routines.show', $routine->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $routine)) {
                    $str .= '<a href="' . route('admin.routines.edit', $routine->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $routine)) {
                    $str .= '<a href="#" data-action="' . route('admin.routines.destroy', $routine->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

}
