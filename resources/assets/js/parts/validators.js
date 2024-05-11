import {trans} from "../i18n/i18n";

const requiredValidator = (label) => {
    return (rule, value) => {
        if (!value) {
            return new Error(trans('validation.required', { attribute: label }))
        }
    };
}

export {requiredValidator}