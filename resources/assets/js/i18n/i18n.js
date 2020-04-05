import Vue from "vue";

import plurals from './plurals';

// http://docs.translatehouse.org/projects/localization-guide/en/latest/l10n/pluralforms.html
const pluralForms = {
    default: (n) => (n !== 1 ? 1 : 0),
    en: (n) => (n !== 1 ? 1 : 0),
    ru: (n) => (n%10===1 && n%100!==11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2)
}

Vue.prototype.pluralize = (choice, choicesLength) => {
    let lang = document.documentElement.lang;

    if (!plurals.hasOwnProperty(lang)) {
        lang = 'default';
    }

    if (!plurals[lang].hasOwnProperty(choice)) {
        return choice;
    }

    const index = pluralForms[lang](choicesLength);

    return plurals[lang][choice][index] === undefined
        ? plurals[lang][choice][0]
        : plurals[lang][choice][index];
};

Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};