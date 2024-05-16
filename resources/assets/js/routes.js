import EmptyView from "./views/EmptyView.vue";
import ServersView from "./views/ServersView.vue";
import ServerIdView from "./views/ServerIdView.vue";
import AdminServersList from "./views/adminviews/AdminServersList.vue";
import AdminNodesView from "./views/adminviews/AdminNodesView.vue";
import HomeView from "./views/HomeView.vue";
import AdminServersCreate from "./views/adminviews/AdminServersCreate.vue";
import AdminServersEdit from "./views/adminviews/AdminServersEdit.vue";
import AdminGamesList from "./views/adminviews/AdminGamesList.vue";

const routes = [
    { path: '/', name: 'home', component: HomeView, alias: '/home' },
    { path: '/servers', name: 'servers', component: ServersView },
    { path: '/servers/:id', name: 'servers.control', component: ServerIdView },
    { path: '/admin/nodes', name: 'admin.nodes.index', component: AdminNodesView, alias: '/admin/dedicated_servers' },
    { path: '/admin/nodes/:id', name: 'admin.nodes.edit', component: EmptyView, alias: '/admin/dedicated_servers/:id' },
    { path: '/admin/servers', name: 'admin.servers.index', component: AdminServersList },
    { path: '/admin/servers/create', name: 'admin.servers.create', component: AdminServersCreate },
    { path: '/admin/servers/:id/edit', name: 'admin.servers.edit', component: AdminServersEdit },
    { path: '/admin/games', name: 'admin.games.index', component: AdminGamesList },
]

export {routes}