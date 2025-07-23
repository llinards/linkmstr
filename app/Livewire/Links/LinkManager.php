<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class LinkManager extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    protected array $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /**
     * Sort links by the given field.
     */
    public function sortBy(string $field): void
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
    public function toggleActive(Link $link): void
    {
        $link->is_active = ! $link->is_active;
        $link->save();
    }

    /**
     * Copy the short URL to clipboard.
     */
    public function copyToClipboard(Link $link): void
    {
        $this->dispatch('copy-to-clipboard', url: $link->short_url);
        session()->flash('message', 'Link has been saved in clipboard.');
    }

    /**
     * Delete the link.
     */
    public function deleteLink(Link $link, LinkService $linkService): void
    {
        try {
            $linkService->deleteLink($link);
            $this->dispatch('link-deleted');
            session()->flash('message', 'Link deleted successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'An error occurred while deleting the link. Please try again.');
        }
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        $links = Link::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('original_url', 'like', '%'.$this->search.'%')
                        ->orWhere('short_code', 'like', '%'.$this->search.'%')
                        ->orWhere('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.links.link-manager', [
            'links' => $links,
        ]);
    }
}
