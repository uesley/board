<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Label;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\WorkspaceResource;
use App\Models\Goal;
use App\Models\BoardList;
use App\Constants\BoardListsKeys;
use App\Constants\CardTypes;

class WorkspaceController extends Controller
{
	public function index()
	{
		$workspaces = Workspace::all();

		return WorkspaceResource::collection($workspaces);
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|string|unique:workspaces',
			'team_ids' => 'nullable|array',
			'label_ids' => 'nullable|array',
			'lottie_file' => 'nullable|string',
			'settings' => 'nullable|array',
		]);

		$workspace = Workspace::create($data);
		$workspace->associateMany(Team::class, $data['team_ids'] ?? []);
		$workspace->associateMany(Label::class, $data['label_ids'] ?? []);

		Goal::create([
			'title' => 'Defina um objetivo',
			'workspace_id' => $workspace->id,
		]);

		$this->createBoardList(BoardListsKeys::NOT_PRIORITIZED, $workspace, 0);
		$this->createBoardList(BoardListsKeys::BACKLOG, $workspace, 1);

		return new WorkspaceResource($workspace);
	}

	public function update(Request $request, Workspace $workspace)
	{
		$data = $request->validate([
			'name' => 'required|string',
			'team_ids' => 'nullable|array',
			'label_ids' => 'nullable|array',
			'lottie_file' => 'nullable|string',
			'settings' => 'nullable|array',
		]);

		$workspace->update($data);
		$workspace->syncTeams($data['team_ids'] ?? []);
		$workspace->syncLabels($data['label_ids'] ?? []);

		$this->updateBoardList(BoardListsKeys::BACKLOG, $workspace);
		$this->updateBoardList(BoardListsKeys::NOT_PRIORITIZED, $workspace);

		return new WorkspaceResource($workspace);
	}

	public function destroy(Workspace $workspace)
	{
		$this->removeBoardList(BoardListsKeys::BACKLOG, $workspace);
		$this->removeBoardList(BoardListsKeys::NOT_PRIORITIZED, $workspace);

		$workspace->teams()->unset('workspace_id');
		$workspace->labels()->unset('workspace_id');
		$workspace->delete();

		return Response::json('Deletado com sucesso.', 200);
	}

	private function createBoardList($key, $workspace, $position)
	{
		BoardList::create([
			'name' => $this->getBoardListLabel($key, $workspace),
			'key' => $this->getBoardListKey($key, $workspace),
			'accepts_card_type' => CardTypes::USER_STORY,
			'is_goalable' => true,
			'position' => $position,
		]);
	}

	private function updateBoardList($key, $workspace)
	{
		$board_list = BoardList::where('key', $this->getBoardListKey($key, $workspace))->first();

		$board_list->name = $this->getBoardListLabel($key, $workspace);

		$board_list->save();
	}

	private function removeBoardList($key, $workspace)
	{
		$board_list = BoardList::where('key', $this->getBoardListKey($key, $workspace))->first();

		$board_list->delete();
	}

	private function getBoardListLabel($key, $workspace)
	{
		$label = 'Backlog';
		if($key === BoardListsKeys::NOT_PRIORITIZED) {
			$label = 'Não priorizados';
		}

		$label = $label . ' - ' . $workspace->name;

		return $label;
	}

	private function getBoardListKey($key, $workspace)
	{
		return $key.'-'.$workspace->id;
	}
}
