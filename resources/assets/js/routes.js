import EmptyView from "./views/EmptyView.vue";
import ServersView from "./views/ServersView.vue";
import ServerIdView from "./views/ServerIdView.vue";
import AdminServersView from "./views/adminviews/AdminServersView.vue";

const routes = [
    { path: '/', component: EmptyView },
    { path: '/home', name: 'home', component: EmptyView },
    { path: '/servers', name: 'servers', component: ServersView },
    { path: '/servers/:id', name: 'servers.control', component: ServerIdView },
    { path: '/admin/servers', name: 'admin.servers.index', component: AdminServersView },
    { path: '/admin/servers/:id/edit', name: 'admin.servers.edit', component: EmptyView},
]

export {routes}