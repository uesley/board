export default [
	{
		path: '/home',
		name: 'home',
		component: () => import('../views/Home'),
		meta: {
			title: 'Home',
		},
	},
	{
		path: '/planning',
		name: 'planning',
		component: () => import('../views/Planning'),
		meta: {
			title: 'Planning',
		},
	},
	{
		path: '/sprint/:teamId',
		name: 'sprint',
		component: () => import('../views/Sprint'),
		meta: {
			title: 'Sprint',
		},
		props: true,
	},
	{
		path: '/settings/members',
		name: 'settings.members',
		component: () => import('../views/MemberSettings'),
		meta: {
			title: 'Membros',
		},
	},
];
