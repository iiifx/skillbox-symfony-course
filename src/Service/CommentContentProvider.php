<?php

declare(strict_types=1);

namespace App\Service;

use App\Homework\ComentContentProviderInterface;

class CommentContentProvider implements ComentContentProviderInterface
{
    protected PasteWordsService $pasteWordsService;

    protected array $contents = [
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
        'Vitae et leo duis ut diam quam nulla porttitor massa. Justo nec ultrices dui sapien eget mi proin',
        'Et magnis dis parturient montes nascetur ridiculus mus. Facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum',
        'Gravida in fermentum et sollicitudin ac orci. Elit duis tristique sollicitudin nibh sit amet commodo nulla facilisi',
        'Pellentesque habitant morbi tristique senectus. Ut sem viverra aliquet eget sit amet tellus. Aliquam sem fringilla ut morbi tincidunt',
        'Duis at tellus at urna. Commodo quis imperdiet massa tincidunt nunc',
        'Ultrices sagittis orci a scelerisque purus semper eget. Ut morbi tincidunt augue interdum velit euismod in',
        'Neque convallis a cras semper auctor neque. Ultrices tincidunt arcu non sodales neque sodales. Cras ornare arcu dui vivamus arcu felis',
        'Ac tortor vitae purus faucibus ornare suspendisse sed nisi. Odio pellentesque diam volutpat commodo sed egestas egestas fringilla',
        'Turpis massa tincidunt dui ut ornare lectus. Nisi est sit amet facilisis magna etiam tempor',
    ];

    public function __construct(PasteWordsService $pasteWordsService)
    {
        $this->pasteWordsService = $pasteWordsService;
    }

    public function get(string $word = null, int $wordsCount = 0): string
    {
        $content = $this->createContent();

        if (null !== $word && $wordsCount > 0) {
            $content = $this->pasteWordsService->paste($content, $word, $wordsCount);
        }

        return $content;
    }

    private function createContent(): string
    {
        return $this->contents[random_int(0, count($this->contents) - 1)];
    }
}
