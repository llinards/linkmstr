<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LinkManager extends Component
{
    use WithPagination;

    public ?string $search = null;
    public ?string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public bool $showDeleteModal = false;
    public ?Link $linkToDelete = null;
    public bool $showCopiedMessage = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /**
     * Sort links by the given field.
     */
    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Toggle link active status.
     */
    public function toggleActive(Link $link)
    {
        $link->is_active = !$link->is_active;
        $link->save();
    }

    /**
     * Copy the short URL to clipboard.
     */
    public function copyToClipboard(Link $link)
    {
        $this->dispatch('copy-to-clipboard', url: $link->short_url);
        $this->showCopiedMessage = true;
    }

    /**
     * Confirm link deletion.
     */
    public function confirmDelete(Link $link)
    {
        $this->linkToDelete = $link;
        $this->showDeleteModal = true;
    }

    /**
     * Delete the link.
     */
    public function deleteLink(LinkService $linkService)
    {
        if ($this->linkToDelete) {
            $linkService->deleteLink($this->linkToDelete);
            $this->showDeleteModal = false;
            $this->linkToDelete = null;
        }
    }

    /**
     * Cancel link deletion.
     */
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->linkToDelete = null;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $links = Link::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('original_url', 'like', '%' . $this->search . '%')
                        ->orWhere('short_code', 'like', '%' . $this->search . '%')
                        ->orWhere('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.links.link-manager', [
            'links' => $links,
        ]);
    }
}
