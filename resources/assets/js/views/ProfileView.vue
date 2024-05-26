<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>

  <GButton color="green" size="middle" class="mb-5" v-on:click="onClickUpdate()">
    <i class="fa-solid fa-user-pen mr-1"></i>
    <span>{{ trans('profile.edit')}}</span>
  </GButton>

  <n-card
      :title="trans('profile.profile')"
      size="small"
      class="mb-3"
      header-class="bg-stone-100"
      :segmented="{
                            content: true,
                            footer: 'soft'
                          }"
  >
    <n-table :bordered="false" :single-line="true">
      <tbody>
      <tr>
        <td><strong>{{ trans('users.login') }}:</strong></td>
        <td>{{ user.login }}</td>
      </tr>
      <tr>
        <td><strong>Email:</strong></td>
        <td>{{ user.email }}</td>
      </tr>
      <tr>
        <td><strong>{{ trans('users.name') }}:</strong></td>
        <td>{{ user.name }}</td>
      </tr>
      <tr>
        <td><strong>{{ trans('users.roles') }}:</strong></td>
        <td>{{ user.roles.join(', ')  }}</td>
      </tr>
      </tbody>
    </n-table>
  </n-card>

  <n-modal
      v-model:show="updateProfileModalEnabled"
      class="custom-card"
      preset="card"
      :title="trans('profile.edit')"
      :bordered="false"
      style="width: 600px"
      :segmented="{content: 'soft', footer: 'soft'}"
  >
    <UpdateProfileForm v-model="updateProfileModel" v-on:update="onUpdate" />
  </n-modal>
</template>

<script setup>
import {computed, ref} from "vue"
import GBreadcrumbs from "../components/GBreadcrumbs.vue"
import {trans} from "../i18n/i18n"
import {
  NCard,
  NTable,
  NModal,
} from "naive-ui"
import UpdateProfileForm from "./forms/UpdateProfileForm.vue";
import {useAuthStore} from "../store/auth";
import GButton from "../components/GButton.vue";
import {errorNotification, notification} from "../parts/dialogs";

const authStore = useAuthStore()

const breadcrumbs = computed(() => {
  return [
    {'route':'/', 'text':'GameAP', 'icon': 'gicon gicon-gameap'},
    {'route':{name: 'profile'}, 'text':trans('profile.profile')},
  ]
})

const user = computed(() => {
  return authStore.user
})

const onClickUpdate = () => {
  updateProfileModalEnabled.value = true
}

const updateProfileModalEnabled = ref(false)
const updateProfileModel = ref({
  name: user.value.name,
})

const onUpdate = () => {
  let profile = {
    name: updateProfileModel.value.name,
  }

  if (updateProfileModel.value.password) {
    profile.current_password = updateProfileModel.value.currentPassword
    profile.password = updateProfileModel.value.password
  }

  authStore.saveProfile(profile).then(() => {
    notification({
      content: trans('profile.update_success_msg'),
      type: "success",
    })

    authStore.fetchProfile()

    updateProfileModalEnabled.value = false
  }).catch(() => {
    errorNotification(error)
    updateProfileModalEnabled.value = false
  })
}

</script>