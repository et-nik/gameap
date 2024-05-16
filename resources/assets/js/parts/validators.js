import {trans} from "../i18n/i18n";

const requiredValidator = (label) => {
    return (rule, value) => {
        if (!value) {
            return new Error(
                trans('validation.required', { attribute: label }),
            )
        }
    };
}

const stringLengthValidator = (label, min, max) => {
    return (rule, value) => {
        if (value.length < min || value.length > max) {
            return new Error(
                trans(
                    'validation.between.string',
                    { attribute: label, min: min, max: max },
                ),
            )
        }
    }
}

const allOfValidator = (...validators) => {
    return (rule, value) => {
        for (const validator of validators) {
            const error = validator(rule, value)
            if (error) {
                return error
            }
        }
    }
}

export {
    requiredValidator,
    stringLengthValidator,
    allOfValidator,
}