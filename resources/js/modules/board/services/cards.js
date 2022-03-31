import http from '../../../http';

export const createCard = (payload) => http.post('/cards', payload);

export const createCards = (payload) => http.post('/cards/store-many', payload);

export const getCardsByListsIds = (params) => http.get('/cards/lists-ids', {
	params,
});

export const updateCard = ({ id, ...params }) => http.put(`/cards/${id}`, params);

export const deleteCard = (id) => http.delete(`/cards/${id}`);

export const deleteManyCards = (payload) => http.delete('/cards/delete-many', { data: payload });

export const updateCardsPositions = (cards = []) => http.post('/cards/update-positions', { cards });

export const synchronize = () => http.get('/cards/synchronize');
