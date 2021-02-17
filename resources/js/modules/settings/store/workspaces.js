import makeRequestStore from '../../../core/utils/makeRequestStore';
import convertKeysToCamelCase from '../../../core/utils/convertKeysToCamelCase';

import {
	getWorkspaces,
	createWorkspace,
	updateWorkspace,
	deleteWorkspace,
} from '../services/workspaces';

const modules = [
	{ getWorkspaces },
	{ createWorkspace },
	{ updateWorkspace },
	{ deleteWorkspace },
];

export default {
	namespaced: true,
	modules: {
		...modules.reduce((acc, module) => ({
			...acc,
			...makeRequestStore(module),
		}), {}),
	},
	state: {
		items: [],
	},
	mutations: {
		setItems(state, payload) {
			state.items = convertKeysToCamelCase(payload);
		},
	},
}
