<?php

namespace ProcessMaker\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use ProcessMaker\Http\Controllers\Admin\GroupController;
use ProcessMaker\Http\Controllers\Api\GroupController as ApiGroupController;
use ProcessMaker\Models\Group;
use ProcessMaker\Models\User;

class UserGroupMembershipUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $userUpdated;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Array $data, User $userUpdated)
    {
        $this->user = Auth::user();
        $this->userUpdated = $userUpdated;
        $this->buildData($data);
    }

    /**
     * Building the data
     */
    public function buildData($data) {
        
        $groups_deleted = [];
        $groups_added = [];
        
        foreach ($data['attached'] as $group_id) {
            $group = Group::findOrFail($group_id);
            $groups_added[] = $group->name;
        }
        foreach ($data['detached'] as $group_id) {
            $group = Group::findOrFail($group_id);
            $groups_deleted[] = $group->name;
        }

        $this->data = [
            'User name' => $this->userUpdated->username,
            'Groups added' => $groups_added,
            'Groups deleted' => $groups_deleted
        ];
    }

    /**
     * 
     */

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
