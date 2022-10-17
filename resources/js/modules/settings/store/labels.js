import makeRequestStore from '../../../core/utils/makeRequestStore';
import convertKeysToCamelCase from '../../../core/utils/convertKeysToCamelCase';

import {
	getLabels,
	createLabel,
	updateLabel,
	deleteLabel,
	getLabelsByWorkspaceId,
} from '../services/labels';

const modules = [
	{ getLabels },
	{ createLabel },
	{ updateLabel },
	{ deleteLabel },
	{ getLabelsByWorkspaceId },
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
		selectedWorkspaceId: null,
	},
	mutations: {
		setItems(state, payload) {
			state.items = convertKeysToCamelCase(payload);
		},
		setSelectedWorkspaceId(state, payload) {
			state.selectedWorkspaceId = payload;
		},
	},
};
