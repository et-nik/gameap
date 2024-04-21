<template>
    <div>
        <div id="dedicatedServerForm" class="mb-3">
          <n-select v-model:value="selectedDs" :options="nodesOptions" :placeholder="trans('labels.ds_id')" />
        </div>

        <div class="mb-3">
            <n-select
                v-model:value="selectedIp"
                :disabled="!selectedDs"
                :options="ipListOptions"
                :placeholder="trans('labels.ip')"
            />
        </div>
    </div>
</template>

<script setup>
  import { computed, watch, onMounted } from 'vue';
  import { useStore } from 'vuex';

  const props = defineProps({
    dsList: Object,
    initialDsId: Number,
    initialIp: String,
    serverIpFieldName: {
      type: String,
      default: 'server_ip',
    },
    dsIdFieldName: {
      type: String,
      default: 'ds_id',
    }
  });

  const store = useStore();

  const ipList = computed(() => store.state.dedicatedServers.ipList);

  const nodesOptions = computed(() => {
    return Object.entries(props.dsList).map(([id, name]) => ({ value: Number(id), label: name }));
  });

  const ipListOptions = computed(() => {
    return ipList.value.map((ip) => ({ value: ip, label: ip }));
  });

  const selectedDs = computed({
    get: () => store.state.dedicatedServers.dsId,
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
    store.dispatch('dedicatedServers/fetchIpList');
  });

  // Mounted lifecycle hook equivalent
  onMounted(() => {
    selectedDs.value = props.initialDsId || null;
    selectedIp.value = props.initialIp;
  });
</script>
