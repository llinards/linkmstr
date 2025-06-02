<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Component;

class LinkEditor extends Component
{
    public Link $link;

    #[Rule('required|url|max:2000')]
    public string $originalUrl = '';

    #[Rule('nullable|string|max:255')]
    public ?string $title = null;

    #[Rule('nullable|string|max:1000')]
    public ?string $description = null;

    #[Rule('nullable|date|after:now')]
    public ?string $expiresAt = null;

    #[Rule('nullable|string|max:10|alpha_num')]
    public ?string $customCode = null;

    #[Rule('boolean')]
    public bool $isActive = true;

    /**
     * Mount the component.
     */
    public function mount(Link $link)
    {
        $this->link        = $link;
        $this->originalUrl = $link->original_url;
        $this->title       = $link->title;
        $this->description = $link->description;
        $this->expiresAt   = $link->expires_at ? $link->expires_at->format('Y-m-d\TH:i') : null;
        $this->customCode  = $link->short_code;
        $this->isActive    = $link->is_active;
    }

    /**
     * Update the link.
     */
    public function updateLink(LinkService $linkService)
    {
        $this->validate();

        try {
            $linkService->updateLink($this->link, [
                'original_url' => $this->originalUrl,
                'title'        => $this->title,
                'description'  => $this->description,
                'expires_at'   => $this->expiresAt,
                'custom_code'  => $this->customCode,
                'is_active'    => $this->isActive,
            ]);

            $this->dispatch('link-updated');
            session()->flash('message', 'Link updated successfully.');
        } catch (ValidationException $e) {
            $this->addError('customCode', 'This short code is already taken. Please try another.');
        } catch (\Exception $e) {
            $this->addError('originalUrl', 'An error occurred while updating your link. Please try again.');
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.links.link-editor');
    }
}
