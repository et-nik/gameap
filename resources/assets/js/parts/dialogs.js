import {trans} from "../i18n/i18n";

const errorNotification = function(error, callback) {
    let title = trans('main.error')
    let content = ''

    switch (typeof error) {
        case "string":
            content = error
            break
        case "object":
            if ('title' in error) {
                title = error.title
            } else if ('name' in error) {
                title = error.name
            }

            if ('content' in error) {
                content = error.content
            } else if ('message' in error) {
                content = error.message
            }
            break
        default:
            content = "Something went wrong."
    }

    notification({
        title: title,
        content: content,
        type: 'error'
    })
}

const notification = function(n, callback) {
    let notification = n

    if (typeof n === "string") {
        notification = {
            content: notification,
            type: 'info'
        }
    }

    if (!notification.title) {
        switch (notification.type) {
            case 'error':
                notification.title = trans('main.error')
                break
            case 'success':
                notification.title = trans('main.success')
                break
            default:
                notification.title = trans('main.info')
                break
        }
    }

    switch (notification.type) {
        case 'error':
            window.$dialog.error({
                title: notification.title,
                content: notification.content,
                positiveText: trans('main.close'),
                closable: false,
                onPositiveClick: () => {
                    if (typeof callback === "function") {
                        callback();
                    }
                },
            });
            break
        case 'success':
            window.$dialog.success({
                title: notification.title,
                content: notification.content,
                positiveText: trans('main.close'),
                closable: false,
                onPositiveClick: () => {
                    if (typeof callback === "function") {
                        callback();
                    }
                },
            });
            break
        default:
            window.$dialog.info({
                title: notification.title,
                content: notification.content,
                positiveText: trans('main.close'),
                closable: false,
                onPositiveClick: () => {
                    if (typeof callback === "function") {
                        callback();
                    }
                },
            });
            break
    }
}

const alert = function(message, callback, content = "") {
    window.$dialog.info({
        title: message,
        content: content,
        positiveText: trans('main.close'),
        closable: false,
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

export {errorNotification, notification, alert, confirmAction, confirm}
