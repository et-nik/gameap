<template>
    <div>
        <button class="btn btn-sm btn-success m-1" data-toggle="modal" v-on:click="createTask()">{{ trans('main.add')}}</button>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>Task name</td>
                <td>Date</td>
                <td>Repeat</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody v-for="(value, key) in tasks">
            <tr>
                <td>{{ value.task }}</td>
                <td>{{ value.execute_date }}</td>
                <td>{{ humanRepeatText(value.repeat) }}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-success m-1" v-on:click="editTask(key)">{{ trans('main.edit') }}</button>
                    <button class="btn btn-sm btn-info btn-danger m-1" v-on:click="deleteTask(key)">{{ trans('main.delete') }}</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" tabindex="-1" role="dialog" id="createTaskModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Server Task</h5>
                        <button type="button" class="close" data-dismiss="modal" :aria-label="trans('main.close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="task" class="control-label">Task</label>

                                <select id="task" class="custom-select" name="task" v-model="task">
                                    <option value="restart">{{ trans('servers.restart') }}</option>
                                    <option value="start">{{ trans('servers.start') }}</option>
                                    <option value="stop">{{ trans('servers.stop') }}</option>
                                    <option value="update">{{ trans('servers.update') }}</option>
                                    <option value="reinstall">{{ trans('servers.reinstall') }}</option>
                                </select>

                                <span v-if="errors['task']" class="help-block">
                                    <strong class="text-danger">{{ errors['task'] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <date-picker type="datetime" v-model="taskDate" valueType="format"></date-picker><br>
                                <span v-if="errors['taskDate']" class="help-block">
                                    <strong class="text-danger">{{ errors['taskDate'] }}</strong>
                                </span>
                            </div>

                            <div class="form-check">
                                <label class="control-label">
                                    <input v-model="taskRepeatRadio" type="radio" name="repeat" value="1">
                                    Do not repeat
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="control-label">
                                    <input v-model="taskRepeatRadio" type="radio" name="repeat" value="0">
                                    Repeat Endlessly
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="control-label">
                                    <input v-model="taskRepeatRadio" type="radio" name="repeat" value="">
                                    Custom
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="repeat" class="control-label">Repeat</label>
                                <input
                                        v-model="taskRepeatInput"
                                        :disabled="taskRepeatRadio !== ''"
                                        id="repeat"
                                        type="number"
                                        min="1"
                                        max="255"
                                        class="form-control">

                                <span v-if="errors['taskRepeatInput']" class="help-block">
                                    <strong class="text-danger">{{ errors['taskRepeatInput'] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="repeat_period" class="control-label">Period</label>

                                <select
                                        v-model="taskRepeatPeriod"
                                        :disabled="repeat === 1"
                                        id="repeat_period"
                                        name="repeat_period"
                                        class="custom-select">

                                    <option value="30 minutes">30 min</option>
                                    <option value="1 hour">One hour</option>
                                    <option value="6 hours">6 hours</option>
                                    <option value="12 hours">12 hours</option>
                                    <option value="1 day">One day</option>
                                    <option value="1 week">One week</option>
                                </select>

                                <span v-if="errors['taskRepeatPeriod']" class="help-block">
                                    <strong class="text-danger">{{ errors['taskRepeatPeriod'] }}</strong>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('main.close') }}</button>
                        <button type="button" class="btn btn-primary" v-on:click="sendTaskForm">{{ buttonName }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import { mapState } from 'vuex';

    const REPEAT_ENDLESSLY          = 0;
    const REPEAT_ONCE               = 1;

    const RADIO_REPEAT_CUSTOM       = '';

    export default {
        components: { DatePicker },
        props: {
            serverId: Number
        },
        data: function () {
            return {
                task: '',
                taskDate: '',
                taskRepeatInput: 1,
                taskRepeatRadio: 0,
                taskRepeatPeriod: 0,
                selectedTaskIndex: null,

                errors: {},

                buttonName: this.trans('main.create'),
            }
        },
        methods: {
            createTask() {
                this.task = null;
                this.taskDate = null;
                this.taskRepeatInput = 1;
                this.taskRepeatPeriod = 24;

                this.selectedTaskIndex = null;

                this.buttonName = this.trans('main.create');

                this.showModal();
            },
            editTask(index) {
                this.task = this.tasks[index].task;
                this.taskDate = this.tasks[index].execute_date;
                this.taskRepeatInput = '';
                this.repeat = this.tasks[index].repeat;
                this.taskRepeatPeriod = this.tasks[index].repeat_period;

                this.selectedTaskIndex = index;

                this.buttonName = this.trans('main.save');

                this.showModal();
            },
            sendTaskForm() {
                if (!this.checkForm()) {
                    return;
                }

                const form = {
                    server_id: this.serverId,
                    task: this.task,
                    execute_date: this.taskDate,
                    repeat: this.repeat,
                };

                form.repeat_period = form.repeat !== 1
                    ? this.taskRepeatPeriod
                    : 0;

                if (this.selectedTaskIndex === null) {
                    this.$store.dispatch('servers/storeTask', form)
                        .then(() => {
                            this.hideModal();
                        }).catch((e) => {
                            this.hideModal();
                            gameap.alert('Error');
                        });
                } else {
                    this.$store.dispatch('servers/updateTask', {
                            taskIndex: this.selectedTaskIndex,
                            task: form
                        }).then(() => {
                            this.hideModal();
                        }).catch((e) => {
                            this.hideModal();
                            gameap.alert(e);
                        });
                }
            },
            checkForm() {
                this.resetErrors();
                let error = false;

                if (!this.task) {
                    error = true;
                    this.errors.task = 'Empty Task';
                }

                if (!this.taskDate) {
                    error = true;
                    this.errors.taskDate = 'Empty Task Execute Date';
                }

                if (this.taskRepeatRadio === RADIO_REPEAT_CUSTOM
                    && (isNaN(parseInt(this.taskRepeatInput))
                        || this.taskRepeatInput < 1
                        || this.taskRepeatInput > 255)
                ) {
                    error = true;
                    this.errors.taskRepeatInput = 'Invalid Repeat value';
                }

                if (this.repeat !== REPEAT_ONCE && !this.taskRepeatPeriod) {
                    error = true;
                    this.errors.taskRepeatPeriod = 'Empty Task Repeat Period';
                }

                return !error;
            },
            resetErrors() {
                this.errors = {
                    task: null,
                    taskDate: null,
                    taskRepeatRadio: null,
                    taskRepeatInput: null,
                    taskRepeatPeriod: null,
                };
            },
            deleteTask(taskIndex) {
                gameap.confirm('Are you sure?', () => {
                    this.$store.dispatch('servers/destroyTask', taskIndex);
                })
            },
            humanRepeatText(repeatInt) {
                if (repeatInt === REPEAT_ENDLESSLY) {
                    return 'endlessly';
                }

                if (repeatInt === REPEAT_ONCE) {
                    return 'once';
                }

                return repeatInt;
            },
            showModal() {
                this.resetErrors();
                $('#createTaskModal').modal('show');
            },
            hideModal() {
                this.resetErrors();
                $('#createTaskModal').modal('hide');
            },
        },
        computed: {
            ...mapState({
                tasks: state => state.servers.tasks,
            }),
            repeat: {
                get() {
                    return parseInt(this.taskRepeatRadio === RADIO_REPEAT_CUSTOM
                        ? this.taskRepeatInput
                        : this.taskRepeatRadio);
                },
                set(repeat) {
                    repeat = parseInt(repeat);
                    if (repeat <= 0) {
                        this.taskRepeatRadio = 0;
                    } else if (repeat === REPEAT_ONCE) {
                        this.taskRepeatRadio = 1;
                    } else {
                        this.taskRepeatRadio = RADIO_REPEAT_CUSTOM;
                        this.taskRepeatInput = repeat;
                    }
                }
            }
        },
        mounted() {
            this.$store.dispatch('servers/setServerId', this.serverId);
            this.$store.dispatch('servers/fetchTasks');
        }
    }
</script>