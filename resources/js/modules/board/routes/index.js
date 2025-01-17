import settingsRoutes from '../../settings/routes';
import processesRoutes from '../../processes/routes';
import reportsRoutes from '../../reports/routes';

import Home from '../views/Home.vue';
import Planning from '../views/Planning.vue';
import Sprint from '../views/Sprint.vue';
import WorkspaceSelection from '../views/WorkspaceSelection.vue';
import CompanyPlanning from '../views/CompanyPlanning.vue';

export default [
	{
		path: '/home',
		name: 'home',
		component: Home,
		meta: {
			title: 'Home',
		},
	},
	{
		path: '/workspace/:workspaceId/planning',
		name: 'planning',
		component: Planning,
		meta: {
			title: 'Planning',
		},
	},
	{
		path: '/workspace/:workspaceId/sprint/:teamId',
		name: 'sprint',
		component: Sprint,
		meta: {
			title: 'Sprint',
		},
		props: true,
	},
	{
		path: '/workspace/select',
		name: 'workspace.select',
		component: WorkspaceSelection,
		meta: {
			title: 'Selecione seu Workspace',
		},
	},
	{
		path: '/workspace/company',
		name: 'workspace.company',
		component: CompanyPlanning,
		meta: {
			title: 'Backlogs',
		},
	},
	...settingsRoutes,
	...processesRoutes,
	...reportsRoutes,
];
