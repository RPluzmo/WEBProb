<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;
use App\Models\Track;

class TrackImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private const SLOTS = ['cover', 'gallery_1', 'gallery_2', 'gallery_3'];
    private const EXTENSIONS = ['png', 'jpg', 'jpeg', 'webp'];

    public function run(): void
    {
        $tracks = Track::select('id')->get();

        foreach ($tracks as $track) {
            foreach (self::SLOTS as $slot) {
                $relativePath = $this->resolveTrackImagePath($track->id, $slot);

                if ($relativePath === null) {
                    continue;
                }

                Image::updateOrCreate(
                    [
                        'track_id' => $track->id,
                        'slot' => $slot,
                    ],
                    [
                        'path' => $relativePath,
                    ]
                );
            }
        }
    }

    private function resolveTrackImagePath(int $trackId, string $slot): ?string
    {
        foreach (self::EXTENSIONS as $extension) {
            $relative = "track_images/track_{$trackId}/{$slot}.{$extension}";

            if (file_exists(public_path($relative))) {
                return $relative;
            }
        }

        return null;
    }
}
