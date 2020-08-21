<?php

namespace App\Http\Controllers;

use App\Constants\BoardListsKeys;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Http\Request;
use stdClass;

class CardController extends Controller
{
    public function getCardsByListsIds(Request $in)
    {
        $cards = Card::whereIn('board_list_id', $in->lists_ids)
            ->get();
        $payload = array();
        collect($in->lists_ids)->each(
            function ($item) use (&$payload, &$cards) {
                $payload[$item] = $cards
                    ->where('board_list_id', $item)
                    ->sortBy('position')
                    ->values();
            }
        );

        return $payload;
    }

    public function store(Request $in)
    {
        $card = Card::create([
            'board_list_id' => $in->board_list_id,
            'title' => $in->title
        ]);

        if ($this->isListAnUserStoryHolder($card->boardList->key)) {
            $card->isUserStory = true;
            $card->save();
        }

        return $card;
    }

    public function update(Request $in, $id)
    {
        $params = [
            'board_list_id' => $in->board_list_id,
            'title' => $in->title,
            'link' => $in->link,
            'labels' => $in->labels,
            'members' => $in->members,
            'estimated' => $in->estimated,
            'team_id' => $in->team_id,
            'acceptance_criteria' => $in->acceptance_criteria,
        ];

        $list_key = BoardList::where('_id', $in->board_list_id)->first()->key;

        if ($this->isListAnUserStoryHolder($list_key)) {
            $params['is_user_story'] = true;
        } else {
            $params['is_user_story'] = false;
        }

        $card = Card::where('_id', $id);
        $card->update($params);

        return $card->first();
    }

    public function updateCardsPositions(Request $in)
    {
        $requestCards = collect($in->cards);

        $result = $requestCards
            ->each(function ($requestCard) {
                $card = Card::where('_id', $requestCard['id'])->first();
                $card->position = $requestCard['position'];
                $card->save();
            });

        return $result;
    }

    public function destroy($id)
    {
        $card = Card::where('_id', $id)
            ->delete();
        return $card;
    }

    private function isListAnUserStoryHolder($key)
    {
        return in_array(
            $key,
            [
                BoardListsKeys::SPRINT_BACKLOG,
                BoardListsKeys::BACKLOG
            ]
        );
    }
}
