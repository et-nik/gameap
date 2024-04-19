@php
/**
 * @var $modelsList array
 * @var $labels array
 * @var $attributes array
 * @var $customActionsBefore callable|null
 * @var $viewRoute string|null
 * @var $editRoute string|null
 * @var $destroyRoute string|null
**/

$showActionCollumn = isset($customActionsBefore) || isset($viewRoute) || isset($editRoute) || isset($destroyRoute);
@endphp
<div class="w-full max-w-full">
    <div class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white">
        <div class="relative flex flex-col min-w-0 break-words bg-clip-border border-stone-200 bg-light/30">
            <table class="w-full text-left rtl:text-right border text-gray-700 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 rounded-lg dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        @foreach ($labels as $label)
                            <th scope="col" class="px-4 py-4">{{ $label }}</th>
                        @endforeach

                        @if ($showActionCollumn)
                            <th scope="col" class="px-4 py-4">{{ __('main.actions') }}</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach($modelsList as $key => $model)

                        @if (is_object($model) && method_exists($model, 'getKey'))
                            @php($modelKey = $model->getKey())
                        @elseif ((is_array($model) && array_key_exists('id', $model)) || (is_object($model) && property_exists($model, 'id')))
                            @php ($modelKey = is_array($model) ? $model['id'] : $model->id)
                        @endif

                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            @foreach ($attributes as $attr)
                                @php($cellValue = '')

                                {{--Get Cell value--}}
                                @if (is_array($attr))
                                    @php ($type = $attr[0])
                                    @php ($params = $attr[1])

                                    @if ($type == 'raw')
                                        @php($cellValue = $params)
                                    @elseif ($type == 'lambda')
                                        @php($cellValue = $params($model))
                                    @elseif ($type == 'twoSeparatedValues')
                                        @php($cellValue = $model->{$params[0]} . $params[1] . $model->{$params[2]})
                                    @endif
                                @elseif (is_string($attr))
                                    @if (is_array($model))
                                        @php($model = (object)$model)
                                    @endif

                                    @if (is_array($model->{$attr}))
                                        @foreach ($model->{$attr} as $val)
                                            @php($cellValue .= "<p>{$val}</p>")
                                        @endforeach
                                    @else
                                        @if(strpos($attr, '.') !== false)
                                            @php($ex = explode('.', $attr, 2))

                                            @if (isset($model->{$ex[0]}))
                                                @php($cellValue = $model->{$ex[0]}->{$ex[1]})
                                            @else
                                                @php($cellValue = '')
                                            @endif
                                        @else
                                            @php($cellValue = $model->{$attr})
                                        @endif
                                    @endif
                                @endif


                                @if($cellValue instanceof \Carbon\Carbon)
                                    <td class="px-3 py-4">{!! \Gameap\Helpers\DateHelper::convertToLocal($cellValue) !!}</td>
                                @else
                                    <td class="px-3 py-4">{!! $cellValue !!}</td>
                                @endif

                            @endforeach

                            @if (isset($modelKey) && $showActionCollumn)
                                <td class="px-3 py-4 whitespace-nowrap">
                                        @if (isset($customActionsBefore))
                                            {!! $customActionsBefore($modelKey, $model) !!}
                                        @endif

                                        @if (isset($viewRoute))
                                            <a class="inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded no-underline btn-small bg-lime-500 text-white hover:bg-lime-600 py-1.5 px-2 leading-tight text-xs  btn-view"
                                               title="{{ __('main.view') }}"
                                               href="{{ route($viewRoute, $modelKey) }}">
                                                <i class="fas fa-eye"></i><span class="hidden xl:inline">&nbsp;{{ __('main.view') }}</span>
                                            </a>&nbsp;
                                        @endif

                                        @if (isset($editRoute))
                                            <a class="inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded no-underline btn-small bg-teal-500 text-white hover:bg-teal-600 py-1.5 px-2 leading-tight text-xs btn-edit"
                                               title="{{ __('main.edit') }}"
                                               href="{{ route($editRoute, $modelKey) }}">
                                                <i class="fas fa-edit"></i><span class="hidden xl:inline">&nbsp;{{ __('main.edit') }}</span>
                                            </a>&nbsp;
                                        @endif

                                        @if (isset($destroyRoute))
                                            {{ Form::open(['id' => 'form-destroy-' . $modelKey, 'url' => route($destroyRoute, $modelKey), 'style'=>'display:inline']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}

                                            {{ Form::button( '<i class="fas fa-trash"></i><span class="hidden xl:inline">&nbsp;' . __('main.delete') . '</span>',
                                                [
                                                    'class' => 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded no-underline btn-small bg-red-500 text-white hover:bg-red-600 py-1.5 px-2 leading-tight text-xs btn-delete',
                                                    'title' => __('main.delete'),
                                                    'v-on:click' => $destroyConfirmAction ?? 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                                                    'type' => 'submit'
                                                ]
                                                ) }}

                                            {{ Form::close() }}
                                        @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>