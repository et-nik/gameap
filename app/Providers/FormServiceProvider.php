<?php

namespace Gameap\Providers;

use Illuminate\Support\ServiceProvider;
use \Collective\Html\FormFacade as Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function () {
            Form::component('bsText', 'components.form.text',
                ['name', 'value' => null, 'label' => null, 'attributes' => []]
            );

            Form::component('bsTextArea', 'components.form.textarea',
                ['name', 'value' => null, 'label' => null, 'attributes' => []]
            );

            Form::component('bsEmail', 'components.form.email',
                ['name', 'value' => null, 'label' => null, 'attributes' => []]
            );

            Form::component('bsPassword', 'components.form.password',
                ['name', 'label' => null, 'attributes' => []]
            );
        });
    }
}
