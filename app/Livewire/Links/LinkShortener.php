<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Component;

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

    /**
     * Create a new short link.
     */
    public function createLink(LinkService $linkService): void
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

            $this->reset(['originalUrl', 'title', 'description', 'expiresAt', 'customCode']);
            session()->flash('message', 'Your link has been shortened!');
            redirect()->route('links.index');
        } catch (ValidationException $e) {
            $this->addError('customCode', 'This short code is already taken. Please try another.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'An error occurred while creating your link. Please try again.');
            $this->addError('originalUrl', 'An error occurred while creating your link. Please try again.');
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.links.link-shortener');
    }
}
