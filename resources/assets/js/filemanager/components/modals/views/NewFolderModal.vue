<template>
    <div class="modal-content fm-modal-folder">
        <div class="modal-header grid grid-cols-2">
            <h5 class="modal-title">{{ lang.modal.newFolder.title }}</h5>
            <button type="button" class="btn-close" aria-label="Close" v-on:click="hideModal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="fm-folder-name">{{ lang.modal.newFolder.fieldName }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="fm-folder-name"
                    v-focus
                    v-bind:class="{ 'is-invalid': directoryExist }"
                    v-model="directoryName"
                    v-on:keyup="validateDirName"
                />
                <div class="invalid-feedback" v-show="directoryExist">
                    {{ lang.modal.newFolder.fieldFeedback }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info rounded mr-2" v-bind:disabled="!submitActive" v-on:click="addFolder">
                {{ lang.btn.submit }}
            </button>
            <button type="button" class="btn btn-light rounded mr-2" v-on:click="hideModal">{{ lang.btn.cancel }}</button>
        </div>
    </div>
</template>

<script>
import modal from '../mixins/modal.js';
import translate from '../../../mixins/translate.js';

export default {
    name: 'NewFolderModal',
    mixins: [modal, translate],
    data() {
        return {
            // name for new directory
            directoryName: '',

            // directory exist
            directoryExist: false,
        };
    },
    computed: {
        /**
         * Submit button - active or no
         * @returns {string|boolean}
         */
        submitActive() {
            return this.directoryName && !this.directoryExist;
        },
    },
    methods: {
        /**
         * Check the folder name if it exists or not.
         */
        validateDirName() {
            if (this.directoryName) {
                this.directoryExist = this.$store.getters[`fm/${this.activeManager}/directoryExist`](
                    this.directoryName
                );
            } else {
                this.directoryExist = false;
            }
        },

        /**
         * Create new directory
         */
        addFolder() {
            this.$store.dispatch('fm/createDirectory', this.directoryName).then((response) => {
                if (response.data.result.status === 'success') {
                    this.hideModal();
                }
            });
        },
    },
};
</script>
