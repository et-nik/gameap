<template>
    <div>
        <input type="hidden" :name="dsIdFieldName" v-model="selectedDs" />
        <input type="hidden" :name="serverIpFieldName" v-model="selectedIp" />

        <n-form-item :path="nodeIdPath">
          <n-select
              v-model:value="selectedDs"
              :disabled="nodeSelectDisabled"
              :options="nodesOptions"
              :placeholder="trans('labels.ds_id')"
          />
        </n-form-item>

        <n-form-item :path="ipPath" :show-label="false">
          <n-select
              v-model:value="selectedIp"
              :disabled="!selectedDs"
              :options="ipListOptions"
              :placeholder="trans('labels.ip')"
          />
        </n-form-item>
    </div>
</template>

<script setup>
  import { computed, watch, onMounted } from 'vue'
  import { useStore } from 'vuex'
  import {NFormItem} from "naive-ui"

  const props = defineProps({
    dsList: Object,
    serverIpFieldName: {
      type: String,
      default: 'server_ip',
    },
    dsIdFieldName: {
      type: String,
      default: 'ds_id',
    },
    nodeSelectDisabled: {
      type: Boolean,
      default: false,
    },
    nodeIdPath: "nodeId",
    ipPath: "ip",
  });

  const nodeIdModel = defineModel('nodeId')
  const ipModel = defineModel('ip')

  const store = useStore();

  const ipList = computed(() => store.state.dedicatedServers.ipList);

  const nodesOptions = computed(() => {
    return Object.entries(props.dsList).map(([id, name]) => ({ value: Number(id), label: name }));
  });

  const ipListOptions = computed(() => {
    return ipList.value.map((ip) => ({ value: ip, label: ip }));
  });

  const selectedDs = computed({
    get: () => {
      if (
          !store.state.dedicatedServers.dsId ||
          store.state.dedicatedServers.dsId === ""
      ) {
        return null;
      }

      return store.state.dedicatedServers.dsId
    },
    set: (dsId) => store.dispatch('dedicatedServers/setDsId', dsId)
  });

  const selectedIp = computed({
    get: () => store.state.servers.ip,
    set: (ip) => store.dispatch('servers/setIp', ip)
  });

  watch(ipList, (list) => {
    if (list.length >= 1 && !list.includes(selectedIp.value)) {
      selectedIp.value = list[0];
    }
  });

  watch(selectedDs, (val) => {
    nodeIdModel.value = val;
    store.dispatch('dedicatedServers/fetchIpList');
  });

  watch(selectedIp, (val) => {
    ipModel.value = val;
  });

  watch(nodeIdModel, (val) => {
    selectedDs.value = val;
  });

  watch(ipModel, (val) => {
    selectedIp.value = val;
  });
</script>
