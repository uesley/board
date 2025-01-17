import Vue from 'vue';
import Vuex from 'vuex';

import cards from './cards';
import boards from './boards';
import sprint from './sprint';
import events from './events';
import goals from './goals';
import planning from './planning';
import sprintReport from './sprintReport';

import settingsModules from '../../settings/store';
import processesModules from '../../processes/store';
import reportsModules from '../../reports/store';

Vue.use(Vuex);

export default new Vuex.Store({
	namespaced: true,
	modules: {
		cards,
		boards,
		sprint,
		events,
		goals,
		planning,
		sprintReport,
		...settingsModules,
		...processesModules,
		...reportsModules,
	},
});
