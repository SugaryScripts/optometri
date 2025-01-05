<?php


namespace App\Helper;


use Illuminate\Support\Str;

class SlugHelper {
    /**
     * Generate a unique slug.
     * Usage :  $this->slug = SlugHelper::generateUniqueSlug($value, YourModel::class);
     * If it already at max length, truncate to 99 and at the end add counter.
     * And so on until truncate to just 1 char and the rest are the counters.
     * But you know, it's unlikely
     *
     * @param string $title
     * @param string $model
     * @param string $column
     * @param int $maxLength
     * @return string
     */
    public static function generateUniqueSlug(
        string $title,
        $model,
        string $column = 'slug',
        int $maxLength = 100,
        ?int $excludeId = null
    ) {
        // Generate the initial slug
        $slug = Str::slug($title);

        // Ensure the slug is within the maximum length
        if (strlen($slug) > $maxLength) {
            $slug = substr($slug, 0, $maxLength);
        }

        // Save the truncated original slug
        $originalSlug = $slug;

        $counter = 1;

        // Build the query
        while (true) {
            $query = $model::where($column, $slug);

            // Exclude the current model when updating
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }

            // Check if slug exists
            if (!$query->exists()) {
                break;
            }

            // Generate a new slug with the counter appended
            $suffix = '-' . $counter;

            // Make sure we don't exceed maxLength when adding the suffix
            $slugWithoutSuffix = substr($originalSlug, 0, $maxLength - strlen($suffix));
            $slug = $slugWithoutSuffix . $suffix;

            $counter++;
        }

        return $slug;
    }
}

