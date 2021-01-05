<?php

namespace Gameap\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        view()->composer('*', function(): void {
            Form::component(
                'bsInput',
                'components.form.input',
                ['name', 'options' => []]
            );

            Form::component(
                'bsText',
                'components.form.text',
                ['name', 'value' => null, 'label' => null, 'attributes' => []]
            );

            Form::component(
                'bsTextArea',
                'components.form.textarea',
                ['name', 'value' => null, 'label' => null, 'attributes' => []]
            );

            Form::component(
                'bsEmail',
                'components.form.email',
                ['name', 'value' => null, 'label' => null, 'attributes' => []]
            );

            Form::component(
                'bsPassword',
                'components.form.password',
                ['name', 'label' => null, 'attributes' => []]
            );
        });
    }
}
