<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LinkService
{
    /**
     * Create a new link.
     *
     * @param  array  $data
     *
     * @return Link
     * @throws ValidationException
     */
    public function createLink(array $data): Link
    {
        $validator = Validator::make($data, [
            'original_url' => ['required', 'url', 'max:2000'],
            'title'        => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'expires_at'   => ['nullable', 'date', 'after:now'],
            'custom_code'  => ['nullable', 'string', 'max:10', 'alpha_num', 'unique:links,short_code'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $link               = new Link();
        $link->user_id      = Auth::id();
        $link->original_url = $data['original_url'];
        $link->title        = $data['title'] ?? null;
        $link->description  = $data['description'] ?? null;
        $link->expires_at   = $data['expires_at'] ?? null;
        $link->short_code   = $data['custom_code'] ?? Link::generateUniqueShortCode();
        $link->save();

        return $link;
    }

    /**
     * Update an existing link.
     *
     * @param  Link  $link
     * @param  array  $data
     *
     * @return Link
     * @throws ValidationException
     */
    public function updateLink(Link $link, array $data): Link
    {
        $validator = Validator::make($data, [
            'original_url' => ['sometimes', 'required', 'url', 'max:2000'],
            'title'        => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'is_active'    => ['sometimes', 'boolean'],
            'expires_at'   => ['nullable', 'date', 'after:now'],
            'custom_code'  => [
                'nullable', 'string', 'max:10', 'alpha_num',
                'unique:links,short_code,'.$link->id,
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (isset($data['original_url'])) {
            $link->original_url = $data['original_url'];
        }

        if (isset($data['title'])) {
            $link->title = $data['title'];
        }

        if (isset($data['description'])) {
            $link->description = $data['description'];
        }

        if (isset($data['is_active'])) {
            $link->is_active = $data['is_active'];
        }

        if (isset($data['expires_at'])) {
            $link->expires_at = $data['expires_at'];
        }

        if ( ! empty($data['custom_code'])) {
            $link->short_code = $data['custom_code'];
        }

        $link->save();

        return $link;
    }

    /**
     * Delete a link.
     *
     * @param  Link  $link
     *
     * @return bool|null
     */
    public function deleteLink(Link $link): ?bool
    {
        return $link->delete();
    }
}
