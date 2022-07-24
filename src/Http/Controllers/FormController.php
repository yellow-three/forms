<?php

namespace YellowThree\VoyagerForms\Http\Controllers;

use Illuminate\Http\Request;
use YellowThree\VoyagerForms\Form;
use YellowThree\VoyagerForms\FormInput;
use YellowThree\VoyagerForms\Traits\DataType;
use YellowThree\VoyagerForms\Helpers\Layouts;
use YellowThree\VoyagerForms\Validators\FormValidators;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class FormController extends VoyagerBaseController
{
    use DataType;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('add', app(Form::class));

        return view('voyager-forms::forms.edit-add', [
            'dataType' => $this->getDataType($request),
            'layouts' => Layouts::getLayouts('voyager-forms'),
            'emailTemplates' => Layouts::getLayouts('voyager-forms', 'email-templates'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('add', app(Form::class));

        $dataType = $this->getDataType($request);

        if ($request->input('hook')) {
            $validator = FormValidators::validateHook($request);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with([
                        'message' => __('voyager::json.validation_errors'),
                        'alert-type' => 'error',
                    ]);
            }
        }

        // Create the form
        $form = Form::create($request->all());

        // Create some default inputs
        $inputs = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
            'message' => 'text_area',
        ];
        $order = 1;
        foreach ($inputs as $key => $value) {
            FormInput::create([
                'form_id' => $form->id,
                'label' => ucwords(str_replace('_', ' ', $key)),
                'type' => $value,
                'required' => 1,
                'order' => $order,
            ])->save();

            $order++;
        }

        return redirect()
            ->route('voyager.forms.edit', ['id' => $form->id])
            ->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, $id)
    {
        $this->authorize('read', app(Form::class));

        $form = Form::findOrFail($id);

        return view('voyager-forms::forms.edit-add', [
            'form' => $form,
            'layouts' => Layouts::getLayouts('voyager-forms'),
            'emailTemplates' => Layouts::getLayouts('voyager-forms', 'email-templates'),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('edit', app(Form::class));

        $form = Form::findOrFail($id);

        return view('voyager-forms::forms.edit-add', [
            'dataType' => $this->getDataType($request),
            'form' => $form,
            'layouts' => Layouts::getLayouts('voyager-forms'),
            'emailTemplates' => Layouts::getLayouts('voyager-forms', 'email-templates'),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', app(Form::class));

        $dataType = $this->getDataType($request);
        $form = Form::findOrFail($id);

        if ($request->input('hook')) {
            $validator = FormValidators::validateHook($request);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with([
                        'message' => __('voyager::json.validation_errors'),
                        'alert-type' => 'error',
                    ]);
            }
        }

        $form->fill($request->all());
        $form->save();

        return redirect()
            ->back()
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
