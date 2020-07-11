<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeRequest;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Type;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.types.create');
    }

    public function store(StoreTypeRequest $request)
    {
        $type = Type::create($request->all());

        return redirect()->route('admin.types.index');
    }

    public function edit(Type $type)
    {
        abort_if(Gate::denies('type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.types.edit', compact('type'));
    }

    public function update(UpdateTypeRequest $request, Type $type)
    {
        $type->update($request->all());

        return redirect()->route('admin.types.index');
    }

    public function show(Type $type)
    {
        abort_if(Gate::denies('type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.types.show', compact('type'));
    }

    public function destroy(Type $type)
    {
        abort_if(Gate::denies('type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type->delete();

        return back();
    }

    public function massDestroy(MassDestroyTypeRequest $request)
    {
        Type::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getTypeByFactor(Request $request)
    {
        if (!$request->user_id) {
            $html = '<option selected value="">'.trans('global.pleaseSelect').'</option>';
        } else {
            $html = '<option selected value="">'.trans('global.pleaseSelect').'</option>';
            $user = User::findOrFail($request->user_id);

            $types_opt1 = Type::whereHas('factors', function ($q) use ($user) {
                $q->where('id', '=', $user->factor_id);
            })->where(['active' => true, 'instructor' => 0])->pluck('name', 'id');

            if (count($types_opt1)) {
                $html .= '<optgroup label="'.trans('cruds.activity.fields.opt1').'" id="opt1">';
                foreach ($types_opt1 as $id => $type) {
                    $html .= '<option value="'.$id.'" >'.$type.'</option>';
                }
                $html .= '</optgroup>';
            }

            $types_opt2 = Type::whereHas('factors', function ($q) use ($user) {
                $q->where('id', '=', $user->factor_id);
            })->where(['active' => true, 'instructor' => 1])->pluck('name', 'id');

            if (count($types_opt2)) {
                $html .= '<optgroup label="'.trans('cruds.activity.fields.opt2').'" id="opt2">';
                foreach ($types_opt2 as $id => $type) {
                    $html .= '<option value="'.$id.'" >'.$type.'</option>';
                }
                $html .= '</optgroup>';
            }
        }

        return response()->json(['html' => $html]);
    }
}
