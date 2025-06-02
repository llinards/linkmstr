<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Rule;

class LinkShortener extends Component
{
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

    public ?Link $createdLink = null;
    public bool $showForm = true;
    public bool $showCopiedMessage = false;

    /**
     * Create a new short link.
     */
    public function createLink(LinkService $linkService)
    {
        $this->validate();

        try {
            $this->createdLink = $linkService->createLink([
                'original_url' => $this->originalUrl,
                'title' => $this->title,
                'description' => $this->description,
                'expires_at' => $this->expiresAt,
                'custom_code' => $this->customCode,
            ]);

            $this->showForm = false;
            $this->reset(['originalUrl', 'title', 'description', 'expiresAt', 'customCode']);
        } catch (ValidationException $e) {
            $this->addError('customCode', 'This short code is already taken. Please try another.');
        } catch (\Exception $e) {
            $this->addError('originalUrl', 'An error occurred while creating your link. Please try again.');
        }
    }

    /**
     * Copy the short URL to clipboard.
     */
    public function copyToClipboard()
    {
        $this->dispatch('copy-to-clipboard', url: $this->createdLink->short_url);
        $this->showCopiedMessage = true;
    }

    /**
     * Reset the form to create another link.
     */
    public function createAnother()
    {
        $this->createdLink = null;
        $this->showForm = true;
        $this->showCopiedMessage = false;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.links.link-shortener');
    }
}
