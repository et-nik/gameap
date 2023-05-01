import {trans} from "../i18n/i18n";

const alert = function(message, callback) {
    window.$dialog.info({
        title: message,
        content: "",
        positiveText: trans('main.close'),
        onPositiveClick: () => {
            if (typeof callback === "function") {
                callback();
            }
        },
    });
}

let actionConfirmed = false;
const confirmAction = (e, message) => {
    if (!actionConfirmed) {
        e.preventDefault();

        confirm(message, () => {
            const clonedEvent = new e.constructor(e.type, e);
            e.target.dispatchEvent(clonedEvent);
        });
    }
}

const confirm = (message, callback) => {
    window.$dialog.success({
        title: message,
        content: "",
        positiveText: trans('main.yes'),
        negativeText: trans('main.no'),
        closable: false,
        onPositiveClick: () => {
            actionConfirmed = true
            if (typeof callback === "function") {
                callback();
            }
        },
        onNegativeClick: () => {
            actionConfirmed = false
        }
    });
}

export {alert, confirmAction, confirm}
